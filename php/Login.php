<?php
	session_start();
	require_once 'connection.php';
	$link = mysqli_connect( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ) 
	 	or die("Ошибка " . mysqli_error($link)); 

	if(isset($_POST['email'])) 
		$email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	if(isset($_POST['password'])) 
		$password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));
		$password = md5($password);

	

	$query ="SELECT pass FROM users WHERE `users`.`email` = '" . $email . "'";
	
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
	if($result)
	{	
		$query1 ="SELECT name FROM users WHERE `users`.`email` = '" . $email . "'";
		$query2 ="SELECT id FROM users WHERE `users`.`email` = '" . $email . "'";
		

	 	$row = mysqli_fetch_row($result);
	 	mysqli_free_result($result);

	 	if($row[0] == $password)
	 	{
	 		$result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
	 		$result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link));
	 		$row1 = mysqli_fetch_row($result1);
	 		$row2 = mysqli_fetch_row($result2);
	 		mysqli_free_result($result1);

			mysqli_close($link);

	 		$_SESSION['email'] = $email;
	 		$_SESSION['name'] = $row1[0];
	 		$_SESSION['id'] = $row2[0];
	 		header("Location: ./../index.php");
	 	}
	 	else 
	 	{	session_destroy();
	 		header("Location: ../signin.php");
	 	}
	}
	else
	{	
		mysqli_free_result($result);
	 	mysqli_close($link);
		session_destroy();
		header("Location: ../signin.php");
	}


?>