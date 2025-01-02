<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/snippets.php";
?>
<!doctype html>
<html lang="hu">
<head>
    <link href="/css/index.css" rel="stylesheet">
    <?php echo Snippets::head(); ?>
</head>
<body>
    <nav class="navbar navbar-expand-sm sticky-top mb-2"><div class="container justify-content-start">
        <a class="navbar-brand pt-0 pb-0 fs-3" href="/">
            <img src="/img/icon.png" id="icon" alt="KódKihívás">
            KódKihívás
        </a>
        <span class="navbar-text">Válassz egy kihívást:</span>
        <ul class="navbar-nav navbar-nav-scroll">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                1. Rudolf</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/rudolf.php">1. Rudolf</a></li>
                    <li><a class="dropdown-item" href="/akarmi.php">2. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                    <li><a class="dropdown-item" href="/akarmi2.php">3. Akármi</a></li>
                </ul>
            </li>
        </ul>
    </div></nav>
    <div class="container">
        <div class="row">
            <h1>Elsőw</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
            <h1>Háegy</h1>
        </div>
    </div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
