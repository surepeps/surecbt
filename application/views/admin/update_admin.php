<?php
    $admin_details = $this->db->get_where('admin', array('admin_id' => $param2))->row_array();
?>

<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card-header">
      <h4>Edit Admin Details</h4>
    </div>
    <div class="card-body">
      <form id="editadminForm">

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputState">Full Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $admin_details['name']; ?>" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputState">Email Address</label>
            <input type="email" class="form-control" name="email" value="<?php echo $admin_details['email']; ?>" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputState">Password</label>
            <input type="password" class="form-control" name="password">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Status</label>
            <select name="status"  class="form-control select2" style="width: 100%;" required>
              <option value="active" <?php if($admin_details['status'] == 'active') echo 'selected'; ?>>Active</option>
              <option value="inactive" <?php if($admin_details['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
            </select>
          </div>
        </div>


          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block" id="editadminText"></button>
          </div>

      </form>
    </div>
  </div>
</div>


<!-- EDIT ADMIN JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#editadminText').html('Update Admin');
    $('#editadminForm').submit(function(e){
      e.preventDefault();
      $("#editadminText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#editadminForm').serialize();
      var admin_id = '<?php echo $param2;?>';
      var editadmin = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/manage_admin/update/' + admin_id,
            dataType: 'json',
            data: user,
          success:function(response){
          $("#editadminText").removeClass('btn-progress disabled');
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
        setTimeout(editadmin, 2000);
      });

    });
</script>
<!-- EDIT ADMIN JS END -->
