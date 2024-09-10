<?php
  use Asn\Core\Session;
  $erros = [];
  if (Session::get("errors")) {
    $erros = Session::get("errors");
  }
?>

<div class="bg-gradient-to-t from-[#c2c9fb] to-[#eea6af]">
  <div class="flex items-center justify-center h-screen">
    <div class="container mx-auto flex flex-col items-center justify-center h-full gap-10">
      <div class="bg-white p-10 rounded-lg shadow-lg max-w-2xl w-full overflow-auto mb-5 mt-5">
        <h1 class="text-2xl font-bold mb-6">Ajouter un article</h1>
        <form class="space-y-6" action="<?= WEBROOT ?>" method="post">
          <div>
            <label for="libelle" class="block text-sm font-medium text-gray-700">libelle</label>
            <input type="text" id="inputLibelle" name="libelle" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#a6c1ee] focus:border-[#a6c1ee] sm:text-sm <?= add_class_invalid("libelle")?>" placeholder="Libelle de l'article" value="<?= $article['libelle'] ?>">
            <div id="errorLibelle" class="text-red-500 text-sm mt-1"><?=$erros["libelle"]??""?></div>
          </div>
          <div>
            <label for="qte" class="block text-sm font-medium text-gray-700">Quantite</label>
            <input id="inputQuantite" name="qteStock" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#a6c1ee] focus:border-[#a6c1ee] sm:text-sm <?= add_class_invalid("qteStock")?>" placeholder="Quantite en stock" value="<?= $article['qteStock'] ?>">
            <div id="errorQuantite" class="text-red-500 text-sm mt-1"><?=$erros["qteStock"]??""?></div>
          </div>
          <div>
            <label for="prix" class="block text-sm font-medium text-gray-700">Prix</label>
            <input type="text" id="inputPrix" name="prixAppro" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#a6c1ee] focus:border-[#a6c1ee] sm:text-sm <?= add_class_invalid("prixAppro")?>" placeholder="Prix de l'article" value="<?= $article['prixAppro'] ?>">
            <div id="errorPrix" class="text-red-500 text-sm mt-1"><?=$erros["prixAppro"]??""?></div>
          </div>
          <div>
            <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
            <select id="categorie" name="categorieId" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#eea6af] focus:border-transparent sm:text-sm bg-white hover:bg-[#eea6af] transition duration-300">
              <?php foreach ($categories as $categorie) : ?>
                <option value="<?= $categorie['categorieId'] ?>" <?php if ($categorie['categorieId'] == $article['categorieId']) echo "selected"; ?>><?= $categorie['nomCategorie'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select id="type" name="typeId" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#eea6af] focus:border-transparent sm:text-sm bg-white hover:bg-[#eea6af] transition duration-300">
              <?php foreach ($types as $type) : ?>
                <option value="<?= $type['typeId'] ?>" <?php if ($type['typeId'] == $article['typeId']) echo "selected"; ?>><?= $type['nomType'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image de l'article</label>
            <input type="file" name="image" id="inputImage" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#a6c1ee] focus:border-[#a6c1ee] sm:text-sm <?= add_class_invalid("image")?>">
            <div id="errorImage" class="text-red-500 text-sm mt-1"><?=$erros["image"]??""?></div>
          </div>
          <div class="flex justify-end">
            <input type="hidden" name="action" value="update-article">
            <input type="hidden" name="articleId" value="<?= $article['articleId'] ?>">
            <input type="hidden" name="controller" value="article">
            <button type="button" class="text-[#eea6af] px-5 py-2 rounded-full hover:text-[#c2c9fb] border border-[#eea6af] hover:border-[#c2c9fb] mr-4 transition duration-300&page=0"><a href="<?= WEBROOT ?>?action=liste-article&controller=article&page=0">Annuler</a></button>
            <button type="submit" class="bg-[#eea6af] text-white px-5 py-2 rounded-full hover:bg-[#c2c9fb] transition duration-300" name="btnUpdate" id="addArticle">Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php Session::remove("errors");?>