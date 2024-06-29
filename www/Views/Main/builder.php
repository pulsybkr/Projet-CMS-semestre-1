<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder</title>
    <link href="styles.css" rel="stylesheet">
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet"/>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        #gjs {
            height: 100%;
        }
    </style>
</head>
<body>
    <?php if (!empty($page)): ?>
        <form id="editForm" method="post" action="">
            <div id="gjs"><?php echo $page['content']; ?></div>
            <input class="button" type="hidden" name="content" id="content">
            <button type="submit">Save Page</button>
        </form>
        <script src="https://unpkg.com/grapesjs"></script>
        <script>
            const editor = grapesjs.init({
                container: '#gjs',
                fromElement: true,
                height: '100vh',
                width: 'auto',
                storageManager: { type: null },
                plugins: ['gjs-preset-webpage'],
                pluginsOpts: {
                    'gjs-preset-webpage': { /* options */ }
                },
            });

            // Ajouter des blocs personnalisés
            editor.BlockManager.add('my-block', {
                label: 'Simple Block',
                content: '<div class="my-block">This is a simple block</div>',
                category: 'Basic',
            });

            editor.BlockManager.add('my-button', {
                label: 'Button',
                content: '<button class="my-button">Click me</button>',
                category: 'Basic',
            });

            editor.BlockManager.add('my-menu', {
                label: 'Menu',
                content: `
                    <nav class="my-menu">
                        <ul>
                         <?php if (!empty($pages)): ?>
                            <?php foreach ($pages as $page): ?>
                            <li><a href="/front/<?php echo $page['type']; ?>"><?php echo $page['title']; ?></a></li>
                           <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </nav>
                `,
                category: 'Basic',
            });
            
            document.getElementById('editForm').addEventListener('submit', function () {
            const htmlContent = editor.getHtml();
            const cssContent = editor.getCss();
            const content = `<style>${cssContent}</style>${htmlContent}`;
            document.getElementById('content').value = content;
            });
        </script>
        <!-- <script>
             function saveContent() {
                const htmlContent = editor.getHtml();
                const cssContent = editor.getCss();
                const content = `<style>${cssContent}</style>${htmlContent}`;

                fetch('update_page.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ content: content, id:  })
                }).then(response => response.json())
                .then(data => alert(data.message));

                console.log(content)
            }
        </script>
        <button onclick="saveContent()">Save Page</button> -->
    <?php endif; ?>
</body>
</html>
