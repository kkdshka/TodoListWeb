<!DOCTYPE html>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Subject</th>
        <th>Completed</th>
        <th colspan="2"></th>
    </tr>
    <?php foreach($tasks as $task): ?>
        <tr>
            <td><?= $task->getId() ?></td>
            <td><?= $task->getSubject() ?></td>
            <td><?= $task->isCompleted() ? "Yes" : "No" ?></td>
            <td><a href="/?action=complete&id=<?= $task->getId() ?>">Complete</a></td>
            <td><a href="/?action=delete&id=<?= $task->getId() ?>">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/?action=create">Add</a>