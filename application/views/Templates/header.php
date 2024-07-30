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
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://localhost/Forms_Clone/assets/js/script.js"></script>
    <style>
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 300px;
        padding: 15px;
        margin-top:50px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        z-index: 1000; /* Ensure it floats above other content */
        color: #ffffff; /* Text color to contrast with the background */
    }

    .alert-success {
        background-color: #00cc66;
        /* border-color: #1a252f; */
    }

    .alert-danger {
        background-color: #ff3300                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ;
        /* border-color: #1a252f; */
    }

    .fade-out {
        animation: fadeOut 15s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }

    body {
        margin: 0; /* Remove default margin */
        padding: 0; /* Remove default padding */
    }
</style>
</head>
<body>
    <header>
        <nav id="header-nav" class="navbar">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="navbar-brand">
                        <p style="padding: 0;">
                            <!-- The image should redirect to home page -->
                            <a href="<?php echo base_url(); ?>home"><img src="http://localhost/Forms_Clone/assets/images/aissel_logo.png" alt="Logo" style="height: 50px;"></a>
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
                                <button type="button" class="btn btn-success" style="color: #fff;" onclick="location.href='<?php echo site_url('fillform'); ?>';">Fill Form</button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-success" style="color: #fff;" onclick="location.href='<?php echo site_url('create'); ?>';">Create Form</button>
                            </li>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('current_page') == 'edit'): ?>
                            <li>
                                <button type="submit" id="form-publish" class="btn btn-success">Publish Form</button>
                            </li>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('current_page') == 'responses'): ?>
                            <li>
                                <button type="button" class="btn btn-success" style="color: #fff;" onclick="location.href='<?php echo site_url('responses/responseStats/'.$form_id); ?>';">Response Summary</button>
                            </li>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('current_page') == 'fillform'): ?>
                            <li>
                                <!-- <a href="<?= base_url('home'); ?>" class="btn btn-primary back-button" style="margin:0 20px 0 0; color:#ffffff;">Back</a> -->
                                <button type="button" class="btn btn-primary back-button" style="color: #fff;" onclick="location.href='<?= base_url('home'); ?>';">Back</button>
                            </li>
                            <?php endif; ?>
                            <li><a href="<?php echo base_url(); ?>users/logout">Logout</a></li>
                            <!-- <li><a href="#"><img src="http://localhost/Forms_Clone/assets/images/Subbu.png" alt="Subbu"></a></li> -->
                            <li><a href="<?php echo site_url('profile'); ?>"><span class="glyphicon glyphicon-user" style="font-size: 20px; color: #1b263a;" title="Profile"></span></a></li>
                        <?php endif; ?>
                        <!-- <li><a href="view_form.html" target="_blank" title="View Form"><span class="glyphicon glyphicon-eye-open"></span></a></li>
                        <li><a href="#" title="Back"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a href="#" title="Next"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        <li><a href="#"><button type="button" class="btn btn-success">Send</button></a></li>
                        <li><a href="#" title="Options"><span class="glyphicon glyphicon-option-vertical"></span></a></li> -->
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
    <?php if($this->session->flashdata('user_registered')): ?>
        <span class="alert alert-success fade-out"><?php echo $this->session->flashdata('user_registered'); ?></span>
    <?php endif; ?>

    <?php if($this->session->flashdata('login_failed')): ?>
        <span class="alert alert-danger fade-out""><?php echo $this->session->flashdata('login_failed'); ?></span>
    <?php endif; ?>

    <?php if($this->session->flashdata('user_loggedin')): ?>
        <span class="alert alert-success fade-out"><?php echo $this->session->flashdata('user_loggedin'); ?></span>
    <?php endif; ?>

    <?php if($this->session->flashdata('user_loggedout')): ?>
        <span class="alert alert-success fade-out"><?php echo $this->session->flashdata('user_loggedout'); ?></span>
    <?php endif; ?>

    <?php if($this->session->flashdata('form_errors')): ?>
        <span class="alert alert-danger fade-out"><?php echo $this->session->flashdata('form_errors'); ?></span>
    <?php endif; ?>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.add('fade-out');
            });
        }, 3000); // Change this value to set how long the message should be visible
    });
</script>
<style>
    /* General Reset and Body */
*, *::before, *::after, html, body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #f0f4f7;
}

/* Header and Navbar */
#header-nav {
    width: 100%;
    background-color: #0195db;
    background-size: cover;
    background-position: center;
    overflow: hidden;
    border: none;
    margin: 0;
    padding: 0;
    border-radius: 0%;
}

.navbar-brand img {
    filter: brightness(0) invert(1);
    height: 50px;
}

a {
    text-decoration: none;
}

a:hover {
    background-color: transparent;
    opacity: 0.7;
}

.nav>li>a:focus, .nav>li>a:hover {
    background-color: transparent;
    opacity: 0.7;
}

.navbar-header {
    display: flex;
    align-items: center;
    height: 64px;
    border-radius: 0%;
    justify-content: flex-start; /* Aligns navbar header to the left */
}

.container-fluid {
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-right {
    display: flex;
    align-items: center;
    margin-left: auto; /* Pushes navbar right to the right */
}

.navbar-right .nav {
    display: flex;
    align-items: center;
}

.navbar-right .nav li {
    margin-left: 10px;
}

/* .navbar-right .nav li a button {
    color: #000;
    font-size: 1em;
    background-color: #149b9b;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
}

.navbar-right .nav li a img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
} */

@media (max-width: 600px) {
    .navbar-right .nav li button {
        margin-top: 10px;
        padding: 5px 0px;
        font-size: 0.8em;
    }

    .navbar-right .nav li a {
        margin-top: 10px;
        padding: 5px 0px;
        font-size: 0.8em;
    }    
}

</style>