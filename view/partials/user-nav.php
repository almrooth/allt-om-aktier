<nav class="user-nav">
    <?php if ($this->di->get("session")->has("username")) : ?>
        <div class="navbar-dropdown">
            <?= $this->di->get("session")->get("username") ?>

            <div>
                <a href="<?= $this->di->get('url')->create('user/profile/'. $this->di->get('session')->get('user_id')) ?>">Min profil</a>
                
                <?php if ($this->di->get("session")->get("user_role") == "admin") : ?>
                    <a href="<?= $this->di->get('url')->create('admin/users') ?>">Användare</a>
                    <a href="<?= $this->di->get('url')->create('admin/questions') ?>">Frågor</a>
                <?php endif; ?>
            </div>            
        </div>
        <a href="<?= $this->di->get('url')->create('user/logout') ?>">Logga ut</a>
    <?php else : ?>
        <a href="<?= $this->di->get('url')->create('user/login') ?>">Logga in</a>
    <?php endif; ?>
</nav>
