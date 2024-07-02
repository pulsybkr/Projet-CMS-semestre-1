<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon front</title>
        <meta name="description" content="Super site avec une magnifique intégration">
        <link rel="stylesheet" href="http://<?php 
                                    $domain = $_SERVER['HTTP_HOST'];
                                    echo $domain;
                                ?>/Asset/scss/style.css">
    </head>
    <body>
         <main>
            <?php include "../Views/".$this->view.".php";?>
         </main>
         <script src="http://<?php
    $domain = $_SERVER['HTTP_HOST'];
    echo $domain;
    ?>/Asset/script.js"></script>
    </body>
</html>