<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon front</title>
        <meta name="description" content="Super site avec une magnifique intégration">
        <link rel="stylesheet" href="Asset/scss/style.css">
    </head>
    <body>
        <h1 class="h1">Template Front</h1>
        <!-- intégration de la vue -->
         <main class="main">
            <?php include "../Views/".$this->view.".php";?>
         </main>
    </body>
</html>