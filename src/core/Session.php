<?php
    namespace Asn\Core;
    class Session {
        public static function ouvrir() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
        public static function add(string $key, mixed $data) {
            $_SESSION[$key] = $data;
        }
        public static function remove(string $key):bool {
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
                return true;
            }
            return false;
        }
        public static function get(string $key):mixed {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
            return false;
        }
        public static function fermer() {
            unset($_SESSION['userConnect']);
            session_destroy();
        }
    }