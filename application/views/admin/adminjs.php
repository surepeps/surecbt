<!-- ADD ADMIN JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#addadminText').html('Add Admin');
    $('#addadminForm').submit(function(e){
      e.preventDefault();
      $("#addadminText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#addadminForm').serialize();
      var addadmin = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/manage_admin/create/',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#addadminText").removeClass('btn-progress disabled');
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
                $('#addadminForm')[0].reset();
                setTimeout(function(){
                  location.reload();
                }, 3000);
              }
            }
          });
        };
        setTimeout(addadmin, 2000);
      });

    });
</script>
<!-- ADD ADMIN JS END -->



<!-- DELETE ADMIN START -->
<script type="text/javascript">
$(".deleteAdmin").click(function () {
  var id = $(this).parents("tr").attr("id");

  swal({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover this imaginary file!',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  })
    .then((willDelete) => {
      if (willDelete) {
        var url = '<?php echo base_url()?>';
        $.ajax({
           url: url + 'admin/manage_admin/delete/'+id,
           type: 'post',
           error: function() {
              alert('Something is wrong');
           },
           success: function(data) {
                $("#"+id).remove();
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
           }
        });
        swal('Poof! Your imaginary file has been deleted!', {
          icon: 'success',
        });
      } else {
        swal('Your imaginary file is safe!');
      }
    });
});
</script>
<!-- DELETE ADMIN END -->




<!-- UPDATE SYSTEM SETTINGS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#updatesystemsettingsText').html('Update System Settings');
    $('#updatesystemsettingsForm').submit(function(e){
      e.preventDefault();
  $("#updatesystemsettingsText").addClass('btn-progress disabled');

    var url = '<?php echo base_url()?>';
    var formData = new FormData(this);
    var systemsettings = function(){
    $.ajax({
    type: 'POST',
    url: url + 'admin/system_settings/do_update/',
    dataType: 'json',
    cache:false,
    contentType: false,
    processData: false,
    data:formData,
      success:function(response){
        $("#updatesystemsettingsText").removeClass('btn-progress disabled');
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
  setTimeout(systemsettings, 2000);
  });

});

</script>
<!-- UPDATE SYSTEM SETTINGS JS END -->



<!-- SYSTEM PAGE SETTINGS UPDATE JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#updatepageSettingText').html('Update Page Settings');
    $('#updatepageSettingForm').submit(function(e){
      e.preventDefault();
      $("#updatepageSettingText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#updatepageSettingForm').serialize();
      var updatepagesetting = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/system_settings/page_settings/',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#updatepageSettingText").removeClass('btn-progress disabled');
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
        setTimeout(updatepagesetting, 2000);
      });

    });
</script>
<!-- SYSTEM PAGE SETTINGS UPDATE JS END -->



<!-- DELETE TEACHER START -->
<script type="text/javascript">
$(".deleteTeacher").click(function () {
  var id = $(this).parents("tr").attr("id");

  swal({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to recover this imaginary file!',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  })
    .then((willDelete) => {
      if (willDelete) {
        var url = '<?php echo base_url()?>';
        $.ajax({
           url: url + 'admin/deleteTeacher/'+id,
           type: 'post',
           error: function() {
              alert('Something is wrong');
           },
           success: function(data) {
                $("#"+id).remove();
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
           }
        });
        swal('Poof! Your imaginary file has been deleted!', {
          icon: 'success',
        });
      } else {
        swal('Your imaginary file is safe!');
      }
    });
});
</script>
<!-- DELETE TEACHER END -->
