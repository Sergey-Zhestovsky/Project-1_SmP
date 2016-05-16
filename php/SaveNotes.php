<?php 
	session_start();
	require_once 'connection.php';
	$link = mysqli_connect( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ) 
	 	or die("Ошибка " . mysqli_error($link)); 

	if(isset($_POST['title'])) 
		$title = htmlentities(mysqli_real_escape_string($link, $_POST['title']));
	if(isset($_POST['context'])) 
		$context = htmlentities(mysqli_real_escape_string($link, $_POST['context']));
	if(isset($_POST['id'])) 
		$id = htmlentities(mysqli_real_escape_string($link, $_POST['id']));


	$query ="UPDATE notes SET title='".$title."', context='".$context."' WHERE `notes`.`id`='".$id."' and `notes`.`userid`='".$_SESSION['id']."'";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	mysqli_free_result($result);
	mysqli_close($link);
?>