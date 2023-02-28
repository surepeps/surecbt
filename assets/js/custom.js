/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

 function readURL(input) {
   if (input.files && input.files[0]) {
     var reader = new FileReader();
     reader.onload = function(e) {
         $('#imagePreview').css('background-image', 'url('+e.target.result +')');
         $('#imagePreview').hide();
         $('#imagePreview').fadeIn(650);
     }
     reader.readAsDataURL(input.files[0]);
   }
 }
 $("#imageUpload").change(function() {
   readURL(this);
 });
