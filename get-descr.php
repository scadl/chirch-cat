<!DOCTYPE html>
<html lang='ru-RU'>
<head>
<meta charset="win-1251">
<title>ChircCat.DescrParse</title>
<style>
	img {
		margin: 0px 15px 15px 0px;
		border: solid 5px lightgrey;
		border-radius: 15px;
		height: 200px;
	}
</style>
</head>
<body style="font-family:sans-serif;">

<?php

$prints=false;
$inter=0;

$lines = file ('https://scadsdnd.org/'.$_GET['page']);
foreach ($lines as $line_num => $line)
{
	if ( stripos( htmlspecialchars($line), 'entry-content' ) && $inter==0 ){ $prints = true; $inter++; }
    if ( stripos( htmlspecialchars($line), 'yandex.st' ) ){ $prints = false; }
	if ( $prints ) { echo $line; }	
	//if ( $prints ) { echo "Строка #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n"; }	
	//if (htmlspecialchars($line) == ' <p style="text-align: center;"><script type="text/javascript" src="//yandex.st/share/share.js" '){ $prints = false; }
	//echo "Строка #<b>{$line_num}</b> : " . htmlspecialchars($line) ."<br>";
}

//print_r($lines);

//$res = array_search('		<div class="entry-content">', $lines);
//echo count($lines);

/*
$dbsrv_descriptor=@mysql_connect("db14.freehost.com.ua","sevblag_hersones","eZhPhJv5c");
if($dbsrv_descriptor==0){
   $dbsrv_status="Не удалось подключиться MySQL серверу!<br>".mysql_error()."<br>";
} else {	
	$dbsrv_status="Подключение к MySQL серверу успешно.<br>";
}

//global $sdres;

function DBConn($dbname, $dbdscr){
$req_res=@mysql_select_db($dbname, $dbdscr);
if($req_res==0){        
		return $sdres="БД '".$dbname."' не найдена!<br>".mysql_error()."<br>".$req_res;
		//return $sdresid=0;
    } else {        
		return $sdres="БД '".$dbname."' отрыта успешно.<br>";
		//return $sdresid=1;
    }
}

DBConn("sevblag_hersones", $dbsrv_descriptor);

//echo $dbsrv_status.'<br>';
//echo $sdres.'<br>';

$req_res=mysql_query("SELECT post_content FROM wp_posts WHERE id=2126;");
if ($req_res){
	//echo 'Query ok<hr>';
	while ( $row = mysql_fetch_array($req_res) ){
		echo $row[0];
	}
} else {
	echo mysql_error();
}
*/

?>


</body>
</html>