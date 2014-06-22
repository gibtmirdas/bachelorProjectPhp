<?PHP
include 'config.php';

// $user = $_POST['user'];
// $pass = $_POST['password'];
$user="thomas";
$pass="00e29ed2637611b998c5bf577783ad8d3";

$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());
$result = "";
$result = mysql_query("SELECT * FROM `".$table_player."` WHERE `username`='".$user."'");
//$numrows = mysql_num_rows($check);
if(mysql_num_rows($result) == 1){
	while ($row = mysql_fetch_array($result)) {
		if($pass == $row['password'])
			echo txtToXML("login", "OK");
	}
}else
	echo txtToXML("login", "Error: Username or password doesn't exist");
?>