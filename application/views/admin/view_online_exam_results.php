<?php
    $online_exam_details = $this->db->get_where('exam', array('exam_id' => $exam_id))->row_array();
    $students_array = $this->db->get_where('enroll', array('class_id' => $online_exam_details['class_id']))->result_array();


    $subject_info = $this->db->get_where('courses', array('course_id' => $online_exam_details['course_id']))->row()->name;

    $total_mark = $this->crud_model->get_total_mark($exam_id);

    $class_id = $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->class_id;

?>

<div class="row">
  <div class="card-body" style="text-align: center;">
    <blockquote class="blockquote">
      <h3 class="mb-0"><?php echo $online_exam_details['title']; ?></h3>
      <p class="mb-0"><?php echo 'CLass: '.$this->db->get_where('classes', array('class_id' => $class_id))->row()->name; ?></p>
      <p class="mb-0"><?php echo 'Subject: '.$subject_info; ?></p>
      <p class="mb-0"><?php echo 'Total Mark: '.$total_mark; ?></p>
      <p class="mb-0"><?php echo 'Minimum Percentage: '.$online_exam_details['minimum_percentage'].'%'; ?></p>
      <?php
          $current_time = time();
          $exam_end_time = strtotime(date('Y-m-d', $online_exam_details['exam_date']).' '.$online_exam_details['time_end']);
          if ($current_time < $exam_end_time):?>
              <h4 class="mb-0" style="color: #ef5350;"> <strong><?php echo 'Exam has not finished yet'; ?></strong></h4>
      <?php endif ?>
    </blockquote>
  </div>





  <div class="col-12 col-md-12 col-lg-12">
    <div class="card card-secondary">
      <div class="card-body">
          <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
              <thead>
                  <tr>
                      <th>Exam Id</th>
                      <th>Student Name</th>
                      <th>Mark Obtained</th>
                      <th>Result</th>
                      <th>Exam Script</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                      foreach ($students_array as $row):
                      ?>
                      <tr>
                          <td>
                            <?php
                              $student_details = $this->db->get_where('student', array('student_id' => $row['student_id']))->row_array();
                                echo $student_details['exam_code'];
                            ?>
                          </td>
                          <td>
                            <?php
                              $student_details = $this->db->get_where('student', array('student_id' => $row['student_id']))->row_array();
                                echo $student_details['name'];
                            ?>
                          </td>
                          <td>
                            <?php
                                    $query = $this->db->get_where('online_exam_result', array('exam_id' => $exam_id, 'student_id' => $row['student_id']));
                                    if ($query->num_rows() > 0){
                                        $query_result = $query->row_array();
                                        echo $query_result['obtained_mark'];
                                    }
                                    else {
                                        echo 'No Mark Yet';
                                    }
                                 ?>
                          </td>
                          <td>
                            <?php
                                $query = $this->db->get_where('online_exam_result', array('exam_id' => $exam_id, 'student_id' => $row['student_id']));
                                if ($query->num_rows() > 0){
                                    $query_result = $query->row_array();
                                    echo $query_result['result'];
                                }
                                else {
                                  echo 'No Score Yet.';
                                }
                             ?>
                          </td>
                          <td>
                            <?php
                                $query = $this->db->get_where('online_exam_result', array('exam_id' => $exam_id, 'student_id' => $row['student_id']));
                                if ($query->num_rows() > 0){ ?>
                                  <a href="<?php echo base_url('admin/show_script/'.$exam_id.'/'.$row['student_id']); ?>" class="btn btn-success">
                                      View Exam Script
                                  </a>
                                <?php  }
                                else {
                                  echo 'No Score Yet.';
                                }
                             ?>
                          </td>
                      </tr>
                  <?php
                  endforeach; ?>
              </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
