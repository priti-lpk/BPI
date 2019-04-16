<?php

$response = array();
$access_key = "6808";
include_once 'shreeLib/DBAdapter.php';
include 'shreeLib/dbconn.php';
$dba = new DBAdapter();
if (isset($_POST['access_key']) && $_POST['name'] == 'main_category') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    $sql = "select * from main_category";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} elseif (isset($_POST['access_key']) && $_POST['name'] == 'sub_category') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    $sql = "select sub_category.id,main_category.main_cat_name,sub_category.sub_cat_name,sub_category.sub_image from sub_category inner join main_category on sub_category.main_cat_id=main_category.id";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} elseif (isset($_POST['access_key']) && $_POST['name'] == 'question') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    $sql = "select * from question_master";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} elseif (isset($_POST['access_key']) && $_POST['name'] == 'country') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }

    $sql = "select * from countries";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} elseif (isset($_POST['access_key']) && $_POST['name'] == 'state') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    $sql = "select * from states";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} elseif (isset($_POST['access_key']) && $_POST['name'] == 'view_user') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    $sql = "SELECT user_master.id,user_master.user_name,user_master.address,user_master.mobile_no,countries.cname,states.state_name,user_master.city,user_master.user_type FROM user_master INNER JOIN countries ON user_master.country_id=countries.id INNER JOIN states ON user_master.state_id=states.id";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} else if (isset($_POST['access_key']) && $_POST['name'] == 'main_result') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    if (isset($_POST['main_cat_id'])) {

        $sql = "SELECT question_master.id,main_category.main_cat_name,countries.cname,states.state_name,question_master.question,question_master.answer FROM question_master INNER JOIN main_category ON question_master.main_cat_id=main_category.id INNER JOIN countries ON question_master.country_id=countries.id INNER JOIN states ON question_master.state_id=states.id where question_master.main_cat_id='" . $_POST['main_cat_id'] . "'";

        $result = mysqli_query($con, $sql);

        $data = array();

        while ($rows = mysqli_fetch_assoc($result)) {

            $data[] = $rows;
        }
        echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
    }
} else if (isset($_POST['access_key']) && $_POST['name'] == 'main_sub_result') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;
    }
    if (isset($_POST['main_cat_id']) && isset($_POST['sub_cat_id'])) {

        $sql = "SELECT question_master.id,main_category.main_cat_name,countries.cname,states.state_name,question_master.question,question_master.answer FROM question_master INNER JOIN main_category ON question_master.main_cat_id=main_category.id INNER JOIN countries ON question_master.country_id=countries.id INNER JOIN states ON question_master.state_id=states.id where question_master.main_cat_id='" . $_POST['main_cat_id'] . "' AND question_master.sub_cat_id='" . $_POST['sub_cat_id'] . "'";

        $result = mysqli_query($con, $sql);

        $data = array();

        while ($rows = mysqli_fetch_assoc($result)) {

            $data[] = $rows;
        }
        echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
    }
} else if (isset($_POST['access_key']) && $_POST['name'] == 'question_result') {
    if ($access_key != $_POST['access_key']) {
        $response['error'] = "true";
        $response['message'] = "Invalid Access Key";
        print_r(json_encode($response));
        return false;      
    }
    $sql = "SELECT question_master.id,main_category.main_cat_name,countries.cname,states.state_name,question_master.question,question_master.answer FROM question_master INNER JOIN main_category ON question_master.main_cat_id=main_category.id INNER JOIN countries ON question_master.country_id=countries.id INNER JOIN states ON question_master.state_id=states.id order by rand() limit 10";

    $result = mysqli_query($con, $sql);

    $data = array();

    while ($rows = mysqli_fetch_assoc($result)) {

        $data[] = $rows;
    }
    echo json_encode(array("status" => TRUE, "data" => $data, "msg" => "data get successfully"));
} elseif (isset($_POST) && $_POST['name'] == 'user') {

    unset($_POST['name']);

    if ($dba->setData("user_master", $_POST)) {

        echo json_encode(array("status" => TRUE, "data" => "Data Insert Successfully"));
    } else {

        echo json_encode(array("status" => FALSE, "msg" => "error"));
    }
} elseif (isset($_POST) && $_POST['name'] == 'result') {

    unset($_POST['name']);

    if ($dba->setData("store_result", $_POST)) {

        echo json_encode(array("status" => TRUE, "data" => "Data Insert Successfully"));
    } else {

        echo json_encode(array("status" => FALSE, "msg" => "error"));
    }
}
?>