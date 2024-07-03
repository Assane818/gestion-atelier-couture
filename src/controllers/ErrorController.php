<?php
    namespace Asn\Controllers;
    use Asn\Core\Controller;
    class ErrorController extends Controller {
        public function __construct() {
            parent::__construct();
            $this->layout = "errors";
            $this->load();

        }
        public function load() {
           $this->showPage(); 
        }

        public function showPage() {
            parent::renderView("errors/404");
        }
        
    }