<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Model\CategorieModel;
    use Asn\Core\Autorisation;
    class CategorieController extends Controller {
        private  CategorieModel $categorieModel;
        public function __construct() {
            parent::__construct();
            if (!Autorisation::isConnect()) {
                parent::redirectToRoute("action=show-form&controller=security");
            }
            if (!Autorisation::hasRole("Admin")) {
                parent::redirectToRoute("action=logout&controller=security");
            }
            $this->categorieModel = new CategorieModel;
            $this->load();
        }
        private function lister(int $page = 0):void {
            $this->renderView("categories/liste", [
                "reponse" => $this->categorieModel->findAllWithPaginate($page,OFFSET),
                "currentPage" => $page
            ]);
        }
        private function store(array $categorie):void {
            Validator::isEmpty($categorie["nomCategorie"],"nomCategorie");
            if (Validator::isValide()) {
                $categorieExiste = $this->categorieModel->findByNameCategorie($categorie["nomCategorie"]);
                if ($categorieExiste) {
                    Validator::add("nomCategorie","La valeur existe deja");
                    Session::add("errors",Validator::$errors);
                } else {
                    $this->categorieModel->save($categorie);
                }
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=liste-categorie&controller=categorie&page=0");
        }
        private function supprimer(array $categorie):void {
            $this->categorieModel->delete($categorie);
            parent::redirectToRoute("action=liste-categorie&controller=categorie&page=0");
        }
        private function get(int $id):array {
            return $this->categorieModel->get($id);
        }
        private function chargerListeUpdateCategorie(int $id):void {
            $this->renderView("categories/listeUpdate", [
                "categories" => $this->categorieModel->findAll(),
                "categorie" => $this->get($id)
            ]);
            
        }
        private function modifier(array $categorie):void {
            Validator::isEmpty($categorie["nomCategorie"],"nomCategorie");
            if (Validator::isValide()) {
                $categorieExiste = $this->categorieModel->findByNameCategorie($categorie["nomCategorie"]);
                if ($categorieExiste) {
                    Validator::add("nomCategorie","La valeur existe deja");
                    Session::add("errors",Validator::$errors);
                } else {
                    $this->categorieModel->update($categorie);
                }
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=liste-categorie&controller=categorie&page=0");
        }
        public function load() {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == "liste-categorie") {
                    $this->lister($_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "save-categorie") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnSave']);
                    $this->store($_REQUEST);
                } elseif ($_REQUEST['action'] == "delete-categorie") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnDelete']);
                    $this->supprimer($_REQUEST);
                } elseif ($_REQUEST['action'] == "listeUpdate-categorie") {
                    $this->chargerListeUpdateCategorie($_REQUEST['categorieId']);
                } elseif ($_REQUEST['action'] == "update-categorie") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnUpdate']);
                    $this->modifier($_REQUEST);
                } else {
                    new ErrorController();
                }
            }
            else {
                $this->lister();
            }
        }

    }
    
?>