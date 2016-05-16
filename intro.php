<?php
	session_start();
?>
<html>
<head>
<title>Warebase</title>
<meta charset="utf-8">
<link rel="shortcut icon" href="img/min.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<body>
<div id="main">
	<div class="top">
		<div id="imgbord">
			<a href="index.php"><img src="img/WareBaseNew1.png" id="icon"></a>
		</div>
		<div id="nav">
			<ul id="site">
				<li class="list">
					<a class="inlinelist" href="">About us</a>
				</li>
				<?php  require_once 'top.php'; ?>
			</ul>
		</div>
	</div>

	<div>

	</div>

	<div class="header head fullscreen background parallax scrollblock" id="head"  data-img-width="750" data-img-height="502" data-diff="100">
		
		<div id="mainpart" class="scrollblock">
			<img src="img/MyLock1.png" id="mainimg">
			<div id="buttons">
				<p class="botbut">
					<a href="reg.php" class="mainbutton" id="b1">Sign up</a>
				</p>
				<p class="botbut">
					<a href="signin.php" class="mainbutton" id="b2">Sign in</a>
				</p>
			</div>
		</div>

	</div>

	<div id="block2">
	</div>

</div>

<script>
	document.getElementById("head").style.height = (window.innerHeight - 75) + "px";
	$(function(){
		$(".inlinelist").mousedown(function(){ 
		    $(this).css('color', 'rgba(106, 128, 127, 1)');
		    $(this).css('text-shadow', '1px 1px 5px #fff');
		});
	});
	$(function(){
		$(".inlinelist").mouseout(function(){ 
		    $(this).css('color', '');
		    $(this).css('text-shadow', '');
		});
	});

	$(function(){
		$(".mainbutton").mousedown(function(){ 
		    $(this).css('background', 'rgba(180, 231, 252, .2)');    
		});
	});
	$(function(){
		$(".mainbutton").mouseout(function(){ 
		    $(this).css('background', 'rgba(0, 0, 0, .6)');
		});
	});
// main height + buttons
</script>	

<script>
	/* detect touch */
	if("ontouchstart" in window){
	    document.documentElement.className = document.documentElement.className + " touch";
	}
	if(!$("html").hasClass("touch")){
	    /* background fix */
	    $(".parallax").css("background-attachment", "fixed");
	}

	/* fix vertical when not overflow
	call fullscreenFix() if .fullscreen content changes */
	function fullscreenFix(){
	    var h = $('body').height();
	    // set .fullscreen height
	    $(".content-b").each(function(i){
	        if($(this).innerHeight() > h){ $(this).closest(".fullscreen").addClass("overflow");
	        }
	    });
	}
	$(window).resize(fullscreenFix);
	fullscreenFix();

	/* resize background images */
	function backgroundResize(){
	    var windowH = $(window).height();
	    $(".background").each(function(i){
	        var path = $(this);
	        // variables
	        var contW = path.width();
	        var contH = path.height();
	        var imgW = path.attr("data-img-width");
	        var imgH = path.attr("data-img-height");
	        var ratio = imgW / imgH;
	        // overflowing difference
	        var diff = parseFloat(path.attr("data-diff"));
	        diff = diff ? diff : 0;
	        // remaining height to have fullscreen image only on parallax
	        var remainingH = 0;
	        if(path.hasClass("parallax") && !$("html").hasClass("touch")){
	            var maxH = contH > windowH ? contH : windowH;
	            remainingH = windowH - contH;
	        }
	        // set img values depending on cont
	        imgH = contH + remainingH + diff;
	        imgW = imgH * ratio;
	        // fix when too large
	        if(contW > imgW){
	            imgW = contW;
	            imgH = imgW / ratio;
	        }
	        //
	        path.data("resized-imgW", imgW);
	        path.data("resized-imgH", imgH);
	        path.css("background-size", imgW + "px " + imgH + "px");
	    });
	}
	$(window).resize(backgroundResize);
	$(window).focus(backgroundResize);
	backgroundResize();

	/* set parallax background-position */
	function parallaxPosition(e){
	    var heightWindow = $(window).height();
	    var topWindow = $(window).scrollTop();
	    var bottomWindow = topWindow + heightWindow;
	    var currentWindow = (topWindow + bottomWindow) / 2;
	    $(".parallax").each(function(i){
	        var path = $(this);
	        var height = path.height();
	        var top = path.offset().top;
	        var bottom = top + height;
	        // only when in range
	        if(bottomWindow > top && topWindow < bottom){
	            var imgW = path.data("resized-imgW");
	            var imgH = path.data("resized-imgH");
	            // min when image touch top of window
	            var min = 0;
	            // max when image touch bottom of window
	            var max = - imgH + heightWindow;
	            // overflow changes parallax
	            var overflowH = height < heightWindow ? imgH - height : imgH - heightWindow; // fix height on overflow
	            top = top - overflowH;
	            bottom = bottom + overflowH;
	            // value with linear interpolation
	            var value = min + (max - min) * (currentWindow - top) / (bottom - top);
	            // set background-position
	            var orizontalPosition = path.attr("data-oriz-pos");
	            orizontalPosition = orizontalPosition ? orizontalPosition : "50%";
	            $(this).css("background-position", orizontalPosition + " " + value + "px");
	        }
	    });
	}
	if(!$("html").hasClass("touch")){
	    $(window).resize(parallaxPosition);
	    //$(window).focus(parallaxPosition);
	    $(window).scroll(parallaxPosition);
	    parallaxPosition();
	}
</script>
</body>
</html>