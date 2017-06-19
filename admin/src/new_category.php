<div class="row">
	<div class="col-lg-12">
		<h1>New category</h1>

		<?php 
		if(isset($_POST['do_save'])) {
			$value = protect($_POST['value']);
			$check_category = mysql_query("SELECT * FROM blogger_categories WHERE value='$value'");

			if(empty($value)) { echo error("Please enter some category name."); }
			elseif(mysql_num_rows($check_category)>0) { echo error("This category already exists."); }
			else {
				$insert = mysql_query("INSERT blogger_categories (value) VALUES ('$value')");
				echo success("Category was added successfully.");
			}
		}
		?>

		<form role="form" action="" method="POST">
		  <div class="form-group">
			<label>Category name</label>
			<input type="text" class="form-control" name="value">
		  </div>
		  <button type="submit" class="btn btn-default" name="do_save">Add</button>
		</form>
	</div>
</div>
