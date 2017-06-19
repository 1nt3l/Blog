		<div class="row">
			<div class="col-lg-12">
				<h1>Manage archives</h1>

				<table class="table table-striped">
				  <thead>
					<tr>
						<td width="60%">Archive</td>
						<td width="25%">Posts in archive</td>
						<td width="15%">Actions</td>
					</tr>
				</thead> 
				  <tbody>
				  <?php
					  $sql = mysql_query("SELECT * FROM blogger_archives ORDER BY id");
					  if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							echo '<tr>
									<td>'.decode_month($row[month]).' '.$row[year].'</td>
									<td>'.mysql_num_rows(mysql_query("SELECT * FROM archives_posts WHERE archive_id='$row[id]'")).'</td>
									<td><a href="'.$aurl.'?m=delete&type=archive&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
								</tr>';
						}
					  } else {
						echo '<tr><td colspan="3">No have archives.</td></tr>';
					  }
					  ?>
					  </tbody>
					</table>
			</div>
		</div>
