<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mini Car Inventory System</title>
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
    <div class="col-sm-4">
      
      <div class="thumbnail">
          <a href="AddManufacturer.php" target="_self">
            <div class="caption text-center">
              <h3>Add Manufacturer</h3>
            <p>Click here to add a car manufacturer</p>
          </div>
          <img src="assets/images/manufacturer.jpg" class="img-thumbnail" alt="Fjords" style="width:80%">
          
        </a>
      </div>
    </div>
    <div class="col-sm-4">
      
      <div class="thumbnail">
          <a href="addcarmodel.php" target="_self">
            <div class="caption text-center">
              <h3>Add Model</h3>
            <p>Click here to add a car model</p>
          </div>
          <img src="assets/images/image4.jpg" class="img-thumbnail"  alt="Fjords" style="width:80%">
        </a>
      </div>
    </div>
    <div class="col-sm-4">
             
      <div class="thumbnail">
        <a href="inventory.php" target="_self">
            <div class="caption text-center">
            <h3>View Inventory</h3> 
            <p>Click here to view inventory</p>
          </div>
          <img src="assets/images/inventory.jpg" class="img-thumbnail" alt="Fjords" style="width:80%">
        </a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
