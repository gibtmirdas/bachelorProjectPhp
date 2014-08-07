<?PHP

include 'config.php';

//$user = $_POST['player'];
$user = "test";

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
$result = mysql_query("SELECT * FROM `".$table_achievement."` WHERE `player`='".$user."'");
echo sqlToXml($result,"achievementUsernames","achievementUsername");
?>