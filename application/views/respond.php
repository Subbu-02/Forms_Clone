<!DOCTYPE html>
<html>
<head>
    <title>View Form</title>
    <style>
        .question-container {
            margin-bottom: 20px;
        }
        .option {
            margin-left: 20px;
            display: flex;
            align-items: center;
        }
        .form-title {
            margin-bottom: 10px;
        }
        .form-description {
            margin-bottom: 20px;
        }
        .form-check-label {
            margin-left: 10px;
        }
        .required {
            color: red;
            font-weight: bold;
        }
        /* .child-selectable * {
            pointer-events: auto;
        } */
    </style>
</head>
<div class="container mt-5">
    <br><br>
        <div class="card">
            <div class="card-body">
            <form id="form-respond" action="<?= base_url('forms/saveResponses') ?>" method="POST">
            <script>var userId = <?php echo $form['user_id']; ?>;</script>
            <script>var numberOfQuestions = <?php echo count($questions); ?>;</script>
            <input type="hidden" id="form_id" name="form_id" value="<?php echo isset($form['form_id']) ? $form['form_id'] : ''; ?>">
                <h1 class="form-title"><?= $form['form_title'] ?></h1>
                <p class="form-description"><?= $form['form_description'] ?></p>
                <?php foreach ($questions as $question): ?>
                    <?php $options = json_decode($question['options'], true); ?>
                    <script>var questionId = <?php echo $question['question_id']; ?>;</script>
                    <script>var questionType = <?php echo $question['type']; ?>;</script>
                    <div class="question-container no-select" id="question-<?= $question['question_id'] ?>" data-type="<?= $question['type'] ?>">
                        <h4>
                            <?= $question['question_text'] ?>
                            <?php if ($question['required']): ?>
                                <span class="required">*</span>
                            <?php endif; ?>
                        </h4>
                        <?php if (in_array($question['type'], ['1', '4'])): ?>
                            <?php foreach ($options as $option): ?>
                                <div class="option form-check">
                                    <input class="form-check-input" type="<?= $question['type'] === '4' ? 'checkbox' : 'radio' ?>" name="responses[<?= $question['question_id'] ?>][]" value="<?= htmlspecialchars($option) ?>">
                                    <label class="form-check-label"><?= $option ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif ($question['type'] === '2'): ?>
                            <input type="text" class="form-control" name="responses[<?= $question['question_id'] ?>]">
                        <?php elseif ($question['type'] === '3'): ?>
                            <textarea class="form-control" rows="3" name="responses[<?= $question['question_id'] ?>]"></textarea>
                        <?php elseif ($question['type'] === '5'): ?>
                            <select class="form-control" name="responses[<?= $question['question_id'] ?>]">
                                <?php foreach ($options as $option): ?>
                                    <option><?= $option ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <p>Unknown question type: <?= $question['type'] ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <button type="submit" form="form-respond" class="btn btn-primary">Submit</button>
                <button class="btn btn-primary mt-3" onclick="history.back()">Back</button>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#form-respond').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var responses = [];
            var allRequiredFilled = true; // Flag to check if all required questions are answered

            $('.question-container').each(function() {
                var questionId = $(this).attr('id').split('-')[1];
                var questionType = $(this).data('type'); // Correctly retrieve the data-type attribute
                var isRequired = $(this).find('.required').length > 0; // Check if the question is required
                var responseContent;
                switch (questionType) {
                    case 1: // Multiple choice
                    case 4: // Checkboxes
                        responseContent = $(this).find('input:checked').map(function() {
                            return $(this).val();
                        }).get();
                        if (isRequired && responseContent.length === 0) allRequiredFilled = false;
                        break;
                    case 2: // Short answer
                        responseContent = $(this).find('input[type="text"]').val();
                        if (isRequired && !responseContent) allRequiredFilled = false;
                        break;
                    case 3: // Paragraph
                        responseContent = $(this).find('textarea').val();
                        if (isRequired && !responseContent) allRequiredFilled = false;
                        break;
                    case 5: // Dropdown
                        responseContent = $(this).find('select').val();
                        if (isRequired && !responseContent) allRequiredFilled = false;
                        break;
                }
                if (!isRequired && !responseContent) responseContent = null; // Assign null if not required and empty
                responses.push({
                    question_id: questionId,
                    response: responseContent
                });
            });

            if (!allRequiredFilled) {
                swal.fire({
                        title: 'Please fill in all the required fields',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Okay'
                    })
                return; // Stop the form submission if not all required questions are filled
            }

            console.log("Sending data:", responses); // Debugging output
            var userId = <?= $this->session->userdata('user_id') ?>; // Extract user_id from session data

            $.ajax({
                    url: '<?= base_url("forms/saveResponses") ?>',
                    method: 'POST',
                    data: { responses: responses, form_id: $('#form_id').val(), user_id: userId }, // Pass extracted user_id
                    success: function(response) {
                        swal.fire({
                            title: 'Responses saved successfully',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Okay'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= base_url("fillform") ?>';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while saving the responses: ' + error);
                    }
                });
            });
        });
</script>
