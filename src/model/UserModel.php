<?php
    namespace Asn\Model;
    use Asn\Core\Model;
    class UserModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "user";
        }

        public function findByLoginAndPassword(string $login, string $password):array|false {
            return $this->executeSelect("SELECT * FROM $this->table u, role r WHERE u.roleId = r.id and u.login like '$login' and u.password like '$password'",true);
        }
    }