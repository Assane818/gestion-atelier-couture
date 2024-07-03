<?php

    namespace Asn\Model;
    use Asn\Core\Model;
    use Asn\Core\Session;
    class ApproModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "appro";
            $this->primaryKey = "approId";
        }
        public function save(PanierModel $panier):int {
            $date = new \DateTime();
            $date = $date->format('Y-m-d');
            $userId = Session::get('userConnect')['userId'];
            $this->executeUpdate("INSERT INTO `$this->table` (`date`, `montant`, `fournisseurId`, `userId`) VALUES ('$date',$panier->total, $panier->fournisseur, $userId);");
            $approId = $this->pdo->lastInsertId();
            foreach ($panier->articles as $article) {
                $articleId = $article['articleId'];
                $qteAppro = $article['qteAppro'];
                $qteStock = $article['qteStock'];
                $this->executeUpdate("INSERT INTO `detail` (`qteAppro`, `approId`, `articleId`) VALUES ('$qteAppro',$approId, $articleId);");
                $this->executeUpdate("UPDATE `article` SET `qteStock`= $qteStock + $qteAppro WHERE `article`.`articleId`=$articleId;");
            }
            return 1;
            
        }
        public function findAll(): array {
            return $this->executeSelect("SELECT * FROM `$this->table` a , `fournisseur` f WHERE a.`fournisseurId`=f.fourId");
        }
        public function findAllWithPaginate(int $page=0, int $offset=OFFSET): array {
            $page = $page*$offset;
            $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table`",true);
            $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `fournisseur` f WHERE a.`fournisseurId`=f.fourId  limit $page,$offset");
            return [
                'totalElement' => $result['nbreTotal'],
                'data' => $data,
                'pages' => ceil($result['nbreTotal']/$offset)
            ];
        }
        public function findAllWithFiltre(int $page=0, int $offset=OFFSET, string $date = '',$articleId = '',$fournisseurId = ''): array {
            $page = $page*$offset;
            if ($date != '' && $articleId == '' && $fournisseurId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` where `date` = '$date'",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `fournisseur` f WHERE `date` = '$date' AND a.`fournisseurId`=f.fourId limit $page,$offset");
            } else if ($articleId != '' && $date == '' && $fournisseurId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detail` d WHERE d.`articleId` = $articleId AND d.`approId` = a.`approId`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`a, `fournisseur` f ,`detail` d WHERE `articleId` = $articleId AND d.`approId` = a.`approId` AND  a.`fournisseurId`=f.fourId limit $page,$offset");
            } else if ($fournisseurId != '' && $date == '' && $articleId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `fournisseur` f WHERE a.`fournisseurId` = $fournisseurId AND a.`fournisseurId`=f.fourId",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `fournisseur` f WHERE `fournisseurId` = $fournisseurId  AND a.fournisseurId=f.`fourId` Limit $page,$offset");
            } else if ($date != '' && $articleId != '' && $fournisseurId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detail` d WHERE d.`approId` = a.`approId` AND `date` = '$date' AND `articleId` = $articleId",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a, `detail` d , `fournisseur` f  WHERE d.`approId` = a.`approId` AND `date` = '$date' AND `articleId` = $articleId AND  a.`fournisseurId`=f.fourId limit $page,$offset");
            } else if ($date != '' && $fournisseurId != '' && $articleId == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `fournisseur` f WHERE a.`fournisseurId` = $fournisseurId AND `date` = '$date'",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `fournisseur` f WHERE `date` = '$date' AND `fournisseurId` = $fournisseurId AND a.`fournisseurId`=f.fourId limit $page,$offset");
            } else if ($fournisseurId != '' && $articleId != '' && $date == '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `detail` d WHERE d.`approId` = a.`approId` AND a.`fournisseurId` = $fournisseurId AND d.`articleId` = $articleId",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`a, `fournisseur` f ,`detail` d WHERE a.`fournisseurId` = $fournisseurId AND d.`articleId` = $articleId AND d.`approId` = a.`approId` AND  a.`fournisseurId`=f.fourId limit $page,$offset");
            } else if ($date != '' && $fournisseurId != '' && $articleId != '') {
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table` a, `fournisseur` f, `detail` d WHERE a.`fournisseurId` = $fournisseurId AND a.`date` = '$date' AND d.`articleId` = $articleId AND d.`approId` = a.`approId` AND f.fourId = a.`fournisseurId`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table`a, `detail` d, `fournisseur` f WHERE `date` = '$date' AND a.`fournisseurId` = $fournisseurId AND d.`articleId` = $articleId AND d.`approId` = a.`approId` AND  a.`fournisseurId`=f.fourId limit $page,$offset");
            } else{
                $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table`",true);
                $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `fournisseur` f WHERE a.`fournisseurId`=f.fourId  limit $page,$offset");
            }
            return[
                'totalElement' => $result['nbreTotal'],
                'data' => $data,
                'pages' => ceil($result['nbreTotal']/$offset)
            ];
        }
        public function get(int $id) {
            return [
                "appro" => $this->executeSelect("SELECT * FROM `$this->table`a, `fournisseur` f, `user` u , `role` r, `detail` d WHERE a.`approId` = $id AND a.`fournisseurId`=f.fourId AND a.`userId`=u.userId AND u.roleId = r.id AND d.`approId` = a.`approId`",true),
                "detail" => $this->executeSelect("SELECT * FROM `detail` d, `article` a WHERE d.`articleId` = a.`articleId` AND d.`approId` = $id")
            ];
        }
    }
    
