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
                <label>Subject Name</label>
                <input type="hidden" class="form-control" placeholder="" name="course_id" value="<?php echo $subject_id; ?>" required>
                <input type="text" class="form-control" placeholder="" value="<?php echo $subject_name; ?>" readonly required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Class</label>
                <select name="class_id"  class="form-control select2" style="width: 100%;" required>
                  <option value="">Select</option>
                  <?php
                      $classes = $this->db->get_where('classes', array('class_cat_id' => $class_cat_id))->result_array();
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
