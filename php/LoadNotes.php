<?php
	session_start();
	$id = $_SESSION['id'];
	require_once 'connection.php';
	$link = mysqli_connect( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ) 
	 	or die("Ошибка " . mysqli_error($link)); 

	$query ="SELECT title FROM notes WHERE `notes`.`userid` = '" . $id . "'";
	$query1 ="SELECT context FROM notes WHERE `notes`.`userid` = '" . $id . "'";
	$query2 ="SELECT id FROM notes WHERE `notes`.`userid` = '" . $id . "'";


	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	$result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
	$result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link));
	mysqli_close($link);

	if($result)
	{
		$i=0;
		while ($row = mysqli_fetch_row($result)) {
			$rez[$i] = $row[0];
			$i++;
		}

		$i=0;
		while ($row = mysqli_fetch_row($result1)) {
			$rez1[$i] = $row[0];
			$i++;
		}

		$i=0;
		while ($row = mysqli_fetch_row($result2)) {
			$rez2[$i] = $row[0];
			$i++;
		}

		mysqli_free_result($result);
		mysqli_free_result($result1);
		mysqli_free_result($result2);
		$notes = array($rez, $rez1, $rez2);
		echo json_encode($notes); 	
	}
?>