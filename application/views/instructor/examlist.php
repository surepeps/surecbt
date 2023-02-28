<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
          <h4>List of Exams Created By You</h4>
      </div>
      <div class="card-body">
        <ul class="nav nav-pills" id="myTab3" role="tablist">
          <li class="nav-item">
            <a href="<?php echo site_url('instructor/exam_view');?>" class="nav-link <?php echo $status == 'active' ? 'active' : 'white'; ?>">
                <?php echo 'Active Exams';?>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('instructor/exam_view/expired');?>" class="nav-link <?php echo $status == 'expired' ? 'active' : 'white'; ?>">
                <?php echo 'Expired Exams';?>
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent2">
          <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Exam Code</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Class</th>
                    <th scope="col">Subject</th>
                    <th scope="col">No. Of Questions</th>
                    <th scope="col">Exam Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($online_exams as $row):?>
                  <tr id="<?php echo $row['exam_id']; ?>">
                    <td><?php echo $row['exam_code'];?></td>
                    <td>
                      <a href="<?php echo site_url('instructor/exam_question/').$row['exam_id']; ?>">
                          <?php echo $row['title'];?>
                      </a>
                    </td>
                    <td>
                      <?php
                          echo $this->db->get_where('classes', array('class_id' => $row['class_id']))->row()->name;
                      ?>
                    </td>
                    <td>
                      <?php
                          echo $this->db->get_where('courses', array('course_id' => $row['course_id']))->row()->name;
                       ?>
                    </td>
                    <td>
                        <?php 
                            echo $this->db->where('exam_id', $row['exam_id'])->get('question_bank')->num_rows(); 
                        ?>
                    </td>
                    <td>
                      <?php
                          echo '<b> Date :</b> '.date('M d, Y', $row['exam_date']).'<br>'.'<b> Time :</b> '.$row['time_start'].' - '.$row['time_end'];
                      ?>
                    </td>
                    <td>
                      <span class="badge badge-<?php echo $row['state'] == 'published' ? 'success' : 'warning'; ?> ">
                          <?php echo ucfirst($row['state']);?>
                      </span>
                    </td>
                    <td>
                      <div class="dropdown d-inline">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item has-icon" href="<?php echo site_url('instructor/exam_question/').$row['exam_id']; ?>"><i class="fas fa-file-alt"></i> Manage Question</a>
                          <a class="dropdown-item has-icon" href="<?php echo site_url('instructor/update_exam/').$row['exam_id']; ?>"><i class="fas fa-edit"></i> Edit Exam</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item has-icon" href="<?php echo site_url('instructor/view_exam_result/'.$row['exam_id']); ?>"><i class="fas fa-eye"></i>View Result</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
