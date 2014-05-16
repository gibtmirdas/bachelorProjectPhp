<?PHP

include 'config.php';

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
 * Return leaderboard *
**********************/
$return="";
$leaderboard = mysql_query("SELECT * FROM `".$table_leaderboard."` ORDER BY track ASC, score ASC;");
while($row = mysql_fetch_assoc($leaderboard)){
	$return.=$row['username']."/".$row['score']."/".$row['track']."-";
}
echo substr($return, 0, strlen($return)-1);
?>