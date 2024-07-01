<?php
    namespace Asn\Core;
    use Asn\Core\Session;
    class Controller {
        protected string $layout;
        public function __construct() {
            $this->layout = "base";
            Session::ouvrir();
        }
        public function redirectToRoute(string $path) {
            header("location:".WEBROOT."?$path");
            exit;
        }
        public function renderView(string $view, array $data = []) {
            ob_start();
            extract($data);
            require_once("../views/$view.html.php");
            $contentView = ob_get_clean();
            require_once("../views/layout/$this->layout.layout.php");
        }
        public function renderJson(array $data = []) {
            echo json_encode($data);
        }
        public function renderArray() {
            dd(file_get_contents('php://input'));
            echo json_decode(file_get_contents('php://input'), true);
        }
    }
?>