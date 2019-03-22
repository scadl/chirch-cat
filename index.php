<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Каталог храмов СевБлагочиния</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<style>
@font-face{
	font-family: Izhitza;
	src: url('icons/a_la_russ.ttf');
}

.out_cell{
	display:inline-block;
	width: 140px;
	height: 170px;
	border: double 3px lightgrey;
	background: #6874d0;  /* #58788f; */
	padding: 10px;
	border-radius: 5px;
	margin: 13px;
	vertical-align: middle;
	opacity: 0.8;
};

.cont_c{
	background: #3f3f3f;
	vertical-align: middle;
};

.icon_cap{
	font-size: 5pt;
	color:white;
}

.active_tab{
	font-weight: bold;
	border: solid 1px lightgrey;
	background: lightgrey;
	border-radius: 10px 10px 0px 0px;
	padding-bottom: 5px;
}
.normal_tab{
	font-weight:normal;
	border: solid 2px lightgrey;
	background: white;
	border-radius: 10px 10px 0px 0px;
	padding-bottom: 5px;
}

#descr{
 	font-weight:normal;
	border: solid 2px lightgrey;
	background: lightgrey;
	border-radius: 10px;
	position: relative;
	top: -2px;
}

body{
	background: url('icons/Silhoete.svg') no-repeat #404c0d;
	background-position: center top;
	background-size: cover;
	text-align: center; 
	vertical-align: middle; 
	font-family: sans-serif;
}

.head_block{
	font-family: Izhitza;
	display: inline-block;
	color: gold;
	width: 30%;
	text-align: center;
	font-size: 40pt;
	margin: 10px 0px;
	font-weight: 400;
	border: solid 0px;
	letter-spacing: 3px;
	/*
	text-shadow: 
		yellow 1px 0px, 	yellow 1px 1px, 
		yellow 0px 1px, 	yellow -1px 1px, 
		yellow -1px 0px, 	yellow -1px -1px, 
		yellow 0px -1px, 	yellow 1px -1px, 
		yellow 0 0 3px, 	yellow 0 0 3px, 
		yellow 0 0 3px, 	yellow 0 0 3px, 
		yellow 0 0 3px, 	yellow 0 0 3px, 
		yellow 0 0 3px, 	yellow 0 0 3px;
		*/
}

/* poupup {background:white; opacity:0.9; z-index:3; display:none; position:absolute; top:100px; left:100px; border-radius: 15px; border: solid 3px grey;} */

</style>
</head>
<body>

<div class='head_block'>
Севастопольское
<br><small> Каталог </small>
</div>
<div style='display:inline-block; width: 10px;'>
</div>
<div class='head_block'>
Благочиние
<br> <small> Храмов </small>
</div>

<div id='backgr' style='background:#3f3f3f; opacity:0.8; z-index:2; display:none; position:absolute; top:0px; left:0px;'></div>
<div id='poupmsg' style='display:none; z-index:3; position:absolute; top:50px; left:50px;'>
<table width="100%" border="0">
<tr>
<td id="ptitle" align="center;"></td>
<td id="pclose" style="cursor:pointer; width:20px;"> <img src='icons/Error.png' width='20'> </td>
</tr>
</table>
<table width="100%" border="0">
<tr>
<td id="maps"></td>
<td id="btnPn" valign="middle">
<div id='About' class='tab' style='display:inline-block; width:30%; cursor:pointer;'> <img src='icons/document_notes.png' width='20' style="position:relative; top:5px; left:0px;"> Описание храма</div>
<div id='Maps' class='tab' style='display:inline-block; width:30%; cursor:pointer;'> <img src='icons/map.png' width='20' style="position:relative; top:5px; left:0px;"> Найти храм на карте</div>
<div id='Timet' class='tab' style='display:inline-block; width:30%; cursor:pointer;'> <img src='icons/table_select_big.png' width='20' style="position:relative; top:5px; left:0px;"> Расписание богослужений</div>
<div id="descr" arrid="0"></div>
</td>
<td id="timet"></td>
</tr>
</table>
</div>

<div id='transfer' valign='top'>
<?php
	
error_reporting(-1);

//require '../../wp-config.php';
//require '../../wp-includes/class-phpass.php';

//echo DB_NAME;
//echo ('SELECT user_pass FROM wp_users WHERE user_nicename='.$_POST['user'].';');

require 'dbconfig.php';
	
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS)
	or die ('Нет соединения с бд: '.mysql_error($conn));	
mysqli_select_db($conn,$WP_DB)
	or die ('НЕ могу выбрать бд: '.mysqli_error($conn));
	
	if ( mysqli_query($conn,"SELECT ID FROM chirch;") ){
			   mysqli_query($conn,'SET NAMES utf8');
		$req = mysqli_query($conn,"SELECT ID, Title, Photo FROM chirch;");
		while ($row = mysqli_fetch_array($req, MYSQLI_BOTH)){
			$safestr = str_replace('"', '&#34;', $row[1]);
			print('<div class="out_cell" align="center" valign="middle" style="vertical-align: middle;">'.
			'<img class="cont_c" elem="' . $row[0] . '" title="' . $safestr . '" src="photos/' . $row[2] . '"' . 
			'style="max-width:128px; max-height:128px; border-radius:10px; border:solid 2px #7b94b0; vertical-align: middle; opacity: 1; cursor:pointer;">'.
			'<div style="font-size: 9pt; line-height:100%; color:white; padding-top:3px;">' . $row[1] . '</div>'.
			'</div>');
		}
		mysqli_close($conn);
	} else {
		echo "<div style='color:red; text-align:center;'>НЕ найдена БД,<br>работа программы не возможна!</div>";
		//new SQLite3("chirch-db.sqlite");
	}

?>
</div>

<script type="text/javascript">

$(document).ready(function(){

var row = [];

$(".cont_c").click(function(){
            
			var ico = $(this);
			
            $(this).animate({
                height: '-=20',
                width: '-=20',
                opacity: 0.5
            }, 100).animate({
                height: '+=20',
                width: '+=20',
                opacity: 1
            }, 100);
			
			$('#backgr').width($(document).width());
			$('#backgr').height($(document).height());			
			$('#poupmsg').width($(document).width() - 100);
			$('#poupmsg').height($(window).height() - 100);
			$('#poupmsg').css({'top': ($(window).scrollTop()+50) +'px'});
			//alert($(window).scrollTop());
			
			//$('#descr').attr("arrid", $(this).attr('elem')-1 );
			
			$.post('get-chdata.php', { id: $(this).attr('elem') }, function(data){ 
				//alert(data);
				row.length = 0;
				row = data.split(' * ');
				$('#ptitle').html('<span style="color:lightblue; font-weight:bold; font-family: Izhitza; font-size: 20pt;">' + ico.attr('title') + '</span>');
				$('#poupmsg').fadeIn(500);
				$('#backgr').fadeIn(500);
				$("#About").click();
			});
				
});

$('.tab').click(function(){

		$(".tab").removeClass("active_tab");
		$(".tab").addClass("normal_tab");
		$(this).removeClass("normal_tab");
		$(this).addClass("active_tab");
	
});

$("#About").click(function(){
		//alert('desc');
		$('#descr').html("<iframe id='frdesc' frameborder='0' src='descr-page.html?" + row[1] + "' style='background:#eee; border-radius:10px;' seamless>Ждите</iframe>");
		$('#frdesc').width($(document).width() - 130);
		$('#frdesc').height($(window).height() - 180);
		
});

$("#Maps").click(function(){
		//alert('desc');
		cord = row[0].split('|');
		$('#descr').html("<table width='100%'><tr><td> <iframe id='frGm' frameborder='0' src='http://maps.google.com/maps/ms?msa=0&amp;msid=205934511869600275291.0004c08eb64c2db352bbc&amp;hl=ru&amp;ie=UTF8&amp;t=h&amp;ll="+cord[0]+","+cord[1]+"&amp;spn="+cord[2]+","+cord[3]+"&amp;z="+cord[4]+"&amp;output=embed' style='border-radius:10px; border: solid 3px lightgrey;'></iframe> </td><td> <iframe id='frYm' frameborder='0' src='yamaps.html?"+cord[1]+"|"+cord[0]+"|"+cord[4]+"' style='border-radius:10px; border: solid 3px lightgrey;'></iframe> </td></tr></table>");
		//$('#descr').html("<iframe id='frYm' frameborder='0' src='get-descr.php?page=" + pags[$('#descr').attr("arrid")] + "'></iframe>");
		$('#frGm').width( ($(document).width() - 140)/2 );
		$('#frGm').height($(window).height() - 190);
		$('#frYm').width( ($(document).width() - 140)/2 );
		$('#frYm').height($(window).height() - 190);
		

});

$("#Timet").click(function(){
		//alert('desc');
		matrix = row[2].split(",");
		$('#descr').load("Table_Frame.htm", function(){
			$('td#s').each(function(ind){
				//alert('first switch'+matrix[ind]);
				switch (matrix[ind]){
					case "0": $(this).css({"background":"#D7D7EF","color":"#000000","text-align":"center","border":"1px solid #a1a1a1"}); break;
					case "1": $(this).css({"background":"#2389ca","color":"#ffffff","text-align":"center","border":"1px solid #a1a1a1"}); break;
					default: $(this).text("Ждём...");
				}
			});
			$('td#s').each(function(ind2){
				$(this).html(matrix[42+ind2]);
			});
			
			$("#ttComm").html( row[3] );
			
			$('#the_timet').width($(document).width() - 150);
			$('#the_timet').height($(window).height() - 175);
		});	

});

$("#pclose").click(function(){
	$('#backgr').fadeOut(500);
	$('#poupmsg').fadeOut(500);
});


});
</script>
<br>
<a href="editor.php" target="_blank" style='color:grey; font-size:12pt;'>[Pедактировать каталог]</a>
<br><br>
<div style='color:green; font-size:7pt; line-height: 1;'>Программирование и Дизайн 
<a href='http://scadsdnd.ddns.net/' target='_blank' style='color:green;'>SCAD's Design & Develop &copy;</a>
(июнь 2014)</div>

</body>
</html>