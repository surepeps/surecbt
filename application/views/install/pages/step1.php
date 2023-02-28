<?php
  $db_file_write_perm = is_writable('application/config/database.php');
  $routes_file_write_perm = is_writable('application/config/routes.php');
  $curl_enabled = function_exists('curl_version');
  if ($db_file_write_perm == false || $routes_file_write_perm == false || $curl_enabled == false) {
    $valid = false;
  } else {
    $valid = true;
  }
?>

<div class="card">
	<div class="card-header">
		<h4>Server configuration</h4>
	</div>
	<div class="card-body">
		<div class="media">
			<div class="media-body">
				<h5 class="mt-0">We ran diagnosis on your server. Review the items that have a red mark on it. If everything is green (confirmed), you
        are good to go to the next step.!</h5>
        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<p style="font-size: 14px;">
	          <?php if ($db_file_write_perm == true) { ?>
	            <i class="entypo-check" style="color: #5ac52d;">Confirmed</i>
	          <?php } else { ?>
	            <i class="entypo-cancel" style="color: #f12828">Error</i>
	          <?php } ?>
	          <strong>application/config/database.php </strong>: file has write permission
	        </p>
					<p style="font-size: 14px;">
	          <?php if ($routes_file_write_perm == true) { ?>
	            <i class="entypo-check" style="color: #5ac52d;">Confirmed</i>
	          <?php } else { ?>
	            <i class="entypo-cancel" style="color: #f12828">Error</i>
	          <?php } ?>
	          <strong>application/config/routes.php </strong>: file has write permission
	        </p>
					<p style="font-size: 14px;">
	          <?php if ($curl_enabled == true) { ?>
	            <i class="entypo-check" style="color: #5ac52d;">Confirmed</i>
	          <?php } else { ?>
	            <i class="entypo-cancel" style="color: #f12828">Error</i>
	          <?php } ?>
	          <strong>Curl Enabled</strong>
	        </p>
					<p style="font-size: 14px;">
	          <strong>To continue the installation process, all the above requirements are needed to be checked</strong>
	        </p>
				</div><br>

        <?php if ($valid == true) { ?>
        <div class="container-contact100-form-btn">
          <div class="wrap-contact100-form-btn">
            <div class="contact100-form-bgbtn"></div>
            <?php if ($_SERVER['SERVER_NAME'] != 'localhost' || $_SERVER['SERVER_NAME'] != '127.0.0.1') { ?>
            <a href="<?php echo site_url('install/step2');?>" class="contact100-form-btn btn btn-primary" style="text-decoration: none;">
              <span>
                Next
                <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
              </span>
            </a>
            <?php } else { ?>
            <a href="<?php echo site_url('install/step1');?>" class="contact100-form-btn btn btn-primary" style="text-decoration: none;">
              <span>
                  
                Could Not Proceed
                <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
              </span>
            </a>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
			</div>
		</div>
	</div>
</div>
