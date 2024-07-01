<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    use Asn\Model\ArticleModel;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Core\Autorisation;
    use Asn\Model\ClientModel;
    use Asn\Model\PanierModel;
    use Asn\Model\VenteModel;

    class VenteController extends Controller {
        private  ArticleModel $articleModel;
        private ClientModel $clientModel;
        private VenteModel $VenteModel;
        public function __construct() {
            parent::__construct();
            if (!Autorisation::isConnect()) {
                parent::redirectToRoute("action=show-form&controller=security");
            }
            $this->articleModel = new ArticleModel;
            $this->clientModel = new ClientModel;
            $this->VenteModel = new VenteModel;
            $this->load();
        }
        private function listerVente(int $page = 0): void {
            $this->renderView("ventes/liste", [
                "reponse" => $this->VenteModel->findAllWithFiltre($page,OFFSET),
                "articles" => $this->articleModel->findAllArticleVente(),
                "clients" => $this->clientModel->findAll(),
                "currentPage" => $page
            ]);
            if (Session::get("panier") != false) {
                Session::get("panier")->clear();
                Session::remove("panier");
            }
        }
        private function listerventeFiltre($date,$articleId,$clientId,$page = 0): void {
            $this->renderView("ventes/liste", [
                "reponse" => $this->VenteModel->findAllWithFiltre($page,OFFSET,$date,$articleId,$clientId),
                "articles" => $this->articleModel->findAllArticleVente(),
                "clients" => $this->clientModel->findAll(),
                "currentPage" => $page
            ]);
        }
        private function chargerFormulaire(): void {
            $this->renderView("ventes/form", [
                "articles" => $this->articleModel->findAllArticleVente(),
                "clients" => $this->clientModel->findAll()
            ]);
        }
        
        public function load() {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == "liste-vente") {
                    $this->listerVente($_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "form-vente") {
                    $this->chargerFormulaire();
                } elseif ($_REQUEST['action'] == "add-articleVente") {
                    $this->ajouterArticleDansVente($_POST);
                } elseif ($_REQUEST['action'] == "add-vente") {
                    $this->ajouterVente();
                } elseif ($_REQUEST['action'] == "listeFiltre-vente") {
                    $this->listerVenteFiltre($_REQUEST['dateFiltre'],$_REQUEST['articleId'],$_REQUEST['clientId'],$_REQUEST['page']);
                }
            } else {
                $this->listerVente();
            }
        }
        public function ajouterArticleDansVente(array $data):void {
            if (Session::get("panier") == false) {
                $panier = new PanierModel;
            } else {
                $panier = Session::get("panier");
            }
            $panier->addArticleVente($this->articleModel->get($data['articleId']),$data['qteVente'],$data['clientId'],$data['observation']);
            Session::add("panier",$panier);
            parent::redirectToRoute("action=form-vente&controller=vente");
        }
        public function ajouterVente():void {
            $panier = Session::get("panier");
            $this->VenteModel->save($panier);
            $panier->clear();
            Session::remove("panier");
            parent::redirectToRoute("action=liste-vente&controller=vente&page=0");
        }
    }
?>