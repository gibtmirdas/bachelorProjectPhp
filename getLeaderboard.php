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
$leaderboard = mysql_query("SELECT t.name, p.username,a.ranking, a.date, SUM(po.points) AS total 
		FROM `".$table_achivement."` AS a 
		JOIN `".$table_track."` AS t ON `t`.`name`=`a`.`track` 
		JOIN `".$table_player."` AS p ON a.`player`=p.`username` 
		JOIN `".$table_points."` AS po ON po.ranking=a.ranking AND po.difficulty=t.difficulty 
		GROUP BY p.username 
		ORDER BY total;");
echo $leaderboard;
logg($leaderboard);
//echo sqlToXml($leaderboard,"leaderboards","leaderboards");
?>