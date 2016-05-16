<?php session_start(); 
	if(!isset($_SESSION['email']))
	header("Location: intro.php");

	require_once 'php/connection.php';
?>
<html>
<head>
<title>Warebase</title>
<meta charset="utf-8">
<link rel="shortcut icon" href="img/min.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/mainpage.css">
</head>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<body>
	<div class="main">
	</div>
	<div id="txteditor">
	</div>
	
	<div id="deletewarning-box">
		<div id="warning">
			Delete note?
			<a class="warningbutton" id="acceptbutton">accept</a>
			<a class="warningbutton" id="cancelbutton">cancel</a>
		</div>
	</div>


	<div class="top">
		<div id="imgbord">
			<a href="index.php"><img src="img/WareBaseNew1.png" id="icon"></a>
		</div>
		<div id="nav">
			<ul id="site">
				<?php  require_once 'top.php'; ?>
			</ul>
		</div>
	</div>

<div id="main">
	<div id="menu">
		<a id="addbut"  class="noselect" onClick="txtedit();">+ Add </a>
	</div>

	<div id="mNotesBlock">
	</div>
</div>
<script>
	$(function(){
		$("#addbut").click(function(){
			Colltxteditor();
		});
	});
	$(function(){
		$(".main").click(function(){
			Colltxtexit();
			RemoveWarning();
		});
	});

	$(function(){
		ClickToColl();
	});

	function ClickToColl()
	{
		$('.note').click(function(){
			Colltxtreader($(this).attr('own-id'));
		});
	}

	function topexit()
	{
		$('#toptxtedit-exit').mouseover(function(){
			$('.fa-times').css('color', '#777');
		});	
		$('#toptxtedit-exit').mouseout(function(){
			$('.fa-times').css('color', '#556');
		});
		$("#toptxtedit-exit").click(function(){
			Colltxtexit();
		});
	}
	function topdelete(x)
	{
		$('#toptxtedit-delete').mouseover(function(){
			$('.fa-trash').css('color', '#d9534f');
		});	
		$('#toptxtedit-delete').mouseout(function(){
			$('.fa-trash').css('color', '#555');
		});
		$('#toptxtedit-delete').click(function(){
			DeleteWarning(x);
		});
	}
	function topedit(x)
	{
		$('#editbutton').click(function(){
			Colltxteditor(x);
		});
	}
	function savebut(x)
	{
		$('#savebutton').click(function(){
			if(x)
				SaveNotes(x);
			else
				AddNotes();
		});
	}
	function Colltxtreader(x) //открывание текст. редактора (чтение)
	{
		$('#txteditor').html('');
		$('#txteditor').html(
			'<div id="toptxteditor"><a id="editbutton" class="noselect topbutton">Edit</a><div id="toptxtedit-icons"><a id="toptxtedit-exit"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a><a id="toptxtedit-delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></div></div><div class="txteditor-read" id="txteditor-title"></div><div class="txteditor-read" id="txteditor-context"></div>'
		);
		topexit(); topdelete(x); topedit(x);
		if($('#txteditor').css('display') == 'none')
		{
			$('.main').css('display','block');
			$('#txteditor').css('display','block');
			$('#main').addClass('blur');
			$("#txteditor").css('height', window.innerHeight -75 + 'px');
			$("#txteditor-context").css('height', $("#txteditor").height() - $("#txteditor-title").height() - 225 + 'px');
			
			var index = notes_id.indexOf(x);
			$("#txteditor-title").html(notes_title[index]);
			$("#txteditor-context").html(notes_context[index]);
		}
	}
	function Colltxteditor(x)
	{
		$('#txteditor').html('');
		$('#txteditor').html(
			'<div id="toptxteditor"><div id="toptxtedit-icons"><a id="toptxtedit-exit"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a></div></div><textarea class="write-field" id="title-field" placeholder="Title..."></textarea><textarea class="write-field" id="context-field" placeholder="Main text..."></textarea> <a id="savebutton" class="noselect topbutton">Save</a>'
		);
		topexit(); savebut(x);
		if($('#txteditor').css('display') == 'none')
		{
			$('.main').css('display','block');
			$('#txteditor').css('display','block');
			$('#main').addClass('blur');
			$("#txteditor").css('height', window.innerHeight -75 + 'px');
			$("#context-field").css('height', $("#txteditor").height() - $("#title-field").height() - 260 + 'px');
		}	
		else
		{
			$("#context-field").css('height', $("#txteditor").height() - $("#title-field").height() - 260 + 'px');
			
			var index = notes_id.indexOf(x);
			$("#title-field").html(notes_title[index]);
			$("#context-field").html(notes_context[index]);
		}
			
		
	}

	function  Colltxtexit()
	{
		$('.main').css('display','none');
		$('#txteditor').css('display','none');
		$('#main').removeClass('blur');
	}

	//шрифт для контекста записок
	function fontSize() {
	  	if ($('.note').width() <= 1000) 
	  		$('.notecontext').css('font-size', 17+'px');
	  	else
	  		$('.notecontext').css('font-size', 1.2+'vw');
	}
	$(function() { fontSize(); });
	$(window).resize(function() { fontSize(); });

	LoadNotes();
	function CatchNotes()
	{
		notes_id = new Array();
		notes_title = new Array();
		notes_context = new Array();

		$.ajax({
    	type: "POST",
    	url: "php/LoadNotes.php",
    	async: false,
    	dataType: 'json',
    	cache: false,
    	success: function(result){
    		notes_id = result[2];
    		notes_title = result[0];
    		notes_context = result[1];
    	}
  		}).responseText;
	}

	function LoadNotes()
	{
		CatchNotes();
		if(notes_id.length == 0)
			return;

		$('#mNotesBlock').html('');

		for(var i = 0;i<notes_id.length; i++)
		{
			if(notes_title[i].length > 10)
				var n_titl = notes_title[i].substring(0, 9) + '...';
			else
				var n_titl = notes_title[i];

			if(notes_context[i].length > 91)
				var n_con = notes_context[i].substring(0, 91) + '...';
			else
				var n_con = notes_context[i];

			$('#mNotesBlock').append(
				'<div class="note" own-id='+notes_id[i]+'><div class="notetitle">'
				+n_titl+'</div><div class="notecontext noselect">'+n_con+
				'</div></div>');
		}
	}

	function SaveNotes(x)
	{
		var t = $("#title-field").val();
		var c = $("#context-field").val();

		$.ajax({
    	type: "POST",
    	url: "php/SaveNotes.php",
    	async: false,
    	data:({title:t, context:c, id:x}),
    	cache: false
  		});

		var index = notes_id.indexOf(x);
		notes_title[index] = t;
		notes_context[index] = c;

		if(t.length > 10)
				var t = t.substring(0, 9) + '...';

		if(c.length > 91)
				var c = c.substring(0, 91) + '...';


		$('[own-id="'+x+'"]').children('.notetitle').text(t);
		$('[own-id="'+x+'"]').children('.notecontext').text(c);

		Colltxtexit();
	}
	function AddNotes()
	{
		var t = $("#title-field").val();
		var c = $("#context-field").val();

		var ownid = $.ajax({
    	type: "POST",
    	url: "php/AddNotes.php",
    	async: false,
    	data:({title:t, context:c}),
    	cache: false
  		}).responseText;

		notes_id.push(ownid);
		notes_title.push(t);
		notes_context.push(c);

		if(t.length > 10)
			var t = t.substring(0, 9) + '...';


		if(c.length > 91)
			var c = c.substring(0, 91) + '...';

		$('#mNotesBlock').append(
			'<div class="note" own-id='+ownid+'><div class="notetitle">'
			+t+'</div><div class="notecontext noselect">'+c+
			'</div></div>');

		ClickToColl();
		Colltxtexit();
	}
	function DeleteWarning(x)
	{
		if(x)
		{
			$('#deletewarning-box').css('display', 'block');
			$('#acceptbutton').click(function(){
				$('#deletewarning-box').css('display', 'none');
				DeleteNotes(x);
				RemoveWarning();
				Colltxtexit();
			});
			$('#cancelbutton').click(function(){
				RemoveWarning();
			});
		}
	}
	function RemoveWarning()
	{
		$('#deletewarning-box').css('display', 'none');
	}

	function DeleteNotes(x)
	{	
		$.ajax({
    	type: "POST",
    	url: "php/DeleteNotes.php",
    	async: false,
    	data:({id: x}),
    	cache: false
  		});

		var index = notes_id.indexOf(x);
		delete notes_id[index];
		delete notes_title[index];
		delete notes_context[index];


		$('[own-id="'+x+'"]').remove();

  		Colltxtexit();
	}

</script>
</body>
</html>