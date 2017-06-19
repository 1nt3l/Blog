		<div class="row">
			<div class="col-lg-12">
				<h1>Manage posts  <small><a href="./?m=new_post"><i class="fa fa-plus"></i> New post</a></small></h1>

				<form action="" method="POST">
					<div class="input-group" style="margin-bottom:20px;">
					  <input type="text" class="form-control" name="q" placeholder="Search posts by title...">
					  <span class="input-group-btn">
						<button class="btn btn-default" type="submit" name="do_search"><i class="fa fa-search"></i> Search</button>
					  </span>
					</div><!-- /input-group -->
				</form> 

				<table class="table table-striped">
				  <thead>
					<tr>
						<td width="40%">Title</td>
						<td width="25%">Author</td>
						<td width="10%">Comments</td>
						<td width="15%">Actions</td>
					</tr>
				  </thead>
				  <tbody>
				  <?php
				  if(isset($_POST['do_search'])) {
					 $q = protect($_POST['q']);
					 if(empty($q)) { echo '<tr><td colspan="4">No results for empty query.</td></tr>'; }
					 else {
					 $sql = mysql_query("SELECT * FROM blogger_posts WHERE title LIKE '%$q%' ORDER BY id DESC");
					  if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							echo '<tr>
									<td><a href="'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'" target="_blank">'.$row[title].'</a></td>
									<td>'.idinfo($row[author],"name").' <span class="text-muted">@'.idinfo($row[author],"usern").'</span></td>
									<td>'.$row[comments].'</td>
									<td><a href="'.$aurl.'?m=edit&type=post&id='.$row[id].'"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=delete&type=post&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
								</tr>';
						}
					  } else {
						echo '<tr><td colspan="4">No found results.</td></tr>';
					  }
					  }
					  ?>
					  </tbody>
					</table>
					<?php
				  } else {
					  $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
					  $limit = 30;
					  $startpoint = ($page * $limit) - $limit;
					  $sql = mysql_query("SELECT * FROM blogger_posts ORDER BY id DESC LIMIT $startpoint , $limit");
					  if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							echo '<tr>
									<td><a href="'.$url.'post/'.make_post_link($row[id]).'-'.$row[id].'" target="_blank">'.$row[title].'</a></td>
									<td>'.idinfo($row[author],"name").' <span class="text-muted">@'.idinfo($row[author],"usern").'</span></td>
									<td>'.$row[comments].'</td>
									<td><a href="'.$aurl.'?m=edit&type=post&id='.$row[id].'"><i class="fa fa-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.$aurl.'?m=delete&type=post&id='.$row[id].'"><i class="fa fa-times"></i> Delete</a></td>
								</tr>';
						}
					  } else {
						echo '<tr><td colspan="4">No have posts.</td></tr>';
					  }
					  ?>
					  </tbody>
					</table>
					<?php
					$num_rows = mysql_num_rows(mysql_query("SELECT * FROM blogger_posts"));
					$itemPerPage = $limit;
					$firstPage = 1; // or 1, depending on your implementation
					$totalPage = ceil($num_rows / $itemPerPage);
					$currentPage = (int)$page;
					if($currentPage > $firstPage) {
						$pg = $currentPage-1;
						echo '<a href="'.$aurl.'?m=manage_posts&page='.$pg.'" class="btn btn-primary"><i class="fa fa-arrow-circle-o-left"></i> Previous</a>';
					}

					if($currentPage < $totalPage) {
						$pg = $currentPage+1;
						echo '<a href="'.$aurl.'?m=manage_posts&page='.$pg.'" class="btn btn-primary pull-right">Next <i class="fa fa-arrow-circle-o-right"></i></a>';
					}
				}
				?>
			</div>
		</div>
