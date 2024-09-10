<div class="bg-gradient-to-t from-[#c2c9fb] to-[#eea6af] min-h-screen flex items-center justify-center">
    <div class="container mx-auto flex items-center justify-center h-full p-6">
        <div class="bg-white p-10 rounded-lg shadow-lg max-w-4xl w-full overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#eea6af]">Détail de la production</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-2 text-[#eea6af]">Informations de l'utilisateur</h2>
                    <p><strong>Nom:</strong> <?= $reponse['prod']['nomComplet'] ?></p>
                    <p><strong>Email:</strong> <?= $reponse['prod']['login'] ?></p>
                    <p><strong>Role:</strong> <?= $reponse['prod']['name'] ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md col-span-2">
                    <p><strong>Date:</strong> <?= $reponse['prod']['date'] ?></p>
                    <p><strong>Montant:</strong> <span class="text-green-600"><?= $reponse['prod']['montant'] ?> FCFA</span></p>
                    <p><strong>Observation:</strong> <?= $reponse['prod']['observation'] ?></p>
                </div>
            </div>
            <div class="mt-6 text-center overflow-x-auto">
                <h2 class="text-xl font-semibold mb-2 text-[#eea6af]">Liste des articles</h2>
            </div>
            <div class="flex flex-nowrap space-x-6 overflow-x-auto">
                <div class="flex flex-wrap justify-center space-x-6">
                    <?php foreach ($reponse['detail'] as $article) : ?>
                        <div class="flex-none min-w-[250px] bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 mb-6">
                        <div class="flex justify-center mb-4">
                            <img src="<?= WEBROOT ?>/img/<?= $article['image'] ?>" alt="<?= $article['libelle'] ?>" class="w-32 h-32 object-cover rounded-full">
                        </div>
                            <h3 class="text-lg font-bold mb-2 text-center text-gray-800"><?= $article['libelle'] ?></h3>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Quantité:</span>
                                <span><?= $article['qteProd'] ?></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Prix:</span>
                                <span><?= $article['prixAppro'] ?> FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Montant:</span>
                                <span class="text-green-600"><?= $article['prixAppro'] * $article['qteProd'] ?> FCFA</span>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="mt-7 text-center mb-2">
                <a href="<?= WEBROOT ?>?action=liste-prod&controller=prod&page=0" class="bg-[#eea6af] text-white w-full px-5 py-2 mb-1 rounded-full hover:bg-[#c2c9fb] transition duration-300">Retour</a>
            </div>
        </div>
    </div>
</div>


