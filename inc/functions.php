<?php
function protect($string) {
	$protection = htmlspecialchars(trim($string), ENT_QUOTES);
	return $protection;
} 

function idinfo($id,$value) {
	$sql = mysql_query("SELECT * FROM blogger_users WHERE id='$id'");
	$row = mysql_fetch_array($sql);
	return $row[$value];
}

function success($text) {
	return '<div class="alert alert-success">'.$text.'</div>';
}

function info($text) {
	return '<div class="alert alert-info">'.$text.'</div>';
}

function error($text) {
	return '<div class="alert alert-danger">'.$text.'</div>';
}

function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function isValidUsername($str) {
    return preg_match('/^[a-zA-Z0-9-_]+$/',$str);
}

function isValidEmail($str) {
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}

function get_profile_photo($id) {
	global $web;
	if(idinfo($id,"profile_photo")) {
		return idinfo($id,"profile_photo");
	} else {
		return $web['url']."imgs/default_avatar.png";
	}
}

function percentage($val1, $val2, $precision) {
	$division = $val1 / $val2;

	$res = $division * 100;

	$res = round($res, $precision);

	return $res;
}


function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function clean_input($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   /* strip out javascript */
		'@<style[^>]*?>.*?</style>@siU',    /* strip style tags properly */
		'@<![\s\S]*?--[ \t\n\r]*>@'         /* strip multi-line comments */
	);

	$output = preg_replace($search, '', $input);
	return $output;
}

function clean_input2($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   /* strip out javascript */
		'@<[\/\!]*?[^<>]*?>@si',            /* strip out HTML tags */
		'@<style[^>]*?>.*?</style>@siU',    /* strip style tags properly */
		'@<![\s\S]*?--[ \t\n\r]*>@'         /* strip multi-line comments */
	);

	$output = preg_replace($search, '', $input);
	return $output;
}

function captcha($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) {
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		$_SESSION['captcha_code'] = $code;
		return $code;
}

function format_time($type,$time) {
	if($type == "1") {
		return date("F d, Y",$time);
	} elseif($type == "2") {
		return date("d F Y",$time);
	} elseif($type == "3") {
		return date("d M Y",$time);
	} else {
		return 'Undefined';
	}
}

function decode_month($month) {
	global $lang;
	if($month == "01") { return $lang[january]; }
	elseif($month == "02") { return $lang[february]; }
	elseif($month == "03") { return $lang[march]; }
	elseif($month == "04") { return $lang[april]; }
	elseif($month == "05") { return $lang[may]; }
	elseif($month == "06") { return $lang[june]; }
	elseif($month == "07") { return $lang[july]; }
	elseif($month == "08") { return $lang[august]; }
	elseif($month == "09") { return $lang[september]; }
	elseif($month == "10") { return $lang[october]; }
	elseif($month == "11") { return $lang[november]; }
	elseif($month == "12") { return $lang[december]; }
	else {
		return 'Undefined';
	}
}

function check_urls($text){
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,6}(\/\S*)?/";
            preg_match_all($reg_exUrl, $text, $matches);
            $usedPatterns = array();
            foreach($matches[0] as $pattern){
                if(!array_key_exists($pattern, $usedPatterns)){
                    $usedPatterns[$pattern]=true;
                    $text = str_replace($pattern, "<a href='$pattern' target='_blank'>$pattern</a> ", $text);
                }
            }
            return $text;
}

function make_category_link($id) {
	$sql = mysql_query("SELECT * FROM blogger_categories WHERE id='$id'");
	$row = mysql_fetch_array($sql);
	$value = str_ireplace(
                            array (
                                    ' ',
                                    '!',
									'.',
									',',
                                    '@',
                                    '#',
									'$',
									'%',
									'^',
									'&',
									'(',
									')',
									'_',
									'=',
									'[',
									']',
									':',
									';',
									'<',
									'>',
									'?',
									'/',
									'`',
									'~'
                                  ),
                            array (
                                    "-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-"
                                  ),
                            $row[value]
                          );
	return utf8_encode($value);
}

function make_post_link($id) {
	$sql = mysql_query("SELECT * FROM blogger_posts WHERE id='$id'");
	$row = mysql_fetch_array($sql);
	$value = str_ireplace(
                            array (
                                    ' ',
                                    '!',
									'.',
									',',
                                    '@',
                                    '#',
									'$',
									'%',
									'^',
									'&',
									'(',
									')',
									'_',
									'=',
									'[',
									']',
									':',
									';',
									'<',
									'>',
									'?',
									'/',
									'`',
									'~'
                                  ),
                            array (
                                    "-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-",
									"-"
                                  ),
                            $row[title]
                          );
	return utf8_encode($value);
}
?>
