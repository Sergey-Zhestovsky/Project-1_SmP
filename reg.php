<?php session_start(); 
	if(isset($_SESSION['email']))
		header("Location: index.php");
?>
<html>
<head>
<title>Warebase sign-up</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="shortcut icon" href="img/min.ico" type="image/x-icon">
</head>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
	$(function(){
		$("#submitButton").click(function(){
			if(buttON())
				$("#regform").submit();
		});
	});
	$(function(){
		$("#submitButton").mouseover(function(){ 
		    $(this).css('border-radius', '40px'); 
		    $(this).css('height', '70px');
		    $(this).css('margin-top', '10px');  
		    $(this).css('width', '210px');    
		});
	});
	$(function(){
		$("#submitButton").mouseout(function(){ 
		    $(this).css('border-radius', '4px');
		    $(this).css('height', '60px');  
		    $(this).css('margin-top', '15px');  
		    $(this).css('width', '200px');    
		});
	});


	$(function(){
		$("#name").blur(function(){
			CheckN();
			buttON();
		});
	});
	$(function(){
		$("#surname").blur(function(){
			CheckS();
			buttON();
		});
	});
	$(function(){
		$("#email").blur(function(){
			CheckE();
			buttON();
		});
	});
	$(function(){
		$("#password").keyup(function(){
			CheckP();
			buttON();
		});
	});
	$(function(){
		$("#re_password").keyup(function(){
			CheckP();
			buttON();
		});
	});

	var name=false, surname=false, email=false, pass=false, repass=false;
	
	function CheckN()
	{
		var t = $("#name").val();
		if(t == undefined || t == '')
		{
			worning("name");
			//--enter name--
			name = false;
			return 0;
		}
		else
		{
			for(var i=0;i<t.length; i++)
			{
				if(!(t[i] >='A' && t[i] <='Z' || t[i] >= 'a' && t[i] <= 'z' || t[i] >= 'А' && t[i] <= 'я'))
				{
					error("name");
					//--inappropriate symbols--
					name = false;
					return 0;
				}
			}	
			good("name");
			name = true;
			return 1;
		}
	buttON(name, surname, email, pass, repass);
	}

	function CheckS()
	{
		var t = $("#surname").val();
		if(t == undefined || t == '')
		{
			worning("surname");
			//--enter surname--
			surname = false;
			return 0;
		}
		else
		{
			for(var i=0;i<t.length; i++)
			{
				if(!(t[i] >='A' && t[i] <='Z' || t[i] >= 'a' && t[i] <= 'z' || t[i] >= 'А' && t[i] <= 'я'))
				{
					error("surname");
					//--inappropriate symbols--
					surname = false;
					return 0;
				}
			}	
			good("surname");
			surname = true;
			return 1;
		}
	buttON(name, surname, email, pass, repass);
	}

	function queryajax(t)
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

	function CheckE()
	{
		var t = $("#email").val();
		
		if(t == undefined || t == '')
		{
			worning("email");;
			//empty field
			email = false;
			return 0;
		}

		if(queryajax(t) == "true")
		{
			error('email');
			//mail is already taken
			email = false;
			return 0;
		}
		
		if(t.indexOf("@") == -1)
		{
			error("email");
			//mail not valid
			email = false;
			return 0;
		}
		else
		{	var x = t.split("@");
			if(x.length > 2 || x[1].indexOf('.') == -1)
			{
				error("email");
				email = false;
				//mail not valid
				return 0;
			}
			else
			{
				var x1 = x[1].split(".");
				if(x1.length > 2 || x1[1].length == 0)
				{
					error("email");
					email = false;
					//mail not valid
					return 0;
				}
			}
			good("email");
			email = true;
			return 1;
		}
	}

	function CheckP()
	{
		var t = $("#password").val();
		var t1 = $("#re_password").val();
		if( t == '' && t1 == '')
		{
			worning("password");
			worning("re_password");
			//empty field
			pass = false;
			repass = false;
			return 0;
		}
		if(t != t1 || t == '' || t1 == '')
		{	
			error("re_password");
			error("password");
			//--passes are not the same--
			pass = false;
			repass = false;
			return 0;
		}
		else
		{	
			good("re_password");
			good("password");
			pass = true;
			repass = true;
			return 1;
		}
	}

	function buttON()
	{
		//alert(CheckN());alert(CheckS());alert(CheckE());alert(CheckP());
		if(CheckN() && CheckS() && CheckE() && CheckP())
		{
			$("#submitButton").css("pointer-events", "auto");
			$("#submitButton").css("background", "rgba(136, 170, 0, 0.76)");
			$("#submitButton").css("opacity", "1");
			return 1;
		}
		else
		{
			$("#submitButton").css("pointer-events", "none");
			$("#submitButton").css("background", "rgba(999, 999, 999, 0.76)");
			$("#submitButton").css("opacity", ".4");
			return 0;
		}
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
		<div id="registration">
			<p id="regmane">Create your new account</p><br>
				<form id="regform" method="POST" action="php/registration.php">
					<input type="text" name="name" id="name" placeholder="Name" /><br>
					<input type="text" name="surname"  id="surname" placeholder="Surname"/><br>
				    <input type="text" name="email" id="email" placeholder="Your email" /><br>
				    <input type="password" name="password" id="password" placeholder="Password"/><br>
				    <input type="password" name="re_password" id="re_password" placeholder="Repeat password"/><br><br>
				    <input type="button" id="submitButton" name="subm" value="Войти" />
				</form>
		</div>
	</div>
	</div>
<script> 
	document.getElementById("head").style.height = (window.innerHeight - 75) + "px";
	buttON(name, surname, email, pass, repass);	
</script>

</body>
</html>