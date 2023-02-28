<form action="<?php echo base_url(); ?>admin/add_student" method="POST">
  <div class="row">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Add Student Form</h4>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('flash_message') != ""):?>
              <div class="alert alert-success alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Success</div>
                  <?php echo $this->session->flashdata("flash_message");?>.
                </div>
              </div>
            <?php endif;?>
            <?php if ($this->session->flashdata('error_message') != ""):?>
              <div class="alert alert-danger alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">Error</div>
                  <?php echo $this->session->flashdata("error_message");?>.
                </div>
              </div>
            <?php endif;?>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Full Name</label>
                <input type="text" class="form-control" name="name" value="" required>
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
                <label for="inputState">Phone</label>
                <input type="text" class="form-control" name="phone" value="" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Gender</label>
                <select name="sex"  class="form-control select2" style="width: 100%;" required>
                  <option value="">Select</option>
                  <option value="make">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
            </div>
            

          </div>

      </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-info">Add Student</button>
        </div>
    </div>
  </div>
</form>
