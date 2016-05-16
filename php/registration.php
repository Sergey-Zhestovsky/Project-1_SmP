<?php
session_start();
require_once 'connection.php';
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link)); 

	if(isset($_POST['name'])&& isset($_POST['surname']))
		$name = htmlentities(mysqli_real_escape_string($link, $_POST['name'])) ." ". htmlentities(mysqli_real_escape_string($link, $_POST['surname'])); 
	if(isset($_POST['email'])) 
		$email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	if(isset($_POST['password'])) 
		$password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));
		$password = md5($password);
	$query ="INSERT INTO users VALUES(NULL, '$name','$email', '$password')";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	
	$query1 ="SELECT id FROM users WHERE `users`.`email` = '" . $email . "'";
	$result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link)); 
	$row = mysqli_fetch_row($result1);
	mysqli_free_result($result1);

	mysqli_close($link);

$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['id'] = $row[0];

header('Location: ./../index.php');
//$password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));
?>