<style type="text/css" media="screen">
	.red {
        color: #f44336;
    }
</style>


<div class="alert alert-secondary alert-dismissible show fade">
	<div class="alert-body">
		<div class="alert-title">Instruction</div>
		<button class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
		<p>
			<?php echo 'This Insrtuction Is Only Required For Fill In The Gaps Type Question. When You Will Need To Insert A Gap You Can Simply Enter <b>^</b> symbol To Get A Blank line. You Can Check It On Preview...'; ?>
		</p>
	</div>
</div>

<form id="addFGquestionForm">

	<input type="hidden" name="type" value="<?php echo $question_type;?>">

	<div class="form-group">
	  <label>Mark</label>
	  <input type="number" class="form-control" name="mark" required min="0"/>
	</div>

	<div class="form-group">
	  <label>Question Title</label>
    <textarea onkeyup="changeTheBlankColor()" name="question_title" class="form-control" id="question_title" rows="8" cols="80" required></textarea>
	</div>

	<div class="form-group">
	  <label>Preview</label>
    <div class="" id="preview"></div>
	</div>

	<div class="form-group">
	  <label>Suitable Words</label>
	  <textarea name="suitable_words" class = "form-control" rows="12" cols="100" required placeholder="<?php echo 'This Area Will Contain Suitable Words For The Blanks. please write down the suitable words side by side separated by a comma'; ?>"></textarea>
	</div>

	<div class="form-group">
	  <button type="submit" class="btn btn-info btn-block" id="addFGquestionText"></button>
	</div>
</form>



<script type="text/javascript">
	function changeTheBlankColor() {
        var alpha = ["^"];
        var res = "", cls = "";
        var t = jQuery("#question_title").val();

        for (i=0; i<t.length; i++) {
            for (j=0; j<alpha.length; j++) {
                if (t[i] == alpha[j])
                {
                    cls = "red";
                }
            }
            if (t[i] === "^") {
                res += "<span class='"+cls+"'>"+'__'+"</span>";
            }
            else{
                res += "<span class='"+cls+"'>"+t[i]+"</span>";
            }
            cls="";
        }
        jQuery("#preview").html(res);
    }
</script>


<!-- ADD QUESTIONS JS START -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#addFGquestionText').html('Add Question');
    $('#addFGquestionForm').submit(function(e){
      e.preventDefault();
      $("#addFGquestionText").addClass('btn-progress disabled');
      var url = '<?php echo base_url(); ?>';
      var user = $('#addFGquestionForm').serialize();
      var online_exam_id = '<?php echo $exam_id;?>';
      var addTFquestion = function(){
          $.ajax({
            type: 'POST',
            url: url + 'admin/manage_online_exam_question/' + online_exam_id + '/add/fill_in_the_blanks',
            dataType: 'json',
            data: user,
          success:function(response){
          $("#addFGquestionText").removeClass('btn-progress disabled');
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
                $('#addFGquestionForm')[0].reset();
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
