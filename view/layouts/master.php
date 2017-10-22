<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <?php foreach ($stylesheets as $stylesheet) : ?>
        <link rel="stylesheet" type="text/css" href="<?= $this->asset($stylesheet) ?>">
    <?php endforeach; ?>
</head>
<body>

<div class="container">

    <?php if ($this->regionHasContent("header")) : ?>
        <div class="header-wrap">
            <?php $this->renderRegion("header") ?>
        </div>
    <?php endif; ?>

    <?php if ($this->regionHasContent("main")) : ?>
        <div class="main-wrap">
            <?php $this->renderRegion("main") ?>        
        </div>
    <?php endif; ?>

    <?php if ($this->regionHasContent("footer")) : ?>
        <div class="footer-wrap">
            <?php $this->renderRegion("footer") ?>
        </div>
    <?php endif; ?>

</div>
    
</body>
</html>