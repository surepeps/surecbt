<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
    <div class="card card-secondary">
      <div class="card-header">
        <h4>Exam Report</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table  class="table table-bordered">
            <tbody>
                <tr>
                    <td><b>Full Name</b></td>
                    <td><?php echo $student_name; ?></td>
                    <td><b>Exam ID</b></td>
                    <td><?php echo $exam_id; ?></td>
                </tr>
                <tr>
                    <td><b>Exam Expected</b></td>
                    <td>
                        <?php 
                        $class_cat_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->class_cat_id;
                        echo $this->db->get_where('courses', array('class_cat_id' => $class_cat_id))->num_rows();
                        ?>
                    </td>
                    <td><b>Exam Taken</b></td>
                    <td>
                      <?php
                        $query = $this->db->get_where('online_exam_result', array('student_id' => $student_id))->num_rows();
                        echo $query;
                      
                      ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Total Marks</b></td>
                    <td>
                        <?php
                            $this->db->select_sum('total_marK');
                            $this->db->WHERE('student_id', $student_id);
                            $this->db->FROM('online_exam_result');
                            $query = $this->db->get()->row();
                            
                            echo $query->total_marK;
                        ?>
                    </td>
                    <td><b>Total Marks Obtained</b></td>
                    <td>
                        <?php
                            $this->db->select_sum('obtained_mark');
                            $this->db->WHERE('student_id', $student_id);
                            $this->db->FROM('online_exam_result');
                            $query2 = $this->db->get()->row();
                            
                            echo $query2->obtained_mark;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Your Percentage Score</b></td>
                    <td>
                        <?php
                        $totalmark = $query->total_marK;
                        $obtainedmark = $query2->obtained_mark;
                        $percent = $obtainedmark / $totalmark * 100;
                        echo round($percent,1).'%';
                        ?>
                    </td>
                    <td><b>Grade</b></td>
                    <td>
                       <?php
                        if($percent >= 70){
                            echo 'A';
                        }elseif($percent <= 69 && $percent >= 60){
                            echo 'B';
                        }elseif($percent <= 59 && $percent >= 50){
                            echo 'C';
                        }elseif($percent <= 49 && $percent >= 45){
                            echo 'D';
                        }elseif($percent <= 44 && $percent >= 40){
                            echo 'E';
                        }else{
                            echo 'F';
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table_export">
      			<thead>
                      <tr>
                          <th>Subject</th>
                          <th>Total Marks</th>
                          <th>Obtained Marks</th>
                          <th>Result</th>
                          <th>Script</th>
                      </tr>
                  </thead>
                  <tbody>
                  	<?php
                    $class_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->class_id;
                    $match = array('class_id' => $class_id, 'state' => 'published');
                    $this->db->order_by("exam_date", "dsc");
                    $exams = $this->db->where($match)->get('exam')->result_array();
                          foreach ($exams as $row):

                          $online_exam_details = $this->db->get_where('exam', array('exam_id' => $row['exam_id']))->row_array();
                          $current_time = time();
                          $exam_end_time = strtotime(date('yy-mm-dd', $online_exam_details['exam_date']).' '.$online_exam_details['time_end']);
                          ?>
                          <tr>
                          	<td> <?php echo $this->db->get_where('courses', array('course_id' => $online_exam_details['course_id']))->row()->name;?> </td>
                          	<td>
                              <?php
                    						if ($current_time > $exam_end_time){
                    								$query = $this->db->get_where('online_exam_result', array('student_id' => $this->session->userdata('login_user_id'), 'exam_id' => $row['exam_id']));
                    								if ($query->num_rows() > 0) {
                    									$query_result = $query->row_array();
                    									$obtained_marks = $query_result['obtained_mark'];
                    								}
                    								else {
                    									$obtained_marks = 'No Result Found';
                    								}

                    								echo $obtained_marks;
                    							 }
      							          ?>
                            </td>
      						          <td>
                              <?php
                  							 if ($current_time > $exam_end_time){
                  								$query = $this->db->get_where('online_exam_result', array('student_id' => $this->session->userdata('login_user_id'), 'exam_id' => $row['exam_id']));
                  								if ($query->num_rows() > 0) {
                  									$query_result = $query->row_array();
                  									$result = ucfirst($query_result['result']);
                  								}
                  								else {
                  									$result = 'No Result Found';
                  								}

                  								echo $result;
                  							 }
      							          ?>
                              </td>
                          	<td>
                                <?php
                                $query = $this->db->get_where('online_exam_result', array('exam_id' => $row['exam_id'], 'student_id' => $this->session->userdata('login_user_id')));
                                if ($query->num_rows() > 0){ ?>
                                  <a href="<?php echo base_url('student/show_script/'.$row['exam_id'].'/'.$student_id); ?>" class="btn btn-success">
                                      View Exam Script
                                  </a>
                                <?php  }
                                else {
                                  echo 'No Score Yet.';
                                }
                             ?>
                            </td>
                          </tr>
                  <?php endforeach; ?>
                  </tbody>
      		</table
        </div>
      </div>
    </div>
	</div>
</div>
