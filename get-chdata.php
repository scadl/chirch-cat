<?php

	require 'dbconfig.php';
	
	$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
	mysqli_select_db($link, $WP_DB);
	mysqli_query($link, "SET sql_mode = ''");
	mysqli_query($link, 'SET NAMES utf8');
	
	if ( mysqli_query($link, "SELECT ID FROM chirch;") ){
			   mysqli_query($link, 'SET NAMES utf8');
		$req = mysqli_query($link, "SELECT GMYM, Page, TimeT, Comment FROM chirch WHERE ID=".$_POST['id'].";");
		while ($row = mysqli_fetch_array($req, MYSQLI_NUM)){
			print( $row[0] . ' * ' . $row[1] . ' * ' . $row[2] . ' * ' . $row[3] );
		}
	} else {
		echo "<div style='color:red; text-align:center;'>НЕ найдена БД,<br>или сломаны перменные!</div>";
	}
	
	mysqli_close($link);

?>