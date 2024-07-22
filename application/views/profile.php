<div class="container mt-5">
    <h1 class="text-center"><?php echo $title; ?></h1>
    <div class="card">
        <div class="card-body">
            <!-- <h2 class="card-title">User Profile</h2> -->
            <h3 class="card-text"><strong><?php echo $user->name; ?></strong></h3>
            <p class="card-text"><strong>Username:</strong> <?php echo $user->username; ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo $user->email; ?></p>
        </div>
    </div>
    <button class="btn btn-primary" onclick="history.back()">Back</button><br>
</div>
<br>