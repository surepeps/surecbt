<!-- ADD EXAM JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#addexamText').html('Add Exam');
    $('#addexamForm').submit(function(e){
      e.preventDefault();
      $("#addexamText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#addexamForm').serialize();
      var addexam = function(){
          $.ajax({
            type: 'POST',
            url: url + 'instructor/manage_exam/create/',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#addexamText").removeClass('btn-progress disabled');
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
                $('#addexamForm')[0].reset();
                setTimeout(function(){
                  location.reload();
                }, 4000);
              }
            }
          });
        };
        setTimeout(addexam, 2000);
      });

    });
</script>
<!-- ADD EXAM JS END -->

<!-- UPDATE EXAM JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#editexamText').html('Update Exam');
    $('#editexamForm').submit(function(e){
      e.preventDefault();
      $("#editexamText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#editexamForm').serialize();
      var editexam = function(){
          $.ajax({
            type: 'POST',
            url: url + 'instructor/manage_exam/edit/',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#editexamText").removeClass('btn-progress disabled');
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
        setTimeout(editexam, 2000);
      });

    });
</script>
<!-- UPDATE EXAM JS END -->

<!-- Exam status-->
<script type="text/javascript">
function confirm_modal(exam_id,status) {
    if (exam_id !== '' || status !== '') {
    $.ajax({
        url: '<?php echo site_url('instructor/manage_online_exam_status/');?>' + exam_id + '/' + status,
        success: function (response)
        {
          iziToast.success({
            title: 'Success!',
            message: 'Successfully updated',
            position: 'topRight'
          });
        }
    });
  }else {
    iziToast.error({
      title: 'Error!',
      message: 'error could not update',
      position: 'topRight'
    });
  }
}
</script>


<!-- Hide print buttons -->
<script type="text/javascript">

    $(document).ready(function() {
        $('#print_options').hide();
        $('#questions_print').on('click', function() {
            $('#print_options').fadeIn();
        });
        $('#question_type').on('change', function() {
          var exam_id = '<?php echo $exam_id;?>';
            var question_type = $(this).val();
            if (question_type == '' || exam_id == '') {
              iziToast.error({
                title: 'Error!',
                message: 'Please select a question type',
                position: 'topRight'
              });
                return;
            }
            $.ajax({
                url: '<?php echo site_url('instructor/load_question_type/');?>' + question_type + '/' + exam_id
            }).done(function(response) {
                $('#question_holder').html(response);
            });
        });
    });

</script>



<!-- DELETE QUESTIONS START-->
<script type="text/javascript">
$(".deleteQuestion").click(function () {
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
           url: url + 'instructor/delete_question_from_online_exam/'+id,
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
<!-- DELETE QUESTIONS END -->
