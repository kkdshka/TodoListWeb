<form action="/?action=create" method="POST">
    <div><label for="subject">Subject</label>
        <input id="subject" name="subject" placeholder="Enter your subject">
    </div>
    <div><label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Enter description of your task"></textarea>
    </div>
    <div><label id="priority">Priority</label>
        <select id="priority" name="priority">
            <?php foreach ($priorities as $value => $name): ?> 
                <option value="<?= $value ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div><label id="status">Status</label>
        <select id="status" name="status">
            <?php foreach ($statuses as $value => $name): ?> 
                <option value="<?= $value ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div><input type="submit" value="create"></div>
</form>