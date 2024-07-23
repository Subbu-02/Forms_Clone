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
        .info-container {
            display: flex; /* Use flexbox for layout */
            justify-content: space-between; /* Space between items */
            align-items: flex-start; /* Align items at the start */
            margin-top: 20px; /* Add space above */
        }
        .user-info {
            text-align: right; /* Align text to the right */
            font-size: 16px; /* Adjust font size */
        }
        .user-info h3 {
            margin: 0; /* Remove margin for a cleaner look */
            font-weight: bold; /* Make the name bold */
        }
        .user-info p {
            margin: 5px 0; /* Add vertical spacing between paragraphs */
        }
        .form-details {
            flex: 1; /* Allow form details to take available space */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <br>
    <div class="card">
        <div class="card-body">
            <?php foreach ($response as $key => $value) {
                $response[$key] = trim($value, '"');
            }?>

            <div class="info-container">
                <div class="form-details">
                    <h1 class="form-title" style="font-size: 50px;"><?= htmlspecialchars($form['form_title']) ?></h1>
                    <p class="form-description" style="font-size: 20px;"><?= htmlspecialchars($form['form_description']) ?></p>
                </div>
                <div class="user-info">
                    <h3><?= htmlspecialchars($user->name) ?></h3>
                    <p>Username: <?= htmlspecialchars($user->username) ?></p>
                    <p>Email: <?= htmlspecialchars($user->email) ?></p>
                    <p>Filled at: <?= htmlspecialchars($created_at) ?></p>
                </div>
            </div>
            <?php foreach ($questions as $index => $question): ?>
                <?php $options = json_decode($question['options'], true); ?>
                <div class="question-container">
                    <h4>
                        <?= htmlspecialchars($question['question_text']) ?>
                        <?php if ($question['required']): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </h4>
                    <?php if (in_array($question['type'], ['1', '4'])): ?>
                        <?php $response[$index] = json_decode($response[$index]);?>
                        <?php foreach ($response[$index] as $key => $val) {
                            $response[$index][$key] = trim($val, '"');
                        }?>
                        <?php foreach ($options as $option): ?>
                            <div class="option form-check">
                                <input class="form-check-input" type="<?= $question['type'] === '4' ? 'checkbox' : 'radio' ?>"
                                       <?= is_array($response[$index]) && in_array($option, $response[$index]) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label"><?= htmlspecialchars($option) ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($question['type'] === '2'): ?>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($response[$index]) ?>" disabled>
                    <?php elseif ($question['type'] === '3'): ?>
                        <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($response[$index]) ?></textarea>
                    <?php elseif ($question['type'] === '5'): ?>
                        <select class="form-control" disabled>
                            <?php foreach ($options as $option): ?>
                                <option <?= $option == $response[$index] ? 'selected' : '' ?>><?= htmlspecialchars($option) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <a href="<?php echo site_url('responses/responses_fetch/'.$form['form_id']); ?>" class="btn btn-primary">Back to Responses</a>
        </div>
    </div>
</div>
<br>
</body>
</html>