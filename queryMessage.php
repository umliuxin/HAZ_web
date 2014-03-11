<?php 
	header('Content-Type: application/json');
	$link = mysql_connect('liuxincom.ipagemysql.com', 'hazdb', 'liuxin1009');
	if (!$link) { 
	    die('Could not connect: ' . mysql_error()); 
	} 
	//echo 'Connected successfully'; 
	mysql_query("SET NAMES 'gbk'");
	mysql_select_db(haz_web_1); 

	$sql="SELECT * FROM chattest ORDER BY time DESC";
	$result=mysql_query($sql);
	$returnJson=array();
	while($row=mysql_fetch_row($result)){
		//$returnJson=$returnJson."{'time':'".$row[3]."','content':'".$row[2]."','user':'USER_NAME'},";
		$returnJson[]=array('time' => $row[3],'content' => $row[2],'user' => 'USER_NAME' );
	}
	
	echo json_encode($returnJson);


 ?>