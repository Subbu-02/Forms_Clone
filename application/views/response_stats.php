    <!-- <style>
        table.dataTable thead th, table.dataTable tbody td {
            border: 1px solid #ddd;
        }
    </style> -->

<div class="container mt-5">
    <h2 class="mb-4">All Responses</h2>
    <hr style='border-top: 2px solid #1b263a; height:10px; margin-left: auto; margin-right:auto;'>
    <?php

    // Organize questions by their IDs for easy lookup

use function PHPSTORM_META\type;

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
            // Check if the question has options and is an array
            $options_type = gettype($question['options']);
            print($options_type);
            if (!empty($question['options']) && is_array($question['options'])) {
                // Ensure options are structured correctly
                if (array_is_list($question['options'])) {
                    // Prepare data for the pie chart
                    $option_counts = array_fill_keys(array_column($question['options'], 'option_text'), 0);
                    foreach ($question_responses[$question_id] as $response) {
                        $response_text = is_array($response->response) ? implode(", ", $response->response) : $response->response;
                        if (isset($option_counts[$response_text])) {
                            $option_counts[$response_text]++;
                        }
                    }
                    $chart_data = json_encode(array_values($option_counts));
                    $chart_labels = json_encode(array_keys($option_counts));
                    echo "<canvas id='chart_$question_id' width='400' height='200'></canvas>";
                    echo "<script>
                        var ctx = document.getElementById('chart_$question_id').getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: $chart_labels,
                                datasets: [{
                                    data: $chart_data,
                                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                                }]
                            }
                        });
                    </script>";
                } else {
                    // Handle the case where options are not structured correctly
                    echo "<p>Options for question '{$question_text}' are not structured correctly.</p>";
                }
            }
            echo "<div style='text-align: center;'></div><h4 class='mt-4'>Question: <strong>{$question_text}</strong></h4>";
            echo "<table id='table_$question_id' class='display' >";
            echo "<thead><tr><th>Response</th><th>Submitted By</th><th>Submitted At</th></tr></thead><tbody>";

            foreach ($question_responses[$question_id] as $response) {
                $response_text = is_array($response->response) ? implode(", ", $response->response) : $response->response;
                // Remove quotes if the response is a string
                $response_text = trim($response_text, '"');
                // Display a hyphen if the response is empty
                $response_text = $response_text === '' ? '-' : $response_text; 
                echo "<tr>";
                echo "<td>{$response_text}</td>";
                echo "<td>{$response->user_data->name}</td>";
                echo "<td>{$response->created_at}</td>";
                echo "</tr>";
            }

            echo "</tbody></table><br>";
        }
    }
    ?>
    <hr style='border-top: 2px solid #1b263a; height:10px; margin-left: auto; margin-right:auto;'>
    <a href="<?php echo site_url('responses/responses_fetch/'.$form['form_id']); ?>" class="btn btn-primary">Back to Responses</a>
</div>
<br>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        <?php foreach ($questions as $question): ?>
            $('#table_<?php echo $question['question_id']; ?>').DataTable({"lengthMenu": [5, 10, 25, 50]});
        <?php endforeach; ?>
    });
</script>