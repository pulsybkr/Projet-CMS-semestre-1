<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tableau de bord</title>
        <meta name="description" content="le site de ton club de foot preferé">
        <link rel="stylesheet" href="http://localhost/Asset/scss/style.css">
    </head>
    <body>
    <header class="header">
        <?php if (!empty($club)): ?>
            <h2>
                <?php echo htmlspecialchars($club->getName()); ?>
            </h2>
        <?php endif; ?>
        <h3>Tableau de bord</h3>
        <button>User</button>
    </header>
    <section class="nav">
        <ul>
            <li><a href="/dashboard/">Tableau de bord</a></li>
            <li><a href="/dashboard/user">Utilisateur</a></li>
            <li><a href="/dashboard/manages-pages">Manage page</a></li>
            <li><a href="/dashboard/">Infos Club</a></li>
            <li><a href="/dashboard/profil">Profil</a></li>
        </ul>
    </section>
        <!-- intégration de la vue -->
        <main class="main">
            <?php include "../Views/".$this->view.".php";?>
         </main>
    </body>
</html>