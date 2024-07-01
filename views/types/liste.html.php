<?php
    use Asn\Core\Session;
    $erros = [];
    if (Session::get("errors")) {
        $erros = Session::get("errors");
    }
?>

<div class="flex items-center justify-center h-[calc(100vh-5rem)]">
    <div class="container mx-auto flex flex-col items-center justify-center gap-10">
        <div class="bg-white p-10 rounded-lg shadow-lg max-w-2xl w-full overflow-hidden mb-5 mt-5">
            <h1 class="text-2xl font-bold mb-6 text-[#eea6af]">Gestion des types</h1>
            <form class="mb-6" action="<?=WEBROOT?>" method="post">
                <div class="flex flex-col w-full">
                    <div class="flex items-center">
                        <input name="nomType" id="inputTypeCategorie" class="block w-full border border-[#c2c9fb] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#a6c1ee] focus:border-[#a6c1ee] sm:text-sm <?= add_class_invalid("nomType")?>" placeholder="Nom du nouveau type">
                        <button type="submit" class="ml-4 bg-[#eea6af] text-white px-5 py-2 rounded-full hover:bg-[#c2c9fb] transition duration-300" name="btnSave" id="addTypeCategorie">Ajouter</button>
                    </div>
                    <div id="errorTypeCategorie" class="text-red-500 text-sm mt-1"><?=$erros["nomType"]??""?></div>
                </div>
                <input type="hidden" name="action" value="save-type" id="upadteType">
                <input type="hidden" name="controller" value="type">
            </form>
            <div class="overflow-x-auto max-h-[300px] overflow-y-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-[#eea6af] text-white">
                        <tr>
                            <th class="px-4 py-2 border-b">Nom du type</th>
                            <th class="px-4 py-2 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reponse['data'] as $type):?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-6 text-center"><?= $type['nomType']?></td>
                                <td class="px-4 py-2 text-center flex justify-center gap-4">
                                    <form action="<?=WEBROOT?>" method="post">
                                        <div class="p-2 bg-blue-100 rounded-full">
                                            <input type="hidden" name="action" value="listeUpdate-type">
                                            <input type="hidden" name="typeId" value="<?= $type['typeId']?>">
                                            <input type="hidden" name="controller" value="type">
                                            <button type="submit" name="btnUpdate">
                                                <i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer hover:text-blue-600 transition duration-300"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <form action="<?=WEBROOT?>" method="post">
                                        <input type="hidden" name="action" value="delete-type">
                                        <input type="hidden" name="typeId" value="<?= $type['typeId']?>">
                                        <input type="hidden" name="controller" value="type">
                                        <div class="p-2 bg-red-100 rounded-full">
                                            <button type="submit" name="btnDelete">
                                                <i class="fa-solid fa-trash text-red-500 cursor-pointer hover:text-red-600 transition duration-300"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center mt-6">
                <nav class="inline-flex space-x-2">
                    <a href="<?=WEBROOT?>?action=liste-type&controller=type&page=<?php if ($currentPage == 0) echo 0; else echo $currentPage-1?>" class="inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-200 transition duration-300">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <?php for ($i=0; $i < $reponse['pages'] ; $i++) :?>
                        <a href="<?=WEBROOT?>?action=liste-type&controller=type&page=<?=$i?>" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-200 transition duration-300<?php if ($i == $currentPage) echo"text-white bg-[#eea6af] border border-[#eea6af]";else echo "text-gray-700 bg-white border border-gray-" ?>"><?= $i+1?></a>
                    <?php endfor ?>
                    <a href="<?=WEBROOT?>?action=liste-type&controller=type&page=<?php if ($currentPage == $reponse['pages']-1) echo $reponse['pages']-1; else echo $currentPage+1?>" class="inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-200 transition duration-300">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php Session::remove("errors");?>