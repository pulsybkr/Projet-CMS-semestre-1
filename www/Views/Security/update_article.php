<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Article</title>
</head>
<body>
    <h1 class="title-page">Modifier un Article</h1>
    <?php if (isset($articleData)): ?>
    <form method="POST" class="form-container">
        <div>
            <label for="title">Titre de l'article:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($articleData['title']) ?>" required minlength="5" maxlength="255">
        </div>
        <div>
            <label for="author">Auteur de l'article:</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($articleData['author']) ?>" required minlength="2" maxlength="100">
        </div>
        <div>
            <label for="content">Contenu de l'article:</label>
            <textarea id="content" name="content" required minlength="20" maxlength="5000" rows="10" cols="50"><?= htmlspecialchars($articleData['content']) ?></textarea>
        </div>
        <div>
            <button type="submit" class="button button--primary button--sm">Mettre à jour l'article</button>
        </div>
    </form>
    <?php else: ?>
        <p>Article introuvable.</p>
    <?php endif; ?>
</body>
</html>