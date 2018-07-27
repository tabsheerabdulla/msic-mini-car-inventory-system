<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'carManufacturer.php';
if ($_POST) {
    if ($_POST['manufacturer']) {
        $mfg = new carManufacturer;
        $msg = $mfg->addManufacturer($_POST['manufacturer']);
    } else {
        $msg['flag'] = false;
        $msg['message'] = "Please provide required input";
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>MCIS | Add Manufacturer</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="jumbotron text-center" style="padding-top:  5px;padding-bottom:  5px;">
            <h1>Mini Car Inventory System</h1>
            <p>Inventory of all your cars</p> 
        </div>
        <div class="container">
            <div class="row pull-right">
                <div class="col-xs-12">
                    <a type="button" class="btn btn-success btn-lg"  href="/MiniCarInvSys">Back </a>
                </div>
            </div>
            <br>
            <h3 class="text-center">Add a Manufacturer</h3>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" class="form-control input-lg" placeholder="Add Manufacturer" name="manufacturer" >
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-lg" type="submit" value="Submit">
                            Submit
                        </button>
                    </span>
                </div>
                <br>
                <?php
                if (isset($msg)) {
                    if ($msg['flag']) {
                        ?>

                        <div class="alert alert-success">
                            <strong>Success!</strong> <?php echo $msg['message']; ?>
                        </div>
                        <?php
                    } else {
                        ?> 
                        <div class="alert alert-danger">
                            <strong>Failure!</strong> <?php echo $msg['message']; ?>
                        </div>

                        <?php
                    }
                }
                ?>  
            </form>
        </div>
    </body>
</html>
