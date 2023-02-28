<div class="card">
	<div class="card-header">
		<h4>Database configuration</h4>
	</div>
	<div class="card-body">
		<div class="media">
			<div class="media-body">
				<?php if(isset($error_con_fail)) { ?>
				<div class="row"
			    style="margin-top: 20px;">
			    <div class="col-md-12 col-md-offset-2">
			      <div class="alert alert-danger" style=" color: red;">
			        <strong><?php echo $error_con_fail; ?></strong>
			      </div>
			    </div>
			  </div>
			<?php } ?>
			<?php if(isset($error_nodb)) { ?>
				<div class="row"
					style="margin-top: 20px;">
					<div class="col-md-12 col-md-offset-2">
						<div class="alert alert-danger">
							<strong><?php echo $error_nodb; ?></strong>
						</div>
					</div>
				</div>
			<?php } ?>
			<form class="contact100-form validate-form" method="post"
				action="<?php echo site_url('install/step2/configure_database');?>">
				<p style="font-size: 14px;">
          Below you should enter your database connection details. If you’re not sure about these, contact your host.
        </p><br>
				<div class="form-group">
					<label>Database Name</label>
					<input type="text"  name="dbname" class="form-control">
				</div>

				<div class="form-group">
					<label>Database Username</label>
					<input type="text"  name="username" class="form-control">
				</div>

				<div class="form-group">
					<label>Database Password</label>
					<input type="password"  name="password" class="form-control">
				</div>

				<div class="form-group">
					<label>Database Host</label>
					<input type="text"  name="hostname" class="form-control">
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button type="submit" class="contact100-form-btn btn btn-primary" style="text-decoration: none;">
							<span>
								Next
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</button>
						</a>
					</div>
				</div>

			</form>
			</div>
		</div>
	</div>
</div>
