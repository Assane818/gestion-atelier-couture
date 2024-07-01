<?php
    namespace Asn\Core;
    class Validator {
        public static array $errors = [];

        public static function isValide():bool {
            return count(self::$errors) == 0;
        }

        public static function isEmpty(mixed $valueField, string $nameField, string $message = "Le champs est requis"):bool {
            if (empty($valueField)) {
                self::$errors[$nameField] = $message;
                return true;
            }
            return false;
        }

        public static function add(string $key, mixed $message) {
            self::$errors[$key] = $message;
        }

        public static function isEmail(string $valueField, string $nameField, string $message = "Ceci n'est pas un email") {
            if (!filter_var($valueField,FILTER_VALIDATE_EMAIL)) {
                self::$errors[$nameField] = $message;
            }
        }

        public static function isPositif(string $valueField, string $nameField, string $message = "Le champs doit être positif"):bool {
            if ((int)$valueField <= 0) {
                self::$errors[$nameField] = $message;
                return false;
            }
            return true;
        }
    }