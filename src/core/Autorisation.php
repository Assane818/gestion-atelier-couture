<?php
    namespace Asn\Core;
    use Asn\Core\Session;
    class Autorisation {
        public static function isConnect():bool {
            return Session::get("userConnect") != false;
        }

        public static function hasRole(string $roleName):bool {
            $userConnect =  Session::get("userConnect");
            if ($userConnect) {
                return $userConnect['name'] == $roleName;
            } else {
                return false;
            }
            
        }
    }
    