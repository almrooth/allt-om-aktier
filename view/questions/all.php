<h1>Frågor</h1>

<?php if($this->di->get("session")->has("username")) : ?>
    <nav class="main-nav">
        <a href="<?= $this->di->get('url')->create('questions/create') ?>" class="btn btn-green">Ny fråga</a>
    </nav>
<?php endif; ?>

<?php foreach(array_reverse($questions) as $question) : ?>
    <?php include(__DIR__ . '/question.php'); ?>
<?php endforeach; ?>
