<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="<?php echo base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>/assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>/assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">DG</h1>

        </div>
        <h3>Welcome to Hello goald coast</h3>
        <p>Attraction and supplier management system login<!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->.</p>
        <form class="m-t" role="form" action="index.html">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            <a href="#"><small>Forgot password?</small></a>
<!--            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
        </form>
        <p class="m-t"> <small>&copy; 2014</small> Hello goald coast | Powered by <a href="http://www.digitalglare.com.au">Digital Glare</a></p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo base_url() ?>/assets/js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url() ?>/assets/js/bootstrap.min.js"></script>

</body>

</html>