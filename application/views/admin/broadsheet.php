
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page_title;?></title>
	<!-- General CSS Files -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css">
<!-- Template CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/izitoast/css/iziToast.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
<!-- Custom style CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
</head>
<body>



  <div style="text-align: center;">
		<img src="<?php echo base_url(); ?>uploads/sys_image/logo.png" width="80" height="80" alt=""><br><br>

      <b><?php echo 'Class';?>: <?php echo $this->db->get_where('classes', array('class_id'=> $class_id))->row()->name;?></b><br>
  </div>
  <div style="margin: 50px 20px 20px 20px;">

      <div style="height: auto;">

          <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            <thead>
              <tr>
                <th>Student Name</th>
                <?php
                $class_cat_id = $this->db->get_where('classes', array('class_id'=> $class_id))->row()->class_cat_id;
                $courses = $this->db->order_by('course_id', 'ASC')->get_where('courses', array('class_cat_id'=> $class_cat_id))->result_array();
                // $courses = $this->db->get_where('courses', array('class_cat_id'=> 1))->result_array();
                foreach($courses as $cour): ?>

                <th><?php echo $cour['name']; ?></th>

                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>


                <?php
                $students = $this->db->get_where('enroll', array('class_id'=> $class_id))->result_array();

                    foreach($students as $row):?>
                    <tr id="">
                      <td>
                          <?php
                        echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;

                        ?>
                      </td>
                     <?php
                     $arrange = $this->db->order_by('course_id', 'ASC')->get_where('exam', array('class_id'=> $class_id))->result_array();

                     foreach($arrange as $ned):
                     $score = $this->db->get_where('online_exam_result', array('student_id'=> $row['student_id'], 'exam_id'=> $ned['exam_id']))->result_array();

                     foreach($score as $re):

                     ?>
                      <td>
                        <?php echo $re['obtained_mark'];  ?>
                    </td>

                      <?php endforeach;?>
                      <?php endforeach;?>
                    </tr>
                  <?php endforeach;?>

            </tbody>
          </table>

      </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		window.print();
	});
</script>
</html>
