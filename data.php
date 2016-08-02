<?php 

    $data  =  array();
    $data[0]  =  5;
    $data[1] =  20;
    $data[2] = 36;
	$data[3] = 10;
	$data[4] = 10;
	$data[5] = 20;
	$data[6] = 30;
	$data[7] = 60;
	$data[8] = 50;
	$data[9] = 70;
    header("Content-Type:application/json; charset=utf-8");
	echo json_encode($data);


?>