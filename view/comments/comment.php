<div class="comment">
    <div class="content">
        <?= $comment->content ?>
    </div>
    <footer>
        <div class="summary">
            
        </div>
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