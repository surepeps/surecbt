<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?> | Instructor Register Page</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/izitoast/css/iziToast.min.css">

<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>uploads/sys_image/logo.png">
</head>
<?php $instructor_reg = $this->db->get_where('settings' , array('type'=>'instructor_reg'))->row()->description; ?>
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
                <h4 style="text-align: center;"><?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?> Instructor Registration Page</h4>
              </div>
              <div class="card-body">


                <?php
                if ($instructor_reg == 'inactive') { ?>
                  <?php if ($this->session->flashdata('error_message') != ""):?>
                    <div class="alert alert-danger alert-has-icon">
                      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">Error!</div>
                        <?php echo $this->session->flashdata("error_message");?>
                      </div>
                    </div>
                  <?php endif;?>
                  <form id="" action="<?php echo base_url('instructor/register_validate'); ?>" method="post" class="needs-validation">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-user-alt"></i>
                          </div>
                        </div>
                        <input id="email" type="text" class="form-control" name="name" autofocus placeholder="Enter Your Full Name" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-inbox"></i>
                          </div>
                        </div>
                        <input id="email" type="email" class="form-control" name="email" autofocus placeholder="Enter Parent Email Address" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-key"></i>
                          </div>
                        </div>
                        <input id="email" type="password" class="form-control" name="password" autofocus placeholder="Enter Password" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input id="email" type="text" class="form-control" name="phone" autofocus placeholder="Enter Phone Number" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-venus-mars"></i>
                          </div>
                        </div>
                        <select  class="form-control select2" name="sex" required>
                          <option value="">SELECT GENDER</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-chalkboard"></i>
                          </div>
                        </div>
                        <select  class="form-control select2" name="course_id" required>
                          <option value="">SELECT YOUR SUBJECT</option>
                          <?php foreach ($courses as $row): ?>
                            <option value="<?php echo $row['course_id']; ?>"><?php echo $row['name']; ?></option>
                          <?php  endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <p style="color: red; font-size: 20px;">Note: Email Address and password used during Registration will be used to login... </p>
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-lg btn-round btn-primary">
                        Register
                      </button>
                      <p>If already Registered Click <a href="<?php echo base_url('instructor'); ?>"><b>Here to Login</b></a></p>
                    </div>
                  </form>
                </div>
                <?php }else{ ?>
                  <p><?php echo $this->db->get_where('settings' , array('type'=>'instructor_reg_note'))->row()->description; ?></p>
                <?php } ?>

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

</body>

</html>
