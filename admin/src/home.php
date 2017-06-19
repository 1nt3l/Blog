        <div class="row">
          <div class="col-lg-4">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo mysql_num_rows(mysql_query("SELECT * FROM blogger_comments WHERE status='2'")); ?></p>
                    <p class="announcement-text">comments waiting</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $aurl.'?m=manage_comments'; ?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo mysql_num_rows(mysql_query("SELECT * FROM blogger_posts")); ?></p>
                    <p class="announcement-text">total posts</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $aurl.'?m=manage_posts'; ?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-users fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $web['visitors']; ?></p>
                    <p class="announcement-text">blog visitors</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $aurl.'?m=stats'; ?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
		  </div>
        </div><!-- /.row -->

		<div class="row">
			<div class="col-lg-12">
				<h2>Latest visitors</h2>
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
				  $sql = mysql_query("SELECT * FROM blogger_visitors ORDER BY id DESC LIMIT 15");
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
			</div>
		</div>
