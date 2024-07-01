<?php
    use Asn\Core\Session;
    $erros = [];
    if (Session::get("errors")) {
        $erros = Session::get("errors");
    }
?>
<div class="flex justify-center items-center min-h-screen">
    <div class="max-w-sm w-full bg-white bg-gradient-to-b from-white to-blue-100 rounded-3xl p-8 border-4 border-white shadow-lg m-5">
        <div class="text-center font-black text-3xl text-[#fbc2eb] mb-6">Connexion</div>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 <?= add_class_hidden("error_connexion") ?>" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <span class="block sm:inline"><?= $erros["error_connexion"] ?? "" ?></span>
        </div>
        <form action="<?= WEBROOT ?>" method="post" class="space-y-6">
            <input  class="w-full bg-white border-none p-4 rounded-xl mt-4 shadow-lg focus:outline-none focus:border-blue-400 placeholder-gray-400 <?= add_class_invalid("login") ?>" type="text" name="login" id="login" placeholder="Utilisateur">
            <div id="errorTypeCategorie" class="text-red-500 text-sm mt-1"><?= $erros["login"] ?? "" ?></div>
            <input  class="w-full bg-white border-none p-4 rounded-xl mt-4 shadow-lg focus:outline-none focus:border-blue-400 placeholder-gray-400 <?= add_class_invalid("password") ?>" type="password" name="password" id="password" placeholder="Mot de passe">
            <div id="errorTypeCategorie" class="text-red-500 text-sm mt-1"><?= $erros["password"] ?? "" ?></div>
            <span class="block mt-2 ml-2">
                <a href="#" class="text-xs text-[#fbc2eb] no-underline">Mot de passe oublié ?</a>
            </span>
            <input type="hidden" name="action" value="connexion">
            <input type="hidden" name="controller" value="security">
            <input class="w-full font-bold bg-gradient-to-r from-[#fbc2eb] to-[#c2c9fb] text-white py-3 mt-5 rounded-xl shadow-lg transition-transform transform hover:scale-105 active:scale-95" type="submit" value="Se connecter">
        </form>
    </div>
</div>
<?php Session::remove("errors"); ?>
