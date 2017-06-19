		<div class="row">
			<div class="col-lg-12">
				<h1>Manage users <small><a href="./?m=new_user"><i class="fa fa-plus"></i> New user</a></small></h1>

				<table class="table table-striped">
				  <thead>
					<tr> 
						<td width="20%">Name</td>
						<td width="20%">Username</td>
						<td width="20%">Email address</td>
						<td width="15%">Posts by user</td>
						<td width="25%">Actions</td>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					  $sql = mysql_query("SELECT * FROM blogger_users ORDER BY id");
					  if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							echo '<tr>
									<td>'.$row[name].'</td>
									<td>'.$row[usern].'</td>
									<td>'.$row[email].'</td>
									<td>'.mysql_num_rows(mysql_query("SELECT * FROM posts WHERE author='$row[id]'")).'</td>
									<td><a href="'.$aurl.'?m=login_as&id='.$row[usern].'"><i class="fa fa-sign-in"></i> Login as '.$row[usern].'</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=delete&type=user&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
								</tr>';
						}
					  } else {
						echo '<tr><td colspan="3">No have users.</td></tr>';
					  }
					  ?>
					  </tbody>
					</table>
			</div>
		</div>
