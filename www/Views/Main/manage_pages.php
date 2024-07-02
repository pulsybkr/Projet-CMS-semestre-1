<h1 class="title-page">Pages</h1>
    <table class="table-page">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody >
            <?php if (!empty($pages)): ?>
                <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?php echo htmlspecialchars($page['title']); ?></td>
                    <td>
                        <a class="button button--secondary button--sm" href="manage-pages/build-page?id=<?php echo $page['id']; ?>">Modifier</a>
                        <a class="button button--danger button--sm" href="manage-pages/delete-page?id=<?php echo $page['id']; ?>">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a class="button button--primary button--lg" href="/dashboard/manage-pages/create-page">Ajouter une page</a>
