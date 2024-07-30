    <!-- <style>
        table.dataTable thead th, table.dataTable tbody td {
            border: 1px solid #ddd;
        }
    </style> -->

<div class="container mt-5">
    <h2 class="mb-4">All Responses</h2>
    <hr style='border-top: 2px solid #1b263a; height:10px; margin-left: auto; margin-right:auto;'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    // print_r($responses);
    // Display responses ordered by questions
    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        if (isset($question_responses[$question_id])) {
            $question_text = $question['question_text'];
            $question['options'] = json_decode($question['options'], true);
            // print_r($question['options']);
            // print_r($question_responses[$question_id]);
            echo "<div style='text-align: center;'></div><h4 class='mt-4'>Question: <strong>{$question_text}</strong></h4>";
            echo "<table id='table_$question_id' class='display' >";
            echo "<thead><tr><th>Response</th><th>Submitted By</th><th>Submitted At</th></tr></thead><tbody>";

            foreach ($question_responses[$question_id] as $response) {
                $response_text = $response->response;
                // Remove brackets, quotes, and add proper comma separation
                if (is_string($response_text)) {
                    $response_text = trim($response_text, '[]"');
                    $response_array = explode('","', $response_text);
                    $response_array = array_map('trim', $response_array);
                    $response_array = array_filter($response_array, function($value) { return $value !== '' && $value !== 'null'; });
                    $response_text = implode(', ', $response_array);
                } elseif (is_array($response_text)) {
                    $response_array = array_filter($response_text, function($value) { return $value !== '' && $value !== 'null'; });
                    $response_text = implode(', ', $response_array);
                } else {
                    $response_text = '';
                }
                // Display a hyphen if the response is empty
                $response_text = $response_text === '' ? '-' : $response_text; 
                echo "<tr>";
                echo "<td>{$response_text}</td>";
                echo "<td>{$response->user_data->name}</td>";
                echo "<td>{$response->created_at}</td>";
                echo "</tr>";
            }

            echo "</tbody></table><br>";
            if (!empty($question['options']) && is_array($question['options']) && ($question['type'] == 1 || $question['type'] == 5)) {
                // Prepare data for the pie chart
                $option_counts = array_fill_keys($question['options'], 0);
                // print_r($option_counts);
                foreach ($question_responses[$question_id] as $response) {
                    $response_text = $response->response;
                    // Remove brackets, quotes, and add proper comma separation
                    if (is_string($response_text)) {
                        $response_text = trim($response_text, '[]"');
                        $response_array = explode('","', $response_text);
                        $response_array = array_map('trim', $response_array);
                        $response_array = array_filter($response_array, function($value) { return $value !== '' && $value !== 'null'; });
                        $response_text = implode(', ', $response_array);
                    } elseif (is_array($response_text)) {
                        $response_array = array_filter($response_text, function($value) { return $value !== '' && $value !== 'null'; });
                        $response_text = implode(', ', $response_array);
                    } else {
                        $response_array = [];
                    }
                    foreach ($response_array as $option) {
                        if (isset($option_counts[$option])) {
                            $option_counts[$option]++;
                        }
                    }
                }
                // Remove options with zero count
                $option_counts = array_filter($option_counts);
                $chart_data = json_encode(array_values($option_counts));
                $chart_labels = json_encode(array_keys($option_counts));
                
                // echo "<h4 class='mt-4'>Question: {$question_text}</h4>";
                echo "<canvas class='chart' id='chart_$question_id'></canvas>";
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
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 16 // Increase label font size
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Response Distribution',
                                    font: {
                                        size: 20 // Increase title font size
                                    }
                                }
                            }
                        }
                    });
                </script>";
            } 
        }
    }
    ?>
    <hr style='border-top: 2px solid #1b263a; height:10px; margin-left: auto; margin-right:auto;'>
    <a href="<?php echo site_url('responses/responses_fetch/'.$form['form_id']); ?>" class="btn btn-primary">Back to Responses</a>
</div>
<br>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        <?php foreach ($questions as $question): ?>
            $('#table_<?php echo $question['question_id']; ?>').DataTable({"lengthMenu": [5, 10, 25, 50]});
        <?php endforeach; ?>
    });
</script>

<?php
// Check if $questions is set and is an array
if (!isset($questions) || !is_array($questions)) {
    echo "<p>No questions found.</p>";
} else {
    // Group responses by question ID
    $grouped_responses = array();
    foreach ($responses as $response) {
        $question_id = $response->question_id;
        if (!isset($grouped_responses[$question_id])) {
            $grouped_responses[$question_id] = array();
        }
        $grouped_responses[$question_id][] = $response;
    }

    // Function to generate random color
    function random_color() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    // Loop through each question and create a pie chart for types 1 and 5
    foreach ($questions as $question) {
        if (!isset($question['question_id']) || !isset($question['question_type']) || !isset($question['question_text'])) {
            continue; // Skip this question if it's missing required fields
        }

        $question_id = $question['question_id'];
        $question_type = $question['question_type'];
        
        // Only process question types 1 and 5
        if ($question_type == 1 || $question_type == 5) {
            if (isset($grouped_responses[$question_id])) {
                $question_responses = $grouped_responses[$question_id];
                
                // Count occurrences of each response
                $response_counts = array();
                foreach ($question_responses as $response) {
                    $answer = trim($response->response, '"');
                    if ($question_type == 5) {
                        // For multiple choice, split the response
                        $choices = json_decode($answer, true);
                        if (is_array($choices)) {
                            foreach ($choices as $choice) {
                                if (!isset($response_counts[$choice])) {
                                    $response_counts[$choice] = 1;
                                } else {
                                    $response_counts[$choice]++;
                                }
                            }
                        }
                    } else {
                        if (!isset($response_counts[$answer])) {
                            $response_counts[$answer] = 1;
                        } else {
                            $response_counts[$answer]++;
                        }
                    }
                }

                // Only create chart if there are responses
                if (!empty($response_counts)) {
                    // Prepare data for Chart.js
                    $labels = json_encode(array_keys($response_counts));
                    $data = json_encode(array_values($response_counts));

                    // Generate colors for each slice
                    $colors = json_encode(array_map('random_color', $response_counts));

                    echo "<h4 class='mt-4'>{$question['question_text']}</h4>";
                    echo "<canvas id='chart_$question_id'></canvas>";

                    echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var ctx = document.getElementById('chart_$question_id').getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: $labels,
                                datasets: [{
                                    data: $data,
                                    backgroundColor: $colors
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 16 // Increase label font size
                                            }
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Response Distribution',
                                        font: {
                                            size: 20 // Increase title font size
                                        }
                                    }
                                }
                            }
                        });
                    });
                    </script>";
                } else {
                    echo "<p>No responses for question: {$question['question_text']}</p>";
                }
            } else {
                echo "<p>No responses found for question: {$question['question_text']}</p>";
            }
        }
    }
}
?>
<style>
    canvas{
        height: 600px !important; 
        width: 600px !important;
        display: block; /* Centering the canvas */
        margin: 0 auto; /* Centering the canvas */
    }

@media (max-width: 768px) {
    canvas {
        height: 300px !important; /* Shrinking the canvas height for smaller screens */
        width: 300px !important; /* Shrinking the canvas width for smaller screens */
    }
}
</style>