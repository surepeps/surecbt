<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Your Subject List</h4>
      </div>
      <div class="card-body">
        <ul class="list-unstyled list-unstyled-border user-list" id="message-list">
          <?php
          date_default_timezone_set('Africa/Lagos');
          $class_cat_id = $this->db->get_where('enroll',array('student_id' => $this->session->userdata('student_id')))->row()->class_cat_id;
          $class_id = $this->db->get_where('enroll',array('student_id' => $this->session->userdata('student_id')))->row()->class_id;

          $courses = $this->db->get_where('courses', array('class_cat_id' => $class_cat_id))->result_array();
          ?>
          <?php foreach ($courses as $row2): ?>
          <li class="media">
            <div class="media-body">
              <div class="mt-0 font-weight-bold"><?php echo $row2['name']; ?></div>
            </div>
          </li>
        <?php endforeach; ?>
        </ul>
        <br>
         <?php

         $show_result_now = $this->db->get_where('settings' , array('type'=>'show_result_now'))->row()->description;
         if ($show_result_now == 'yes') { ?>
           <a href="<?php echo base_url(); ?>student/results" class="btn btn-success">View all my Result</a>
        <?php  }  ?>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-12 col-lg-7">
      <div class="card card-danger">
          <div class="card-header">
            <h4>Available Exams</h4>
          </div>
          <div class="card-body">
            <div class="owl-carousel owl-theme" id="users-carousel">
            	<?php
               $exams = $this->db->get_where('exam', array('class_id' => $class_id, 'state' => 'published', 'status' => 'active'));
               $examreal = $exams->result_array();
               if($exams->num_rows() > 0){
                foreach ($examreal as $row):
                      	$current_time = time();
                      	$exam_start_time = strtotime(date('Y-m-d', $row['exam_date']).' '.$row['time_start']);
                      	$exam_end_time = strtotime(date('Y-m-d', $row['exam_date']).' '.$row['time_end']);
                      	if ($current_time > $exam_end_time)
                      		continue;
              	?>
              <div>
                <div class="user-item">
                  <div class="user-details">
                    <div class="user-name"><?php echo $this->db->get_where('courses', array('course_id' => $row['course_id']))->row()->name;?></div>
                    <div class="text-job text-muted"><?php echo '<b> Date : </b> '.date('M d, Y', $row['exam_date']).'<br><b> Time : </b> '.date('g:i a',strtotime($row['time_start'])).' - '.date('g:i a',strtotime($row['time_end'])); ?></div>
                    <div class="user-cta">
                        <?php if ($this->crud_model->check_availability_for_student($row['exam_id']) != "submitted"): ?>
							<?php if ($current_time >= $exam_start_time && $current_time <= $exam_end_time): ?>
								<a href="<?php echo site_url('student/take_exam/'.$row['exam_code']);?>" class="btn btn-success">
									<i class="fas fa-laptop"></i>&nbsp; Take Exam
								</a>
							<?php else: ?>
								<div class="alert alert-info">
									<?php echo 'You can only take the exam during the scheduled time';?>
								</div>
							<?php endif; ?>

						<?php else: ?>
							<div class="alert alert-success">
								Exam Done
							</div>
						<?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <?php endforeach; ?>
              <?php }else{ ?>
              <p>No Exams Yet For You check back later</p>
              <?php } ?>
            </div>
          </div>
      </div>
  </div>
