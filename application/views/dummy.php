<div class="form-body">
                <form id="google-form-clone">
                    <div id="questions-container">
                        <!-- <?php foreach ($questions as $question): ?>
                            <script>
                                window.addEventListener("load",function () {
                                    const questionHtml = generateQuestionHtml(<?php echo $question['question_id']; ?>);
                                    $('#questions-container').append(questionHtml);
                                    $('#question-<?php echo $question['question_id']; ?> .form-question').val('<?php echo $question['question_text']; ?>');
                                    $('#question-<?php echo $question['question_id']; ?> .question-type').val('<?php echo $question['type']; ?>').trigger('change');
                                    <?php foreach (json_decode($question['options']) as $index => $option): ?>
                                        const optionHtml = `
                                            <div class="option">
                                                <input type="text" class="form-control option-input" name="questions[<?php echo $question['question_id']; ?>][options][]" value="<?php echo $option; ?>" placeholder="Option <?php echo $index + 1; ?>">
                                                <button type="button" class="remove-option" data-question-id="<?php echo $question['question_id']; ?>">&times;</button>
                                            </div>
                                        `;
                                        $('#form-options-<?php echo $question['question_id']; ?>').append(optionHtml);
                                    <?php endforeach; ?>
                                });
                            </script>
                        <?php endforeach; ?> -->
                    </div>
        </form>
    </div>