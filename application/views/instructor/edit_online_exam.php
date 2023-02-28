<?php
    $online_exam = $this->db->get_where('exam', array('exam_id' => $exam_id))->row_array();
    $class_cat_id = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->class_cat_id;
    $subject_name = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->name;
    $subject_id = $this->db->get_where('courses', array('instructor_id' => $this->session->userdata('instructor_id')))->row()->course_id;

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
            <h4>Exam Instruction</h4>
          </div>
          <div class="card-body">

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
