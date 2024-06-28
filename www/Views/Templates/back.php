<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ceci est mon back</title>
        <meta name="description" content="Super site avec une magnifique intégration">
    </head>
    <body>
    <header>
    <?php if (!empty($club)): ?>
            <h2>
                <?php echo htmlspecialchars($club->getName()); ?>
            </h2>
        <?php endif; ?>
        <h3>Tableau de bord</h3>
        <button>User</button>
    </header>
    <section>
        <ul>
            <li><a href="/dashboard/">Tableau de bord</a></li>
            <li><a href="/dashboard/user">Utilisateur</a></li>
            <li><a href="/dashboard/manages-pages">Manage page</a></li>
            <li><a href="/dashboard/">Infos Club</a></li>
            <li><a href="/dashboard/">Infos personnel</a></li>
        </ul>
    </section>
        <!-- intégration de la vue -->
        <main>
            <?php include "../Views/".$this->view.".php";?>
        </main>
    </body>
</html>