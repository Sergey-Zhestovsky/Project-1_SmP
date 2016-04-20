<html>
<head>
<title>Веб-сайт</title>
<meta charset="utf-8">
</head>
<?php 
	require_once 'Checkpass.php';
?>
<script>
var email = false, pass = false;
function Checkmail()
{
	var t = document.getElementById("email");


	all = all.split(" ");
	//var counter = -1;
	for(var i = 0; i < all.length -1; i++)
	{	
		if(all[i] == t.value)
		{
			good("email");
			email = true;
			return i;
		}
	}
	error("email");
	email = false;
	buttON(email, pas);
	return -1;
}

function Checkpass()
{
	if(email == false)
	{
		pass = false;
		return;
	}
	
	var t = document.getElementById("password");
	var all = '<?php echo Chpass('document.getElementById("email").value');?>';
}

function buttON(q,w)
{
	if(q == true && w == true)
	{
		document.getElementById("submitButton").style = "pointer-events: auto";
	}
	else
	{
		document.getElementById("submitButton").style = "pointer-events: none";
	}
}

function error(x)
{
	var t = document.getElementById(x);
	t.style.border = "1px solid #ff4444";
}
function good(x)
{
	var t = document.getElementById(x);
	t.style.border = "1px solid #aaa";	
}
</script>
<body>
<h3>Вход</h3>
<form onsubmit="" method="" action="">
Email:<input type="text" name="email" id="email" placeholder="youremail@gmail.com" onblur="Checkmail()"/><br><br>
Пароль: <input type="password" name="password" id="password" placeholder="Пароль" onkeyup="Checkpass()"/><br><br>
<input type="submit" id="submitButton" name="subm" value="Войти" >
</form>
<script>
	if(document.getElementById("email").value != '') Checkmail(); 
	if(document.getElementById("password").value != '') Checkpass(); 
</script>
</body>
</html>
