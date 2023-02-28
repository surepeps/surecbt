<?php for($i = 1; $i <= $number_of_options; $i++): ?>
    <div class="form-group options">
      <label><?php echo 'Option'.$i; ?></label>
      <div class="input-group">
        <input type="text" class="form-control" name = "options[]" id="option_<?php echo $i; ?>" placeholder="<?php echo 'Option '.$i; ?>" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <input class="input-group-text" type='checkbox' name="correct_answers[]" value=<?php echo $i; ?>>
          </div>
        </div>
      </div>
    </div>
<?php endfor; ?>
