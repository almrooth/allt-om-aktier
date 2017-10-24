<h1>Fråga</h1>

<?php include(__DIR__ . '/question.php'); ?>

<div class="answers">
    <h2>Kommentarer</h2>
    <?php foreach ($question->comments as $comment) : ?>
        <?php include(__DIR__ . "/../comments/comment.php"); ?>
    <?php endforeach; ?>
</div>

<?php if ($this->di->get("session")->has("username")) : ?>
    <div class="form-wrap">
        <h2>Skriv en kommentar</h2>
        <?= $form ?>
    </div>
<?php endif; ?>
