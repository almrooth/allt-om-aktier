<div class="comment">
    <?php if ($this->di->get("session")->get("user_id") == $comment->user_id || $this->di->get("session")->get("user_role") == "admin") : ?>
        <div class="menu flex flex-between-center">
            <a class="btn" href="<?= $this->di->get('url')->create('comments/' . $comment->id . '/update') ?>">Redigera</a>
            <a class="btn" href="<?= $this->di->get('url')->create('comments/' . $comment->id . '/delete') ?>">Radera</a>
        </div>
    <?php endif; ?>
    <div class="content">
        <?= $comment->content ?>
    </div>
    <footer>
        <div class="summary">
            
        </div>
        <?php if ($this->di->get("session")->has("username")) : ?>
        <div>
            Betyg: <?= $comment->votes ?>
            Rösta: 
            <a class="btn" href="<?= $this->di->get('url')->create('vote/comment/' . $comment->id . '/up') ?>">+</a>
            <a class="btn" href="<?= $this->di->get('url')->create('vote/comment/' . $comment->id . '/down') ?>">-</a>
        </div>
        <?php endif; ?>
        <div class="meta">
            <div>
                <div class="created">
                    <?= $comment->created ?>
                </div>
                <div class="by">
                    av <a href="<?= $this->di->get('url')->create('user/profile/' . $comment->user->id) ?>"><?= $comment->user->username ?></a>
                </div>
            </div>
            <img class="gravatar" src="<?= $comment->user->gravatar() ?>" alt="User picture">
        </div>
    </footer>
</div>