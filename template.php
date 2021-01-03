<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

</head>
<body>
<header>
    <?php require "menu.php" ?>
</header>
<section class="section">
    <div class="container">
        <?= $content ?>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</body>
</html>

