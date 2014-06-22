<?PHP
include 'config.php';

// $user = $_POST['user'];
// $pass = $_POST['password'];
$user="thomas";
$pass="00e29ed2637611b998c5bf577783d8d3";

$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());
$result = mysql_query("SELECT * FROM `".$table_player."` WHERE `username`='".$user."'");

// Reponse empty
if($result == "")
	echo txtToXML("login", "Error: Username or password incorrect");
// More than 1 row
else if(mysql_num_rows($result) != 1)
	echo txtToXML("login", "Error: Username or password incorrect");

// Get 1 row => compare hashed pwd
else{
	$row = mysql_fetch_array($result);
	if($pass == $row['password'])
		echo txtToXML("login", "OK");
	else
		echo txtToXML("login", "Error: Username or password incorrect");
}
?>