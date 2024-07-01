<?php

namespace App\Models;

use App\Core\SQL;
use PDO;

class Page extends SQL
{
    private ?int $id = null;
    protected string $title;
    protected string $content;
    protected string $html;
    protected string $css = "/*! modern-normalize v2.0.0 | MIT License | https://github.com/sindresorhus/modern-normalize */
/*
Document
========
*/
/**
Use a better box model (opinionated).
*/
*,
::before,
::after {
  box-sizing: border-box; }

html {
  /* Improve consistency of default fonts in all browsers. (https://github.com/sindresorhus/modern-normalize/issues/3) */
  font-family: system-ui, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji';
  line-height: 1.15;
  /* 1. Correct the line height in all browsers. */
  -webkit-text-size-adjust: 100%;
  /* 2. Prevent adjustments of font size after orientation changes in iOS. */
  -moz-tab-size: 4;
  /* 3. Use a more readable tab size (opinionated). */
  tab-size: 4;
  /* 3 */ }

/*
Sections
========
*/
body {
  margin: 0;
  /* Remove the margin in all browsers. */ }

/*
Grouping content
================
*/
/**
1. Add the correct height in Firefox.
2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
*/
hr {
  height: 0;
  /* 1 */
  color: inherit;
  /* 2 */ }

/*
Text-level semantics
====================
*/
/**
Add the correct text decoration in Chrome, Edge, and Safari.
*/
abbr[title] {
  text-decoration: underline dotted; }

/**
Add the correct font weight in Edge and Safari.
*/
b,
strong {
  font-weight: bolder; }

/**
1. Improve consistency of default fonts in all browsers. (https://github.com/sindresorhus/modern-normalize/issues/3)
2. Correct the odd 'em' font sizing in all browsers.
*/
code,
kbd,
samp,
pre {
  font-family: ui-monospace, SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;
  /* 1 */
  font-size: 1em;
  /* 2 */ }

/**
Add the correct font size in all browsers.
*/
small {
  font-size: 80%; }

/**
Prevent 'sub' and 'sup' elements from affecting the line height in all browsers.
*/
sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline; }

sub {
  bottom: -0.25em; }

sup {
  top: -0.5em; }

/*
Tabular data
============
*/
/**
1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
2. Correct table border color inheritance in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
*/
table {
  text-indent: 0;
  /* 1 */
  border-color: inherit;
  /* 2 */ }

/*
Forms
=====
*/
/**
1. Change the font styles in all browsers.
2. Remove the margin in Firefox and Safari.
*/
button,
input,
optgroup,
select,
textarea {
  font-family: inherit;
  /* 1 */
  font-size: 100%;
  /* 1 */
  line-height: 1.15;
  /* 1 */
  margin: 0;
  /* 2 */ }

/**
Remove the inheritance of text transform in Edge and Firefox.
*/
button,
select {
  text-transform: none; }

/**
Correct the inability to style clickable types in iOS and Safari.
*/
button,
[type='button'],
[type='reset'],
[type='submit'] {
  -webkit-appearance: button; }

/**
Remove the inner border and padding in Firefox.
*/
::-moz-focus-inner {
  border-style: none;
  padding: 0; }

/**
Restore the focus styles unset by the previous rule.
*/
:-moz-focusring {
  outline: 1px dotted ButtonText; }

/**
Remove the additional ':invalid' styles in Firefox.
See: https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737
*/
:-moz-ui-invalid {
  box-shadow: none; }

/**
Remove the padding so developers are not caught out when they zero out 'fieldset' elements in all browsers.
*/
legend {
  padding: 0; }

/**
Add the correct vertical alignment in Chrome and Firefox.
*/
progress {
  vertical-align: baseline; }

/**
Correct the cursor style of increment and decrement buttons in Safari.
*/
::-webkit-inner-spin-button,
::-webkit-outer-spin-button {
  height: auto; }

/**
1. Correct the odd appearance in Chrome and Safari.
2. Correct the outline style in Safari.
*/
[type='search'] {
  -webkit-appearance: textfield;
  /* 1 */
  outline-offset: -2px;
  /* 2 */ }

/**
Remove the inner padding in Chrome and Safari on macOS.
*/
::-webkit-search-decoration {
  -webkit-appearance: none; }

/**
1. Correct the inability to style clickable types in iOS and Safari.
2. Change font properties to 'inherit' in Safari.
*/
::-webkit-file-upload-button {
  -webkit-appearance: button;
  /* 1 */
  font: inherit;
  /* 2 */ }

/*
Interactive
===========
*/
/*
Add the correct display in Chrome and Safari.
*/
summary {
  display: list-item; }

:root {
  --text-color: #000;
  --primary: var(--blue);
  --secondary: var(--grey);
  --danger: var(--red);
  --blue: #0d6efd;
  --white: #fff;
  --grey: #6c757d;
  --red: #dc3545;
  --light-grey: #ccc;
  --bkg_second: #2D2D2D;
  --bkg_primary: #161616;
  --main-radius: 8px;
  --padding-small: 0.5rem 1rem;
  --padding-large: 1rem 2rem; }

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0; }

body {
  background-color: #161616;
  color: #fff;
  font-family: sans-serif;
  width: 100%;
  position: relative; }

a {
  color: inherit !important;
  text-decoration: none !important; }

ul, li {
  list-style: none; }

p {
  line-height: 1.5; }

.home {
  padding: 48px;
  width: 100%;
  height: 100vh;
  display: flex;
  align-items: center; }
  .home .containt {
    display: flex;
    background-color: var(--bkg_second);
    border-radius: 48px;
    height: 100%; }
    .home .containt section {
      width: 50%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 50px; }
      .home .containt section .logo {
        display: flex; }
        .home .containt section .logo img {
          width: 38px;
          margin-right: 16px; }
        .home .containt section .logo h2 {
          font-size: 1rem; }
      .home .containt section h1 {
        font-size: 3rem;
        margin: 16px 0; }
    .home .containt .left {
      width: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 48px;
      background-color: var(--bkg_primary); }
      .home .containt .left .image {
        width: 400px;
        height: 400px;
        border-radius: 48px; }
        .home .containt .left .image img {
          width: 100%;
          height: 100%;
          object-fit: cover; }

#gjs {
  height: 100%; }

.button {
  display: inline-block;
  line-height: 1;
  text-decoration: none;
  border: none;
  cursor: pointer;
  --padding: rem(10) rem(16);
  --fontSize: 1rem;
  font-size: var(--fontSize);
  padding: var(--padding);
  background-color: var(--bg-color);
  color: var(--text-color);
  border-radius: var(--main-radius);
  font-weight: 600; }
  .button--primary {
    --bg-color: var(--primary);
    --text-color: var(--white); }
  .button--secondary {
    --bg-color: var(--secondary);
    --text-color: var(--white); }
  .button--danger {
    --bg-color: var(--danger);
    --text-color: var(--white); }
  .button--lg {
    --padding: rem(16) rem(24); }
  .button--sm {
    --fontSize: rem(14);
    --padding: rem(8) rem(12); }

.button {
  display: inline-block;
  line-height: 1;
  text-decoration: none;
  border: none;
  cursor: pointer;
  --padding: rem(10) rem(16);
  --fontSize: 1rem;
  --bg-color: var(--bg-color, #e0e0e0);
  --text-color: var(--text-color, #000);
  --border-radius: var(--main-radius);
  font-size: var(--fontSize);
  padding: var(--padding);
  background-color: var(--bg-color);
  color: var(--text-color);
  border-radius: var(--border-radius);
  font-weight: 600; }
  .button--primary {
    --bg-color: var(--primary);
    --text-color: var(--white); }
  .button--secondary {
    --bg-color: var(--secondary);
    --text-color: var(--white); }
  .button--danger {
    --bg-color: var(--danger);
    --text-color: var(--white); }
  .button--lg {
    --padding: var(--padding-large); }
  .button--sm {
    --fontSize: rem(14);
    --padding: var(--padding-small); }

.header {
  display: flex;
  width: 100%;
  justify-content: space-between;
  padding: 20px;
  position: fixed;
  top: 0;
  left: 0;
  height: 100px;
  background-color: var(--bkg_primary);
  z-index: 9; }
  .header h2 {
    font-weight: 700;
    text-transform: capitalize; }

.nav {
  background-color: var(--bkg_second);
  height: 100vh;
  width: 180px;
  position: fixed;
  left: 0;
  top: 0;
  padding-top: 150px;
  z-index: 7;
  padding-left: 20px;
  padding-right: 20px; }
  .nav li {
    margin-bottom: 10px; }
    .nav li a {
      padding: 5px !important;
      transition: all 0.5s ease; }
    .nav li a:hover {
      background-color: var(--danger);
      border-radius: 50px;
      width: 100%; }

.main {
  position: relative;
  padding-top: 100px;
  padding-left: 220px; }
  .main .title-page {
    margin-bottom: 50px; }
  .main .table-page {
    margin-bottom: 100px;
    padding-right: 40px;
    width: 100%; }
    .main .table-page table {
      width: 100%;
      border-collapse: collapse; }
      .main .table-page table thead tr {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid white;
        padding-bottom: 5px;
        margin-bottom: 10px; }
      .main .table-page table tbody tr {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid var(--bkg_second);
        padding-bottom: 10px;
        margin-bottom: 10px; }
        .main .table-page table tbody tr:last-child {
          border-bottom: none; }
      .main .table-page table tbody td {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 8px; }
  .main .form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: var(--bkg_second);
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
    .main .form-container .form-title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center; }
    .main .form-container label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px; }
    .main .form-container input[type='text'],
    .main .form-container input[type='email'],
    .main .form-container input[type='password'],
    .main .form-container select,
    .main .form-container textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px; }
    .main .form-container textarea {
      resize: vertical; }
    .main .form-container input[type='submit'] {
      background-color: #007bff;
      color: #ffffff;
      border: none;
      padding: 12px 20px;
      font-size: 18px;
      cursor: pointer;
      border-radius: 4px; }
      .main .form-container input[type='submit']:hover {
        background-color: #0062cc; }

.auth {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100vw;
  height: 100vh; }
  .auth form {
    position: relative;
    z-index: 1;
    background: var(--bkg_second);
    max-width: 460px;
    margin: 0 auto 100px;
    padding: 45px;
    text-align: center;
    margin-top: 45px;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); }
    .auth form input {
      font-family: 'Roboto', sans-serif;
      outline: 0;
      background: #f2f2f2;
      width: 100%;
      border: 0;
      margin: 0 0 15px;
      padding: 15px;
      box-sizing: border-box;
      font-size: 14px; }
    .auth form input[type='submit'] {
      font-family: 'Roboto', sans-serif;
      text-transform: uppercase;
      outline: 0;
      background: var(--primary);
      width: 100%;
      border: 0;
      padding: 15px;
      color: #FFFFFF;
      font-size: 14px;
      -webkit-transition: all 0.3 ease;
      transition: all 0.3 ease;
      cursor: pointer;
      margin-top: 15px; }

.notification {
  position: fixed;
  top: 20px;
  right: 10%;
  transform: translateX(-50%);
  z-index: 1000;
  padding: 15px;
  max-width: 400px;
  width: 100%;
  text-align: center;
  border-radius: 4px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  opacity: 1;
  pointer-events: none;
  transition: opacity 0.3s ease-in-out;
  animation: slideIn 0.5s forwards, slideOut 0.5s forwards 4.5s; }
@keyframes slideIn {
  from {
    transform: translateY(-150%); }
  to {
    transform: translateY(0); } }
@keyframes slideOut {
  from {
    transform: translateY(0); }
  to {
    transform: translateY(-150%); } }
  .notification--success {
    background-color: #4caf50;
    color: #fff; }
  .notification--danger {
    background-color: #f44336;
    color: #fff; }

/*# sourceMappingURL=style.css.map */
";
    protected string $custom_css;
    protected string $type;

    const PAGE_TYPES = [
        'home' => 'Accueil',
        'about' => 'À propos',
        'actu' => 'Actualités',
        'galerie' => 'Galerie',
        'contact' => 'Contact',
        'forum' => 'Forum'
    ];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function gettitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function settitle(string $title): void
    {
        $this->title = trim($title);
    }

    /**
     * @return string
     */
    public function getcontent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setcontent(string $content): void
    {
        $this->content = trim($content);
    }

    /**
     * @return string
     */
    public function gethtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function sethtml(string $html): void
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getcss(): string
    {
        return $this->css;
    }

    /**
     * @param string $css
     */
    public function setcss(string $css): void
    {
        $this->css = $css;
    }

    /**
     * @return string
     */
    public function getcustom_css(): string
    {
        return $this->custom_css;
    }

    /**
     * @param string $custom_css
     */
    public function setcustom_css(string $custom_css): void
    {
        $this->custom_css = $custom_css;
    }

    /**
     * @return string
     */
    public function gettype(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function settype(string $type): void
    {
        if (!array_key_exists($type, self::PAGE_TYPES)) {
            throw new \InvalidArgumentException("Type de page invalide");
        }
        $this->type = $type;
    }

    /**
     * Vérifie si un type de page existe déjà dans la base de données
     *
     * @param PDO $pdo
     * @param string $type
     * @return bool
     */
    public static function istypeExists(PDO $pdo, string $type): bool
    {
        $sql = "SELECT COUNT(*) FROM esgi_page WHERE type = :type";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':type' => $type]);
        $count = $stmt->fetchColumn();
        return ($count > 0);
    }

    public function getAllPages($pdo)
    {
        $this->pdo = $pdo;
        $sql = "SELECT * FROM esgi_page";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageById($pdo, $id)
    {
        $this->pdo = $pdo;
        $sql = "SELECT * FROM esgi_page WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':id', $id, PDO::PARAM_INT);
        $queryPrepared->execute();
        return $queryPrepared->fetch(PDO::FETCH_ASSOC);
    }

    public function getPageContentByType($pdo, $type)
    {
        $this->pdo = $pdo;
        $sql = "SELECT content FROM esgi_page WHERE type = :type";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':type', $type, PDO::PARAM_STR);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['content'] : null; // Retourne le contenu ou null si aucune page trouvée
    }

    public function updatePageContent($pdo, $id, $newContent)
    {
        $this->pdo = $pdo;
        $sql = "UPDATE esgi_page SET content = :content WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':content', $newContent, PDO::PARAM_STR);
        $queryPrepared->bindParam(':id', $id, PDO::PARAM_INT);
        return $queryPrepared->execute();
    }

    public function deletePageById($pdo, $id)
    {
        $this->pdo = $pdo;
        $sql = "DELETE FROM esgi_page WHERE id = :id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindParam(':id', $id, PDO::PARAM_INT);
        $queryPrepared->execute();

        // Vérifier si la suppression a réussi
        if ($queryPrepared->rowCount() > 0) {
            return true; // La suppression a réussi
        } else {
            return false; // Aucun enregistrement n'a été supprimé
        }
    }


}
