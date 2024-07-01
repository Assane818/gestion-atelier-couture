<?php

    namespace Asn\Model;
    use Asn\Core\Model;
    use Asn\Core\Session;
use DateTime;

    class ProductionModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "production";
            $this->primaryKey = "productionId";
        }
        public function save(PanierModel $panier):int {
            $date = new \DateTime();
            $date = $date->format('Y-m-d');
            $userId = Session::get('userConnect')['userId'];
            $this->executeUpdate("INSERT INTO `$this->table` (`date`, `montant`, `observation`, `userId`) VALUES ('$date',$panier->total, '$panier->observation', $userId);");
            $prodId = $this->pdo->lastInsertId();
            foreach ($panier->articles as $article) {
                $articleId = $article['articleId'];
                $qteProd = $article['qteProd'];
                $qteStock = $article['qteStock'];
                $this->executeUpdate("INSERT INTO `detailprod` (`qteProd`, `productionId`, `articleId`) VALUES ($qteProd,$prodId, $articleId);");
                $this->executeUpdate("UPDATE `article` SET `qteStock`= $qteStock + $qteProd WHERE `article`.`articleId`=$articleId;");
            }
            return 1;
        }
        public function findAllWithPaginate(int $page=0, int $offset=OFFSET, string $date = '',$articleId = ''): array {
            $page = $page*$offset;
            if ($date != '' && $articleId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` WHERE `date` = '$date'",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` WHERE `date` = '$date' limit $page,$offset");
            } else if ($articleId != null && $date == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table`, `detailprod` d where d.`articleId` = $articleId AND d.`productionId` = `$this->table`.`productionId`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`,`detailprod` WHERE `articleId` = $articleId AND `detailprod`.`productionId` = `$this->table`.`productionId` limit $page,$offset");
            } else if ($date != '' && $articleId != '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detailprod` d WHERE a.`date` = '$date' AND d.`articleId` = $articleId AND d.`productionId` = a.`productionId`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`,`detailprod` d WHERE d.`productionId` = `$this->table`.`productionId` AND `date` = '$date' AND d.`articleId` = $articleId limit $page,$offset");
            } else{
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` limit $page,$offset ");
            }
            return[
                'totalElement' => $result['nbreTotal'],
                'data' => $data,
                'pages' => ceil($result['nbreTotal']/$offset)
            ];
        }
    }
    
    
