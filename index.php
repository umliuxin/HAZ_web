<?php 
require_once('db.php');
if(isset($_POST['chatcontent'])){
	$content=$_POST['chatcontent'];
	addMessage($content);
	unset($_POST['chatcontent']);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>CHAT</title>
</head>
<body>


<!--<script src="jquery-2.0.2.js"></script>-->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<form method="POST">
	<input type="text" name="chatcontent">
	<input type="submit">
</form>

<div>
	<p>Chat Content</p>
	<div id="content">
	LOADING
	</div>
</div>


<script type="text/javascript">
	var OLD_TIMEOUT = false; 

	$(document).ready(function(){ 

	console.log('Hello JQuery..'); 

	OLD_TIMEOUT = setTimeout('updateMsg()', 200); 

	}); 


	function updateMsg(){

		console.log("updateMsg()");

		if ( OLD_TIMEOUT ) { 

		clearTimeout(OLD_TIMEOUT); 

		OLD_TIMEOUT = false
		} 
		console.log("Sth")

		$.getJSON("queryMessage.php", function( data ) {

			
			$("#content").empty();
			if(data.length==0){
					$('#content').append('<p>No message</p>')
			}
			else{
				for(i=0;i<data.length-1;i++){

					$("#content").append('<div class="message"><p>'+data[i].user+'</p><p>'+data[i].content+'</p><p>'+data[i].time+'</p></div>')

				}

			}
			

		OLD_TIMEOUT = setTimeout('updateMsg()', 500);  	

		});
	}
</script>
</body>
</html>