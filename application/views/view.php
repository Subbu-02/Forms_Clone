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
    </style>
</head>
<div class="container mt-5">
    <br><br>
        <div class="card">
            <div class="card-body">
                <h1 class="form-title"><?= $form['form_title'] ?></h1>
                <p class="form-description"><?= $form['form_description'] ?></p>
                <?php foreach ($questions as $question): ?>
                    <?php $options = json_decode($question['options'], true); ?>
                    <div class="question-container">
                        <h4>
                            <?= $question['question_text'] ?>
                            <?php if ($question['required']): ?>
                                <span class="required">*</span>
                            <?php endif; ?>
                        </h4>
                        <?php if (in_array($question['type'], ['1', '4'])): ?>
                            <?php foreach ($options as $option): ?>
                                <div class="option form-check">
                                    <input class="form-check-input" type="<?= $question['type'] === '4' ? 'checkbox' : 'radio' ?>" disabled>
                                    <label class="form-check-label"><?= $option ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif ($question['type'] === '2'): ?>
                            <input type="text" class="form-control" >
                        <?php elseif ($question['type'] === '3'): ?>
                            <textarea class="form-control" rows="3" ></textarea>
                        <?php elseif ($question['type'] === '5'): ?>
                            <select class="form-control" >
                                <?php foreach ($options as $option): ?>
                                    <option><?= $option ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <p>Unknown question type: <?= $question['type'] ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <a href="<?= base_url('home'); ?>" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <br>
</body>
</html>
