<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?> | Admin Login Page</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/izitoast/css/iziToast.min.css">


  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>uploads/sys_image/logo.png">>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="login-brand">
              <img src="<?php echo base_url(); ?>uploads/sys_image/logo.png" width="80" height="80" alt="">
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4 style="text-align: center;">  <?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?></h4>
              </div>
              <div class="card-body">
                <form id="" action="<?php echo base_url('admin/validate_login'); ?>" method="post" class="needs-validation">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
                      <input id="email" type="email" class="form-control" name="email" autofocus placeholder="Email">
                    </div>
                  </div>

									<div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-key"></i>
                        </div>
                      </div>
                      <input id="password" type="password" class="form-control" name="password" autofocus placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-lg btn-round btn-primary">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
                <?php echo $this->db->get_where('settings' , array('type'=>'system_footer'))->row()->description; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
	<script src="<?php echo base_url(); ?>assets/bundles/izitoast/js/iziToast.min.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

	<?php if ($this->session->flashdata('error_message') != ""):?>

  <script type="text/javascript">
    iziToast.error({
      title: 'Error!',
      message: '<?php echo $this->session->flashdata("error_message");?>',
      position: 'topRight'
    });
  </script>

  <?php endif;?>
</body>

</html>
