<?php
	require_once 'connection.php';

	$q = $_REQUEST["email"];
	$email = htmlentities($q);
	$a = htmlentities($_REQUEST["pass"]);
	$pass = md5($a);

 	$link = mysqli_connect( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ) 
	 	or die("Ошибка " . mysqli_error($link)); 
	
	$query ="SELECT pass FROM users WHERE `users`.`email` = '" . $email . "'";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
	if($result)
	{	
	 	$row = mysqli_fetch_row($result);
	 	if($row[0] == $pass)
	 		echo "true";
	 	else 
	 		echo "false";
	}
	else
		echo "false";

	mysqli_free_result($result);
	mysqli_close($link);
?>