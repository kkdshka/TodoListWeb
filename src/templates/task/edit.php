<form action="/?action=edit&id=<?= $task->getId() ?>" method="POST">
    <div><label for="subject">Subject</label>
        <input id="subject" name="subject" value="<?= $task->getSubject() ?>">
    </div>
    <div><label for="description">Description</label>
        <textarea id="description" name="description"><?= $task->getDescription() ?></textarea>
    </div>
    <div><label id="priority">Priority</label>
        <select id="priority" name="priority" value="<?= $task->getPriority() ?>">
            <?php foreach ($priorities as $value => $name): ?> 
                <?php if ($value == $task->getPriority()): ?>
                    <option selected value="<?= $value ?>"><?= $name ?></option>
                <?php else: ?>
                    <option value="<?= $value ?>"><?= $name ?></option>    
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div><label id="status">Status</label>
        <select id="status" name="status" value="<?= $task->getStatus() ?>">
            <?php foreach ($statuses as $value => $name): ?> 
                <?php if ($value == $task->getStatus()): ?>
                    <option selected value="<?= $value ?>"><?= $name ?></option>
                <?php else: ?>    
                    <option value="<?= $value ?>"><?= $name ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>

    <div><input type="submit" value="edit"></div>
    <div><input type="reset" value="Reset changes"</div>
</form>