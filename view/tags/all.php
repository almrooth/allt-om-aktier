<h1>Alla taggar</h1>

<div class="tags">
    <?php foreach ($tags as $tag) : ?>
        <div class="tag">
            <a href="<?= $this->di->get('url')->create('tags/' . $tag->id) ?>"><?= $tag->tag ?></a>
            <p>Antal frågor: <?= $tag->count ?></p>
        </div>
    <?php endforeach; ?>
</div>