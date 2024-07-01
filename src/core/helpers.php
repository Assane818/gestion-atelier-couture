<?php
    use Asn\Core\Session;
    use Asn\Core\Autorisation;
    function add_class_invalid(string $fieldName):void {
        echo isset(Session::get("errors")[$fieldName])? "mt-2 text-sm text-red-600 text-red-500 border-red-600 border-red-50 placeholder-red-700 bg-red-100 p-2 rounded":"";
    }
    function dd(mixed $data) {
        dump($data);die;
    }
    function dump(mixed $data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    function add_class_hidden(string $fieldName):void {
        echo !isset(Session::get("errors")[$fieldName])? "hidden":"";
    }
    function has_role(string $roleName):void {
        echo !Autorisation::hasRole($roleName)? "hidden":"";
    }
