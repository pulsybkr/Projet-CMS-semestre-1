    
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
<h1>Liste des utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <button>
        <a href="/dashboard/invite-user">Inviter des utilisateurs</a>
    </button>
</main>
    