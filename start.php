<?php 
	if(isset($_GET['done'])){
		header("Location: machicorOnline.html");
	}
	if(isset($_GET['one'])){
		header("Location: machicorOffline.html");
	}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Start</title> </head>
 <body>
 	<form action="" method="get" id="form">
 		<input type="submit" name="done" value="игра по сети">
 	</form>
<hr>
 	<form action="" method="get">
 		<input type="submit" name="one" value="игра офлайн">
 	</form>

 </body>
 </html>