
     <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>Check_out/extended_put">


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Extended Date</h4>
        </div>

    <?php foreach ($rooms as $row) { ?> 

        <div class="col-md-6">
            <div class="form-group">
            <label>Old Date</label>
             <div class="multi-field-wrapper multi-add-ca"> 
            <div class="multi-fields">
            <div class="multi-field"> 
            <input readonly type="text" name="old" class="form-control" value="<?= $row->check_out_date; ?>">
             </div>
        </div>
         </div>
        </div>
        </div>

    <div class="col-md-6">
    <div class="form-group">
       <label>New Date</label>
        <input onkeydown="return false" type="date"  maxlength="50" id="check-out-date" class="form-control" name="check_out_date" value="<?php echo set_value('check_out_date'); ?>">
         <?php echo form_error('check_out_date', '<p class="help-block error-info">', '</p>'); ?>
        <p class="help-block error-info" id="title_Err"></p>
    </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden"  name="checkinid" value="<?= $checkinid; ?>">
        <input type="submit"  name="submit" class="btn btn-primary" value="Submit">
      </div>
    </div>
       
    <?php } ?> 

    </form>



<script>

$('.multi-field-wrapper').each(function() {

  var $wrapper = $('.multi-fields', this);
  $(".add-field", $(this)).click(function(e) {

  $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();

  });

  $('.multi-field .remove-field', $wrapper).click(function() {

    if ($('.multi-field', $wrapper).length > 1)

      $(this).parent('.multi-field').remove();
  });

});

</script>

