<h1>Frågor</h1>

<div class="admin">
    <table>
        <thead>
            <th>Titel</th>
            <th>Användare</th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach ($questions as $question) : ?>
                <tr>
                    <td><a href="<?= $this->di->get('url')->create('questions/' . $question->id) ?>"><?= $question->title ?></a></td>
                    <td><a href="<?= $this->di->get('url')->create('user/profile/' . $question->user->id) ?>"><?= $question->user->username ?></a></td>
                    <td>
                        <a href="<?= $this->di->get('url')->create('questions/' . $question->id . '/update') ?>" class="btn btn-green">Redigera</a>
                        <a href="<?= $this->di->get('url')->create('questions/' . $question->id . '/delete') ?>" class="btn btn-green">Ta bort</a>
                    </td>
                </tr>
                
            <?php endforeach; ?>
        </tbody>
    </table>
</div>