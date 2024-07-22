<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div class="container mt-5">
    <h2 class="mb-4">Responses for : <?php echo $form_title; ?></h2>
    <div class="table-responsive">
        <table id="responsesTable" class="table table-bordered table-hover table-striped" style="background-color: #ffffff; color: #343a40;">
            <thead class="thead-dark">
                <tr>
                    <th>User Name</th>
                    <th>Filled At</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($responses as $response) { ?>
                    <tr>
                        <td><?php echo $response->name; ?></td>
                        <td><?php echo $response->created_at; ?></td>
                        <td><a href="<?php echo site_url('responses/view_response/'.$response->created_at.'/'.$response->created_by.'/'.$form_id); ?>" class="btn btn-primary">View</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <button class="btn btn-primary mt-3" onclick="history.back()">Back</button>
</div>
<br>

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#responsesTable').DataTable({
            "pagingType": "full_numbers", // Full pagination controls
            "lengthMenu": [5, 10, 25, 50], // Options for number of rows per page
            "language": {
                "search": "Filter records:", // Custom search label
                "lengthMenu": "Show _MENU_ entries" // Custom length menu label
            },
            "columnDefs": [
                { "orderable": false, "targets": 2 } // Disable sorting for the "View" column (index 2)
            ],
            "order": [[1, "desc"]] // Default sort by "Filled At" column (index 1) in descending order
        });
        // $('#response-stats').click(function(event) {
        //     event.preventDefault(); // Prevent the default form submission

        //     var questions = [];
        //     $('.question-container').each(function() {
        //         var questionId = $(this).attr('id').split('-')[1];
        //         var questionText = $(this).find('.form-question').val();
        //         var questionType = $(this).find('.question-type').val();
        //         // var userId = $(this).find('.user-id').val();
        //         switch (questionType) {
        //             case 'multiple-choice':
        //                 questionType = 1;
        //                 break;
        //             case 'short-answer':
        //                 questionType = 2;
        //                 break;
        //             case 'paragraph': 
        //                 questionType = 3;
        //                 break;
        //             case 'checkboxes':
        //                 questionType = 4;
        //                 break;  
        //             case 'dropdown':
        //                 questionType = 5;
        //                 break;
        //         }
        //         var options = $(this).find('.option-input').map(function() {
        //             return $(this).val();
        //         }).get();
        //         var required = $(this).find('.required-btn').hasClass('btn-success') ? 1 : 0;

        //         questions.push({
        //             question_id: questionId,
        //             question_text: questionText,
        //             type: questionType,
        //             options: options,
        //             user_id: userId,
        //             required: required // Add this line to include the required field
        //         });
        //     });

        //     console.log("Sending data:", questions); // Debugging output

        //     $.ajax({
        //         url: '<?= base_url("forms/publish") ?>',
        //         method: 'POST',
        //         data: { questions: questions, form_id: $('#form_id').val(), form_title: $('#form_title').val(), form_description: $('#form_description').val() },
        //         success: function(response) {
        //             // console.log("Response:", response);
        //             // window.location.href ='<?= base_url("home") ?>';
        //             swal.fire({
        //                 title: 'Data saved and form published successfully',
        //                 icon: 'success',
        //                 confirmButtonColor: '#3085d6',
        //                 cancelButtonColor: '#d33',
        //                 confirmButtonText: 'Okay'
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = '<?= base_url("home") ?>';
        //                 }
        //             })
        //         },
        //         error: function(xhr, status, error) {
        //             // console.error('Error saving questions:', xhr, status, error);
        //             alert('An error occurred while saving the questions.');
        //         }
        //     });
        // });
    });
</script>