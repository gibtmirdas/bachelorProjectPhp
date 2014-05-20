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

/*************************
 * Return occupancy_name *
 *************************/
$return="";
$leaderboard = mysql_query("SELECT occupancy_name FROM `".$table_occupancy."` ORDER BY occupancy_name;");
while($row = mysql_fetch_assoc($leaderboard)){
	$return.=$row['occupancy_name']."-";
}
echo substr($return, 0, strlen($return)-1);
?>