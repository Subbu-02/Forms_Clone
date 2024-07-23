<div class="container">
    <h1 style="text-align: center;">All Forms</h1>
    <div class="form-list" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; margin-bottom: 20px; justify-content: center;">
        <?php foreach ($forms as $form): ?>
            <?php if ($form['status'] == 'published'): ?>
            <div class="form-card <?php echo $form['status']; ?>" style="width: calc(45% - 10px); padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
                <h2><?php echo $form['form_title']; ?></h2>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?php echo site_url('forms/respond/'.$form['form_id']); ?>" class="btn btn-primary">Fill</a>
                </div>
            </div>
            <br>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <a style="margin: 20px 523px;" href="<?= base_url('home'); ?>" class="btn btn-primary">Back</a>
</div>
