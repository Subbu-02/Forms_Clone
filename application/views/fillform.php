<style>
    /* Ensure text overflow is handled */
    .form-card h2 {
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

        .form-card .buttons a {
            width: 100%; /* Full width for buttons */
            margin-top: 5px; /* Reduced margin */
            padding: 5px; /* Reduced padding */
            font-size: 12px; /* Further reduced font size */
        }

        .back-button {
            width: 100%; Full width for smaller screens
            text-align: center;
            margin: 20px 0; /* Center the button */
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

        .back-button {
            /* width: 100%; Full width for smaller screens */
            text-align: center;
            margin: 0 0 10px 10px;
        }
    }
</style>

<div class="container">
    <h1 style="text-align: center;">All Forms</h1>
    <div class="form-list">
        <?php foreach ($forms as $form): ?>
            <?php if ($form['status'] == 'published'): ?>
                <div class="form-card <?php echo $form['status']; ?>">
                    <h2><?php echo $form['form_title']; ?></h2>
                    <div class="buttons">
                        <a href="<?php echo site_url('forms/respond/' . $form['form_id']); ?>" class="btn btn-primary">Fill</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <a href="<?= base_url('home'); ?>" class="btn btn-primary back-button">Back</a>
</div>
