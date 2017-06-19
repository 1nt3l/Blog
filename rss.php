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
include("inc/functions.php");

$rss = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>

<channel>
	<title>'.$web[title].'</title>
	<atom:link href="'.$web[url].'rss" rel="self" type="application/rss+xml" />
	<link>http://wp.me4onkof.info</link>
	<description>'.$web[descriotion].'</description>
	<lastBuildDate>'.date("D, d M Y H:i:s O").'</lastBuildDate>
	<language>en-US</language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>http://blogger.me4onkof.info/?v=1.0</generator>';
$sql = mysql_query("SELECT * FROM blogger_posts ORDER BY id DESC LIMIT 10");
if(mysql_num_rows($sql)>0) {
	while($row = mysql_fetch_array($sql)) {
		$cat = mysql_fetch_array(mysql_query("SELECT * FROM blogger_categories WHERE id='$row[category]'"));
		$content = clean_input2($row['content']);
		$content = (strlen($content) > 903) ? substr($content,0,900).'...' : $content;
		$rss .= '<item>
		<title>'.$row[title].'</title>
		<link>'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'</link>
		<comments>'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'#comments</comments>
		<pubDate>'.date("D, d M Y H:i:s O",$row[time]).'</pubDate>
		<dc:creator>'.$row[author].'</dc:creator>
				<category><![CDATA['.$cat[value].']]></category>

		<guid isPermaLink="false">'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'</guid>
		<description><![CDATA[]]></description>
				<content:encoded><![CDATA['.$content.']]></content:encoded>
		<slash:comments>'.$row[comments].'</slash:comments>
		</item>';
	}
}
$rss .= '</channel>
</rss>';
echo $rss;
?>