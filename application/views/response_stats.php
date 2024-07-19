
    <!-- <style>
        table.dataTable thead th, table.dataTable tbody td {
            border: 1px solid #ddd;
        }
    </style> -->
<div class="container mt-5">
    <h2 class="mb-4">All Responses</h2>

    <?php

    // Organize questions by their IDs for easy lookup
    $question_lookup = [];
    foreach ($questions as $question) {
        $question_lookup[$question['question_id']] = $question;
    }

    // Organize responses by question IDs
    $question_responses = [];
    foreach ($responses as $response) {
        $question_responses[$response->question_id][] = $response;
    }

    // Display responses ordered by questions
    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        if (isset($question_responses[$question_id])) {
            $question_text = $question['question_text'];
            echo "<h3 class='mt-4'>{$question_text}</h3>";
            echo "<table id='table_$question_id' class='table table-bordered'>";
            echo "<thead><tr><th>Response</th><th>Submitted By</th><th>Submitted At</th></tr></thead><tbody>";

            foreach ($question_responses[$question_id] as $response) {
                $response_text = is_array($response->response) ? implode(", ", $response->response) : $response->response;
                // Remove quotes if the response is a string
                $response_text = trim($response_text, '"');
                echo "<tr>";
                echo "<td>{$response_text}</td>";
                echo "<td>{$response->created_by}</td>";
                echo "<td>{$response->created_at}</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        }
    }
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        <?php foreach ($questions as $question): ?>
            $('#table_<?php echo $question['question_id']; ?>').DataTable();
        <?php endforeach; ?>
    });
</script>

