<?PHP
include 'config.php';

// $lvl = $_POST['lvl'];
$lvl = 1;
// $user="thomas";
// $pass="00e29ed2637611b998c5bf577783d8d3a";

$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

$query = mysql_query("SELECT * FROM `".$table_track."` WHERE `lvl`<='".$lvl."' ORDER BY lvl") or die(mysql_error());
echo sqlToXml($query, "tracks", "track");
?>