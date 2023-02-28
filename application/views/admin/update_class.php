<?php
    $class_details = $this->db->get_where('classes', array('class_id' => $param2))->row_array();
?>

<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card-header">
      <h4>Edit Class</h4>
    </div>
    <div class="card-body">
      <form id="editclassForm">

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Class Category</label>
            <select name="class_cat_id"  class="form-control select2" style="width: 100%;" required>
              <option value="">Select</option>
              <?php
                  $class_cat = $this->db->get('class_cat')->result_array();
                  foreach($class_cat as $row2):
              ?>
              <option value="<?php echo $row2['class_cat_id'];?>" <?php if($row2['class_cat_id'] == $class_details['class_cat_id']) echo 'selected'; ?>><?php echo $row2['name'];?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Class Name</label>
          <input type="text" class="form-control" name="name" required value="<?php echo $class_details['name']; ?>"/>
        </div>


          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block" id="editclassText"></button>
          </div>

      </form>
    </div>
  </div>
</div>


<!-- EDIT CLASS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#editclassText').html('Update Class');
    $('#editclassForm').submit(function(e){
      e.preventDefault();
      $("#editclassText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#editclassForm').serialize();
      var class_id = '<?php echo $param2;?>';
      var editclass = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/manage_class/update/' + class_id,
            dataType: 'json',
            data: user,
          success:function(response){
          $("#editclassText").removeClass('btn-progress disabled');
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
        setTimeout(editclass, 2000);
      });

    });
</script>
<!-- EDIT CLASS JS END -->
