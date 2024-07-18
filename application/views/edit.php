            <div class="navbar-tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Questions</a></li>
                    <!-- <li class="disabled"><a href="#" class="hover-only">Responses</a></li>
                    <li class="disabled"><a href="#" class="hover-only">Settings</a></li> -->
                </ul>
            </div>
        </nav>
    </header>
    <script>
        // Convert PHP array to JavaScript array
        var questionsFromDatabase = <?php
        use function PHPSTORM_META\type;

        echo json_encode($questions); ?>;
    </script>
    <div class="container form-container">
        <script>var userId = <?php echo $form['user_id']; ?>;</script>
        <!-- <?php print_r($form); ?>
        <br>
        <?php print_r($questions); ?> -->
        <script>var numberOfQuestions = <?php echo count($questions); ?>;</script>
        <div class="form-card">
        <form id="form-edit" action="<?= base_url('forms/saveForm') ?>" method="POST">
            <div class="form-header">
            <input type="hidden" id="form_id" name="form_id" value="<?php echo isset($form['form_id']) ? $form['form_id'] : ''; ?>">
            <input type="text" class="form-title form-control" id="form_title" name="form_title" value="<?php echo isset($form['form_title']) ? $form['form_title'] : ''; ?>" style="border-radius: 5px; height: 75px"><br>
            <input type="text" class="form-description form-control" id="form_description" name="form_description" value="<?php echo isset($form['form_description']) ? $form['form_description'] : ''; ?>" style="border-radius: 5px;">
            </div>
            <div class="form-body">
                <form id="google-form-clone">
                    <div id="questions-container">
                        <?php foreach ($questions as $question): ?>
                            <script>
                                var questionId = <?php echo $question['question_id']; ?>;
                            </script>
                            <!-- Code to display the question data as in script.js -->
                            <div class="form-group question-container" id="question-<?php echo $question['question_id']; ?>">
                                <div class="question-content">
                                    <input type="hidden" class="user-id" value="<?php echo $form['user_id'];?>">
                                    <input type="text" class="form-control form-question" name="question_text[<?php echo $question['question_id']; ?>]" placeholder="Question <?php echo $question['question_id']; ?>" value="<?php echo htmlspecialchars($question['question_text']); ?>">
                                    <select class="form-control question-type" data-question-id="<?php echo $question['question_id']; ?>">
                                    <?php
                                    $questionId = $question['question_id'];
                                    $questionType = $question['type'];
                                    $options = json_decode($question['options'], true);
                                    $types = ['multiple-choice', 'short-answer', 'paragraph', 'checkboxes', 'dropdown'];
                                    foreach ($types as $index => $type) {
                                        $selected = $index + 1 == $questionType ? 'selected' : '';
                                        echo "<option value='$type' $selected>" . ucfirst(str_replace('-', ' ', $type)) . "</option>";
                                    }
                                    ?>
                                    </select>
                                    <!-- Have this div only if options is 1, 4 or 5 -->
                                    <?php if (in_array($question['type'], ['1', '4', '5'])): ?>
                                        <div class="form-options" id="form-options-<?php echo $question['question_id']; ?>">
                                        <?php
                                        $hasOther = false;
                                        foreach ($options as $option) {
                                            if ($option == "Other") {
                                                $hasOther = true;
                                            }
                                            ?>
                                            <div class="option">
                                                <input type="text" class="form-control option-input" placeholder="Option 1" value="<?php echo $option; ?>">
                                                <button type="button" class="remove-option" data-question-id="<?php echo $question['question_id']; ?>">&times;</button>
                                                <br>
                                            </div>
                                        <?php } ?>
                                        <button type="button" class="btn btn-secondary add-option" data-question-id="<?php echo $question['question_id']; ?>">Add option</button>
                                        <?php if (!$hasOther): ?>
                                            <button type="button" class="btn btn-secondary add-other" data-question-id="<?php echo $question['question_id']; ?>">Add Other</button>
                                        <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-actions text-right">
                                    <button type="button" class="btn btn-default required-btn" data-question-id="<?php echo $question['question_id']; ?>" <?php echo $question['required'] == 1 ? '' : 'disabled'; ?>>Required</button>
                                    <button type="button" class="btn btn-default duplicate-btn" data-question-id="<?php echo $question['question_id']; ?>" title="Duplicate Question">
                                        <span class="glyphicon glyphicon-duplicate"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger delete-btn" data-question-id="<?php echo $question['question_id']; ?>" title="Delete Question">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                    <button type="button" class="btn btn-secondary add-question-btn" data-question-id="<?php echo $question['question_id']; ?>">
                                        <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <!-- Default question will be appended here -->
                    </div>
                </form>
            </div>
        </form>
        </div>
        <div class="add-question-container">
            <button type="button" id="add-question" class="btn btn-secondary add-question-btn"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <button type="submit" form="form-edit" class="btn btn-primary">Save Draft</button>
        <button class="btn btn-primary" onclick="history.back()">Back</button>
    </div>
    

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://localhost/Forms_Clone/assets/js/script.js"></script>
</body>
</html> -->          

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#form-edit').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var questions = [];
            $('.question-container').each(function() {
                var questionId = $(this).attr('id').split('-')[1];
                var questionText = $(this).find('.form-question').val();
                var questionType = $(this).find('.question-type').val();
                // var userId = $(this).find('.user-id').val();
                switch (questionType) {
                    case 'multiple-choice':
                        questionType = 1;
                        break;
                    case 'short-answer':
                        questionType = 2;
                        break;
                    case 'paragraph': 
                        questionType = 3;
                        break;
                    case 'checkboxes':
                        questionType = 4;
                        break;  
                    case 'dropdown':
                        questionType = 5;
                        break;
                }
                var options = $(this).find('.option-input').map(function() {
                    return $(this).val();
                }).get();
                var required = $(this).find('.required-btn').hasClass('btn-success') ? 1 : 0;

                questions.push({
                    question_id: questionId,
                    question_text: questionText,
                    type: questionType,
                    options: options,
                    user_id: userId
                    // required: required
                });
            });

            console.log("Sending data:", questions); // Debugging output

            $.ajax({
                url: '<?= base_url("forms/saveForm") ?>',
                method: 'POST',
                data: { questions: questions, form_id: $('#form_id').val(), form_title: $('#form_title').val(), form_description: $('#form_description').val() },
                success: function(response) {
                    // console.log("Response:", response);
                    // window.location.href ='<?= base_url("home") ?>';
                    swal.fire({
                        title: 'Questions saved successfully',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Okay'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url("home") ?>';
                        }
                    })
                },
                error: function(xhr, status, error) {
                    // console.error('Error saving questions:', xhr, status, error);
                    alert('An error occurred while saving the questions.');
                }
            });
        });
    });
</script>
