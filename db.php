<?php
//$db = new mysqli('thecodingshackcom.ipagemysql.com', 'discover', 'Hithippie13!', 'discover');
$db = new mysqli('localhost', 'root', 'root', 'discover');

if($db->connect_errno > 0){
    die('Unexpected server error. (Database error).');
}