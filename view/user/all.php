<h1>Alla användare</h1>

<div class="users">
    <?php foreach ($users as $user) : ?>
        <div class="user">
            <img src="<?= $user->gravatar() ?>" alt="Profilbild">
            <div>
                <a href="<?= $this->di->get('url')->create('user/profile/'. $user->id) ?>"><?= $user->username ?></a>
                <p><?= $user->email ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
