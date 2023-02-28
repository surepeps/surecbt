<?php
$account_type       =	$this->session->userdata('login_type');
$account_type_id	=	$this->session->userdata('login_user_id');
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description; ?> | <?php echo $page_title; ?></title>
  <?php include $account_type. '/style.php'; ?>
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>uploads/sys_image/logo.png">
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include $account_type.'/nav.php'; ?>
      <?php include $account_type.'/sidenav.php'; ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
              <h4 class="page-title m-b-0"><?php echo ucfirst($page_title); ?></h4>
            </li>
          </ul>
          <div class="section-body">
            <!-- add content here -->
            <?php include $account_type. '/' .$page_name.'.php';?>
          </div>
        </section>

      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <?php echo $this->db->get_where('settings' , array('type'=>'system_footer'))->row()->description; ?>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>


<?php include $account_type.'/script.php'; ?>
<script type="text/javascript">
  $(document).ready(function($) {
        $('.table').DataTable();
  });
</script>
<?php if (isset($page_jsname)) {   include $account_type. '/'. $page_jsname. '.php'; } ?>

<?php include $account_type. '/modal.php';?>

  <!-- SHOW TOASTR NOTIFIVATION -->
  <?php if ($this->session->flashdata('flash_message') != ""):?>

  <script type="text/javascript">
  iziToast.success({
    title: 'Success!',
    message: '<?php echo $this->session->flashdata("flash_message");?>',
    position: 'topRight'
  });
  </script>

  <?php endif;?>
</body>

</html>
