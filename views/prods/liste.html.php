<div class="bg-gradient-to-t from-[#c2c9fb] to-[#eea6af] min-h-screen flex items-center justify-center">
  <div class="container mx-auto flex items-center justify-center h-full p-6">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-4xl w-full overflow-hidden">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#eea6af]">Liste des Productions</h1>
        <button class="bg-[#eea6af] text-white px-5 py-2 rounded-full hover:bg-[#c2c9fb] transition duration-300">
          <a href="<?= WEBROOT ?>?action=form-prod&controller=prod">Ajouter</a>
        </button>
      </div>
      <form class="mb-6" action="<?=WEBROOT?>" method="get">
        <div class="flex gap-4">
          <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Filtrer par Date</label>
            <input type="date" id="date" name="dateFiltre" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#fbc2eb] focus:border-transparent sm:text-sm bg-white transition duration-300" <?php if (isset($_REQUEST['dateFiltre'])) echo 'value="'.$_REQUEST['dateFiltre'].'"';?>>
          </div>
          <div>
            <label for="article" class="block text-sm font-medium text-gray-700">Filtrer par Article</label>
            <select id="article" name="articleId" class="mt-1 block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#fbc2eb] focus:border-transparent sm:text-sm bg-white transition duration-300">
              <option value="">Sélectionnez un article</option>
              <?php foreach ($articles as $article) : ?>
                <option value="<?= $article['articleId'] ?>" <?php if (isset($_REQUEST['articleId']) && $article['articleId'] == $_REQUEST['articleId']) echo 'selected'?>><?= $article['libelle'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="flex items-end">
            <input type="hidden" name="action" value="listeFiltre-prod">
            <input type="hidden" name="controller" value="prod">
            <input type="hidden" name="page" value="0">
            <button type="submit" class="bg-[#eea6af] text-white px-5 py-2 rounded-full hover:bg-[#c2c9fb] transition duration-300">Filtrer</button>
          </div>
        </div>
      </form>
      <div class="overflow-auto max-h-[500px]">
        <table class="min-w-full bg-white border">
          <thead class="bg-[#eea6af] text-white">
            <tr>
              <th class="py-2 px-4 border-b min-w-[150px]">Date</th>
              <th class="py-2 px-4 border-b min-w-[100px]">Montant</th>
              <th class="py-2 px-4 border-b min-w-[150px]">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reponse['data'] as $prod) :
              $date = new DateTime($prod['date']); ?>
              <tr class="bg-gray-100 hover:bg-gray-200 transition duration-300">
                <td class="py-2 px-4 border-b text-center"><?= $date->format('d-m-Y') ?></td>
                <td class="py-2 px-4 border-b text-center"><?= $prod['montant'] ?></td>
                <td class="py-2 px-4 border-b flex items-center justify-center gap-2">
                  <form action="<?= WEBROOT ?>" method="post">
                    <input type="hidden" name="action" value="detail-prod">
                    <input type="hidden" name="productionId" value="<?= $prod['productionId'] ?>">
                    <input type="hidden" name="controller" value="prod">
                    <div class="p-2 bg-green-100 rounded-full">
                      <button type="submit" name="btnViewDetails">
                        <i class="fas fa-eye text-green-500 cursor-pointer hover:text-green-600 transition duration-300"></i>
                      </button>
                    </div>
                  </form>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <?php if ($reponse['pages'] > 1): ?>
        <div class="flex justify-center mt-6">
          <nav class="inline-flex space-x-2">
            <a href="<?=WEBROOT?>?action=listeFiltre-prod&controller=prod&dateFiltre=<?php if (isset($_GET['dateFiltre'])) echo $_GET['dateFiltre']?>&articleId=<?php if (isset($_GET['articleId'])) echo $_GET['articleId']?>&page=<?php if ($currentPage == 0) echo 0; else echo $currentPage-1?>" class="inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-200 transition duration-300">
              <i class="fas fa-chevron-left"></i>
            </a>
            <?php for ($i=0; $i < $reponse['pages'] ; $i++) :?>
              <a href="<?=WEBROOT?>?action=listeFiltre-prod&controller=prod&dateFiltre=<?php if (isset($_GET['dateFiltre'])) echo $_GET['dateFiltre']?>&articleId=<?php if (isset($_GET['articleId'])) echo $_GET['articleId']?>&page=<?=$i?>" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 transition duration-300<?php if ($i == $currentPage) echo"text-white bg-[#eea6af] border border-[#eea6af]";else echo "text-gray-700 bg-white border border-gray-" ?>"><?= $i+1?></a>
            <?php endfor ?>
            <a href="<?=WEBROOT?>?action=listeFiltre-prod&controller=prod&dateFiltre=<?php if (isset($_GET['dateFiltre'])) echo $_GET['dateFiltre']?>&articleId=<?php if (isset($_GET['articleId'])) echo $_GET['articleId']?>&page=<?php if ($currentPage == $reponse['pages']-1) echo $reponse['pages']-1; else echo $currentPage+1?>" class="inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-200 transition duration-300">
              <i class="fas fa-chevron-right"></i>
            </a>
          </nav>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>
