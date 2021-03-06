<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Eesti Olümpiaadide Andmebaas</title>
    <meta name="google-site-verification" content=
    "m3yEMb5b8lxEu4ueaXfeF4SYYjskkfaMiyVRUtXvEHE">
    <meta name="viewport" content=
    "width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/eoa.css">
    <script src="sorttable.js" type="text/javascript"></script>
    <script src="eoa.js" type="text/javascript"></script>
</head>
<body>
    <div id="main">
        <div class="topnav">
            <a onclick="openNav()">
            <div class="manubtn"></div>
            <div class="manubtn"></div>
            <div class="manubtn"></div></a>
            <h1><a href="/">EESTI OLÜMPIAADIDE
            ANDMEBAAS</a></h1>
            <h1><a href="/?kool=true">KOOLID</a></h1>
            <h1><a href="/?hof=true">AUTABEL</a></h1>
            <div class="search-container">
                <button type="button" onclick=
                "findperson()">OTSI</button> <input type="text"
                placeholder="Õpilase/Juhendaja nimi..." name=
                "nameinput" id="NIF" onkeydown="search(this)">
            </div>
        </div>

<?php

include 'credentials.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	echo 'fail';
    die("Connection failed: " . $conn->connect_error);
}

require('code/esialgsed.php');
require('code/tulemus_by_id.php');
require('code/name_search.php');
require('code/sidenav.php');
require('code/mainpage.php');
require('code/koolid.php');
require('code/hof.php');
require('code/school_profile.php');

echo sidenav\get_sidenav($conn);

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
if(!empty($queries['id'])){
	if((int)$queries['id'] > 0 and (int)$queries['id'] < 10000){
			echo tul_by_id\tulemus($conn,(int)$queries['id']);
	}
	/*if((int)$queries['id'] == 10000){
		$url2='https://docs.google.com/spreadsheets/d/e/2PACX-1vQsE0RId6TO33wjVXW_5I4rFbCuTn9lP7B02vEWRExfs5ZncIbPKlzuzydtWGRhf8z8uN-ZucoCCMIV/pub?output=csv';
		echo esialgsed\esialg($url2,6,"EMO sügisene lahtine noorem (ESIALGSED)","mata");
	}
	if((int)$queries['id'] == 10001){
		$url2='https://docs.google.com/spreadsheets/d/e/2PACX-1vQsE0RId6TO33wjVXW_5I4rFbCuTn9lP7B02vEWRExfs5ZncIbPKlzuzydtWGRhf8z8uN-ZucoCCMIV/pub?output=csv&single=true&gid=318187998';
		echo esialgsed\esialg($url2,6,"EMO sügisene lahtine vanem (ESIALGSED)","mata");
	}*/
}elseif(!empty($queries['name'])){
	echo name_s\search($conn, $queries['name']);
}elseif(!empty($queries['name_id'])){
	if((int)$queries['name_id'] > 0 and (int)$queries['name_id'] < 10000){
		echo name_s\person_profile($conn, $queries['name_id']);
	}
}elseif(!empty($queries['kool'])){
	echo koolid\sum_kool($conn);
}elseif(!empty($queries['hof'])){
	echo hof\hof($conn);
}elseif(!empty($queries['school_id'])){
	if((int)$queries['school_id'] > 0 and (int)$queries['school_id'] < 10000){
		echo school_profile\get_profile($conn, $queries['school_id']);
	}
}else{
	echo mainpage\get_mainpage($conn);
}

$conn->close();

?>
    </div>
</body>
</html>
