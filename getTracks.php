<?PHP
include 'config.php';

// $lvl = $_POST['lvl'];
$lvl = 1;

$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

// $query = mysql_query("SELECT * FROM `".$table_track."` WHERE `lvl`<='".$lvl."' ORDER BY lvl") or die(mysql_error());
$query = mysql_query("
		SELECT  track.name, track.lvl, track.type, track.img, type.max_missed AS maxMissed, type.bonus AS typeBonus, lvl.bonus AS lvlBonus, lvl.penalty 
		FROM `".$table_track."` AS track
		JOIN `".$table_type."` AS type ON track.`type`=type.`name`
		JOIN `".$table_lvl."` AS lvl ON track.`lvl`=lvl.`value`
		WHERE `lvl`<='".$lvl."' ORDER BY lvl") or die(mysql_error());
echo sqlToXml($query, $table_track."s", $table_track);
?>