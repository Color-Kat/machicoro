<?php 
    $mysqli = new mysqli('127.0.0.1', 'root', '', 'machi');
    $mysqli->query ("SET NAMES 'utf8'");

    if(isset($_GET['uid']) and isset($_GET['who']))
    {
        $uid=$_GET['uid'];
        $query=$mysqli->query("SELECT `who` FROM `vars_table` WHERE `uid`='$uid';");
        $query = $query->fetch_assoc();

        exit( 
            json_encode($query) 
        );
    }
?>