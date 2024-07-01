<?php

    namespace Asn\Model;
    use Asn\Core\Model;
    use Asn\Core\Session;

    class VenteModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "vente";
            $this->primaryKey = "venteId";
        }
        public function save(PanierModel $panier):int {
            $date = new \DateTime();
            $date = $date->format('Y-m-d');
            $userId = Session::get('userConnect')['userId'];
            $this->executeUpdate("INSERT INTO `$this->table` (`date`, `montant`, `observation`, `clientId`, `userId`) VALUES ('$date',$panier->total, '$panier->observation', $panier->client, $userId);");
            $venteId = $this->pdo->lastInsertId();
            foreach ($panier->articles as $article) {
                $articleId = $article['articleId'];
                $qteVente = $article['qteVente'];
                $qteStock = $article['qteStock'];
                $this->executeUpdate("INSERT INTO `detailVente` (`qtevente`, `venteId`, `articleId`) VALUES ($qteVente,$venteId, $articleId);");
                $this->executeUpdate("UPDATE `article` SET `qteStock`= $qteStock - $qteVente WHERE `article`.`articleId`=$articleId;");
            }
            return 1;
        }
        public function findAllWithFiltre(int $page=0, int $offset=OFFSET, string $date = '',$articleId = '',$clientId = ''): array {
            $page = $page*$offset;
            if ($date != '' && $articleId == '' && $clientId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` where `date` = '$date'",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `client` f WHERE `date` = '$date' AND a.`clientId`=f.clientId limit $page,$offset");
            } else if ($articleId != '' && $date == '' && $clientId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detailvente` d WHERE d.`articleId` = $articleId AND d.`venteId` = a.`venteId`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`a, `client` f ,`detailvente` d WHERE `articleId` = $articleId AND d.`venteId` = a.`venteId` AND  a.`clientId`=f.clientId limit $page,$offset");
            } else if ($clientId != '' && $date == '' && $articleId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `client` f WHERE a.`clientId` = $clientId AND a.`clientId`=f.clientId",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `client` f WHERE a.`clientId` = $clientId  AND a.clientId=f.`clientId` Limit $page,$offset");
            } else if ($date != '' && $articleId != '' && $clientId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detailvente` d WHERE d.`venteId` = a.`venteId` AND `date` = '$date' AND `articleId` = $articleId",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a, `detailvente` d , `client` f  WHERE d.`venteId` = a.`venteId` AND `date` = '$date' AND `articleId` = $articleId AND  a.`clientId`=f.clientId limit $page,$offset");
            } else if ($date != '' && $clientId != '' && $articleId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `client` f WHERE a.`clientId` = $clientId AND `date` = '$date'",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `client` f WHERE `date` = '$date' AND a.`clientId` = $clientId AND a.`clientId`=f.clientId limit $page,$offset");
            } else if ($clientId != '' && $articleId != '' && $date == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detailvente` d WHERE d.`venteId` = a.`venteId` AND a.`clientId` = $clientId AND d.`articleId` = $articleId",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`a, `client` f ,`detailvente` d WHERE a.`clientId` = $clientId AND d.`articleId` = $articleId AND d.`venteId` = a.`venteId` AND  a.`clientId`=f.clientId limit $page,$offset");
            } else if ($date != '' && $clientId != '' && $articleId != '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `client` f, `detailvente` d WHERE a.`clientId` = $clientId AND a.`date` = '$date' AND d.`articleId` = $articleId AND d.`venteId` = a.`venteId` AND f.clientId = a.`clientId`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`a, `detailvente` d, `client` f WHERE a.`date` = '$date' AND a.`clientId` = $clientId AND d.`articleId` = $articleId AND d.`venteId` = a.`venteId` AND  a.`clientId`=f.clientId limit $page,$offset");
            }
            else{
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `client` f WHERE a.`clientId`=f.`clientId`  limit $page,$offset");
            }
            return[
                'totalElement' => $result['nbreTotal'],
                'data' => $data,
                'pages' => ceil($result['nbreTotal']/$offset)
            ];
        }
        
    }
    
    
