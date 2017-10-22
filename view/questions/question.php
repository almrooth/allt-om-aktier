<article class="question">
        <header>
            <h2><a class="title" href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= $question->title ?></a></h2>
            <div class="meta">
            <div>
                <div class="created">
                    <?= $question->created ?>
                </div>
                <div class="by">
                    av <a href="<?= $this->di->get('url')->create('user/profile/' . $question->user->id) ?>"><?= $question->user->username ?></a>
                </div>
            </div>            
            <img class="gravatar" src="<?= $question->user->gravatar() ?>" alt="User picture">
        </div>
        </header>
        <div class="content">
            <?= $question->content ?>
        </div>
        <footer>
            <div class="question-tags">
                Taggar:
                <?php foreach($question->tags as $tag) : ?>
                    <a href="<?= $this->di->get('url')->create('tags/' . $tag->id) ?>"><?= $tag->tag ?></a>
                <?php endforeach; ?>
            </div>
            <div class="summary">
                <a href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= count($question->answers) ?> svar</a> | <a href="<?= $this->di->get('url')->create('questions/' . $question->id . '/comments') ?>"><?= count($question->comments) ?> kommentarer</a>
            </div>
        </footer>
    </article>
    