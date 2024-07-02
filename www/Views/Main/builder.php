<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder</title>
    <!-- Assurez-vous que le CSS compilé est correctement lié ici -->
    <link rel="stylesheet" href="http://<?php 
            $domain = $_SERVER['HTTP_HOST'];
            echo $domain;
        ?>/Asset/css/style.css">
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
            <div id="gjs"> 
                <style><?php echo $page['css']; ?></style>
                <?php echo $page['content']; ?>
            </div>
            <input class="button" type="hidden" name="content" id="content">
            <button class="button button--primary button--sm" type="submit">Enregistrer les modifications</button>
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
                    'gjs-preset-webpage': {}
                },
                canvas: {
                    styles: [
                        'http://<?php 
                            $domain = $_SERVER['HTTP_HOST'];
                            echo $domain;
                        ?>/Asset/css/style.css'
                    ]
                }
            });

            // Ajouter des blocs personnalisés
            editor.BlockManager.add('my-block', {
                label: 'Simple Block',
                content: '<div class="my-block">This is a simple block</div>',
                category: 'Basic',
            });

            editor.BlockManager.add('button-small', {
                label: 'Button Small',
                content: '<button class="button button--primary button--sm">Click me</button>',
                category: 'Basic',
            });

            editor.BlockManager.add('button-large', {
                label: 'Button Large',
                content: '<button class="button button--primary button--lg">Click me</button>',
                category: 'Basic',
            });

            editor.BlockManager.add('menu', {
                label: 'Menu',
                content: `
                    <nav class="nav_bar">
                        <div class="logo">
                            <a href="/">Logo</a>
                        </div>
                        <ul>
                            <?php if (!empty($pages)): ?>
                                <?php foreach ($pages as $page): ?>
                                    <li><a href="/front/<?php echo $page["type"]; ?>"><?php echo $page["title"]; ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </nav>
                `,
                category: 'Basic',
            });

            editor.BlockManager.add('header', {
                label: 'Header',
                content: '<h1>Welcome to my website</h1>',
                category: 'Basic',
            });

            editor.BlockManager.add('footer', {
                label: 'Footer',
                content: '<footer class="footer"><p>© 2024 My Website</p></footer>',
                category: 'Basic',
            });

            editor.BlockManager.add('article', {
                label: 'Article',
                content: `
                    <article>
                        <h2>Article Title</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </article>
                `,
                category: 'Basic',
            });

            editor.BlockManager.add('image-gallery', {
                label: 'Image Gallery',
                content: `
                    <div class="image-gallery">
                        <img src="http://placekitten.com/200/300" alt="Kitten 1">
                        <img src="http://placekitten.com/200/300" alt="Kitten 2">
                        <img src="http://placekitten.com/200/300" alt="Kitten 3">
                    </div>
                `,
                category: 'Media',
            });

            editor.BlockManager.add('contact-form', {
                label: 'Contact Form',
                content: `
                    <form class="contact-form">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                        <label for="message">Message</label>
                        <textarea id="message" name="message"></textarea>
                        <button type="submit">Submit</button>
                    </form>
                `,
                category: 'Forms',
            });

            editor.BlockManager.add('login-form', {
                label: 'Login Form',
                content: `
                    <form class="login-form">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">
                        <button type="submit">Login</button>
                    </form>
                `,
                category: 'Forms',
            });

            editor.BlockManager.add('comment-section', {
                label: 'Comment Section',
                content: `
                    <div class="comment-section">
                        <h3>Comments</h3>
                        <div class="comment">
                            <p><strong>User 1:</strong> This is a great post!</p>
                        </div>
                        <div class="comment">
                            <p><strong>User 2:</strong> Thanks for sharing this information.</p>
                        </div>
                        <form class="comment-form">
                            <label for="comment">Add a comment</label>
                            <textarea id="comment" name="comment"></textarea>
                            <button type="submit">Submit</button>
                        </form>
                    </div>
                `,
                category: 'Basic',
            });

            editor.BlockManager.add('image', {
                label: 'Image',
                content: '<img src="http://placekitten.com/200/300" alt="Kitten">',
                category: 'Media',
            });

            editor.BlockManager.add('header-1', {
                label: 'Header 1',
                content: '<h1 class="header-1">Header 1</h1>',
                category: 'Text',
                attributes: { class: 'gjs-fonts gjs-f-h1p' }
            });

            editor.BlockManager.add('header-2', {
                label: 'Header 2',
                content: '<h2 class="header-2">Header 2</h2>',
                category: 'Text',
                attributes: { class: 'gjs-fonts gjs-f-h2p' }
            });

            editor.BlockManager.add('header-3', {
                label: 'Header 3',
                content: '<h3 class="header-3">Header 3</h3>',
                category: 'Text',
                attributes: { class: 'gjs-fonts gjs-f-h3p' }
            });

            editor.BlockManager.add('container-block', {
                label: 'Container Block',
                content: '<div class="container-block" style="padding: 10px; border: 1px solid #ddd; min-height: 100px;"></div>',
                category: 'Layout',
                attributes: { class: 'gjs-fonts gjs-f-b2' }
            });

            editor.DomComponents.addType('container-block', {
                isComponent: el => el.classList && el.classList.contains('container-block'),
                model: {
                    defaults: {
                        tagName: 'div',
                        draggable: true,
                        droppable: true,
                        attributes: { class: 'container-block' },
                        styles: {
                            padding: '10px',
                            border: '1px solid #ddd',
                            minHeight: '100px'
                        },
                    },
                },
            });

            // Bloc Futur Match
            editor.BlockManager.add('future-match', {
                label: 'Futur Match',
                content: `
                    <div class="future-match">
                        <h3>Prochain Match</h3>
                        <p><strong>Date:</strong> 15 juillet 2024</p>
                        <p><strong>Adversaire:</strong> Équipe adverse</p>
                        <p><strong>Lieu:</strong> Stade XYZ</p>
                        <a href="#" class="btn btn-primary">Détails</a>
                    </div>
                `,
                category: 'Events',
                attributes: { class: 'gjs-fonts gjs-f-button' }
            });

            // Bloc Entraînement
            editor.BlockManager.add('training-session', {
                label: 'Entraînement',
                content: `
                    <div class="training-session">
                        <h3>Entraînement</h3>
                        <p><strong>Date:</strong> 20 juillet 2024</p>
                        <p><strong>Heure:</strong> 10:00 - 12:00</p>
                        <p><strong>Lieu:</strong> Centre d'entraînement</p>
                    </div>
                `,
                category: 'Events',
                attributes: { class: 'gjs-fonts gjs-f-button' }
            });

            // Enregistrer le contenu avant de soumettre le formulaire
            document.getElementById('editForm').onsubmit = function() {
                document.getElementById('content').value = editor.getHtml() + "<style>" + editor.getCss() + "</style>";
                return true;
            };
        </script>
    <?php endif; ?>
</body>
</html>
