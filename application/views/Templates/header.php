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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://localhost/Forms_Clone/assets/js/script.js"></script>
</head>
<body>
    <header>
        <nav id="header-nav" class="navbar">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="navbar-brand">
                        <p style="padding: 0;">
                            <!-- The image should redirect to home page -->
                            <a href="<?php echo base_url(); ?>home"><img src="http://localhost/Forms_Clone/assets/images/aissel_logo.png" alt="Logo"></a>
                            <!-- <input type="text" class="form-control" jsname="YPqjbf" autocomplete="off" tabindex="0" aria-label="Document title" value="Untitled form" dir="auto" data-initial-dir="auto" data-initial-value="Untitled form" maxlength="25">  -->
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
                        <?php if($this->session->userdata('logged_in')) : ?>
                            <!-- <li><a href="<?php echo base_url(); ?>posts/create">Create Post</a></li>
                            <li><a href="<?php echo base_url(); ?>categories/create">Create Category</a></li> -->
                            <?php if ($this->session->userdata('current_page') == 'home'): ?>
                            <li>
                                <a href="<?php echo site_url('fillform'); ?>" class="btn btn-primary" style="color: #fff;">Fill Form</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('create'); ?>" class="btn btn-primary" style="color: #fff;">Create Form</a>
                            </li>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('current_page') == 'edit'): ?>
                            <li>
                                <!-- I want a save draft button and this should save the form to the database and redirect to home page -->
                                <!-- <button type="submit" form="form-edit" class="btn btn-primary">Save Draft</button> -->
                            </li>
                            <li>
                                <!-- I want a publish button and this should save the form to the database and redirect to home page -->
                                <button type="submit" id="save-form" class="btn btn-success">Publish Form</button>
                            </li>
                            <?php endif; ?>
                            <li><a href="<?php echo base_url(); ?>users/logout">Logout</a></li>
                            <!-- <li><a href="#"><img src="http://localhost/Forms_Clone/assets/images/Subbu.png" alt="Subbu"></a></li> -->
                            <li><a href="#"><span class="glyphicon glyphicon-user" style="font-size: 20px; color: #1b263a;" title="Profile"></span></a></li>
                        <?php endif; ?>
                        <!-- <li><a href="view_form.html" target="_blank" title="View Form"><span class="glyphicon glyphicon-eye-open"></span></a></li>
                        <li><a href="#" title="Back"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a href="#" title="Next"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        <li><a href="#"><button type="button" class="btn btn-primary">Send</button></a></li>
                        <li><a href="#" title="Options"><span class="glyphicon glyphicon-option-vertical"></span></a></li> -->
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <?php if($this->session->flashdata('user_registered')): ?>
            <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
        <?php endif; ?>

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