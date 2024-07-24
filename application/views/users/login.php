<?php echo form_open('users/login'); ?>
	<div class="row" style="margin: auto 0; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center;">
		<div class="col-md-4 col-md-offset-4" style="flex: 1; min-width: 200px;">
			<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Enter Username" required autofocus>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Login</button>
		</div>
	</div>
<?php echo form_close(); ?>
<style>
	@media (max-width: 768px) {
		.navbar {
			float: right;
		}
	}
</style>