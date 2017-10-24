<div class="answer">
    <?php if ($this->di->get("session")->get("user_id") == $answer->user_id || $this->di->get("session")->get("user_role") == "admin") : ?>
        <div class="menu flex flex-between-center">
            <a class="btn" href="<?= $this->di->get('url')->create('answers/' . $answer->id . '/update') ?>">Redigera</a>
            <?php if ($answer->accepted) : ?>
                <a class="btn" href="<?= $this->di->get('url')->create('answers/' . $answer->id . '/accept') ?>">Ångra acceptera svar</a>
            <?php else : ?>
                <a class="btn" href="<?= $this->di->get('url')->create('answers/' . $answer->id . '/accept') ?>">Acceptera svar</a>
            <?php endif; ?>
            <a class="btn" href="<?= $this->di->get('url')->create('answers/' . $answer->id . '/delete') ?>">Radera</a>
        </div>
    <?php endif; ?>
    <div class="content">
        <?= $answer->content ?>
    </div>

    <?php if ($answer->accepted) : ?>
        <footer class="accepted">
    <?php else : ?>
        <footer>
    <?php endif; ?>    
        <div class="summary">
        <a href="<?= $this->di->get('url')->create('answers/' . $answer->id . '/comments') ?>"><?= count($answer->comments) ?> kommentarer</a>
        </div>
        <div>
            Betyg: <?= $answer->votes ?>
            Rösta: 
            <a class="btn" href="<?= $this->di->get('url')->create('vote/answer/' . $answer->id . '/up') ?>">+</a>
            <a class="btn" href="<?= $this->di->get('url')->create('vote/answer/' . $answer->id . '/down') ?>">-</a>
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