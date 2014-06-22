<?PHP
include 'config.php';

$lvl = $_POST['lvl'];

$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

$query = mysql_query("SELECT * FROM `".$table_track."` WHERE `lvl`<='".$lvl."' ORDER BY lvl") or die(mysql_error());
echo sqlToXml($query, $table_track."s", $table_track);
?>