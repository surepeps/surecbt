<form id="addadminForm">
  <div class="row">
    <div class="col-12 col-md-5 col-lg-5">
      <div class="card">
        <div class="card-header">
          <h4>Admin Creation Form</h4>
        </div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputState">Full Name</label>
              <input type="text" class="form-control" name="name" value="" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputState">Email Address</label>
              <input type="email" class="form-control" name="email" value="" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputState">Password</label>
              <input type="password" class="form-control" name="password" value="" required>
            </div>
          </div>

          </div>

      </div>
    </div>
    <div class="col-12 col-md-7 col-lg-7">
      <div class="card">
          <div class="card-header">
            <h4>Admin List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($adminlist as $row):?>
                  <tr id="<?php echo $row['admin_id']; ?>">
                    <td><?php echo $row['name'];?></td>
                    <td>
                      <?php echo $row['email'];?>
                    </td>
                    <td>
                      <div class="dropdown d-inline">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" onclick="getAjaxModal('<?php echo site_url('modal/popup/update_admin/'.$row['admin_id']);?>')" class="dropdown-item has-icon" data-toggle="tooltip" title="<?php echo 'Edit'; ?>"><i class="fas fa-edit"></i> Edit Admin</a>
                          <?php if ($row['admin_id'] != 1) { ?>
                            <div class="dropdown-divider"></div>
                            <a class="deleteAdmin dropdown-item has-icon" href="#"><i class="fas fa-trash"></i> Delete</a>
                        <?php   } ?>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>

          </div>
      </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12" style="text-align: center;">
            <button type="submit" class="btn btn-info" id="addadminText"></button>
        </div>
    </div>
  </div>
</form>
