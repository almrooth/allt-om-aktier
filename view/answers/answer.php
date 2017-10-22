<div class="answer">
    <div class="content">
        <?= $answer->content ?>
    </div>
    <footer>
        <div class="summary">
        <a href="<?= $this->di->get('url')->create('answers/' . $answer->id . '/comments') ?>"><?= count($answer->comments) ?> kommentarer</a>
        </div>
        <div class="meta">
            <div>
                <div class="created">
                    <?= $answer->created ?>
                </div>
                <div class="by">
                    av <a href="<?= $this->di->get('url')->create('user/profile/' . $answer->user->id) ?>"><?= $answer->user->username ?></a>
                </div>
            </div>
            <img class="gravatar" src="<?= $answer->user->gravatar() ?>" alt="User picture">
        </div>
    </footer>
</div>