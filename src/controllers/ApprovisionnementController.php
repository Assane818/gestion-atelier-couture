<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    use Asn\Model\ArticleModel;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Core\Autorisation;
    use Asn\Model\ApproModel;
    use Asn\Model\FournisseurModel;
    use Asn\Model\PanierModel;
    class ApprovisionnementController extends Controller {
        private  ArticleModel $articleModel;
        private  FournisseurModel $fournisseurModel;
        private ApproModel $approModel;
        public function __construct() {
            parent::__construct();
            if (!Autorisation::isConnect()) {
                parent::redirectToRoute("action=show-form&controller=security");
            }
            if (!Autorisation::hasRole("Admin") && !Autorisation::hasRole("RS")) {
                parent::redirectToRoute("action=logout&controller=security");
            }
            $this->articleModel = new ArticleModel;
            $this->fournisseurModel = new FournisseurModel;
            $this->approModel = new ApproModel;
            $this->load();
        }
        private function listerAppro(int $page = 0): void {
            $this->renderView("appros/liste", [
                "reponse" => $this->approModel->findAllWithPaginate($page,OFFSET),
                "articles" => $this->articleModel->findAllArticleConfection(),
                "fournisseurs" => $this->fournisseurModel->findAll(),
                "currentPage" => $page
            ]);
            if (Session::get("panier") != false) {
                Session::get("panier")->clear();
                Session::remove("panier");
            }
        }
        private function listerApproFiltre($date,$articleId,$fournisseurId,$page = 0): void {
            $this->renderView("appros/liste", [
                "reponse" => $this->approModel->findAllWithFiltre($page,OFFSET,$date,$articleId,$fournisseurId),
                "articles" => $this->articleModel->findAllArticleConfection(),
                "fournisseurs" => $this->fournisseurModel->findAll(),
                "currentPage" => $page
            ]);
        }
        private function chargerFormulaire(): void {
            $this->renderView("appros/form", [
                "fournisseurs" => $this->fournisseurModel->findAll(),
                "articles" => $this->articleModel->findAllArticleConfection()
            ]);          
        }
        private function detailAppro(int $id): void {
            $this->renderView("appros/detail", [
                "reponse" => $this->approModel->get($id),
            ]);          
        }
        
        public function load() {
            if (isset($_REQUEST['action'])) {
                if (!isset($_REQUEST['page']) || is_string($_REQUEST['page'])) {
                    $this->listerAppro();
                }
                if ($_REQUEST['action'] == "liste-appro") {
                    $this->listerAppro($_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "form-appro") {
                    $this->chargerFormulaire();
                } elseif ($_REQUEST['action'] == "add-article") {
                    $this->ajouterArticleDansAppro($_POST);
                } elseif ($_REQUEST['action'] == "add-appro") {
                    $this->ajouterAppro();
                } elseif ($_REQUEST['action'] == "listeFiltre-appro") {
                    $this->listerApproFiltre($_REQUEST['dateFiltre'],$_REQUEST['articleId'],$_REQUEST['fourId'],$_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "detail-appro") {
                    $this->detailAppro($_REQUEST['approId']);
                } else {
                    new ErrorController();
                }
            } else {
                $this->listerAppro();
            }
        }
        public function ajouterArticleDansAppro(array $data):void {
            if (Session::get("panier") == false) {
                $panier = new PanierModel;
            } else {
                $panier = Session::get("panier");
            }
            Validator::isEmpty($data['qteAppro'],"qteAppro");
            Validator::isPositif($data['qteAppro'],"qteAppro");
            if (Validator::isValide()) {
                $panier->addArticle($this->articleModel->get($data['articleId']),$data['fourId'],$data['qteAppro']);
                    Session::add("panier",$panier);
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=form-appro&controller=appro");
        }
        public function ajouterAppro():void {
            $panier = Session::get("panier");
            Validator::isEmpty($panier,"panier","Le panier est vide");
            if (Validator::isValide()) {
                $this->approModel->save($panier);
                $panier->clear();
                Session::remove("panier");
                parent::redirectToRoute("action=liste-appro&controller=appro&page=0");
            } else{
                Session::add("errors",Validator::$errors);
                parent::redirectToRoute("action=form-appro&controller=appro");
            }
            
        }
    }
?>