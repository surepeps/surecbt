<?php
  $student_reg = $this->db->get_where('settings' , array('type'=>'student_reg'))->row()->description;
  $instructor_reg = $this->db->get_where('settings' , array('type'=>'instructor_reg'))->row()->description;
  $show_result_now = $this->db->get_where('settings' , array('type'=>'show_result_now'))->row()->description;
 ?>
  <div class="row">
    <div class="col-12 col-md-5 col-lg-5">
      <div class="card">
        <div class="card-header">
          <h4>System Details</h4>
        </div>
        <form id="updatesystemsettingsForm" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <label for="inputState">System Logo</label>
            <div class="image-upload">
                <div class="image-edit">
                    <input type='file' id="imageUpload" name="userfile" accept="image/*" />
                    <label for="imageUpload"></label>
                </div>
                <div class="image-preview">
                    <div id="imagePreview" style="background-image: url('<?php echo base_url();?>uploads/sys_image/logo.png');">
                    </div>
                </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputState">System Name</label>
              <input type="text" class="form-control" name="system_name" value="<?php echo $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputState">System Abbreviation Name</label>
              <input type="text" class="form-control" name="system_abbrv" value="<?php echo $this->db->get_where('settings' , array('type'=>'system_abbrv'))->row()->description; ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputState">System Footer</label>
              <input type="text" class="form-control" name="system_footer" value="<?php echo $this->db->get_where('settings' , array('type'=>'system_footer'))->row()->description; ?>" required>
            </div>
          </div>

        </div>
          <div class="card-footer">
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center;">
                    <button type="submit" class="btn btn-info" id="updatesystemsettingsText"></button>
                </div>
            </div>
          </div>
        </form>

      </div>
    </div>



    <div class="col-12 col-md-7 col-lg-7">
      <div class="card">
          <div class="card-header">
            <h4>Page Settings</h4>
          </div>
        <form id="updatepageSettingForm">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Stop Student Registration?</label>
                <select name="student_reg"  class="form-control select2" style="width: 100%;" required>
                  <option value="active" <?php if($student_reg == 'active') echo 'selected'; ?>>Yes</option>
                  <option value="inactive" <?php if($student_reg == 'inactive') echo 'selected'; ?>>No</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Note on Student Registration Page</label>
                <textarea class="form-control" name="student_reg_note" rows="8" cols="80"><?php echo $this->db->get_where('settings' , array('type'=>'student_reg_note'))->row()->description; ?></textarea>
              </div>
            </div>

            <hr>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Stop Instructor Registration?</label>
                <select name="instructor_reg"  class="form-control select2" style="width: 100%;" required>
                  <option value="active" <?php if($instructor_reg == 'active') echo 'selected'; ?>>Yes</option>
                  <option value="inactive" <?php if($instructor_reg == 'inactive') echo 'selected'; ?>>No</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Note on Instructor Registration Page</label>
                <textarea class="form-control" name="instructor_reg_note" rows="8" cols="80"><?php echo $this->db->get_where('settings' , array('type'=>'instructor_reg_note'))->row()->description; ?></textarea>
              </div>
            </div>

            <hr>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Allow Students to access their results?</label>
                <select name="show_result_now"  class="form-control select2" style="width: 100%;" required>
                  <option value="yes" <?php if($show_result_now == 'yes') echo 'selected'; ?>>Yes</option>
                  <option value="no" <?php if($show_result_now == 'no') echo 'selected'; ?>>No</option>
                </select>
              </div>
            </div>

          </div>
          <div class="card-footer">
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center;">
                    <button type="submit" class="btn btn-info" id="updatepageSettingText"></button>
                </div>
            </div>
          </div>
        </form>
      </div>

    </div>


  </div>
