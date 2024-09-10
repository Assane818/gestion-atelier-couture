<?php
    namespace Asn\Controllers;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Core\Autorisation;
    use Asn\Core\Controller;
    use Asn\Model\TypeModel;
    class TypeController extends Controller {
        private  TypeModel $typeModel;
        public function __construct() {
            parent::__construct();
            if (!Autorisation::isConnect()) {
                parent::redirectToRoute("action=show-form&controller=security");
            }
            if (!Autorisation::hasRole("Admin")) {
                parent::redirectToRoute("action=logout&controller=security");
            }
            $this->typeModel = new TypeModel;
            $this->load();
        }
        private function lister(int $page = 0):void {
            $this->renderView("types/liste", [
                "reponse" => $this->typeModel->findAllWithPaginate($page,OFFSET),
                "currentPage" => $page
            ]);
        }
        private function store(array $type):void {
            Validator::isEmpty($type["nomType"],"nomType");
            if (Validator::isValide()) {
                $typeExiste = $this->typeModel->findByNameType($type["nomType"]);
                if ($typeExiste) {
                    Validator::add("nomType","La valeur existe deja");
                    Session::add("errors",Validator::$errors);
                } else {
                    $this->typeModel->save($type);
                }  
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=liste-type&controller=type&page=0");
            
            
        }
        private function supprimer(array $type):void {
            $this->typeModel->delete($type);
            parent::redirectToRoute("action=liste-type&controller=type&page=0");
        }
        private function get(int $id):array {
            return  $this->typeModel->get($id);
        }
        private function chargerListeUpdateType(int $id):void {
            $this->renderView("types/listeUpdate", [
                "types" => $this->typeModel->findAll(),
                "type" => $this->get($id),
            ]);            
        }
        private function modifier(array $type):void {
            Validator::isEmpty($type["nomType"],"nomType");
            if (Validator::isValide()) {
                $typeExiste = $this->typeModel->findByNameType($type["nomType"]);
                if ($typeExiste) {
                    Validator::add("nomType","La valeur existe deja");
                    Session::add("errors",Validator::$errors);
                } else {
                    $this->typeModel->update($type);
                }
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=liste-type&controller=type&page=0");
        }
        public function load() {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == "liste-type") {
                    $this->lister($_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "save-type") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnSave']);
                    $this->store($_REQUEST);
                } elseif ($_REQUEST['action'] == "delete-type") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnDelete']);
                    $this->supprimer($_REQUEST);
                } elseif ($_REQUEST['action'] == "listeUpdate-type") {
                    $this->chargerListeUpdateType($_REQUEST['typeId']);
                } elseif ($_REQUEST['action'] == "update-type") {
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