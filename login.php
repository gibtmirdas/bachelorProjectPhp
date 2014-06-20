<?PHP
include 'config.php';

$user = $_POST['user'];
$pass = $_POST['password'];
// $user="player2";
// $pass="passs";

$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

$check = mysql_query("SELECT * FROM `".$table_account."` WHERE `username`='".$user."'");
$numrows = mysql_num_rows($check);
if ($numrows != 0)
{
	$pass = md5($pass);
	while($row = mysql_fetch_assoc($check))
	{
		if ($pass == $row['password'])
			return txtToXML("login", "OK");
	}
}
return txtToXML("login", "Error: Username or password doesn't exist");
?>