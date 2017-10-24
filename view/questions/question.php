<article class="question">
        <?php if ($this->di->get("session")->get("user_id") == $question->user_id || $this->di->get("session")->get("user_role") == "admin") : ?>
            <div class="menu flex flex-between-center">
                <a class="btn" href="<?= $this->di->get('url')->create('questions/' . $question->id . '/update') ?>">Redigera</a>
                <a class="btn" href="<?= $this->di->get('url')->create('questions/' . $question->id . '/delete') ?>">Radera</a>
            </div>
        <?php endif; ?>
        <header>
            <h2>
                <a class="title" href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= $question->title ?></a>
            </h2>
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
                <?php foreach ($question->tags as $tag) : ?>
                    <a href="<?= $this->di->get('url')->create('tags/' . $tag->id) ?>"><?= $tag->tag ?></a>
                <?php endforeach; ?>
            </div>
            <div class="summary flex flex-between-center">
                <div>
                    <a href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= count($question->answers) ?> svar</a>
                    | <a href="<?= $this->di->get('url')->create('questions/' . $question->id . '/comments') ?>"><?= count($question->comments) ?> kommentarer</a>
                </div>
                <?php if ($this->di->get("session")->has("username")) : ?>
                <div>
                    Betyg: <?= $question->votes ?>
                    Rösta: 
                    <a class="btn" href="<?= $this->di->get('url')->create('vote/question/' . $question->id . '/up') ?>">+</a>
                    <a class="btn" href="<?= $this->di->get('url')->create('vote/question/' . $question->id . '/down') ?>">-</a>
                </div>
                <?php endif; ?>
            </div>
        </footer>
    </article>
    