<h1>Fråga</h1>

<?php include(__DIR__. "/question.php"); ?>

<div class="answers">
    <h2>Svar</h2>
    <?php foreach($question->answers as $answer) : ?>
        <?php include(__DIR__ . "/../answers/answer.php"); ?>
    <?php endforeach; ?>
</div>

<?php if($this->di->get("session")->has("username")) : ?>
    <div class="form-wrap">
        <h2>Skriv ett svar</h2>
        <?= $form ?>
    </div>
<?php endif; ?>
