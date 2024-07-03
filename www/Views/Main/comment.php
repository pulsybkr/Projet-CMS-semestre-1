<h1 class="title-page">Commentaire</h1>
    <table class="table-page">
        <thead>
            <tr>
                <th>Contenu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody >
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment['content']); ?></td>
                    <td>
                        <a class="button button--danger button--sm" href="comment/delete-comment?id=<?php echo $comment['id']; ?>">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a class="button button--primary button--lg" href="/dashboard/article/create-article">Ajouter un Article</a>
