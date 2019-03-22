<?php if(!isset($_SESSION)) { session_start(); }   ?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Кактлог храмов СевБлагочиния [Режим Редактора]</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<style>
.block{
	width: auto;
	background: lightgrey;
	padding: 10px;
	border-radius: 10px;
	border: dashed 2px grey;
}
.field{
	width: auto;
	background: lightgrey;
	padding: 10px;
	border-radius: 10px;
	border: dotted 2px grey;
	margin: 1px;
}
.tt_cact{
	background: #2389ca;
	color: #ffffff;
	text-align: center;
	border: 1px solid #a1a1a1;
}
.tt_cdis{
	background: #D7D7EF;
	color: #000000;
	text-align: center;
	border: 1px solid #a1a1a1;
}

body{
	text-align:center; 
	vertical-align: middle; 
	font-family:sans-serif;
}
</style>
</head>

<h1>Добро пожаловать в редактор каталога храмов СевБлагочиния!</h1>
<center>
<?php 
require 'class-phpass.php';
error_reporting(-1);

require 'dbconfig.php';
	
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS)
	or die ('Нет соединения с бд: '.mysql_error());	
mysqli_select_db($conn,$WP_DB)
	or die ('НЕ могу выбрать бд: '.mysql_error());
	
mysqli_query($conn, 'SET NAMES utf8');

if (isset($_POST['logout'])){
	unset($_SESSION['user']);
	unset($_SESSION['chi']);
	session_unset();
	
}

if ( isset($_POST['user']) ){

	$req = mysqli_query($conn, 'SELECT user_pass, ID FROM wp_users WHERE user_nicename="'.$_POST['user'].'";')
	or die ('Проблемы с запросом: '.mysqli_error($conn));
	while ($row = mysqli_fetch_array($req, MYSQLI_NUM)){ 	$pass = $row[0]; $uid=$row[1]; }
	
	$req = mysqli_query($conn, 'SELECT meta_value FROM wp_usermeta WHERE user_id='.$uid.' AND meta_key="wp_user_level";')
	or die ('Проблемы с запросом: '.mysqli_error($conn));
	while ($row = mysqli_fetch_array($req, MYSQLI_NUM)){ 	$urole = $row[0]; }	
	
	$hasher = new PasswordHash(8, true);
	if ( $hasher->CheckPassword($_POST['pass'], $pass) && $urole > 0 )
		{ 
			$_SESSION['user'] = $_POST['user']; 
			$_SESSION['chi']  = $_POST['chi']; 	
		} else { 
				unset($_SESSION['user']);
				unset($_SESSION['chi']);
				print ("<span style='color:red' style='margin-top:10px;'>Вы <b>НЕ</b> вошли. <br> Возможно введён <b>неправильный</b> логин и/или пароль<br>Или у вас недостаточно <b>прав</b> для редактирования каталога</span><br><br>");
		}
}

if ( isset($_SESSION['user']) ){ ?>

	<form action="" method="post" class="block" style="width:400px;"> 
		Здравствуйте, <b> <?php echo $_SESSION['user']; ?> </b> &emsp;
		<input type="hidden" name="logout" value="1">
		<input type="submit" value="Выйти и сменить храм">
	</form>
	
	<?php
	if ( mysqli_query($conn, "SELECT ID FROM chirch;") ){
				
		if ( isset($_POST['cname']) ){
				if ( mysqli_query($conn, 'UPDATE chirch SET Title="'.$_POST['cname'].'",GMYM="'.$_POST['c_lg'].'|'.$_POST['c_la'].'|'.$_POST['o_x'].'|'.$_POST['o_y'].'|'.$_POST['zm'].'",Page="'.$_POST['cdesc'].'",TimeT="'.$_POST['matrix'].'",Photo="'.$_POST['cph'].'",Comment="'.$_POST['comm'].'" WHERE ID="'.$_POST['cid'].'";') ) { 
					print ("<span style='color:green' style='margin-top:10px;'>Данные <b>успешно</b> сохранены</span>");
				} else { 
					print ("<span style='color:red' style='margin-top:10px;'>Данные <b>НЕ сохранены</b>. Проблемы с БД.</span>");
				} 
		} 
		
		$req = mysqli_query($conn, "SELECT * FROM chirch WHERE ID='".$_SESSION['chi']."';");
		while ($row = mysqli_fetch_array($req, MYSQLI_NUM)){
			$chi = $row;
		}
		
	} else {
		echo "<div style='color:red'>Храмы не найдены</div>";
	}
	
	//print_r($_POST);
	?>
	
	<form action="" method="post" style="margin-top:10px;"> 
	
	<div class="field">
	<b>Название храма:</b> <br>
	<input type="text" style="width:90%" name="cname" value="<?php echo $chi[1] ?>">
	<input type="hidden" style="width:90%" name="cid" value="<?php echo $chi[0] ?>">
	</div>
	
	<div class="field">
	<b>Путь к описанию храма:</b><br> (Описание должно быть ммежду ключевыми словами 'entry-content' и 'yandex.st) <br>
	http://hersones.org/<input type="text" style="width:70%" name="cdesc" value="<?php echo $chi[3] ?>">
	</div>
	
	<div class="field">
	<b>Путь к фото храма:</b> <br>
	photos/<input type="text" style="width:70%" name="cph" value="<?php echo $chi[5] ?>">
	</div>
	
	<div class="field">
	<b>Глобальные координаты храма:</b> <br>
	Широта, Долгота, Оириентация Х и Y, Высота<br>
	<?php $coord = explode('|', $chi[2])  ?>
	<input type="text" style="width:14%" name="c_lg" value="<?php echo $coord[0] ?>">
	<input type="text" style="width:14%" name="c_la" value="<?php echo $coord[1] ?>">
	<input type="text" style="width:14%" name="o_x" value="<?php echo $coord[2] ?>">
	<input type="text" style="width:14%" name="o_y" value="<?php echo $coord[3] ?>">
	<input type="text" style="width:14%" name="zm" value="<?php echo $coord[4] ?>">
	</div>
	
	<div class="field">
	<b>Расписание богослужений:</b> <br>
	<input type="hidden" style="width:70%" name="matrix" id="buf_matrix" value="">
	<div id="timet"></div>
	<script type="text/javascript">
		$(document).ready(function(){
		
			row = "<?php echo $chi[4]; ?>";
			matrix = row.split(",");
			
			$('#timet').load("Table_Frame.htm", function(){
			$('td#s').each(function(ind){
				//alert('first switch'+matrix[ind]);
				switch (matrix[ind]){
					case "0": $(this).addClass("tt_cdis"); break;
					case "1": $(this).addClass("tt_cact"); break;
					default: $(this).text("Ждём...");
				}
			});
			$('td#s').each(function(ind2){
				$(this).html(matrix[42+ind2]);
				$(this).height(70);
			});
			$('#comm_zone').hide();
			
			$('td#s').mouseenter(function(){
				$(this).html("<input type='text' id='tmpval' value='"+$(this).html()+"'>");
				$('#tmpval').width( $(this).innerWidth );
				$('#tmpval').height( $(this).innerHeight()-15 );
			});
			
			$('td#s').mouseleave(function(){
			
				var obj = $(this);
				if ( $('#tmpval').val().length > 0 ){
					$(this).removeClass("tt_cdis");
					$(this).addClass("tt_cact");
				} else {
					$(this).removeClass("tt_cact");
					$(this).addClass("tt_cdis");
				}
			
				$(this).html($('#tmpval').val());
				
				f_matrix = '';
				$('td#s').each(function(ind){ 
					if ( $(this).html().length > 0 ) { f_matrix = f_matrix + '1,'; } else { f_matrix = f_matrix + '0,'; }
				});
				$('td#s').each(function(ind){ 
					safestr = $(this).html().replace(',', '&#44;');
					f_matrix = f_matrix + safestr +',';
				});
				
				$('#buf_matrix').val(f_matrix);
			});
			
			});
			
		});
	</script>	
	</div>
	
	<div class="field">
	<b>Комментарий к расписанию:</b> <br>
	<textarea style="width:70%; height:100px;" name="comm"> <?php echo $chi[6] ?> </textarea>
	</div>
	
	<div class="field">
	<input type="submit" style="width:70%;" value="Сохранить изменения">
	</div>
	
	</form>
	
<?php
} else {
?>
<form action="" method="post" class="block" style="width:500px;">
1) Введите ваши данные с сайта: <br> (Имя пользователя и пароль) <br> <input type="text" name="user"> <input type="password" name="pass"> <br><br>
2) Выберите название хрма, который вы хотите отредактировать<br>
<select name="chi">
<?php
	
	if ( mysqli_query($conn, "SELECT ID FROM chirch;") ){
		$req = mysqli_query($conn, "SELECT ID, Title FROM chirch;");
		while ($row = mysqli_fetch_array($req, MYSQLI_NUM)){
			print('<option value="' . $row[0] . '"> ' . $row[1] . '</option>');
		}
	} else {
		echo "<option selected>Храмы не найдены</option>";
	}
?>
</select><br><br>
<input type="submit" value="Войти и Редактировать">
</form>
</center>

<?php

}
?>

</body>
</html>