<!DOCTYPE html>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Priority</th>
        <th>Status</th>
        <th colspan="3"></th>
    </tr>
    <?php foreach($tasks as $task): ?>
        <tr>
            <td><?= $task->getId() ?></td>
            <td><?= $task->getSubject() ?></td>
            <td><?= $task->getDescription() ?></td>
            <td><?= $priorities[$task->getPriority()] ?></td>
            <td><?= $statuses[$task->getStatus()] ?></td>
            <td><a href="/?action=edit&id=<?= $task->getId() ?>">Edit</a></td>
            <td><a href="/?action=complete&id=<?= $task->getId() ?>">Complete</a></td>
            <td><a href="/?action=delete&id=<?= $task->getId() ?>">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/?action=create">Add</a>