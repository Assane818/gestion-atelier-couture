<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="./css/output.css">
</head>

<body class="font-[Poppins] bg-gradient-to-t from-[#c2c9fb] to-[#eea6af] h-screen ">
    <header class="bg-white">
        <nav class="flex justify-between items-center w-[92%]  mx-auto">
            <div>
                <img class="w-16 cursor-pointer"  src="<?=WEBROOT?>/img/logo2.png" alt="...">
            </div>
            <div class=" bg-white md:min-h-fit min-h-[60vh] left-0 top-[-100%] md:w-auto  w-full flex items-center px-5">
                <ul class="flex md:flex-row flex-col md:items-center md:gap-[4vw] gap-8 text-[#eea6af]">
                    <li class="<?= has_role("Admin")?>">
                        <a class="hover:text-[#c2c9fb]" href="<?=WEBROOT?>?action=liste-article&controller=article&page=0">Article</a>
                    </li>
                    <li>
                        <a class="hover:text-[#c2c9fb]" href="<?=WEBROOT?>?action=liste-type&controller=type&page=0">Type</a>
                    </li>
                    <li>
                        <a class="hover:text-[#c2c9fb]" href="<?=WEBROOT?>?action=liste-categorie&controller=categorie&page=0">Categorie</a>
                    </li>
                    <li>
                        <a class="hover:text-[#c2c9fb]" href="<?=WEBROOT?>?action=liste-appro&controller=appro&page=0">Approvisonnement</a>
                    </li>
                    <li>
                        <a class="hover:text-[#c2c9fb]" href="<?=WEBROOT?>?action=liste-prod&controller=prod&page=0">Production</a>
                    </li>
                    <li>
                        <a class="hover:text-[#c2c9fb]" href="<?=WEBROOT?>?action=liste-vente&controller=vente&page=0">Vente</a>
                    </li>
                </ul>
            </div>
            <div class="flex items-center gap-6">
                <button class="bg-[#eea6af] text-white px-5 py-2 rounded-full hover:bg-[#c2c9fb]"><a href="<?=WEBROOT?>?action=logout&controller=security">Log Out</a></button>
            </div>
        </nav>
    </header>
    <main>
        
        <?php
            echo $contentView;
        ?>

        
    </main>
    <!-- <script src="./js/script.js"></script> -->
    <!-- <script src="./js/script1.js"></script> -->
</body>

</html>