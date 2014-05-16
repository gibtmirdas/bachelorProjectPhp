<?php 

include 'config.php';

$user = $_POST['user'];
$score = $_POST['score'];
$track = $_POST['track'];

// $user="player3";
// $score="20";
// $track="track1";

/**************
 * Connection *
***************/
// Try to connect to DB with unity user
$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

// Select unity DB
mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

/***********************
 * Check if user exist *
***********************/
$check = mysql_query("SELECT * FROM `".$table_account."` WHERE `username`='".$user."'");
$numrows = mysql_num_rows($check);
if ($numrows == 0)
{
	die ("Username does not exist \n");
}
else
{
	echo "OK user exist !";
	add_score($table_leaderboard, $user, $score, $track);
}


/*****************************************
 * Add/update score to leaderboard table *
 *****************************************/
function add_score($table, $user, $score, $track){
	// Check allow only one score per track and per username
	// => check if user already have best score for the current track
	
	$check = mysql_query("SELECT * FROM `".$table."` WHERE `username`='".$user."' AND `track`='".$track."';");
	$numrows = mysql_num_rows($check);
	
	if ($numrows == 0){
		// insert score
		echo "Add score";
		// Add score to DB
		$date="01-01-2014";
		$ins = mysql_query("INSERT INTO  `".$table."` ( `username` ,  `score` , `track`, `date` ) 
				VALUES ('".$user."' ,  '".$score."' ,  '".$track."' ,  '".date("Y-m-d H:i:s")."') ; ");
		if ($ins)
			die ("Score added succesfully!");
		else
			die ("Error: " . mysql_error());
	}else{
		// update score
		echo "Update score";
		$up = mysql_query("UPDATE `".$table."` SET `score`='".$score."', `date`='".date("Y-m-d H:i:s")."' 
				WHERE `username`='".$user."' AND `track`='".$track."'");
		if ($up)
			die ("Score added succesfully!");
		else
			die ("Error: " . mysql_error());
	}
	
	

}
?>