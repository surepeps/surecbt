<div class="row">
  <div class="col-lg-3 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Students</h6>
          <h4 class="text-right"><i class="fas fa-graduation-cap pull-left bg-indigo c-icon"></i>
            <span><?php echo $this->db->count_all('student');?></span>
          </h4>
          <p class="mb-0 mt-3 text-muted">
            <span class="text-success font-weight-bold">Total</span> Students
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Teachers</h6>
          <h4 class="text-right"><i class="fas fa-chalkboard-teacher pull-left bg-cyan c-icon"></i>
            <span><?php echo $this->db->count_all('instructor');?></span>
          </h4>
          <p class="mb-0 mt-3 text-muted">
            <span class="text-success font-weight-bold">Total</span> Teachers
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Exams</h6>
          <h4 class="text-right"><i
              class="fas fa-hand-holding-heart pull-left bg-deep-orange c-icon"></i>
              <span><?php echo $this->db->count_all('exam');?></span>
          </h4>
          <p class="mb-0 mt-3 text-muted">
            <span class="text-success font-weight-bold">Total</span> Exams Created
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6">
    <div class="card">
      <div class="card-statistic-4">
        <div class="info-box7-block">
          <h6 class="m-b-20 text-right">Questions</h6>
          <h4 class="text-right"><i
              class="far fa-calendar-plus pull-left bg-green c-icon"></i>
              <span><?php echo $this->db->count_all('question_bank');?></span>
          </h4>
          <p class="mb-0 mt-3 text-muted">
            <span class="text-success font-weight-bold">Total</span> Questions Created
          </p>
        </div>
      </div>
    </div>
  </div>
  
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
    <div class="card card-danger">
      <div class="card-header">
        <h4><i class="fas fa-plus"></i> Broadsheet</h4>
      </div>
      <div class="card-body">
          <p>
              <?php 
              $classes = $this->db->get('classes')->result_array();
              foreach($classes as $class): ?>
                  <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/broadsheet/<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></a>
              <?php endforeach ;?>
          </p>
        
        <br/>
        <div id="question_holder"></div>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-md-6 col-lg-6">
    <div class="card card-danger">
      <div class="card-header">
        <h4><i class="fas fa-plus"></i> Score & Grade</h4>
      </div>
      <div class="card-body">
          <p>
              <?php 
              $classes = $this->db->get('classes')->result_array();
              foreach($classes as $class): ?>
                  <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/grades/<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></a>
              <?php endforeach ;?>
          </p>
        
        <br/>
        <div id="question_holder"></div>
      </div>
    </div>
  </div>
</div>
