<?php
    $course_details = $this->db->get_where('courses', array('course_id' => $param2))->row_array();
?>

<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card-header">
      <h4>Edit Course</h4>
    </div>
    <div class="card-body">
      <form id="editcourseForm">

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Course Category</label>
            <select name="class_cat_id"  class="form-control select2" style="width: 100%;" required>
              <option value="">Select</option>
              <?php
                  $class_cat = $this->db->get('class_cat')->result_array();
                  foreach($class_cat as $row2):
              ?>
              <option value="<?php echo $row2['class_cat_id'];?>" <?php if($row2['class_cat_id'] == $course_details['class_cat_id']) echo 'selected'; ?>><?php echo $row2['name'];?></option>
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
              <option value="<?php echo $row3['instructor_id'];?>" <?php if($row3['instructor_id'] == $course_details['instructor_id']) echo 'selected'; ?>><?php echo $row3['name'];?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Course Name</label>
          <input type="text" class="form-control" name="name" required value="<?php echo $course_details['name']; ?>"/>
        </div>


          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block" id="editcourseText"></button>
          </div>

      </form>
    </div>
  </div>
</div>


<!-- EDIT COURSE JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#editcourseText').html('Update Course');
    $('#editcourseForm').submit(function(e){
      e.preventDefault();
      $("#editcourseText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#editcourseForm').serialize();
      var course_id = '<?php echo $param2;?>';
      var editcourse = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/manage_course/update/' + course_id,
            dataType: 'json',
            data: user,
          success:function(response){
          $("#editcourseText").removeClass('btn-progress disabled');
              if(response.error){
                iziToast.error({
                  title: 'Error!',
                  message: response.message,
                  position: 'topRight'
                });
              }
              else{
                iziToast.success({
                  title: 'Success!',
                  message: response.message,
                  position: 'topRight'
                });
                setTimeout(function(){
                  location.reload();
                }, 3000);
              }
            }
          });
        };
        setTimeout(editcourse, 2000);
      });

    });
</script>
<!-- EDIT COURSE JS END -->
