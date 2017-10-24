<h1>Svar</h1>

<h2><a href="<?= $this->di->get('url')->create('questions/' . $answer->question->id) ?>"><?= $answer->question->title ?></a></h2>

<?php include(__DIR__ . "/answer.php"); ?>

<div class="comments">
    <h2>Kommentarer</h2>
    <?php foreach ($answer->comments as $comment) : ?>
        <?php include(__DIR__ . "/../comments/comment.php"); ?>
    <?php endforeach; ?>
</div>

<?php if ($this->di->get("session")->has("username")) : ?>
    <div class="form-wrap">
        <h2>Skriv en kommentar</h2>
        <?= $form ?>
    </div>
<?php endif; ?>
