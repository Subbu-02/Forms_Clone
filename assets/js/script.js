$(document).ready(function () {
    let questionCount = numberOfQuestions -1;

    function generateQuestionHtml(questionId, questionData = null) {
        const questionText = questionData ? questionData.text : `Question ${questionId}`;
        const questionType = questionData ? questionData.type : 'multiple-choice';

        let optionsHtml = '';
        if (questionData && questionData.options) {
            questionData.options.forEach((option, index) => {
                optionsHtml += `
                    <div class="option">
                        <input type="text" class="form-control option-input" value="${option}">
                        <button type="button" class="remove-option" data-question-id="${questionId}">&times;</button>
                    </div>
                `;
            });
        } else if (['multiple-choice', 'checkboxes', 'dropdown'].includes(questionType)) {
            optionsHtml = `
                <div class="option">
                    <input type="text" class="form-control option-input" placeholder="Option 1">
                    <button type="button" class="remove-option" data-question-id="${questionId}">&times;</button>
                </div>
                <button type="button" class="btn btn-secondary add-option" data-question-id="${questionId}">Add option</button>
                ${questionType !== 'dropdown' ? `<button type="button" class="btn btn-secondary add-other" data-question-id="${questionId}">Add Other</button>` : ''}
            `;
        }

        return `
            <div class="form-group question-container" id="question-${questionId}">
                <div class="question-content">
                    <input type="text" class="form-control form-question" placeholder="${questionText}" value="${questionText}">
                    <select class="form-control question-type" data-question-id="${questionId}">
                        <option value="multiple-choice" ${questionType === 'multiple-choice' ? 'selected' : ''}>Multiple Choice</option>
                        <option value="short-answer" ${questionType === 'short-answer' ? 'selected' : ''}>Short Answer</option>
                        <option value="paragraph" ${questionType === 'paragraph' ? 'selected' : ''}>Paragraph</option>
                        <option value="checkboxes" ${questionType === 'checkboxes' ? 'selected' : ''}>Checkboxes</option>
                        <option value="dropdown" ${questionType === 'dropdown' ? 'selected' : ''}>Dropdown</option>
                    </select>
                    <div class="form-options" id="form-options-${questionId}">
                        ${optionsHtml}
                    </div>
                </div>
                <div class="form-actions text-right">
                    <button type="button" class="btn btn-default required-btn" data-question-id="${questionId}">Required</button>
                    <button type="button" class="btn btn-default duplicate-btn" data-question-id="${questionId}" title="Duplicate Question">
                        <span class="glyphicon glyphicon-duplicate"></span>
                    </button>
                    <button type="button" class="btn btn-danger delete-btn" data-question-id="${questionId}" title="Delete Question">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                    <button type="button" class="btn btn-secondary add-question-btn" data-question-id="${questionId}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </div>
        `;
    }

    function addQuestion(afterQuestionId, questionData = null) {
        questionCount++;
        const newQuestionHtml = generateQuestionHtml(questionCount, questionData);

        if (afterQuestionId) {
            $(`#question-${afterQuestionId}`).after(newQuestionHtml);
        } else {
            $('#questions-container').append(newQuestionHtml);
        }

        selectQuestion(questionCount);
    }

    function selectQuestion(questionId) {
        $('.form-group').removeClass('selected');
        $(`#question-${questionId}`).addClass('selected');
    }

    $(document).on('click', '.question-container', function () {
        const questionId = $(this).attr('id').split('-')[1];
        selectQuestion(questionId);
    });

    $(document).on('click', '.form-question, .question-type, .form-options, .form-actions button', function (e) {
        e.stopPropagation();
    });

    $(document).on('change', '.question-type', function () {
        const questionId = $(this).data('question-id');
        const type = $(this).val();
        let optionsHtml = '';

        if (type === 'multiple-choice' || type === 'checkboxes' || type === 'dropdown') {
            optionsHtml = `
                <div class="option">
                    <input type="text" class="form-control option-input" placeholder="Option 1">
                    <button type="button" class="remove-option" data-question-id="${questionId}">&times;</button>
                </div>
                <button type="button" class="btn btn-secondary add-option" data-question-id="${questionId}">Add option</button>
                ${type !== 'dropdown' ? `<button type="button" class="btn btn-secondary add-other" data-question-id="${questionId}">Add Other</button>` : ''}
            `;
        }

        $(`#form-options-${questionId}`).html(optionsHtml);
    });

    $(document).on('click', '.delete-btn', function () {
        const questionId = $(this).data('question-id');
        $(`#question-${questionId}`).remove();
    });

    $(document).on('click', '.required-btn', function () {
        const questionId = $(this).data('question-id');
        $(this).toggleClass('btn-success');
    });

    $(document).on('click', '.duplicate-btn', function () {
        const questionId = $(this).data('question-id');
        questionCount++;
        const newQuestionHtml = generateQuestionHtml(questionCount);
        $(`#question-${questionId}`).after(newQuestionHtml);
        selectQuestion(questionCount);
    });

    $(document).on('click', '.add-option', function () {
        const questionId = $(this).data('question-id');
        const optionCount = $(`#form-options-${questionId} .option`).length + 1;
        const newOptionHtml = `
            <div class="option">
                <input type="text" class="form-control option-input" placeholder="Option ${optionCount}">
                <button type="button" class="remove-option" data-question-id="${questionId}">&times;</button>
            </div>
        `;
        $(this).before(newOptionHtml);
    });

    $(document).on('click', '.remove-option', function () {
        const optionDiv = $(this).closest('.option');
        const questionId = $(this).data('question-id');

        if (optionDiv.find('input').val() === 'Other') {
            $(`#form-options-${questionId} .add-other`).remove();
            const addOtherButtonHtml = `<button type="button" class="btn btn-secondary add-other" data-question-id="${questionId}">Add Other</button>`;
            $(`#form-options-${questionId} .add-option`).after(addOtherButtonHtml);
        }

        optionDiv.remove();
    });

    $(document).on('click', '.add-other', function () {
        const questionId = $(this).data('question-id');
        const otherOptionHtml = `
            <div class="option">
                <input type="text" class="form-control option-input" value="Other" readonly>
                <button type="button" class="remove-option" data-question-id="${questionId}">&times;</button>
            </div>
        `;
        $(this).before(otherOptionHtml);
        $(this).remove();
    });

    $(document).on('click', '.add-question-btn', function () {
        const questionId = $(this).data('question-id');
        addQuestion(questionId);
    });

    if (questionsFromDatabase && questionsFromDatabase.length > 0) {
        questionsFromDatabase.forEach((questionData) => {
            addQuestion(null, questionData);
        });
    } else {
        addQuestion();
    }
});