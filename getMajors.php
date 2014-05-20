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

/*********************
 * Return major_name *
 *********************/
$leaderboard = mysql_query("SELECT major_name FROM `".$table_major."` ORDER BY major_name;");
echo sqlToXml($leaderboard, "Major");
?>