<?php
require_once "../../config.php";
require_once $CFG->dirroot."/db.php";
require_once $CFG->dirroot."/lib/lti_util.php";

session_start();

// Sanity checks
if ( !isset($_SESSION['lti']) ) {
	die('This tool must be launched using LTI');
}
$LTI = $_SESSION['lti'];
if ( !isset($LTI['user_id']) || !isset($LTI['link_id']) ) {
	die('A user_id and link_id are required for this tool to function.');
}
$p = $CFG->dbprefix;
$instructor = isset($LTI['role']) && $LTI['role'] == 1 ;

// The reset operation is a normal POST - not AJAX
if ( $instructor && isset($_POST['reset']) ) {
    $sql = "DELETE FROM {$p}chat";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':LI' => $LTI['link_id']));
    header( 'Location: '.sessionize('index.php') ) ;
    return;
}

if (isset($_POST['chat'])){
	$time=date('Y-m-d H:i:s');
	$chat=$_POST['text'];
	$uid=$LTI['user_id'];
	$lid=$LTI['link_id'];
	$sql= "INSERT INTO {$p}chat VALUES (".mysql_real_escape_string($uid).",'".mysql_real_escape_string($time)."','".mysql_real_escape_string($chat)."',".mysql_real_escape_string($lid).")";
	//echo $sql;
	$stmt = $db->prepare($sql);
	$stmt->execute();
}
?>
<html><head><title>Chat

<?php echo(htmlent_utf8($LTI['context_title'])); ?>
</title>

<script type="text/javascript" 
src="<?php echo($CFG->staticroot); ?>/static/js/jquery-1.10.2.min.js"></script>

</head>

<body>
	<h1>Chat</h1>
	<?php
	if($instructor){
		?>
		<a href="<?php echo(sessionize("chatlist.php")); ?>"target="_blank">chatlist.php</a>
	<form method="POST" action="index.php">
		<input type="text" name="text"/>
		<input type="submit" name="chat" value="Chat"/>
		<input type="submit" name="reset" value="Reset"/>
	<?php
	}
	else{
	?>
	<a href="<?php echo(sessionize("chatlist.php")); ?>"target="_blank">chatlist.php</a>
<form method="POST" action="index.php">
	<input type="text" name="text"/>
	<input type="submit" name="chat" value="Chat"/>
	<?php }?>
</form>

<div id="chatbox">
	 Loading
</div>

 
<script type="text/javascript">
var OLD_TIMEOUT = false; 
$(document).ready(function(){ 
window.console && console.log('Hello JQuery..'); 
OLD_TIMEOUT = setTimeout('updateMsg()', 200); 
}); 
function updateMsg(){
	if ( OLD_TIMEOUT ) { 
	clearTimeout(OLD_TIMEOUT); 
	OLD_TIMEOUT = false; 
	} 
	console.log("Sth")
	$.getJSON("<?php echo(sessionize("chatlist.php")); ?>", function( data ) {
		$("#chatbox").empty();
		for(i=0;i<data.length;i++){
			$("#chatbox").append("<p>"+data[i].chat+'<br/>&nbsp;&nbsp;' 
+data[i].displayname+' '+data[i].created_at+"</p>\n")
		}

 	  OLD_TIMEOUT = setTimeout('updateMsg()', 10000);  	
	}); 
		
			
	
}



</script>
	

</body>
</html>

