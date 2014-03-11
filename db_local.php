<?php 
	header("Content-Type: text/html;charset=gbk");
	$link = mysql_connect('localhost:8889', 'root', 'root'); 
	if (!$link) { 
	    die('Could not connect: ' . mysql_error()); 
	} 
	//echo 'Connected successfully'; 
	mysql_query("SET NAMES 'gbk'");
	mysql_select_db(HAZweb); 

	function chatcontent(){
		$sql="SELECT * FROM chattest ORDER BY time DESC";
		$result=mysql_query($sql);
		return chatformat($result);
	}
	function chatformat($result){
		//transfer sql result into HTML format
		$returnStr='';
		while ($row=mysql_fetch_row($result)) {
			# code...
			$returnStr=$returnStr.'<div class="message">';
			$returnStr=$returnStr.'<p>WHO</p><p>'.$row[3].'</p><p>'.$row[2].'</p>';
			$returnStr=$returnStr.'</div>';
		}
		
		return $returnStr;
	}

	function addMessage($content){
		//not user
		$sql="INSERT INTO chattest (content) VALUES ('".$content."')";
		mysql_query($sql);

	}
?>