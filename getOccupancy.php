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
$leaderboard = mysql_query("SELECT name FROM `".$table_occupancy."` ORDER BY `ocpy_id`;");
echo sqlToXml($leaderboard, $table_occupancy."s", $table_occupancy)
?>