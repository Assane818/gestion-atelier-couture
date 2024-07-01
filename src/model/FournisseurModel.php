<?php
    namespace Asn\Model;
    use Asn\Core\Model;
    class FournisseurModel extends Model {
        public function __construct() {
            $this->ouvrirConnexion();
            $this->table = "fournisseur";
        }
    }
    
    
