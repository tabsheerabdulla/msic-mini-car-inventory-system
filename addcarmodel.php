<?php
require_once 'carManufacturer.php';

$car = new carManufacturer;
$result = $car->getManufacturer();
$count = 0;
$msg['message'] = '';

if ($_POST) {

    if ($_POST['manufacturer'] == "Manufacturer") {
        $msg['message'] = "* Please select a manufacturer <br>";
        $count++;
    }
    if ($_POST['carmfgyear'] < 1900 || $_POST['carmfgyear'] > date('Y')) {

        $msg['message'] .= "* Please provide valid manufacturing year (Between 1900 and " . date('Y') . ")<br>";
        $count++;
    }

    if (empty($_POST['carmodelname']) || empty($_POST['carcolor']) || empty($_POST['carregno']) || empty($_POST['comment'])) {
        $msg['message'] .= "* Please don't leave Car name, Car color or Car comment blank. <br>";
        $count++;
    }

    if ($_FILES['carimages']['error'][0] == 4) {

        $msg['message'] .= "* Please upload a Image <br>";
        $count++;
    } else if (count($_FILES['carimages']['name']) > 2) {
        $msg['message'] .= "* Please upload only 2 images for now. <br>";
        $count++;
    }


    if ($count == 0) {
        $car = new carModel;
        $msg = $car->addCar($_POST, $_FILES);
        echo json_encode($msg);
        die;
    } else {
        $msg['flag'] = false;
        echo json_encode($msg);
        die;
    }
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html>
    <head>
        <meta charset="UTF-8">
        <title>MCIS | Add Car Model</title>
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

            <div class="row">
                <div class="col-xs-12">
                    <div id="msg" class="msg"></div>
                </div>
            </div>
            <h3 class="text-center">Add a car model</h3>
            <form method="POST" action="" id="addcarmodel" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="input-group">
                            <select class="form-control input-lg" name="manufacturer"  required="true">
                                <option>Manufacturer</option>
                                <?php foreach ($result as $res) { ?>
                                    <option value="<?php echo $res[0] ?>"><?php echo $res[1] ?></option>
<?php } ?>
                            </select>
                            <span class="input-group-addon">Car Model</span>
                            <input type="text" class="form-control input-lg" name="carmodelname" required="true" placeholder="Car Name">

                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="input-group">
                            <span class="input-group-addon"> Color </span>
                            <input type="text" class="form-control input-lg"   required="true" name="carcolor" placeholder="Color">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <span class="input-group-addon">YOF</span>
                            <input type="text"  maxlength="4"    required="true" onkeypress='return event.charCode >= 48 && event.charCode <= 57'   class="form-control input-lg" name="carmfgyear" placeholder="Manufacuring Year" required="required">

                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <span class="input-group-addon">Reg No.</span>
                            <input type="text" class="form-control input-lg"  required="true" name="carregno" placeholder="Registration Number">
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea2">Note: </label>
                            <textarea class="form-control rounded-0" id="exampleFormControlTextarea2"  required="true" name="comment" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <label for="uploadImages">Upload car images: </label>
                        <br>
                        <label class="btn btn-info btn-lg" for="my-file-selector" style="width: 554px;height: 75px;line-height: 31px;">
                            <input id="my-file-selector"  required="true" class="carimages" type="file" name="carimages[]" multiple="true" style="display:none"
                                   onchange="$('#upload-file-info').html((this.files.length > 1) ? this.files.length + ' files' : this.files[0].name)"  accept="image/gif, image/jpeg, image/png" />
                            <span class ="glyphicon glyphicon-cloud-upload"></span> Upload in Cloud<br>
                            <span class='label label-info' id="upload-file-info"></span>
                        </label>

                    </div>
                    <div class="row text-center" >
                        <div class="col-xs-12">
                            <button type="button"  onclick="submitForm()" class="btn btn-primary btn-lg" style="width: 30%">Submit</button>
                            <a type="button" class="btn btn-success btn-lg" style="width: 30%" href="/MiniCarInvSys">Back </a>
                        </div>
                    </div>
                </div>
                <br>

            </form>
        </div> 

        <script>

            function submitForm() {
                $.ajax({
                    type: 'POST',
                    url: "addcarmodel.php",
                    data: new FormData($('form')[0]),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $('#msg').fadeIn('fast');
                        if (data.flag == true) {

                            $('.msg').html('<div class="alert alert-success"><strong>Success!<br></strong> ' + data.message + '</div>');

                        } else {

                            $('#msg').html('<div class="alert alert-danger"><strong>Failure!<br></strong>  ' + data.message + '</div>');

                        }
                        setTimeout(function () {
                            $('#msg').fadeOut('fast');
                        }, 2000);
                    }
                });
            }

        </script>
    </body>
</html>
