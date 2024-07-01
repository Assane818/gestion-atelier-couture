<?php
    namespace Asn\Model;
    use Asn\Core\Model;
    class ClientModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "client";
        }
    }
    
    
