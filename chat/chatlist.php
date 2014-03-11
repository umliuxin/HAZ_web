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



$stmt = $db->prepare("SELECT chat, displayname, {$p}chat.created_at AS created_at 
FROM {$p}chat JOIN {$p}lti_user 
ON {$p}chat.user_id = {$p}lti_user.user_id 
WHERE link_id = :LI ORDER BY {$p}chat.created_at DESC LIMIT 0,15"); 
$stmt->execute(array(":LI" => $LTI['link_id'])); 

$messages = array(); 

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) { 
$messages[] = $row; 
} 

echo(json_encode($messages)); 

?>