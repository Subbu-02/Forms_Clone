$(document).ready(function () {
    let questionCount = 0;

    function generateQuestionHtml(questionId) {
        return `
            <div class="form-group question-container" id="question-${questionId}">
                <div class="question-content">
                    <input type="text" class="form-control form-question" placeholder="Question ${questionId}">
                    <select class="form-control question-type" data-question-id="${questionId}">
                        <option value="multiple-choice">Multiple Choice</option>
                        <option value="short-answer">Short Answer</option>
                        <option value="paragraph">Paragraph</option>
                        <option value="checkboxes">Checkboxes</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                    <div class="form-options" id="form-options-${questionId}">
                        <div class="option">
                            <input type="text" class="form-control option-input" placeholder="Option 1">
                            <button type="button" class="remove-option" data-question-id="${questionId}">&times;</button>
                        </div>
                        <button type="button" class="btn btn-secondary add-option" data-question-id="${questionId}">Add option</button>
                        <button type="button" class="btn btn-secondary add-other" data-question-id="${questionId}">Add Other</button>
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

    function addQuestion(afterQuestionId) {
        questionCount++;
        const newQuestionHtml = generateQuestionHtml(questionCount);

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

    // Prevent click event propagation to the container
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

        // Check if the option being removed is the 'Other' option
        if (optionDiv.find('input').val() === 'Other') {
            // Re-add the "Add Other" button
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
        $(this).remove(); // Remove the Add Other button after adding the Other option
    });

    $(document).on('click', '.add-question-btn', function () {
        const questionId = $(this).data('question-id');
        addQuestion(questionId);
    });

    // Add a default multiple-choice question on document ready
    addQuestion();
});
