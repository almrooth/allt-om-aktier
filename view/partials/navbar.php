<nav class="navbar">
    <a href="<?= $this->di->get('url')->create('questions') ?>">Frågor</a>
    <a href="<?= $this->di->get('url')->create('tags') ?>">Taggar</a>
    <a href="<?= $this->di->get('url')->create('user/all') ?>">Användare</a>
    <a href="<?= $this->di->get('url')->create('about') ?>">Om sidan</a>
</nav>