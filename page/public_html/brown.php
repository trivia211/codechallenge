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
    <link href="/css/brown.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col main-container">
        <h1>2. Brown mozgás <small class="text-body-secondary">- majd, ha piros hó esik felfelé!</small></h1>
        <div id="alert" class="d-none mb-3"></div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat augue magna, sit amet feugiat mauris tristique ut. Nunc vel libero odio. Quisque et fermentum ligula. Sed vitae enim non nibh porttitor commodo ut nec arcu. Duis velit sem, consectetur sit amet elit eu, rutrum mattis urna. Curabitur laoreet ligula id pharetra maximus. Curabitur eleifend, tortor egestas condimentum porta, lectus quam semper risus, sit amet placerat diam odio ac erat. Praesent nec finibus erat. Proin arcu sem, lobortis sit amet nibh et, finibus laoreet elit. Sed sapien ante, tincidunt eget cursus sed, ultricies eu nulla.</p>
        <p>Proin ac egestas massa, malesuada egestas augue. Maecenas eget consectetur leo. Vestibulum molestie blandit orci, vel tincidunt nunc semper id. Sed sollicitudin justo a pretium tincidunt. Aenean in congue dolor. Suspendisse consequat bibendum arcu, eu dapibus est malesuada et. Pellentesque lacus odio, vulputate vel diam vel, venenatis tincidunt augue. Maecenas in nunc ac tortor bibendum varius sit amet id nisi. Duis ullamcorper, arcu ut consequat porttitor, lorem quam gravida mi, quis volutpat arcu mauris eget ligula. Donec vestibulum nibh ante, eu fringilla ligula porta vel. Pellentesque sem sapien, vehicula eget efficitur et, faucibus quis odio.</p>
        <p>Nullam tempor est nec vestibulum pretium. Suspendisse pulvinar imperdiet vestibulum. Etiam id sapien in dui molestie dignissim sed vitae ligula. Nullam accumsan consequat massa quis suscipit. Fusce feugiat augue quam, id placerat diam pretium eu. Phasellus vel nibh nec turpis ultricies efficitur. Vivamus vel leo id tellus blandit euismod. Aenean nec odio a mauris ornare pharetra. Quisque a euismod ante. Nam scelerisque odio id turpis bibendum posuere. Aenean libero ex, sagittis at auctor in, facilisis sit amet ante. Phasellus cursus feugiat purus eu pellentesque. Nullam turpis dui, ullamcorper a ullamcorper nec, laoreet eu lectus. Suspendisse ultrices sodales orci, ut sollicitudin felis elementum a.</p>
        <p>Phasellus eget leo augue. Maecenas lobortis dui ut augue suscipit venenatis. Donec sem orci, mattis sit amet commodo id, convallis at mauris. Maecenas nisi augue, dapibus quis lacus mollis, iaculis imperdiet sem. Morbi vehicula sapien ut venenatis ornare. Integer elementum, diam quis aliquam faucibus, lectus ex placerat dui, sed accumsan mi elit in nibh. Nullam molestie massa eget tellus vehicula luctus. Aliquam aliquet viverra augue. Maecenas sagittis sem quam, et laoreet mi pretium sed. Mauris molestie tristique suscipit. Aliquam imperdiet metus justo, ut pharetra ex aliquam quis. Suspendisse imperdiet, ipsum ut egestas vehicula, lorem sem condimentum ligula, pretium aliquet arcu velit eleifend erat. Quisque efficitur et nisi id egestas. Etiam in elit mollis, fermentum enim ac, venenatis dolor. Ut faucibus in dolor eu interdum.</p>
        <p>Nunc tincidunt orci tellus, id varius ipsum semper ac. Nunc quis porttitor ex. Duis pulvinar molestie enim nec ornare. In vestibulum diam convallis eleifend tempor. Vivamus sed urna mollis dolor sollicitudin elementum vel ut diam. Cras lobortis, nunc vitae dignissim posuere, elit enim varius lectus, quis hendrerit ipsum elit pellentesque sapien. Integer vitae orci lacinia, ullamcorper nisi tincidunt, molestie neque. Morbi fermentum at nisi quis interdum.</p>
        <div id="snow-container"></div>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/dist/node_modules/q5/q5.js"></script>
    <script src="/js/brown.js"></script>
    <script src="/js/challengepage.js"></script>
</body>
</html>
