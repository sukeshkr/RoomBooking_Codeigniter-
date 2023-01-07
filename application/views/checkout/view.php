<?php foreach ($rooms as $row) { ?> 

     <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>Check_out/service_put">


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>

        <tr>
            <td>Room No.</td>
            <td><?php echo $row->room_no; ?></td>
        </tr>

        <tr>

        <td>Additional Services</td>
        
        <td>

    <div class="col-md-4">
          <div class="form-group">
          <label>Additional Services</label>
           <div class="multi-field-wrapper multi-add-ca"> 
          <div class="multi-fields">
          <div class="multi-field"> 

            <select  name="services[]">
              <option value="">Select</option>
            <?php foreach ($service as $services) { ?>
            <option value="<?= $services->id;?>"  <?php echo set_select('services',$services->id, False); ?> ><?= $services->service_name ." :₹".$services->rate  ?></option>
            <?php } ?>
          </select>
            <input type="text" name="qty[]">
        </div>
      </div>
       <button type="button" class="add-field btn btn-success add-cate-ad"><i class="icon wb-plus" aria-hidden="true"></i>Add</button>

       </div>
      </div>
    </div>

     <input type="hidden"  name="check_in_id"  value="<?= $checkinid; ?>">

     <input type="submit"  name="submit" class="btn btn-primary" value="Submit">
       
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

