<form id="addccourseForm">
  <div class="row">
    <div class="col-12 col-md-5 col-lg-5">
      <div class="card">
        <div class="card-header">
          <h4>Courses Creation Form</h4>
        </div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Course Category</label>
              <select name="class_cat_id"  class="form-control select2" style="width: 100%;" required>
                <option value="">Select</option>
                <?php
                    $class_cat = $this->db->get('class_cat')->result_array();
                    foreach($class_cat as $row2):
                ?>
                <option value="<?php echo $row2['class_cat_id'];?>"><?php echo $row2['name'];?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Select Instructor (Optional)</label>
              <select name="instructor_id"  class="form-control select2" style="width: 100%;">
                <option value="">Select</option>
                <?php
                    $instructors = $this->db->get('instructor')->result_array();
                    foreach($instructors as $row3):
                ?>
                <option value="<?php echo $row3['instructor_id'];?>"><?php echo $row3['name'];?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Course Name</label>
                <input type="text" class="form-control" name="name" value="" required>
              </div>
            </div>

          </div>

      </div>
    </div>
    <div class="col-12 col-md-7 col-lg-7">
      <div class="card">
          <div class="card-header">
            <h4>Course List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Course Name</th>
                    <th scope="col">Course Category</th>
                    <th scope="col">Instructor</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($courseslist as $row):?>
                  <tr id="<?php echo $row['course_id']; ?>">
                    <td><?php echo $row['name'];?></td>
                    <td>
                      <?php
                          echo $this->db->get_where('class_cat', array('class_cat_id' => $row['class_cat_id']))->row()->name;
                      ?>
                    </td>
                    <td>
                      <?php
                          echo $this->db->get_where('instructor', array('instructor_id' => $row['instructor_id']))->row()->name;
                      ?>
                    </td>
                    <td>
                      <div class="dropdown d-inline">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" onclick="getAjaxModal('<?php echo site_url('modal/popup/update_course/'.$row['course_id']);?>')" class="dropdown-item has-icon" data-toggle="tooltip" title="<?php echo 'Edit'; ?>"><i class="fas fa-edit"></i> Edit Course</a>
                          <div class="dropdown-divider"></div>
                          <a class="deleteCourse dropdown-item has-icon" href="#"><i class="fas fa-trash"></i> Delete</a>
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

    <div class="form-group">
        <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-info" id="addcourseText"></button>
        </div>
    </div>
  </div>
</form>
