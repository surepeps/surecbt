<form id="addexamForm">
  <div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Exam Creation Form</h4>
        </div>
        <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Name</label>
                <input type="text" class="form-control" name="title" value="" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Instructor / Teacher</label>
                <select name="instructor_id"  class="form-control select2" style="width: 100%;" required>
                  <option value="">Select</option>
                  <?php
                      $teachers = $this->db->get('instructor')->result_array();
                      foreach($teachers as $row):
                  ?>
                  <option value="<?php echo $row['instructor_id'];?>"><?php echo $row['name'];?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Subject Name</label>
                <select name="course_id"  class="form-control select2" style="width: 100%;" required>
                  <option value="">Select</option>
                  <?php
                      $subjects = $this->db->get('courses')->result_array();
                      foreach($subjects as $row):
                  ?>
                  <option value="<?php echo $row['course_id'];?>"><?php echo $row['name'];?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Class</label>
                <select name="class_id"  class="form-control select2" style="width: 100%;" required>
                  <option value="">Select</option>
                  <?php
                      $classes = $this->db->get('classes')->result_array();
                      foreach($classes as $row):
                  ?>
                  <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Minimum Percentage</label>
                <input type="text" class="form-control" placeholder="Enter Minimum percentage for passing in figure only" name="minimum_percentage" value="" required>
              </div>
            </div>

          </div>

      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
          <div class="card-header">
            <h4>Exam Instruction</h4>
          </div>
          <div class="card-body">

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Instruction</label>
                <textarea name="instruction" class="form-control" required rows="8" cols="80"></textarea>
              </div>
            </div>

          </div>
      </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-info" id="addexamText"></button>
        </div>
    </div>
  </div>
</form>
