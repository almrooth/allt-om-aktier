<h1>Användare</h1>

<div class="admin">
    <table>
        <thead>
            <th>Användarnamn</th>
            <th>Epost</th>
            <th>Typ</th>
            <th>Status</th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><a href="<?= $this->di->get('url')->create('user/profile/' . $user->id) ?>"><?= $user->username ?></a></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->role ?></td>
                    <td>
                        <?php if (isset($user->deleted)) : ?>
                            inaktiv
                        <?php else : ?>
                            aktiv
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= $this->di->get('url')->create('admin/users/' . $user->id) ?>" class="btn btn-green">Redigera</a>
                        <?php if (!isset($user->deleted)) : ?>
                            <a href="<?= $this->di->get('url')->create('admin/users/' . $user->id . '/delete') ?>" class="btn btn-green">Inaktivera</a>
                        <?php else : ?>
                            <a href="<?= $this->di->get('url')->create('admin/users/' . $user->id . '/restore') ?>" class="btn btn-green">Aktivera</a>
                        <?php endif; ?>
                    </td>
                </tr>
                
            <?php endforeach; ?>
        </tbody>
    </table>
</div>