<?php
    namespace Asn\Core;
    use Asn\Api\CategorieController as ApiCategorieController;
    use Asn\Controllers\ArticleController;
    use Asn\Controllers\TypeController;
    use Asn\Controllers\CategorieController;
    use Asn\Controllers\SecuriteController;
    use Asn\Controllers\ApprovisionnementController;
    use Asn\Controllers\ProductionController;
    use Asn\Controllers\VenteController;

    class Router {
        public static function run() {
            if (isset($_REQUEST['controller'])) {
                if ($_REQUEST['controller'] == "article") {
                    new ArticleController();
                } elseif ($_REQUEST['controller'] == "type") {
                    new TypeController();
                } elseif ($_REQUEST['controller'] == "categorie") {
                    new CategorieController();
                } elseif ($_REQUEST['controller'] == "security") {
                    new SecuriteController();
                } elseif ($_REQUEST['controller'] == "api-categorie") {
                    new ApiCategorieController();
                } elseif ($_REQUEST['controller'] == "appro") {
                    new ApprovisionnementController();
                } elseif ($_REQUEST['controller'] == "prod") {
                    new ProductionController();
                } elseif ($_REQUEST['controller'] == "vente") {
                    new VenteController();
                }
            } else {
                new SecuriteController();
            }
        }
    }
?>