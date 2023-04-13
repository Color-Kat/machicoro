<?php
 $mysqli = new mysqli('127.0.0.1', 'root', '', 'machi');
 $mysqli->query ("SET NAMES 'utf8'");
   
 if(isset($_GET['uid']) and isset($_GET['who'])){
     $uid=$_GET['uid'];
     $who=$_GET['who'];

     $query=$mysqli->query("SELECT `variables` FROM `vars_table` WHERE `uid`='$uid' AND `who`='$who'");
     $query=$query->fetch_assoc();

     exit( 
        json_encode($query) 
    );
 }
?>