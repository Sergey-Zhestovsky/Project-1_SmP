<?php
 	if(isset($_SESSION['email']))
	{
		echo '	<li class="list">
					<p class="noselect" id="username" >'.$_SESSION["name"].'</p>
				</li>
				<li class="list">
					<a class="inlinelist" href="php/exit.php">Logout</a>
				</li>';
	}
	else
	{
		echo '	<li class="list">
					<a class="inlinelist" href="reg.php">Sign up</a>
				</li>
				<li class="list">
					<a class="inlinelist" href="signin.php">Sign in</a>
				</li>';
	}

?>