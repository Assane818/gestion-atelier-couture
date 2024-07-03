<?php
    namespace Asn\Core;
    use Asn\Api\CategorieController as ApiCategorieController;
    use Asn\Controllers\ArticleController;
    use Asn\Controllers\TypeController;
    use Asn\Controllers\CategorieController;
    use Asn\Controllers\SecuriteController;
    use Asn\Controllers\ApprovisionnementController;
    use Asn\Controllers\ErrorController;
    use Asn\Controllers\ProductionController;
    use Asn\Controllers\VenteController;

    class Router {
        public static function run() {
            if (isset($_REQUEST['controller'])) {
                if ($_REQUEST['controller'] == "article") {
                    $Controller = new ArticleController();
                } elseif ($_REQUEST['controller'] == "type") {
                    $Controller = new TypeController();
                } elseif ($_REQUEST['controller'] == "categorie") {
                    $Controller = new CategorieController();
                } elseif ($_REQUEST['controller'] == "security") {
                    $Controller = new SecuriteController();
                } elseif ($_REQUEST['controller'] == "api-categorie") {
                    $Controller = new ApiCategorieController();
                } elseif ($_REQUEST['controller'] == "appro") {
                    $Controller = new ApprovisionnementController();
                } elseif ($_REQUEST['controller'] == "prod") {
                    $Controller = new ProductionController();
                } elseif ($_REQUEST['controller'] == "vente") {
                    $Controller = new VenteController();
                } else {
                    $Controller = new ErrorController;
                }
            } else {
                $Controller = new SecuriteController();
            }
        }
    }
?>