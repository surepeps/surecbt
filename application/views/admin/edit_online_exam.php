<?php
    $online_exam = $this->db->get_where('exam', array('exam_id' => $exam_id))->row_array();
    $class_cat_id = $this->db->get_where('courses', array('instructor_id' => $online_exam['instructor_id']))->row()->class_cat_id;
    $subject_name = $this->db->get_where('courses', array('instructor_id' => $online_exam['instructor_id']))->row()->name;
    $subject_id = $this->db->get_where('courses', array('instructor_id' => $online_exam['instructor_id']))->row()->course_id;

    $classes    = $this->db->get_where('classes', array('class_cat_id' => $class_cat_id))->result_array();
?>
<form id="editexamForm">
  <div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h4>Edit Exam</h4>
        </div>
        <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Name</label>
                <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                <input type="text" class="form-control" name="title" value="<?php echo $online_exam['title']; ?>" required>
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
                <select name="class_id" id="class_selector_holder" class="form-control select2" style="width: 100%;" required>
                  <?php foreach ($classes as $class): ?>
                      <option value="<?php echo $class['class_id']; ?>" <?php if($class['class_id'] == $online_exam['class_id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Start Exam</label>
                <select name="state" class="form-control select2" style="width: 100%;" required>
                  <option value="published" <?php if($online_exam['state'] == 'published'){echo "selected";} ?>>Yes</option>
                  <option value="pending" <?php if($online_exam['state'] == 'pending'){echo "selected";} ?>>No</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Minimum Percentage</label>
                <input type="text" class="form-control" placeholder="Enter Minimum percentage for passing in figure only" name="minimum_percentage" value="<?php echo $online_exam['minimum_percentage']; ?>" required>
              </div>
            </div>

          </div>

      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card">
          <div class="card-header">
            <h4>Exam Date & Time</h4>
          </div>
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Date</label>
                <input type="text" class="form-control datepicker" name="exam_date" value="<?php echo date('yy-mm-dd', $online_exam['exam_date']); ?>" required>
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-12">
                <label class="">Exam Time</label>
              </div>
              <div class="col-sm-5">
                <div class="form-group">
                  <input type="text" class="form-control timepicker" name="time_start" id="time_start" data-template="dropdown" data-show-seconds="true" data-default-time="<?php echo $online_exam['time_start'];?>" data-show-meridian="false" data-minute-step="5" data-second-step="5" value=""  required />
                </div>
              </div>
              <div class="col-sm-2" style="text-align: center;">
                <div class="form-group">
                  <h5>
                    <strong>To</strong>
                  </h5>
                </div>
              </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <input type="text" class="form-control timepicker" name="time_end" id="time_end" data-template="dropdown" data-show-seconds="true" data-default-time="<?php echo $online_exam['time_end'];?>" data-show-meridian="false" data-minute-step="5" data-second-step="5" value="" required />
                    </div>
                </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Exam Instruction</label>
                <textarea name="instruction" class="form-control" required rows="8" cols="80"><?php echo $online_exam['instruction']; ?></textarea>
              </div>
            </div>

          </div>
      </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-info" id="editexamText"></button>
        </div>
    </div>
  </div>
</form>
