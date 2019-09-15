<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Layout</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="#">Nội dung</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid my-2">
    <div class="row">
        <div class="col-3">
            <?php
                $this->renderPartial('layouts/sidebar', ['title' => 'Main sidebar'])
            ?>
        </div>
        <div class="col-9">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer text-muted text-center">
    Copyright @ 2019
</footer>

<script type="text/javascript" src="assets/bootstrap/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/popper.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/bootstrap.min.js"></script>
</body>
</html>