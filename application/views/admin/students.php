<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>List of all Students</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            <thead>
              <tr>
                <th>Exam Id</th>
                <th>Name</th>
                <th>Class</th>
                <th>Parent Number</th>
                <th>Results</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($students as $row):?>
                <tr id="<?php echo $row['student_id']; ?>">
                  <td>
                    <?php
                      echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->exam_code;
                    ?>
                </td>
                  <td>
                    <?php
                      echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                    ?>
                  </td>
                  <td>
                    <?php

                      echo $this->db->get_where('classes', array('class_id' => $row['class_id']))->row()->name;
                    ?>
                  </td>
                  <td>
                    <?php
                      echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->phone;
                    ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url('admin/results/'.$row['student_id']); ?>" class="btn btn-primary">View All Result</a>
                  </td>
                  <td>
                    <a class="deleteStudent dropdown-item has-icon" href="#"><i class="fas fa-trash"></i> Delete</a>
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
