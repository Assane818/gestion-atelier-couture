<?php
    namespace Asn\Core;
    class Model {
        protected $dsn = "mysql:host=127.0.0.1;port=3306;dbname=ges_atelier_couture";
        protected $utilisateur = "root";
        protected $motDePasse = "";
        protected \PDO|null $pdo = null;
        protected string $table;
        protected string $primaryKey;
        public function ouvrirConnexion():void {
            try {
                if ($this->pdo == null) {
                    $this->pdo = new \PDO($this->dsn, $this->utilisateur, $this->motDePasse);
                }
            } catch (\PDOException $e) {
                echo "Erreur de connexion:" . $e->getMessage();
            }
        }
        public function fermerConnexion():void {
            if ($this->pdo != null) {
                $this->pdo = null;
            }
           
        }
        protected function executeSelect(string $sql, bool $fetch = false): array|false {
            try {
                $stm = $this->pdo->query($sql);
                return $fetch? $stm->fetch(\PDO::FETCH_ASSOC) : $stm->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                echo "Erreur de connexion:" . $e->getMessage();
            }
        }
        public function executeUpdate(string $sql):int|false {
            try {
                return $this->pdo->exec($sql);
    
            } catch (\PDOException $e) {
                echo "Erreur de connexion:" . $e->getMessage();
            }
            
        }
        public function findAll(): array {
            return $this->executeSelect("SELECT * FROM `$this->table`");
        }
        public function findAllWithPaginate(int $page=0, int $offset=OFFSET): array {
            $page = $page*$offset;
            $result = $this->executeSelect("SELECT count(*) as nbreTotal FROM `$this->table`",true);
            $data =  $this->executeSelect("SELECT * FROM `$this->table`  limit $page,$offset");
            return [
                'totalElement' => $result['nbreTotal'],
                'data' => $data,
                'pages' => ceil($result['nbreTotal']/$offset)
            ];
        }
        public function get(int $id) {
            return $this->executeSelect("SELECT * FROM `$this->table` WHERE `$this->primaryKey` = $id",true);
        }
        
    }