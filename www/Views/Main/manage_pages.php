<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pages</title>
</head>
<body>
    <h1>Manage Pages</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pages)): ?>
                <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?php echo htmlspecialchars($page['title']); ?></td>
                    <td>
                        <a href="manage-pages/build-page?id=<?php echo $page['id']; ?>">Edit</a>
                        <a href="manage-pages/delete-page?id=<?php echo $page['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="/dashboard/manage-pages/create-page">Create New Page</a>
</body>
</html>
