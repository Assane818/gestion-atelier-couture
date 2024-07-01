<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Model\UserModel;
    class SecuriteController extends Controller {
        private  UserModel $userModel;
        public function __construct() {
            parent::__construct();
            $this->userModel = new UserModel;
            $this->layout = "connexion";
            $this->load();
        }
        public function load() {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == "show-form") {
                    $this->showForm();
                } elseif ($_REQUEST['action'] == "connexion") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['controller']);
                    unset($_REQUEST['btnSave']);
                    $this->connexion($_REQUEST);
                } elseif ($_REQUEST['action'] == "logout") {
                    $this->logout();
                }
            } else {
                $this->showForm();
            }
        }

        public function showForm() {
            parent::renderView("security/form");
        }
        public function logout() {
            Session::fermer();
            parent::renderView("security/form");
        }
        public function connexion(array $user) {
            if (!Validator::isEmpty($user["login"],"login")) {
                Validator::isEmail($user["login"],"login");
            }
            Validator::isEmpty($user["password"],"password");
            if (Validator::isValide()) {
                $userConnect = $this->userModel->findByLoginAndPassword($user["login"],$user["password"]);
                if ($userConnect) {
                    Session::add("userConnect",$userConnect);
                    parent::redirectToRoute("action=liste-article&controller=article&page=0");
                } else {
                    Validator::add("error_connexion","Utilisateur Introuvable");
                    Session::add("errors",Validator::$errors);
                }
                
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=show-form&controller=security");
        }
    }