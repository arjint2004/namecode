#!/usr/bin/php
<?php

$dd=exec('date +"%H"');
$jamexekusi=array(21,22,23,24,00,01,02,03,04,05,06);


if(in_array($dd,$jamexekusi)){
	$_SERVER['REQUEST_URI']="/nameconvert/process/301048a7ace156bd32241ba0021b6c0d/process";
	$_SERVER['PATH_INFO']="/nameconvert/process/301048a7ace156bd32241ba0021b6c0d/process";
	$_SERVER['QUERY_STRING']="/nameconvert/process/301048a7ace156bd32241ba0021b6c0d/process";
	$_SERVER['SERVER_PORT']="80";
	$_SERVER['REQUEST_METHOD']="GET";
	$_SERVER['SERVER_NAME']="depan.studentbook.co";
	include "index.php";
}else{
	echo "cron : standby belum jadwal proses";
}
?>