<?php

require_once 'dbConnect.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of addManufacturer
 *
 * @author tabsheer.abdulla
 */
class carManufacturer {

    function __construct() {

        // connecting to database  
        // $db = new dbConnect();
    }

    public function addManufacturer($name) {
        $dbfun = new dbFunction;

        $result = $dbfun->addManufacturer($name);
        if ($result) {
            $rslt['message'] = "Successfully added a Manufacturer";
            $rslt['flag'] = true;
        } else {
            $rslt['message'] = "Something went wrong. Manufacturer already added.";
            $rslt['flag'] = false;
        }

        return $rslt;
    }

    public function getManufacturer() {

        $dbfun = new dbFunction;

        $result = $dbfun->getManufacturer();

        return $result;
    }

}

class carModel extends carManufacturer {

    function __construct() {

        // connecting to database  
        //$db = new dbConnect();
    }

    public function addCar($data) {

        $dbfun = new dbFunction;

        //    Check if it exists

        $chk = $dbfun->checkCarExists($data['carmodelname']);

        if (!$chk) {
            $targetDir = "uploads/";
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            $rslt = array();
            $images_arr = array();
            $data['imageName'] = "";
            foreach ($_FILES['carimages']['name'] as $key => $val) {
                $image_name = $_FILES['carimages']['name'][$key];
                $tmp_name = $_FILES['carimages']['tmp_name'][$key];
                $size = $_FILES['carimages']['size'][$key];
                $type = $_FILES['carimages']['type'][$key];
                $error = $_FILES['carimages']['error'][$key];

                // File upload path
                $fileName = rand(1000, 1000000) . $image_name;
                $targetFilePath = $targetDir . $fileName;

                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    // Store images on the server
                    if (move_uploaded_file($_FILES['carimages']['tmp_name'][$key], $targetFilePath)) {

                        if ($key == (count($_FILES['carimages']['name']) - 1)) {
                            $data['imageName'] .= $fileName;
                            $result = $dbfun->addCar($data);
                            if ($result) {
                                $rslt['message'] = "Successfully added a Car model";
                                $rslt['flag'] = true;
                            } else {
                                $rslt['message'] = "Something went wrong. Car model already exist";
                                $rslt['flag'] = false;
                            }
                        } else {
                            $data['imageName'] .= $fileName . ',';
                        }
                    }
                } else {
                    $rslt['message'] = "Image format is not yet supported for uploading..";
                    $rslt['flag'] = false;
                }
            }
        } else {

            $rslt['message'] = "Car name already exist. So updated the Inventory";
            $rslt['flag'] = True;
        }


        return $rslt;
    }

    public function getCar() {

        $dbfun = new dbFunction;

        $result = $dbfun->getCarDetails();

        return $result;
    }

    public function getCarInfo($postdata) {

        $dbfun = new dbFunction;

        $result = $dbfun->getCarInfoDb($postdata['idV']);
        $result[7] = explode(',', $result[7]);
        $data['type'] = $postdata['typ'];
        $data['body'] = "<div class='row' ><div class='col-sm-12' ><table class='table' ><tbody><tr><td>Manufacturer: </td> <td>$result[10]</td></tr><tr><td>Car Name: </td><td>$result[1]</td> </tr><tr><td>Reg No: </td><td>$result[5]</td>   
      </tr><tr><td>Mfg year: </td><td>$result[3]</td></tr><tr><td>Note: </td><td>$result[6]</td></tr><tr><td>Cars Available: </td><td>$result[8]</td> 
      </tr><tr><td>Color: </td><td>$result[4]</td> </tr><tr><td class='text-center' colspan='2'><b>Images</b></td></tr><tr><td colspan='2'><img src='uploads/" . $result[7][0] . "' class='col-sm-6 img-responsive img-thumbnail'><img src='uploads/" . $result[7][1] . "' class='col-sm-6 img-responsive img-thumbnail'></td>
        </tr></tbody></table><button type='button' class='btn btn-primary btn-lg' style='width:100%' onclick='process($result[0],\"sold\")'>Sold</button></div></div>";
        return $data;
    }

    public function dltCarInfo($data) {

        $dbfun = new dbFunction;
        $result['flag'] = $dbfun->dltCarInfoDb($data['idV']);
        if ($result['flag']) {
            $result['message'] = "Updated it successfully";
            $result['type'] = $data['typ'];
        } else {
            $result['message'] = "Something went wrong";
            $result['type'] = $data['typ'];
        }
        return $result;
    }

}

class dbFunction {

    function __construct() {

        // connecting to database  
        $db = new dbConnect();
    }

    // destructor  
    function __destruct() {
        
    }

    public function addManufacturer($name) {
        $qr = mysql_query("INSERT INTO manufacturer(name) values('" . $name . "')") or mysql_error();

        return $qr;
    }

    public function getManufacturer() {
        $qr = mysql_query("SELECT * FROM manufacturer") or mysql_error();

        $array_result = array();
        while ($row = mysql_fetch_array($qr, MYSQL_NUM)) {
            $array_result[] = $row;
        }
        return $array_result;
    }

    public function addCar($data) {
        $values = "('" . $data['carmodelname'] . "'," . $data['manufacturer'] . "," . $data['carmfgyear'] . ",'" . $data['carcolor'] . "','" . $data['carregno'] . "','" . $data['comment'] . "','" . $data['imageName'] . "')";
        $qr = mysql_query("INSERT INTO carmodel(car_name,manufacturer_id,mfg_year,car_color,reg_no,comments,car_img_name) values" . $values) or mysql_error();
        return $qr;
    }

    public function checkCarExists($data) {
        $qr = mysql_query("SELECT * FROM carmodel where car_name ='" . $data . "'");

        if (mysql_num_rows($qr) > 0) {

            $qr = mysql_query("UPDATE carmodel SET count = count + 1 WHERE car_name ='" . $data . "'");
            return true;
        } else {
            return false;
        }
    }

    public function getCarDetails() {
        $qr = mysql_query("SELECT carmodel.id, carmodel.car_name, manufacturer.name, carmodel.count FROM carmodel join manufacturer on carmodel.manufacturer_id = manufacturer.id") or mysql_error();

        $array_result = array();
        while ($row = mysql_fetch_array($qr, MYSQL_NUM)) {
            $array_result[] = $row;
        }

        return $array_result;
    }

    public function getCarInfoDb($id) {
        $qr = mysql_query("SELECT * FROM carmodel join manufacturer on carmodel.manufacturer_id = manufacturer.id WHERE carmodel.id =" . $id) or mysql_error();


        return mysql_fetch_row($qr);
    }

    public function dltCarInfoDb($id) {
        $qr = mysql_query("SELECT * FROM carmodel join manufacturer on carmodel.manufacturer_id = manufacturer.id WHERE carmodel.id =" . $id) or mysql_error();


        $result = mysql_fetch_row($qr);
        $result = explode(',', $result[7]);

        $qr = mysql_query("DELETE FROM carmodel WHERE carmodel.id =" . $id) or mysql_error();
        if ($qr) {

            unlink("uploads/" . $result[0]);
            unlink("uploads/" . $result[1]);
        }
        return $qr;
    }

}
