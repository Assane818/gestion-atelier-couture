
<div class="bg-gradient-to-t from-[#c2c9fb] to-[#eea6af] min-h-screen flex items-center justify-center">
    <div class="container mx-auto flex flex-col items-center justify-center h-full gap-10">
        <div class="bg-white p-10 rounded-lg shadow-lg max-w-2xl w-full overflow-auto mb-5 mt-5">
            <h1 class="text-3xl font-bold mb-6 text-center text-[#eea6af]">Ajouter une Vente</h1>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-7 mt-1" <?= add_class_hidden("panier") ?> role="alert">
                <strong class="font-bold">Erreur!</strong>
                <span class="block sm:inline"><?= $erros["panier"] ?? "" ?></span>
            </div>
            <form class="space-y-6" action="<?= WEBROOT ?>" method="post">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                        <select id="client" name="clientId" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#eea6af] focus:border-transparent sm:text-sm bg-white hover:bg-[#eea6af] transition duration-300">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?= $client['clientId'] ?>"><?= $client['nom'] . ' ' . $client['prenom'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="article" class="block text-sm font-medium text-gray-700">Article</label>
                        <select id="article" name="articleId" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#eea6af] focus:border-transparent sm:text-sm bg-white hover:bg-[#eea6af] transition duration-300">
                            <?php foreach ($articles as $article) : ?>
                                <option value="<?= $article['articleId'] ?>"><?= $article['libelle'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="w-1/4">
                        <label for="qteProd" class="block text-sm font-medium text-gray-700">Quantité</label>
                        <input type="text" name="qteVente" id="qteVente" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#eea6af] focus:border-[#eea6af] sm:text-sm <?= add_class_invalid("qteProd") ?>" placeholder="Quantité">
                        <div id="errorQuantite" class="text-red-500 text-sm mt-1"><?= $erros["qteProd"] ?? "" ?></div>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="observation" class="block text-sm font-medium text-gray-700">Observation</label>
                    <textarea id="observation" name="observation" rows="4" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#eea6af] focus:border-transparent sm:text-sm bg-white resize-none <?= add_class_invalid("observation") ?>" placeholder="Observation"><?php use Asn\core\Session; if (Session::get("panier") != false) echo Session::get("panier")->observation?></textarea>
                    <div id="errorObservation" class="text-red-500 text-sm mt-1"><?= $erros["observation"] ?? "" ?></div>
                </div>

                <div class="flex justify-end mt-4">
                    <input type="hidden" name="action" value="add-articleVente">
                    <input type="hidden" name="controller" value="vente">
                    <button type="submit" class="bg-[#eea6af] text-white px-5 py-2 mb-1 rounded-full hover:bg-[#c2c9fb] transition duration-300" name="btnSave" id="addArticle">Ajouter</button>
                </div>

                <?php 
                if (Session::get("panier") != false) :?>
                    <div class="overflow-x-auto mt-6">
                        <div class="flex space-x-6">
                            <?php foreach (Session::get("panier")->articles as $article) : ?>
                                <div class="min-w-[250px] bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                                    <h3 class="text-lg font-bold mb-2 text-center text-gray-800"><?= $article['libelle'] ?></h3>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-semibold">Quantité:</span>
                                        <span><?= $article['qteVente'] ?></span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="font-semibold">Prix:</span>
                                        <span><?= $article['prixAppro'] ?> FCFA</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-semibold">Montant:</span>
                                        <span class="text-green-600"><?= $article['montantArticle'] ?> FCFA</span>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <span class="text-xl font-semibold text-black">Total: <span id="totalAmount" class="text-green-600"><?php if (Session::get("panier") != false) echo Session::get("panier")->total; else echo "0" ?></span> FCFA</span> 
                    </div>
                <?php endif; ?>
                <div class="flex gap-4 w-full mt-4">
                    <button type="button" class="text-[#eea6af] w-full px-5 py-2 mb-1 rounded-full hover:text-[#c2c9fb] border border-[#eea6af] hover:border-[#c2c9fb] transition duration-300"><a href="<?= WEBROOT ?>?action=liste-prod&controller=prod&page=0">Annuler</a></button>
                    <button type="button" class="bg-[#eea6af] text-white w-full px-5 py-2 mb-1 rounded-full hover:bg-[#c2c9fb] transition duration-300" name="" id="addArticle"><a href="<?= WEBROOT ?>?action=add-vente&controller=vente">Enregistrer</a></button>
                </div>
            </form>
        </div>
    </div>
</div>




