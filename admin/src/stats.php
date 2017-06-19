		<div class="row">
			<div class="col-lg-12">
				<h1>Stats <small>view blog visitors</h1></h1>

				<table class="table table-striped">
				  <thead>
					<tr>
						<td width="25%">User IP</td>
						<td width="25%">User platform</td>
						<td width="25%">User browser</td>
						<td width="25%">Visit time</td>
					</tr>
				  </thead>
				  <tbody>
				  <?php
				  $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				  $limit = 20;
				  $startpoint = ($page * $limit) - $limit;
				  $sql = mysql_query("SELECT * FROM blogger_visitors ORDER BY id DESC LIMIT $startpoint , $limit");
				  if(mysql_num_rows($sql)>0) {
					while($row = mysql_fetch_array($sql)) {
						echo '<tr>
								<td>'.$row[user_ip].'</td>
								<td>'.$row[os].'</td>
								<td>'.$row[browser].'</td>
								<td>'.date("d.m.Y H:i",$row[time]).'</td>
							</tr>';
					}
				  } else {
					echo '<tr><td colspan="4">No have latest visitors.</td></tr>';
				  }
				  ?>
				  </tbody>
				</table>
				<?php
				$num_rows = mysql_num_rows(mysql_query("SELECT * FROM blogger_visitors"));
				$itemPerPage = $limit;
				$firstPage = 1; // or 1, depending on your implementation
				$totalPage = ceil($num_rows / $itemPerPage);
				$currentPage = (int)$page;
				if($currentPage > $firstPage) {
					$pg = $currentPage-1; 
					echo '<a href="'.$aurl.'?m=stats&page='.$pg.'" class="btn btn-primary"><i class="fa fa-arrow-circle-o-left"></i> Previous</a>';
				}

				if($currentPage < $totalPage) {
					$pg = $currentPage+1;
					echo '<a href="'.$aurl.'?m=stats&page='.$pg.'" class="btn btn-primary pull-right">Next <i class="fa fa-arrow-circle-o-right"></i></a>';
				}
				?>
			</div>
		</div>
