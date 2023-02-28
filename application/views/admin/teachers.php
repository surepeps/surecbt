<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>List of all Teachers</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
            <thead>
              <tr>
                <th>Instructor Id</th>
                <th>Name</th>
                <th>Course</th>
                <th>Number</th>
                <th>Email Address</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($teachers as $row):?>
                <tr id="<?php echo $row['instructor_id']; ?>">
                  <td>
                    <?php
                      echo $row['instructor_id'];
                    ?>
                </td>
                  <td>
                    <?php
                      echo $row['name'];
                    ?>
                  </td>
                  <td>
                    <?php

                      echo $this->db->get_where('courses', array('instructor_id' => $row['instructor_id']))->row()->name;
                    ?>
                  </td>
                  <td>
                    <?php
                      echo $row['phone'];
                    ?>
                  </td>
                  <td>
                    <?php
                      echo $row['email'];
                    ?>
                  </td>
                  <td>
                    <div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu">
                          <a href="#" onclick="getAjaxModal('<?php echo site_url('modal/popup/update_teacher_account/'.$row['instructor_id']);?>')" class="dropdown-item has-icon" data-toggle="tooltip" title="<?php echo 'Edit'; ?>"><i class="fas fa-edit"></i> Edit Teacher</a>
                        <div class="dropdown-divider"></div>
                        <a class="deleteTeacher dropdown-item has-icon" href="#"><i class="fas fa-trash"></i> Delete</a>
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
