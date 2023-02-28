<?php
    $account_details = $this->db->get_where('instructor', array('instructor_id' => $param2))->row_array();
?>

<div class="row">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card-header">
      <h4>Edit Teacher Account</h4>
    </div>
    <div class="card-body">
      <form id="editaccountForm">

        <div class="form-group">
          <label>Name</label>
          <input type="text" class="form-control" name="name" required value="<?php echo $account_details['name']; ?>"/>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email" required value="<?php echo $account_details['email']; ?>" />
        </div>
        
        <div class="form-group">
          <label>Phone</label>
          <input type="text" class="form-control" name="phone" required value="<?php echo $account_details['phone']; ?>" />
        </div>
        
        <div class="form-group">
          <label>Password</label>
          <input type="text" class="form-control" name="password"/>
        </div>


          <div class="form-group">
            <button type="submit" class="btn btn-info btn-block" id="editaccountText"></button>
          </div>

      </form>
    </div>
  </div>
</div>


<!-- EDIT QUESTIONS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#editaccountText').html('Update Account');
    $('#editaccountForm').submit(function(e){
      e.preventDefault();
      $("#editaccountText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#editaccountForm').serialize();
      var instructor_id = '<?php echo $param2;?>';
      var editaccount = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/update_teacher_account/' + instructor_id,
            dataType: 'json',
            data: user,
          success:function(response){
          $("#editaccountText").removeClass('btn-progress disabled');
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
                }, 4000);
              }
            }
          });
        };
        setTimeout(editaccount, 2000);
      });

    });
</script>
<!-- EDIT QUESTIONS JS END -->
