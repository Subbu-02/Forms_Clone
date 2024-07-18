<div class="container">
    <h2>Responses for : <?php echo $form_title; ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Timestamp</th>
                <!-- <th>Responses</th> -->
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <!-- <?php print_r($responses['name']);?> -->
            <?php foreach ($responses as $response) { ?>
                <tr>
                    <td><?php echo $response->created_by; ?></td>
                    <td><?php echo $response->created_at; ?></td>
                    <!-- <td><?php echo $response->responses; ?></td> -->
                    <td><a href="<?php echo site_url('forms/view_response/'.$response->created_at.'/'.$response->created_by); ?>" class="btn btn-primary">View</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
