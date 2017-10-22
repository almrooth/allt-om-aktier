<div class="flex flex-between-center">
    <h1><?= $user->username ?>'s profil</h1>
    <?php if ($this->di->get("session")->get("user_id") === $user->id) : ?>
        <a href="<?= $this->di->get('url')->create('user/update') ?>" class="btn btn-green">Redigera profil</a>
    <?php endif; ?>
</div>


<article class="profile">
    <img class="gravatar" src="<?= $user->gravatar() ?>" alt="Profilbild">
    <table>
        <tr>
            <td>Användarnamn: </td>
            <td><?= $user->username ?></td>
        </tr>

        <tr>
            <td>Användartyp: </td>
            <td><?= $user->role ?></td>
        </tr>

        <tr>
            <td>Epost: </td>
            <td><?= $user->email ?></td>
        </tr>
    </table>
</article>

<div class="flex flex-around-center">
    <div>
        <h2>Frågor (<?= count($user->questions) ?> st)</h2>
        <ol>
            <?php foreach($user->questions as $question) : ?>
                <li><a href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= $question->title ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
    <div>
        <h2>Besvarade frågor (<?= count($user->answeredQuestions) ?> st)</h2>
        <ol>
            <?php foreach($user->answeredQuestions as $question) : ?>
                <li><a href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= $question->title ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>

