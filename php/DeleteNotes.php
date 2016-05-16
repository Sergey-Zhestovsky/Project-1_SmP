<?php
	session_start();
	require_once 'connection.php';
	$link = mysqli_connect( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ) 
	 	or die("Ошибка " . mysqli_error($link)); 

	if(isset($_POST['id'])) 
		$id = htmlentities(mysqli_real_escape_string($link, $_POST['id']));


	$query ="DELETE FROM notes WHERE `notes`.`id` = '".$id."' AND `notes`.`userid` = '".$_SESSION['id']."'";

	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	mysqli_close($link);
?>