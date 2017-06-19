<div class="row">
	<div class="col-lg-12">
		<h1>Approve <small>comment</small></h1>
		 
		<?php
		$id = protect($_GET['id']);
		$sql = mysql_query("SELECT * FROM blogger_comments WHERE id='$id'");
		if(mysql_num_rows($sql)==0) { header("Location: $aurl"); }
		$row = mysql_fetch_array($sql);
		$post = mysql_fetch_array(mysql_query("SELECT * FROM blogger_posts WHERE id='$row[post_id]'"));
		$update = mysql_query("UPDATE blogger_posts SET comments=comments+1 WHERE id='$post[id]'");
		$update = mysql_query("UPDATE blogger_comments SET status='1' WHERE id='$id'");
		echo success("Selected comment was approved successfully.");
		$to      = $row['email'];
		$subject = $web['web_name']." - Your comment was approved";
		$message = 'Hi '.$row[name].'

We approve your comment and you can preview it here:
'.$url.'post/'.make_post_link($post[id]).'-'.$post[id].'

Do not reply on this message.';
		$headers = 'From: '.$web[web_email].'' . "\r\n" .
			'Reply-To: '.$web[web_email].'' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
		?>
	</div>
</div>
