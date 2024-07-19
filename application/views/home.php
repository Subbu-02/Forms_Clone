<script>
function confirmDeletion(formId) {
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('Forms/deleteForm/') ?>" + formId;
        }
    })
}
</script>

<div class="container">
    <h1 style="text-align: center;">My Forms</h1>
    <div class="form-list" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; margin-bottom: 20px; justify-content: center;">
        <?php foreach ($forms as $form): ?>
            <div class="form-card <?php echo $form['status']; ?>" style="width: calc(50% - 10px); padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
                <h2><?php echo $form['form_title']; ?></h2>
                <p>Status: <?php echo ucfirst($form['status']); ?></p>
                <a href="<?php echo site_url('forms/view/'.$form['form_id']); ?>" class="btn btn-primary">View</a>
                <?php if ($form['status'] == 'draft'): ?>
                    <a href="<?php echo site_url('forms/edit/'.$form['form_id']); ?>" class="btn btn-primary">Edit</a>
                <?php endif; ?>
                <?php if ($form['status'] == 'published'): ?>
                    <a href="<?php echo site_url('responses/responses_fetch/'.$form['form_id']); ?>" class="btn btn-primary">Responses</a>
                <?php endif; ?>
                <div style="text-align: right;">
                    <button onclick="confirmDeletion(<?= $form['form_id']; ?>)" class="btn btn-danger">Delete Form</button>
                </div>
            </div>
            <br>
        <?php endforeach; ?>
    </div>
</div>
