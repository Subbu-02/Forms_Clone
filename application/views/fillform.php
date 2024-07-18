<div class="container">
    <h1 style="text-align: center;">All Forms</h1>
    <div class="form-list" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; margin-bottom: 20px; justify-content: center;"> <!-- Changed justify-content to left -->
        <?php foreach ($forms as $form): ?>
            <?php if ($form['status'] == 'published'): ?>
            <div class="form-card <?php echo $form['status']; ?>" style="width: calc(50% - 10px); padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
                <h2><?php echo $form['form_title']; ?></h2>
                <a href="<?php echo site_url('forms/respond/'.$form['form_id']); ?>" class="btn btn-warning" style="">Fill</a>
            </div>
            <br>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <button class="btn btn-primary" style="margin-left: 19em; justify-content: center;" onclick="history.back()">Back</button> <!-- Added margin-top to create space between questions and back button -->
</div>
