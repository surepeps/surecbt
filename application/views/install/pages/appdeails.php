<div class="card">
	<div class="card-header">
		<h4>	Application details</h4>
	</div>
	<div class="card-body">
		<div class="media">
			<div class="media-body">

			<form class="contact100-form validate-form" action="<?php echo site_url('install/finalizing_setup/setup_admin');?>" method="post">

				<div class="wrap-input100 validate-input" data-validate="Name is required">
					<strong>
            Before you start using your application, make it yours. Set your application name and title, admin login email and
            password. Remember the login credentials which you will need later on for signing into your account. After this step,
            you will be redirected to application's login page.
          </strong>
				</div><br>
					<div class="form-group">
						<label>School Name</label>
						<input type="text"  name="system_name" class="form-control">
					</div>

					<div class="form-group">
						<label>Admin Fullname</label>
						<input type="text"  name="name" class="form-control">
					</div>

					<div class="form-group">
						<label>Admin Email</label>
						<input type="email"  name="email" class="form-control">
					</div>

					<div class="form-group">
						<label>Admin Password</label>
						<input type="password"  name="password" class="form-control">
					</div>

					<div class="container-contact100-form-btn">
						<div class="wrap-contact100-form-btn">
							<div class="contact100-form-bgbtn"></div>
							<button type="submit" class="contact100-form-btn btn btn-primary" style="text-decoration: none;">
								<span>
									Finalise
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
<!--  -->
