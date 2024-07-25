<style>
    /* Home Page Styles */
    /* Ensure text overflow is handled */
    .form-card h2,
    .form-card p {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .form-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .form-card {
        width: calc(33.333% - 20px);
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    @media (max-width: 1200px) {
        .form-card {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 768px) {
        .form-card {
            width: 100%; /* Ensure full width for stacking */
            padding: 10px;
            margin-bottom: 20px; /* Add some margin between cards */
        }

        .form-list {
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center the cards */
        }

        .form-card .buttons {
            flex-direction: column; /* Stack buttons vertically */
            width: 100%; /* Full width for buttons */
        }

        .form-card .buttons a,
        .form-card .buttons button {
            width: 100%; /* Full width for buttons */
            margin-top: 5px; /* Reduced margin */
            padding: 5px; /* Reduced padding */
            font-size: 12px; /* Further reduced font size */
        }
    }

    /* Ensure buttons are in a row for screens larger than 768px */
    @media (min-width: 769px) {
        .form-card .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-card .buttons a {
            margin-right: 10px;
        }
    }
</style>

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
    <div class="form-list">
        <?php foreach ($forms as $form): ?>
            <div class="form-card <?php echo $form['status']; ?>">
                <h2><?php echo $form['form_title']; ?></h2>
                <p>Status: <?php echo ucfirst($form['status']);
                if ($form['modified_at']):
                    echo "<br>Last modified at: " . $form['modified_at'];
                else:
                    echo "<br>Created at: " . $form['created_at'];
                endif;
                ?></p>
                <div class="buttons">
                    <a href="<?= base_url('Forms/view/') . $form['form_id']; ?>" class="btn btn-primary">View</a>
                    <?php if ($form['status'] == 'draft'): ?>
                        <a href="<?= base_url('Forms/edit/') . $form['form_id']; ?>" class="btn btn-primary">Edit</a>
                    <?php endif; ?>
                    <?php if ($form['status'] == 'published'): ?>
                        <a href="<?php echo site_url('responses/responses_fetch/' . $form['form_id']); ?>" class="btn btn-primary">Responses</a>
                    <?php endif; ?>
                    <button onclick="confirmDeletion(<?php echo $form['form_id']; ?>)" class="btn btn-danger">Delete Form</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
