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
        <li><a href="/dashboard/">Manage page</a></li>
        <li><a href="/dashboard/">Infos Club</a></li>
        <li><a href="/dashboard/">Infos personnel</a></li>
    </ul>
</section>
<main>

</main>