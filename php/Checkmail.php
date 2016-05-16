<?php	
	require_once 'connection.php';

	$q = $_REQUEST["email"];
	$email = htmlentities($q);

	$link = mysqli_connect( $GLOBALS['host'] ,  $GLOBALS['user'] ,  $GLOBALS['password'] ,  $GLOBALS['database'] ) 
		or die("Ошибка " . mysqli_error($link)); 

	$query ="SELECT email FROM users";
	 
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	if($result)
	{
		$i=0;
		while ($row = mysqli_fetch_row($result)) {
			$rez[$i] = $row[0];
			$i += 1;
		}
		mysqli_free_result($result);
		mysqli_close($link);
		$hit = 0;
		foreach ($rez as $s)
		{
			if($s == $email)
			{	
				echo 'true';
				$hit++;
			}
		}
		if(!$hit)
			echo 'false';
	}

?>