<?php
require_once 'carManufacturer.php';

$car = new carModel;
$result = $car->getCar();
$car = new carModel;
if ($_POST) {
    if ($_POST['typ'] == "get") {

        $result = $car->getCarInfo($_POST);

        echo json_encode($result);
        die;
    } else if ($_POST['typ'] == "sold") {

        $result = $car->dltCarInfo($_POST);
        echo json_encode($result);
        die;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MCIS | Inventory</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
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
            <h3 class="text-center">View Inventory</h3>
            <div class="row">
                <table id="example" class="table table-striped table-bordered" style="width:100%; cursor:pointer;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Manufacturer</th>
                            <th>Car Name</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($result as $ky => $rsl) { ?>
                            <tr onclick="process(<?php echo $rsl[0] ?>, 'get')">

                                <td><?php echo $ky + 1 ?></td>
                                <td><?php echo $rsl[2] ?></td>
                                <td><?php echo $rsl[1] ?></td>
                                <td><?php echo $rsl[3] ?></td>

                            </tr>
<?php } ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Car Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="msg" class="msg"></div>
                            </div>
                        </div>
                        <div class="body">

                        </div>
                    </div>
                    <div class="modal-footer">


                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
        });
    });
    function process(id, type) {
        $.ajax({
            type: 'POST',
            url: "inventory.php",
            data: {idV: id, typ: type},
            dataType: 'json',
            cache: false,
            success: function (data) {
                if (data.type == 'get') {
                    $('#myModal .modal-body .body').html(data.body);
                    $('#myModal').modal('show');
                } else if (data.type == 'sold') {
                    $('#myModal').animate({scrollTop: 0}, 'fast');
                    if (data.flag) {
                        $('#myModal .modal-body .msg').html('<div class="alert alert-success"><strong>Success!<br></strong> ' + data.message + '</div>');

                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        $('#myModal .modal-body .msg').html('<div class="alert alert-danger"><strong>Failure!<br></strong> ' + data.message + '</div>');
                    }

                }

            }
        });

    }

</script>