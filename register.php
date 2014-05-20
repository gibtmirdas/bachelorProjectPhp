<?PHP
include 'config.php';

$user = $_POST['user'];
$pass = $_POST['password'];
$age= $_POST['age'];
$major= $_POST['major'];
$occupancy= $_POST['occupancy'];
$skills= $_POST['skills'];


// $user="player3";
// $pass="passs";
// $age="20";
// $major="Bsc Computer Science";
// $occupancy="Switzerland";
// $skiskills="Pro";



$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_select_db("$db_name" , $con) or die ("could not load the database" . mysql_error());

$check = mysql_query("SELECT * FROM `".$table_account."` WHERE `username`='".$user."'");
$numrows = mysql_num_rows($check);
if ($numrows == 0)
{
	$pass = md5($pass);
	if(isset($_POST['skills'])){
		$ins = mysql_query("INSERT INTO  `".$table_account."` (  `account_id` ,  `username` ,  `password`,  `age`,  `major_name`,  `occupancy_name`,  `ski_skills` )
			 VALUES ('' ,  '".$user."' ,  '".$pass."' ,  '".$age."' ,  '".$major."' ,  '".$occupancy."' ,  '".$skills."') ; ");
	}else{
		$ins = mysql_query("INSERT INTO  `".$table_account."` (  `account_id` ,  `username` ,  `password`,  `age`,  `major_name`,  `occupancy_name` )
			 VALUES ('' ,  '".$user."' ,  '".$pass."' ,  '".$age."' ,  '".$major."' ,  '".$occupancy."') ; ");
	}
	if ($ins)
		die ("Successfully Created User!");
	else
		die ("Error: " . mysql_error());
}
else
{
	die("User already exists!");
}


?>