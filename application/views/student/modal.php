<script type="text/javascript">
function getAjaxModal(url)
{
// SHOWING AJAX PRELOADER IMAGE
$('.bd-example-modal-lg .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url();?>assets/img/loading.gif" /></div>');
// LOADING THE AJAX MODAL
$('.bd-example-modal-lg').modal('show', {backdrop: 'true'});

// SHOW AJAX RESPONSE ON REQUEST SUCCESS
$.ajax({
  url: url,
  success: function(response)
  {
    $('.bd-example-modal-lg .modal-body').html(response);
  }
});
}
</script>


<!-- Ajax Large Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
