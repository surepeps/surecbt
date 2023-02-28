<form id="addTFquestionForm">

  <input type="hidden" name="type" value="<?php echo $question_type;?>">

  <div class="form-group">
    <label>Mark</label>
    <input type="number" class="form-control" name="mark" required min="0"/>
  </div>

  <div class="form-group">
    <label>Question Title</label>
    <textarea onkeyup="changeTheBlankColor()" name="question_title" class="form-control" id="question_title" rows="8" cols="80" required></textarea>
  </div>

  <div class="row"  style="margin-top: 10px; text-align: left;">
      <div class="col-md-12 col-sm-offset-3">
          <p>
              <input type="radio" id="true" name="true_false_answer" value="true" checked>
              <label for="true"><?php echo 'True'; ?></label>
          </p>
      </div>
      <div class="col-md-12 col-sm-offset-3">
          <p>
              <input type="radio" id="false" name="true_false_answer" value="false">
              <label for="false"><?php echo 'False'; ?></label>
          </p>
      </div>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-info btn-block" id="addTFquestionText"></button>
  </div>

</form>



<!-- ADD QUESTIONS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#addTFquestionText').html('Add Question');
    $('#addTFquestionForm').submit(function(e){
      e.preventDefault();
      $("#addTFquestionText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#addTFquestionForm').serialize();
      var online_exam_id = '<?php echo $exam_id;?>';
      var addTFquestion = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/manage_online_exam_question/' + online_exam_id + '/add/true_false',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#addTFquestionText").removeClass('btn-progress disabled');
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
                $('#addTFquestionForm')[0].reset();
                setTimeout(function(){
                  location.reload();
                }, 4000);
              }
            }
          });
        };
        setTimeout(addTFquestion, 2000);
      });

    });
</script>
<!-- ADD QUESTIONS JS END -->
