<h1 class="title-page">Article</h1>
    <table class="table-page">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody >
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?php echo htmlspecialchars($article['title']); ?></td>
                    <td>
                        <a class="button button--secondary button--sm" href="article/update-article?id=<?php echo $article['id']; ?>">Modifier</a>
                        <a class="button button--danger button--sm" href="article/delete-article?id=<?php echo $article['id']; ?>">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a class="button button--primary button--lg" href="/dashboard/article/create-article">Ajouter un Article</a>
