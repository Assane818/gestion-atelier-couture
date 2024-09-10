<div class="bg-gradient-to-t from-[#c2c9fb] to-[#eea6af] min-h-screen flex items-center justify-center">
  <div class="container mx-auto flex items-center justify-center h-full p-6">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-4xl w-full overflow-hidden">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#eea6af]">Liste des articles</h1>
        <button class="bg-[#eea6af] text-white px-5 py-2 rounded-full hover:bg-[#c2c9fb] transition duration-300">
          <a href="<?= WEBROOT ?>?action=form-article&controller=article">Ajouter</a>
        </button>
      </div>
      <div class="max-h-[500px] overflow-y-auto">
        <table class="table-fixed w-full bg-white border">
          <thead class="bg-[#eea6af] text-white">
            <tr>
              <th class="py-2 px-4 border-b">Libellé</th>
              <th class="py-2 px-4 border-b">Qte Stock</th>
              <th class="py-2 px-4 border-b">Prix</th>
              <th class="py-2 px-4 border-b">Categorie</th>
              <th class="py-2 px-4 border-b">Type</th>
              <th class="py-2 px-4 border-b">Image</th>
              <th class="py-2 px-4 border-b">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reponse['data'] as $article) : ?>
              <tr class="bg-gray-100 hover:bg-gray-200 transition duration-300">
                <td class="py-2 px-4 border-b text-center"><?= $article['libelle'] ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $article['qteStock'] ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $article['prixAppro'] ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $article['nomCategorie'] ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $article['nomType'] ?></td>
                <td class="py-2 px-4 border-b text-center"><img src="<?=WEBROOT.'/img/'.$article['image']?>" alt="Image de l'article" class="w-16 h-16 object-cover"></td>
                <td class="py-2 px-4 border-b flex items-center justify-center gap-2">
                  <form action="<?= WEBROOT ?>" method="post">
                    <input type="hidden" name="action" value="formupdate-article">
                    <input type="hidden" name="articleId" value="<?= $article['articleId'] ?>">
                    <input type="hidden" name="controller" value="article">
                    <div class="p-2 bg-blue-100 rounded-full">
                      <button type="submit" name="btnUpdate">
                        <i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer hover:text-blue-600 transition duration-300"></i>
                      </button>
                    </div>
                  </form>
                  <form action="<?= WEBROOT ?>" method="post">
                    <input type="hidden" name="action" value="delete-article">
                    <input type="hidden" name="articleId" value="<?= $article['articleId'] ?>">
                    <input type="hidden" name="controller" value="article">
                    <div class="p-2 bg-red-100 rounded-full">
                      <button type="submit" name="btnDelete">
                        <i class="fa-solid fa-trash text-red-500 cursor-pointer hover:text-red-600 transition duration-300"></i>
                      </button>
                    </div>
                  </form>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-6">
        <nav class="inline-flex space-x-2">
          <a href="<?=WEBROOT?>?action=liste-article&controller=article&page=<?php if ($currentPage == 0) echo 0; else echo $currentPage-1?>" class="inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-200 transition duration-300">
            <i class="fas fa-chevron-left"></i>
          </a>
          <?php for ($i=0; $i < $reponse['pages'] ; $i++) :?>
            <a href="<?=WEBROOT?>?action=liste-article&controller=article&page=<?=$i?>" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 transition duration-300<?php if ($i == $currentPage) echo"text-white bg-[#eea6af] border border-[#eea6af]";else echo "text-gray-700 bg-white border border-gray-" ?>"><?= $i+1?></a>
          <?php endfor ?>
          <a href="<?=WEBROOT?>?action=liste-article&controller=article&page=<?php if ($currentPage == $reponse['pages']-1) echo $reponse['pages']-1; else echo $currentPage+1?>" class="inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-200 transition duration-300">
            <i class="fas fa-chevron-right"></i>
          </a>
        </nav>
      </div>
    </div>
  </div>
</div>


