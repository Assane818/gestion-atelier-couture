<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    use Asn\Model\ArticleModel;
    use Asn\Model\TypeModel;
    use Asn\Model\CategorieModel;
    use Asn\Core\Session;
    use Asn\Core\Validator;
    use Asn\Core\Autorisation;
    class ArticleController extends Controller {
        private  ArticleModel $articleModel;
        private  TypeModel $typeModel;
        private  CategorieModel $categorieModel;
        public function __construct() {
            parent::__construct();
            if (!Autorisation::isConnect()) {
                parent::redirectToRoute("action=show-form&controller=security");
            } if (!Autorisation::hasRole("Admin")) {
                parent::redirectToRoute("action=logout&controller=security");
            }
            $this->articleModel = new ArticleModel;
            $this->typeModel = new TypeModel;
            $this->categorieModel = new CategorieModel;
            $this->load();
        }
        private function listerArticle(int $page = 0): void {
            $this->renderView("articles/liste", [
                "reponse" => $this->articleModel->findAllWithPaginate($page,OFFSET),
                "currentPage" => $page
            ]);
        }
        private function chargerFormulaire(): void {
            $this->renderView("articles/form", [
                "categories" => $this->categorieModel->findAll(),
                "types" => $this->typeModel->findAll()
            ]);          
        }
        
        private function store(array $article):void {
            Validator::isEmpty($article["libelle"],"libelle");
            Validator::isEmpty($article["qteStock"],"qteStock");
            Validator::isEmpty($article["prixAppro"],"prixAppro");
            if (Validator::isValide()) {
                $articleExiste = $this->articleModel->findByNameArticle($article["libelle"]);
                if ($articleExiste) {
                    Validator::add("libelle","La valeur existe deja");
                    Session::add("errors",Validator::$errors);
                } else {
                    Validator::isPositif($article["qteStock"],"qteStock");
                    Validator::isPositif($article["prixAppro"],"prixAppro");
                    if (Validator::isValide()) {
                        $this->articleModel->save($article);
                        parent::redirectToRoute("action=liste-article&controller=article&page=0");
                    } else {
                        Session::add("errors",Validator::$errors);
                    }
                }  
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=form-article&controller=article");
            
        }
        private function supprimer(array $article):void {
            $this->articleModel->delete($article);
            parent::redirectToRoute("action=liste-article&controller=article&page=0");
        }
        private function modifier(array $article):void {
            Validator::isEmpty($article["libelle"],"libelle");
            Validator::isEmpty($article["qteStock"],"qteStock");
            Validator::isEmpty($article["prixAppro"],"prixAppro");
            if (Validator::isValide()) {
                $articleExiste = $this->articleModel->findByNameArticle($article["libelle"]);
                if ($articleExiste) {
                    Validator::add("libelle","La valeur existe deja");
                    Session::add("errors",Validator::$errors);
                } else {
                    Validator::isPositif($article["qteStock"],"qteStock");
                    Validator::isPositif($article["prixAppro"],"prixAppro");
                    if (Validator::isValide()) {
                        $this->articleModel->update($article);
                        parent::redirectToRoute("action=liste-article&controller=article&page=0");
                    } else {
                        Session::add("errors",Validator::$errors);
                    }
                }  
            } else {
                Session::add("errors",Validator::$errors);
            }
            parent::redirectToRoute("action=formupdate-article&controller=article&articleId=".$article['articleId']);
        }
        private function chargerFormulaireUpdate(int $id):void {
            $this->renderView("articles/formUpdate", [
                "categories" => $this->categorieModel->findAll(),
                "types" => $this->typeModel->findAll(),
                "article" => $this->getArticle($id)
            ]);
            
        }
        private function getArticle(int $id):array {
            return $this->articleModel->get($id);
        }
        public function load() {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == "liste-article") {
                    $this->listerArticle($_REQUEST['page']);
                } elseif ($_REQUEST['action'] == "form-article") {
                    $this->chargerFormulaire();
                } elseif ($_REQUEST['action'] == "save-article") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnSave']);
                    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                        $fileName = $_FILES['image']['name'];
                        $tempName = $_FILES['image']['tmp_name'];
                        $folder = 'C:\\Users\\assan\\OneDrive\\Documents\\ges_atelier_couture\\public\\img\\' . $fileName;
                        if (move_uploaded_file($tempName, $folder)) {
                            $_REQUEST['image'] = $fileName;
                        } else {
                            $erros['image'] = 'Échec du téléchargement de l\'image.';
                            Session::add("errors", $erros);
                        }
                    }
                    $this->store($_REQUEST);
                } elseif ($_REQUEST['action'] == "delete-article") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnDelete']);
                    $this->supprimer($_REQUEST);
                } elseif ($_REQUEST['action'] == "formupdate-article") {
                    unset($_REQUEST['action']);
                    $this->chargerFormulaireUpdate($_REQUEST['articleId']);
                } elseif ($_REQUEST['action'] == "update-article") {
                    unset($_REQUEST['action']);
                    unset($_REQUEST['btnUpdate']);
                    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                        $fileName = $_FILES['image']['name'];
                        $tempName = $_FILES['image']['tmp_name'];
                        $folder = 'C:\\Users\\assan\\OneDrive\\Documents\\ges_atelier_couture\\public\\img\\' . $fileName;
                        if (move_uploaded_file($tempName, $folder)) {
                            $_REQUEST['image'] = $fileName;
                        } else {
                            $erros['image'] = 'Échec du déchargement de l\'image.';
                            Session::add("errors", $erros);
                        }
                    } else {
                        $image = $this->getArticle($_REQUEST['articleId'])['image'];
                        $_REQUEST['image'] = $image;
                    }
                    $this->modifier($_REQUEST);
                } else {
                    new ErrorController();
                }
            } else {
                $this->listerArticle();
            }
        }
    }
?>