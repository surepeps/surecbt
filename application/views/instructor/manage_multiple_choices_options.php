<?php 
$alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

for($i = 1; $i <= $number_of_options; $i++): ?>

    <div class="form-group options">
      <label><?php echo 'Option '.$alpha[$i-1]; ?></label>
      <div class="input-group">
        <input type="text" class="form-control" name = "options[]" id="option_<?php echo $i; ?>" placeholder="<?php echo 'Option '.$alpha[$i-1]; ?>" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <input class="input-group-text" type='checkbox' name="correct_answers[]" value=<?php echo $i; ?>>
          </div>
        </div>
      </div>
    </div>
<?php endfor; ?>
