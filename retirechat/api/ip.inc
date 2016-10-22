<?php
/*
 * Functions for determining user's IP address and their location
 * 
 */ 

// API key for geolocation service
define("IP_INFO_DB_KEY", "47489192a3966a1f854662c3598d429f2c31a6d355d6fe427d4feb96c8b668cf");

define("COUNTRY_SHORT", 3);
define("COUNTRY_LONG", 4);
define("STATE", 5);
define("CITY", 6);
 
function getClientIP() {
	return $_SERVER['REMOTE_ADDR'];
}

/*
 * Returns 1 if the user specified by $userID has their IP address set 
 * 	and 0 otherwise.
 */ 
function userIPSet($userID) {
	$query = "SELECT ip FROM users WHERE id='$userID'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$ip = $row['ip'];
	
	return strcmp($ip, ""); // If ip is "", return 0
}

/*
 * Uses external database to get the city in which $ip is located. If no 
 * 	$ip is passed in, uses the client's IP.
 * 
 * If data was successfully retrieved, returns array of form (city, [state|country]).
 * 	Otherwise, returns NULL
 */ 
function getClientLocByIP($ip = NULL) {
	if (!isset($ip))
		$ip = getClientIP();
	
	// http://api.ipinfodb.com/v3/ip-city/?key=<your_api_key>&ip=74.125.45.100
	$url = "http://api.ipinfodb.com/v3/ip-city/?key=".IP_INFO_DB_KEY.
			"&ip=$ip";
/*
	if (!($location_str = file_get_contents($url)))
		return NULL;
	
	$location = explode(';', $location_str);
	if ($location[COUNTRY_SHORT] == "US")
		return array($location[CITY], $location[STATE]);
	else
		return array($location[CITY], $location[COUNTRY_LONG]);
*/

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
	if (!($location_str = curl_exec($ch))) {
		return NULL;
	}
	curl_close($ch);

	$location = explode(';', $location_str);
	if ($location[COUNTRY_SHORT] == "US")
		return array($location[CITY], $location[STATE]);
	else
		return array($location[CITY], $location[COUNTRY_LONG]);

}

?>
