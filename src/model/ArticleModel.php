<?php
    namespace Asn\Model;
    use Asn\Core\Model;
    class ArticleModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "article";
            $this->primaryKey = "articleId";
        }
        public function findAll(): array {
            return $this->executeSelect("SELECT * FROM `$this->table` a , `categorie` c , `type` t  WHERE a.`typeId`=t.typeId and a.`categorieId`=c.categorieId");
        }
        public function save(array $article):int {
            extract($article);
            return $this->executeUpdate("INSERT INTO `$this->table` (`libelle`, `prixAppro`, `qteStock`, `categorieId`, `typeId`, `image`) VALUES ('$libelle', '$prixAppro', '$qteStock', '$categorieId', '$typeId', '$image');");
        }
        public function delete(array $article):int {
            extract($article);
            return $this->executeUpdate("DELETE FROM `$this->table` WHERE `$this->table`.`articleId` = $articleId");
            
        }
        public function update(array $article):int|null {
            extract($article);
            return $this->executeUpdate("UPDATE `$this->table` SET `libelle`='$libelle', `prixAppro`='$prixAppro', `qteStock`='$qteStock', `categorieId`='$categorieId', `typeId`='$typeId', `image` = '$image' WHERE `article`.`articleId`='$articleId'");
            
        }
        public function findByNameArticle(string $nomArticle):array|false {
            return $this->executeSelect("SELECT * FROM `$this->table` WHERE `libelle` like '$nomArticle'",true);
        }
        public function findAllWithPaginate(int $page=0, int $offset=OFFSET): array {
            $page = $page*$offset;
            $result = $this->executeSelect("SELECT count(*) as nbreArticle FROM `$this->table`",true);
            $data =  $this->executeSelect("SELECT * FROM `$this->table` a , `categorie` c , `type` t  WHERE a.`typeId`=t.typeId and a.`categorieId`=c.categorieId limit $page,$offset");
            return [
                'totalElement' => $result['nbreArticle'],
                'data' => $data,
                'pages' => ceil($result['nbreArticle']/$offset)
            ];
        }
        public function findAllArticleVente($positif = true): array {
            if ($positif) {
                return $this->executeSelect("SELECT * FROM `$this->table` a , `categorie` c , `type` t  WHERE a.`typeId`=t.typeId and a.`categorieId`=c.categorieId and a.`typeId` = 79 and a.`qteStock` > 0");
            }
            return $this->executeSelect("SELECT * FROM `$this->table` a , `categorie` c , `type` t  WHERE a.`typeId`=t.typeId and a.`categorieId`=c.categorieId and a.`typeId` = 79");
        }
        public function findAllArticleConfection(): array {
            return $this->executeSelect("SELECT * FROM `$this->table` a , `categorie` c , `type` t  WHERE a.`typeId`=t.typeId and a.`categorieId`=c.categorieId and a.`typeId` = 1 and a.`qteStock` > 0");
        }
        public function get(int $id) {
            return $this->executeSelect("SELECT * FROM `$this->table` a WHERE a.`$this->primaryKey` = $id",true);
        }
    }
    

    
