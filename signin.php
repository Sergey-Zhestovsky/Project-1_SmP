<?php session_start(); 
	if(isset($_SESSION['email']))
		header("Location: index.php");
?>
<html>
<head>
<title>Warebase sign-in</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="shortcut icon" href="img/min.ico" type="image/x-icon">
</head>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
	$(function(){
		$("#submitButton").click(function(){
			Validall();
		});
	});
	$(function(){
		$("#email").blur(function(){
			Validmail();
		});
	});
	$(function(){
		$("#password").blur(function(){
			Validpass();
		});
	});

	function Validmail()
	{
		var t = $("#email").val();
		if(t == '' || t== undefined)
		{
			worning('email');
			//--empty--
			return 0;
		}

		if(querymail(t) == 'true')
		{
			good('email')
			return 1;
		}
		else
		{
			error('email');
			return 0;
		}
	}

	function Validpass()
	{
		var t = $("#password").val();
		if(t == '' || t== undefined)
		{
			//worning('password');
			//--empty--
			return 0;
		}

		if(querypass(t) == 'true')
		{
			//good('password');
			return 1;
		}
		else
		{
			//error('password');
			return 0;
		}
	}

	function Validall()
	{
		if(Validpass() && Validmail())
			$("#regform").submit();
	}

	function querymail(t)
	{
		var result = $.ajax({
    	type: "POST",
    	url: "php/Checkmail.php",
    	data:({email:t}),
    	async: false,
    	success: function(result){}
  		}).responseText;

  		return result;
	}

	function querypass(t)
	{
		var d = $("#email").val();

		var result = $.ajax({
    	type: "POST",
    	url: "php/Checkpass.php",
    	data:({email:d, pass:t}),
    	async: false,
    	success: function(result){}
  		}).responseText;

  		return result;
	}

	function worning(x)
	{
		var t = document.getElementById(x);
		t.style.border = "3px solid #aaa";
	}
	function error(x)
	{
		var t = document.getElementById(x);
		t.style.border = "3px solid rgba(203, 47, 47, .7)";
	}
	function good(x)
	{
		var t = document.getElementById(x);
		t.style.border = "3px solid #8a0";	
	}
</script>
<body>
		<div id="main">
		<div class="top">
		<div id="imgbord">
			<a href="index.php"><img src="img/WareBaseNew1.png" id="icon"></a>
		</div>
		<div id="nav">
			<ul id="site">
				<li class="list">
					<a class="inlinelist" href="reg.php">Sign up</a>
				</li>
				<li class="list">
					<a class="inlinelist" href="signin.php">Sign in</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="header" id="head">
		<div id="login">
			<p id="regmane">Sign in</p><br>
				<form id="regform" method="POST" action="php/Login.php">
				    <input type="text" name="email" id="email" placeholder="Your email" /><br>
				    <input type="password" name="password" id="password" placeholder="Password"/><br>
				    <input type="button" id="submitButton" name="subm" value="Войти" />
				</form>
		</div>
	</div>
	</div>
<script> 
	document.getElementById("head").style.height = (window.innerHeight - 75) + "px";
	if($("#email").val() != ''); 
</script>	
</body>
</html>