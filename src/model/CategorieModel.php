<?php
    namespace Asn\Model;
    use Asn\Core\Model;
    class CategorieModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "categorie";
            $this->primaryKey = "categorieId";
        }
        public function save(array $categorie):int {
            extract($categorie);
            return $this->executeUpdate("INSERT INTO `$this->table` (`nomCategorie`) VALUES ('$nomCategorie');");
        }
        public function delete(array $categorie):int {
            extract($categorie);
            return $this->executeUpdate("DELETE FROM `$this->table` WHERE `$this->table`.`categorieId` = '$categorieId'");
        }
        public function update(array $categorie):int|null {
            extract($categorie);
                $sql = "UPDATE `$this->table` SET `nomCategorie`='$nomCategorie' WHERE `$this->table`.`categorieId` = '$categorieId'";
            return $this->executeUpdate("UPDATE `$this->table` SET `nomCategorie`='$nomCategorie' WHERE `$this->table`.`categorieId` = '$categorieId'");
        }
        public function findByNameCategorie(string $nomCategorie):array|false {
            return $this->executeSelect("SELECT * FROM `$this->table` WHERE `nomCategorie` like '$nomCategorie'",true);
        }
    }
    
    