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
                            <input type="text" class="Hvn9fb zHQkBf" jsname="YPqjbf" autocomplete="off" tabindex="0" aria-label="Document title" value="Untitled form" dir="auto" data-initial-dir="auto" data-initial-value="Untitled form" maxlength="25"> 
                            <a href="#" title="Save to Drive"><span class="glyphicon glyphicon-folder-open"></span></a>
                            <a href="#" title="Star Document" onclick="toggleStar()"><span id="star-icon" class="glyphicon glyphicon-star" aria-hidden="true"></span></a>
                        </p>
                    </div>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="view_form.html" target="_blank" title="View Form"><span class="glyphicon glyphicon-eye-open"></span></a></li>
                        <li><a href="#" title="Back"><span class="glyphicon glyphicon-step-backward"></span></a></li>
                        <li><a href="#" title="Next"><span class="glyphicon glyphicon-step-forward"></span></a></li>
                        <li><a href="#"><button type="button" class="btn btn-primary">Send</button></a></li>
                        <li><a href="#" title="Options"><span class="glyphicon glyphicon-option-vertical"></span></a></li>
                        <li><a href="#"><img src="http://localhost/Forms_Clone/assets/images/Subbu.png" alt="Subbu"></a></li>
                    </ul>
                </div>
            </div>
            <div class="navbar-tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Questions</a></li>
                    <li class="disabled"><a href="#" class="hover-only">Responses</a></li>
                    <li class="disabled"><a href="#" class="hover-only">Settings</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container form-container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title">Untitled form</h1>
                <p class="form-description">Form description</p>
            </div>
            <div class="form-body">
                <form id="google-form-clone">
                    <div id="questions-container">
                        <!-- Default question will be appended here -->
                    </div>
                </form>
            </div>
        </div>
        <div class="add-question-container">
            <button type="button" id="add-question" class="btn btn-secondary add-question-btn"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://localhost/Forms_Clone/assets/js/script.js"></script>
</body>
</html>