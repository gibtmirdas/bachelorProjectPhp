<?php
$url = "localhost";

// sql vars
$sql_usr = "unity";
$sql_pwd = "unitypass";
$db_name = "unityserver";

// Tables names
$table_achievement = "dat_achievement";
$table_player = "dat_player";
$table_major = "set_major";
$table_occupancy = "set_occupancy";
$table_skills = "set_skills";
$table_track = "set_track";
$table_type = "set_type";
$table_lvl = "set_lvl";
$table_ranking = "set_ranking";

/**
 * Convert sql query response into an XML string.
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
				$xmlData .= "0";
			
			$xmlData .= "</" . $fieldName . ">";
		}
		$xmlData .= "</" . $childElementName . ">";
	}
	$xmlData .= "</" . $rootElementName . ">";
	
	return $xmlData;
}

/**
 * Convert a string into a XML string
 * @param unknown $rootElementName
 * @param unknown $message
 * @return string
 */
function txtToXML($rootElementName, $message){

	$xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
	$xmlData .= "<" . $rootElementName . ">";
	$xmlData .= $message;
	$xmlData .= "</" . $rootElementName . ">";
	return $xmlData;
}

/**
 * Display information
 * @param unknown $query
 */
function logg($query){

	while ( $record = mysql_fetch_object ( $query ) ) {
		echo $record."--";
	}
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