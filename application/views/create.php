<div class="container">
    <h1>Create New Form</h1>
    <form action="<?php echo site_url('save'); ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <a href="<?= base_url('home'); ?>" class="btn btn-primary">Back</a>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
