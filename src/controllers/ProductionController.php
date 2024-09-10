<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    use Asn\Model\ArticleModel;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Core\Autorisation;
    use Asn\Model\PanierModel;
    use Asn\Model\ProductionModel;

    class ProductionController extends Controller {
        private  ArticleModel $articleModel;
        private ProductionModel $productionModel;
        public function __construct() {
            parent::__construct();
            if (!Autorisation::isConnect()) {
                parent::redirectToRoute("action=show-form&controller=security");
            }
            if (!Autorisation::hasRole("Admin") && !Autorisation::hasRole("RP")) {
                parent::redirectToRoute("action=logout&controller=security");
            }
            $this->articleModel = new ArticleModel;
            $this->productionModel = new ProductionModel;
            $this->load();
        }
        private function listerProd(int $page = 0): void {
            $this->renderView("prods/liste", [
                "reponse" => $this->productionModel->findAllWithPaginate($page,OFFSET),
                "articles" => $this->articleModel->findAllArticleVente(),
                "currentPage" => $page
            ]);
            if (Session::get("panier") != false) {
                Session::get("panier")->clear();
                Session::remove("panier");
            }
        }
        private function listerProdFiltre($date,$article,$page = 0): void {
            $this->renderView("prods/liste", [
                "reponse" => $this->productionModel->findAllWithPaginate($page,OFFSET,$date,$article),
                "articles" => $this->articleModel->findAllArticleVente(),
                "currentPage" => $page
            ]);
        }
        private function chargerFormulaire(): void {
            $this->renderView("prods/form", [
                "articles" => $this->articleModel->findAllArticleVente(false)
            ]);          
        }
        private function detailProd(int $id): void {
            $this->renderView("prods/detail", [
                "reponse" => $this->productionModel->get($id),
            ]);          
        }
        
        public function load() {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == "liste-prod") {
                    $this->listerProd($_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "form-prod") {
                    $this->chargerFormulaire();
                } elseif ($_REQUEST['action'] == "add-articleProd") {
                    $this->ajouterArticleDansProd($_POST);
                } elseif ($_REQUEST['action'] == "add-prod") {
                    $this->ajouterProd();
                } elseif ($_REQUEST['action'] == "listeFiltre-prod") {
                    $this->listerProdFiltre($_REQUEST['dateFiltre'],$_REQUEST['articleId'],$_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "detail-prod") {
                    $this->detailProd($_REQUEST['productionId']);
                } else {
                    new ErrorController();
                }
            } else {
                $this->listerProd();
            }
        }
        public function ajouterArticleDansProd(array $data):void {
            if (Session::get("panier") == false) {
                $panier = new PanierModel;
            } else {
                $panier = Session::get("panier");
            }
            Validator::isEmpty($data['qteProd'],"qteProd");
            Validator::isPositif($data['qteProd'],"qteProd");
            if (Validator::isValide()) {
                $panier->addArticleProduction($this->articleModel->get($data['articleId']),$data['qteProd'],$data['observation']);
                Validator::isEmpty($panier->observation,"observation");
                if (Validator::isValide()) {
                    Session::add("panier",$panier);
                } else {
                    Validator::add("observation","Il manque l'observation");
                    Session::add("errors",Validator::$errors);
                }
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=form-prod&controller=prod");
        }
        public function ajouterProd():void {
            $panier = Session::get("panier");
            Validator::isEmpty($panier,"panier","Le panier est vide");
            if (Validator::isValide()) {
                $this->productionModel->save($panier);
                $panier->clear();
                Session::remove("panier");
                parent::redirectToRoute("action=liste-prod&controller=prod&page=0");
            } else{
                Session::add("errors",Validator::$errors);
                parent::redirectToRoute("action=form-prod&controller=prod");
            }
            
        }
    }
?>