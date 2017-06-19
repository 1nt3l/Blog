		<div class="row">
			<div class="col-lg-12">
				<h1>Comments <small>waiting for approval</h1>

				<table class="table table-striped">
				  <thead> 
					<tr>
						<td width="80%">Comment info</td>
						<td width="20%">Actions</td>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					  $sql = mysql_query("SELECT * FROM blogger_comments WHERE status='2' ORDER BY id");
					  if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							$post = mysql_fetch_array(mysql_query("SELECT * FROM blogger_posts WHERE id='$row[post_id]'"));
							echo '<tr>
									<td valign="top">
									<table border="0" cellspacing="2" cellpadding="2" width="100%">
										<tr>
											<td width="25%"><i class="fa fa-user"></i> '.$row[name].'</td>
											<td width="25%"><i class="fa fa-envelope"></i> '.$row[email].'</td>
											<td width="25%"><i class="fa fa-globe"></i> <a href="'.$row[website].'">'.$row[website].'</a></td>
											<td width="25%"><i class="fa fa-camera"></i> <a href="'.$row[avatar].'">Preview</a></td>
										</tr>
										<tr>
											<td colspan="4" style="padding-top:5px;">
												Comment: '.$row[comment].'<br/>
												To post: <a href="'.$url.'post/'.make_post_link($post[id]).'-'.$post[id].'">'.$post[title].'</a>
											</td>
										</tr>
									</table>
									</td>
									<td valign="top"><a href="'.$aurl.'?m=approve&id='.$row[id].'"><i class="fa fa-check"></i> Approve</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=edit&type=comment&id='.$row[id].'"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=delete&type=comment&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
								</tr>';
						}
					  } else {
						echo '<tr><td colspan="2">No have comments for approval.</td></tr>';
					  }
					  ?>
					  </tbody>
					</table>

					<h1>Search <small>comments</small></h1>

					<form action="" method="POST">
						<div class="input-group" style="margin-bottom:20px;">
						  <input type="text" class="form-control" name="q" placeholder="Search comments by author name...">
						  <span class="input-group-btn">
							<button class="btn btn-default" type="submit" name="do_search"><i class="fa fa-search"></i> Search</button>
						  </span>
						</div><!-- /input-group -->
					</form>

					<?php
					if(isset($_POST['do_search'])) {
						?>
						<table class="table table-striped">
						  <thead>
							<tr>
								<td width="80%">Comment info</td>
								<td width="20%">Actions</td>
							</tr>
						  </thead>
						  <tbody>
						<?php
						$q = protect($_POST['q']);
						if(empty($q)) { echo '<tr><td colspan="4">No results for empty query.</td></tr>'; }
						else {
							$sql = mysql_query("SELECT * FROM blogger_comments WHERE name LIKE '%$q%' ORDER BY id");
							  if(mysql_num_rows($sql)>0) {
								while($row = mysql_fetch_array($sql)) {
									$post = mysql_fetch_array(mysql_query("SELECT * FROM blogger_posts WHERE id='$row[post_id]'"));
									echo '<tr>
											<td valign="top">
											<table border="0" cellspacing="2" cellpadding="2" width="100%">
												<tr>
													<td width="25%"><i class="fa fa-user"></i> '.$row[name].'</td>
													<td width="25%"><i class="fa fa-envelope"></i> '.$row[email].'</td>
													<td width="25%"><i class="fa fa-globe"></i> <a href="'.$row[website].'">'.$row[website].'</a></td>
													<td width="25%"><i class="fa fa-camera"></i> <a href="'.$row[avatar].'">Preview</a></td>
												</tr>
												<tr>
													<td colspan="4" style="padding-top:5px;">
														Comment: '.$row[comment].'<br/>
														To post: <a href="'.$url.'post/'.make_post_link($post[id]).'-'.$post[id].'">'.$post[title].'</a>
													</td>
												</tr>
											</table>
											</td>
											<td valign="top"><a href="'.$aurl.'?m=edit&type=comment&id='.$row[id].'"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=delete&type=comment&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
										</tr>';
								}
							  } else {
								echo '<tr><td colspan="2">No found results.</td></tr>';
							  }
						}
						?>
							 </tbody>
						</table>
						<?php
					}
					?>
			</div>
		</div>
