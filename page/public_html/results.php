<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/snippets.php";
?>
<!doctype html>
<html lang="hu">
<head>
    <?php echo Snippets::head(); ?>
    <link href="/css/results.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('results'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>Eredmények</h1>
        <div id="alert" class="d-none mb-3"></div>
        <p>Amikor sikerül megoldani egy feladatot, fényes csillagok, vagy akár egy korona fog megjelenni a neved mellett!</p>
        <div class="table-responsive"><table class="table table-bordered table-hover align-middle results-table">
            <thead class="table-light"><tr></tr></thead>
            <tbody></tbody>
        </table></div>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/results.js"></script>
</body>
</html>
