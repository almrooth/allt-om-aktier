<h1>Tagg: <?= $tag->tag ?></h1>

<?php foreach (array_reverse($questions) as $question) : ?>
    <?php include(__DIR__ . '/question.php'); ?>
<?php endforeach; ?>
