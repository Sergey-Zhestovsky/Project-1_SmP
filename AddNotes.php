<?php
	session_start();
	require_once 'connection.php';
	$mysqli = new mysqli( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ); 

	if(isset($_POST['title'])) 
		$title = htmlentities(mysqli_real_escape_string($mysqli, $_POST['title']));
	if(isset($_POST['context'])) 
		$context = htmlentities(mysqli_real_escape_string($mysqli, $_POST['context']));

	$query ="INSERT INTO notes VALUES(NULL, '".$_SESSION['id']."', '".$title."', '".$context."')";

	$mysqli->query($query);

	echo $mysqli->insert_id;

	$mysqli->close();
?>