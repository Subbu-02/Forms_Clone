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
<body>
<div class="container mt-5">
    <br>
    <div class="card">
        <div class="card-body">
            <?php foreach ($response as $key => $value) {
                $response[$key] = trim($value, '"');
            }?>

            <h1 class="form-title" style="font-size: 50px;"><?= htmlspecialchars($form['form_title']) ?></h1>
            <div class="user-info">
                <p><h3><?= htmlspecialchars($user->name) ?></h3>
                Email: <?= htmlspecialchars($user->email) ?></p>
                <p>Filled at: <?= htmlspecialchars($created_at) ?></p>
            </div>
            <p class="form-description" style="font-size: 20px;"><?= htmlspecialchars($form['form_description']) ?></p>
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
            <button class="btn btn-primary mt-3" onclick="history.back()">Back to Responses</button>
        </div>
    </div>
</div>
</body>
</html>
