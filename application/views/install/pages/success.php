<div class="card">
	<div class="card-header">
		<h4>Application Read to Use!</h4>
	</div>
	<div class="card-body">
		<div class="media">
			<div class="media-body">
				<div class="wrap-input100 validate-input" data-validate="Name is required">
					<p style="font-size: 14px;">
	          <strong>Installation was successfull. Please login to continue..</strong>
	        </p>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<table>
	          <tbody>
	            <tr>
	              <td style="padding: 12px;"><strong>Administrator Email |</strong></td>
	              <td style="padding: 12px;"><?php echo $admin_email; ?></td>
	            </tr>
	            <tr>
	              <td style="padding: 12px;"><strong>Password |</strong></td>
	              <td style="padding: 12px;">Your chosen password</td>
	            </tr>
	          </tbody>
	        </table>
				</div>


				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<a href="<?php echo site_url('install/success/login');?>" class="contact100-form-btn btn btn-primary" style="text-decoration: none;">
							<span>
								Proceed to Login
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
