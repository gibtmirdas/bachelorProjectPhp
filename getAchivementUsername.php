<?PHP

include 'config.php';

$user = $_POST['user'];
// $user = "player2";

/**************
 * Connection *
***************/
// Try to connect to DB with unity user
$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

// Select unity DB
mysql_select_db("$db_name" , $con) or die ("could not load the database" . mysql_error());

/**********************
 * Return Achivements *
**********************/
$return="";
$leaderboard = mysql_query("SELECT username, SUM(pts) AS ptss FROM `".$table_achivement."` WHERE `username`='".$user."'");
while($row = mysql_fetch_assoc($leaderboard)){
	$return.=$row['username']."/".$row['ptss']."-";
}
echo substr($return, 0, strlen($return)-1);
?>