<?PHP
include 'config.php';

$user = $_POST['user'];
$pass = $_POST['password'];
// $user="thomas";
// $pass="00e29ed2637611b998c5bf577783d8d3";
$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

$query = mysql_query("SELECT * FROM `".$table_player."` WHERE `username`='".$user."' AND `password`='".$pass."'") or die(mysql_error());
$row = mysql_fetch_array($query);
if(!empty($row['username']) AND !empty($row['password'])) {
	$query2 = mysql_query("SELECT * FROM `".$table_player."` WHERE `username`='".$user."' AND `password`='".$pass."'") or die(mysql_error());
	echo xmlLogin($query2, "OK", "player");
} else { 
	echo txtToXML("login", "Error: Username or password incorrect");
}

function xmlLogin($queryResult, $data, $childElementName) {
	$rootElementName = "login";
	$xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
	$xmlData .= "<" . $rootElementName . ">";
	$xmlData .= "<status>".$data."</status>";

	while ( $record = mysql_fetch_object ( $queryResult ) ) {
		/* Create the first child element */
		$xmlData .= "<" . $childElementName . ">";

		for($i = 0; $i < mysql_num_fields ( $queryResult ); $i ++) {
			$fieldName = mysql_field_name ( $queryResult, $i );
				
			/* The child will take the name of the table column */
			$xmlData .= "<" . $fieldName . ">";
				
			/*
			 * We set empty columns with NULL, or you could set it to '0' or a blank.
			*/
			if (! empty ( $record->$fieldName ))
				$xmlData .= $record->$fieldName;
			else
				$xmlData .= "0";
				
			$xmlData .= "</" . $fieldName . ">";
		}
		$xmlData .= "</" . $childElementName . ">";
	}
	$xmlData .= "</" . $rootElementName . ">";

	return $xmlData;
}
?>