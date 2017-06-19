		<div class="row">
			<div class="col-lg-12">
				<h1>Manage categories <small><a href="./?m=new_category"><i class="fa fa-plus"></i> New category</a></small></h1>

				<table class="table table-striped">
				  <thead>
					<tr> 
						<td width="60%">Category name</td>
						<td width="25%">Posts in category</td>
						<td width="15%">Actions</td>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					  $sql = mysql_query("SELECT * FROM blogger_categories ORDER BY id");
					  if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							echo '<tr>
									<td>'.$row[value].'</td>
									<td>'.mysql_num_rows(mysql_query("SELECT * FROM blogger_posts WHERE category='$row[id]'")).'</td>
									<td><a href="'.$aurl.'?m=edit&type=category&id='.$row[id].'"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=delete&type=category&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
								</tr>';
						}
					  } else {
						echo '<tr><td colspan="3">No have categories.</td></tr>';
					  }
					  ?>
					  </tbody>
					</table>
			</div>
		</div>
