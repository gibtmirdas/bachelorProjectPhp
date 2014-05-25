<?php
$url = "localhost";

// sql vars
$sql_usr = "unity";
$sql_pwd = "unitypass";
$db_name = "unityserver";

// Tables names
$table_achivement = "achivement";
$table_difficulty = "difficulty";
$table_major = "major";
$table_occupancy = "occupancy";
$table_player = "player";
$table_points = "points";
$table_ranking = "ranking";
$table_skills = "skills";
$table_track = "track";

/**
 *
 * @param
 *        	mysql_resource - $queryResult - mysql query result
 * @param
 *        	string - $rootElementName - root element name
 * @param
 *        	string - $childElementName - child element name
 */
function sqlToXml($queryResult, $rootElementName, $childElementName) {
	$xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
	$xmlData .= "<" . $rootElementName . ">";
	
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
				$xmlData .= "null";
			
			$xmlData .= "</" . $fieldName . ">";
		}
		$xmlData .= "</" . $childElementName . ">";
	}
	$xmlData .= "</" . $rootElementName . ">";
	
	return $xmlData;
}

function txtToXML($rootElementName, $message){

	$xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
	$xmlData .= "<" . $rootElementName . ">";
	$xmlData .= $message;
	$xmlData .= "</" . $rootElementName . ">";
	return $xmlData;
}
?>