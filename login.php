<?PHP
include 'config.php';

$user = $_POST['user'];
$pass = $_POST['password'];
// $user="thomas";
// $pass="00e29ed2637611b998c5bf577783d8d3a";
$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

$query = mysql_query("SELECT * FROM `".$table_player."` WHERE `username`='".$user."' AND `password`='".$pass."'") or die(mysql_error());
$row = mysql_fetch_array($query);
if(!empty($row['username']) AND !empty($row['password'])) { 
	$_SESSION['username'] = $row['password']; 
		echo txtToXML("login", "OK");
} else { 
		echo txtToXML("login", "Error: Username or password incorrect");
}
?>