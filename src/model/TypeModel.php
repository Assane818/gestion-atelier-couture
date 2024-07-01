<?php
    namespace Asn\Model;
    use Asn\Core\Model;
    class TypeModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "type";
            $this->primaryKey = "typeId";
        }
        public function save(array $type):int {
            extract($type);
            return $this->executeUpdate("INSERT INTO `$this->table` (`nomType`) VALUES ('$nomType');");
            
        }
        public function delete(array $type):int {
            extract($type);
            return $this->executeUpdate( "DELETE FROM `$this->table` WHERE `$this->table`.`typeId` = $typeId");
        }
        public function update(array $type):int|false {
        extract($type);
        return $this->executeUpdate("UPDATE `$this->table` SET `nomType`='$nomType' WHERE `$this->table`.`typeId` = '$typeId'");
            
        }
        public function findByNameType(string $nameType):array|false {
            return $this->executeSelect("SELECT * FROM `$this->table` WHERE `nomType` like '$nameType'",true);
        }
    }
    
    
