<h1>Allt om aktier</h1>

<p>Välkommen till Allt om aktier. Ett nytt forum aktie och investeringsintresserade.</p>

<div class="stats flex flex-around-center">
    <div class="questions">
        <h3>Senaste frågorna</h3>
        <ol>
            <?php foreach ($questions as $question) : ?>
                <li><a href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= $question->title ?></a></li>
            <?php endforeach; ?>
        </ol>
        <a href="<?= $this->di->get('url')->create('questions') ?>">Alla frågor</a>
    </div>
    <div class="">
        <h3>Populäraste taggarna</h3>
        <ol>
            <?php foreach ($tags as $tag) : ?>
                <li><a href="<?= $this->di->get('url')->create('tags/' . $tag->tag_id) ?>"><?= $tag->tag ?> (<?= $tag->nr ?>)</a></li>
            <?php endforeach; ?>
        </ol>
        <a href="<?= $this->di->get('url')->create('tags') ?>">Alla taggar</a>  
    </div>
    <div class="">
        <h3>Mest aktiva användare</h3>
        <ol>
            <?php foreach ($users as $user) : ?>
                <li><a href="<?= $this->di->get('url')->create('user/profile/' . $user->id) ?>"><?= $user->username ?> (<?= $user->activity ?>)</a></li>
            <?php endforeach; ?>
        </ol>
        <a href="<?= $this->di->get('url')->create('user/all') ?>">Alla användare</a>  
    </div>
</div>
