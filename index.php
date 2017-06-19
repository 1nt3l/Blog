<?php
ob_start();
session_start();
if(file_exists("./install.php")) {
	header("Location: ./install.php");
}  
include("inc/config.php");
// get web settings
$web = mysql_fetch_array(mysql_query("SELECT * FROM blogger_settings ORDER BY id DESC LIMIT 1"));
$url = $web['url'];
include("lang/language.php");
include("inc/functions.php");

$user_ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$check_visit = mysql_query("SELECT * FROM blogger_unique_visitors WHERE user_ip='$user_ip'");
if(mysql_num_rows($check_visit)>0) {
	$visit = mysql_fetch_array($check_visit);
		if($time > $visit['time']) {
		$update = mysql_query("UPDATE blogger_settings SET visitors=visitors+1");
		$ua = getBrowser();
		$user_agent = $ua['name'];
		$user_agent_version = $ua['version'];
		$user_platform = $ua['platform'];
		$browser = $user_agent.' '.$user_agent_version;
		include("inc/geoip/geoipcity.inc");
		include("inc/geoip/geoipregionvars.php");
		$gi = geoip_open("inc/geoip/GeoLiteCity.dat",GEOIP_STANDARD);
		$record = geoip_record_by_addr($gi,$user_ip);
		$country = $record->country_name;
		$city = $record->city;
		$continent = $record->continent_code;
		geoip_close($gi);
		$city = $city.', '.$country;
		$location = $city;
		$insert_visit = mysql_query("INSERT blogger_visitors (user_ip,os,browser,location,time) VALUES ('$user_ip','$user_platform','$browser','$location','$time')");
		$new_time = time() + 86400;
		$update_visit = mysql_query("UPDATE blogger_unique_visitors SET time='$new_time' WHERE user_ip='$user_ip'");
	}
} else {
	$update = mysql_query("UPDATE blogger_settings SET visitors=visitors+1");
	$ua = getBrowser();
	$user_agent = $ua['name'];
	$user_agent_version = $ua['version'];
	$user_platform = $ua['platform'];
	$browser = $user_agent.' '.$user_agent_version;
	include("inc/geoip/geoipcity.inc");
	include("inc/geoip/geoipregionvars.php");
	$gi = geoip_open("inc/geoip/GeoLiteCity.dat",GEOIP_STANDARD);
	$record = geoip_record_by_addr($gi,$user_ip);
	$country = $record->country_name;
	$city = $record->city;
	$continent = $record->continent_code;
	geoip_close($gi);
	$city = $city.', '.$country;
	$location = $city;
	$insert_visit = mysql_query("INSERT blogger_visitors (user_ip,os,browser,location,time) VALUES ('$user_ip','$user_platform','$browser','$location','$time')");
	$new_time = time() + 86400;
	$insert_visitt = mysql_query("INSERT blogger_unique_visitors (user_ip,time) VALUES ('$user_ip','$new_time')");
}

$m = protect($_GET['m']);
include("src/header.php");
switch($m) {
		case "subscribe": include("src/subscribe.php"); break;
		case "unsubscribe": include("src/unsubscribe.php"); break;
		case "search": include("src/search.php"); break;
		case "post": include("src/post.php"); break;
		case "archive": include("src/archive.php"); break;
		case "category": include("src/category.php"); break;
		case "tag": include("src/tag.php"); break;
		default: include("src/home.php");
}
include("src/footer.php");
?>
