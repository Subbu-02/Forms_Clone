<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Form Clone</title>
    <link rel="icon" type="image/x-icon" href="http://localhost/Forms_Clone/assets/images/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/3/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/Forms_Clone/assets/css/styles.css">
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
</head>
<body>
    <header>
        <nav id="header-nav" class="navbar">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="navbar-brand">
                        <p>
                            <img src="http://localhost/Forms_Clone/assets/images/aissel_logo.png" alt="Logo">
                            <input type="text" class="form-control" jsname="YPqjbf" autocomplete="off" tabindex="0" aria-label="Document title" value="Untitled form" dir="auto" data-initial-dir="auto" data-initial-value="Untitled form" maxlength="25"> 
                            <!-- <a href="#" title="Save to Drive"><span class="glyphicon glyphicon-folder-open"></span></a>
                            <a href="#" title="Star Document" onclick="toggleStar()"><span id="star-icon" class="glyphicon glyphicon-star" aria-hidden="true"></span></a> -->
                        </p>
                    </div>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <?php if(!$this->session->userdata('logged_in')) : ?>
                            <li><a href="<?php echo base_url(); ?>users/login">Login</a></li>
                            <li><a href="<?php echo base_url(); ?>users/register">Register</a></li>
                        <?php endif; ?>
                        <!-- <li><a href="view_form.html" target="_blank" title="View Form"><span class="glyphicon glyphicon-eye-open"></span></a></li>
                        <li><a href="#" title="Back"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a href="#" title="Next"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        <li><a href="#"><button type="button" class="btn btn-primary">Send</button></a></li>
                        <li><a href="#" title="Options"><span class="glyphicon glyphicon-option-vertical"></span></a></li>
                        <li><a href="#"><img src="http://localhost/Forms_Clone/assets/images/Subbu.png" alt="Subbu"></a></li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <?php if($this->session->flashdata('login_failed')): ?>
            <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>'; ?>
        <?php endif; ?>

        <?php if($this->session->flashdata('user_loggedin')): ?>
            <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
        <?php endif; ?>

        <?php if($this->session->flashdata('user_loggedout')): ?>
            <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
        <?php endif; ?>
    </div>