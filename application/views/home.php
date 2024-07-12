<div class="container">
    <h1 style="text-align: center;">My Forms</h1>
    <div class="form-list" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; margin-bottom: 20px; justify-content: center;">
        <?php foreach ($forms as $form): ?>
            <div class="form-card <?php echo $form['status']; ?>" style="width: calc(50% - 10px); padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
                <h2><?php echo $form['form_title']; ?></h2>
                <p>Status: <?php echo ucfirst($form['status']); ?></p>
                <a href="<?php echo site_url('forms/view/'.$form['form_id']); ?>" class="btn btn-primary">View</a>
                <?php if ($form['status'] == 'draft'): ?>
                    <a href="<?php echo site_url('forms/edit/'.$form['form_id']); ?>" class="btn btn-secondary" style="color: #1b263a;">Edit</a>
                <?php endif; ?>
                <!-- Insert line break -->
            </div>
            <br>
        <?php endforeach; ?>
    </div>
</div>
