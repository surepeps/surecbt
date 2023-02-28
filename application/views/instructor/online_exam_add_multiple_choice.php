<form id="addquestionForm">
  <input type="hidden" name="type" value="<?php echo $question_type;?>">

  <div class="form-group">
    <label>Mark</label>
    <input type="number" class="form-control" name="mark" required min="0"/>
  </div>

  <div class="form-group">
    <label>Question</label>
    <textarea onkeyup="changeTheBlankColor()" name="question_title" class="form-control" id="question_title" rows="8" cols="80" required></textarea>
  </div>

  <div class="form-group" id='multiple_choice_question'>
    <label>Number Of Options</label>
    <div class="input-group">
      <input type="number" class="form-control" name="number_of_options" id="number_of_options" required min="0"/>
      <div class="input-group-append">
        <button type="button" name="button" onclick="showOptions(jQuery('#number_of_options').val())" class="input-group-text">
          <i class="fa fa-check"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-info btn-block" id="addquestionText"></button>
  </div>

</form>


<!-- ADD QUESTIONS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#addquestionText').html('Add Question');
    $('#addquestionForm').submit(function(e){
      e.preventDefault();
      $("#addquestionText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#addquestionForm').serialize();
      var online_exam_id = '<?php echo $exam_id;?>';
      var addquestion = function(){
          $.ajax({
            type: 'POST',
            url: url + 'instructor/manage_online_exam_question/' + online_exam_id + '/add/multiple_choice',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#addquestionText").removeClass('btn-progress disabled');
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
                $('#addquestionForm')[0].reset();
                setTimeout(function(){
                  location.reload();
                }, 4000);
              }
            }
          });
        };
        setTimeout(addquestion, 2000);
      });

    });
</script>
<!-- ADD QUESTIONS JS END -->


<script type="text/javascript">
	function showOptions(number_of_options){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('instructor/manage_multiple_choices_options'); ?>",
            data: {number_of_options : number_of_options},
            success: function(response){
                console.log(response);
                jQuery('.options').remove();
                jQuery('#multiple_choice_question').after(response);
            }
        });
    }
</script>
