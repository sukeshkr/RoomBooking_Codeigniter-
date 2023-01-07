<!DOCTYPE html>

<html>

  <head>

    <?php include('assets/include/header.php'); ?>

  </head>

  <body class="hold-transition skin-blue sidebar-mini">

    <!-- Site wrapper -->

    <div class="wrapper">



     

 <?php include('assets/include/navigation.php'); ?>

      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>Room Check In</h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#"> Check In</a></li>

            <li class="active"> add</li>

          </ol>

        </section>



          

        <!-- Main content -->

<section class="content">

    <!--            <div class="row">-->

    <div class="box box-primary">

        <div class="box-header with-border">

            <br>

        </div>

        <!-- /.box-header -->

           <form role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>check_in/create" onSubmit="return validForm()">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer name</label>
                                                <select class="form-control" name="customer_id">
                                                <option value="">Select</option>
                                                <?php foreach ($customer as $key => $rows) { ?>
                                                 <option value="<?= $rows->id; ?>" <?php echo set_select('customer_id',$rows->id, False); ?>><?= $rows->name; ?></option>
                                               <?php } ?>
                                               
                                                </select>
                                                 <?php echo form_error('customer_id', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Booking From</label>
                                                <select class="form-control" name="booking_type_id">
                                                <option value="">Select</option>
                                                <?php foreach ($booking as $key => $books) { ?>
                                                 <option value="<?= $books->id; ?>" <?php echo set_select('booking_type_id',$books->id, False); ?>><?= $books->booking_type_name; ?></option>
                                               <?php } ?>
                                               
                                                </select>
                                                 <?php echo form_error('booking_type_id', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Booking ID</label>
                                                <input type="text"  maxlength="50" id="booking_id" class="form-control" name="booking_id" value="<?php echo set_value('booking_id'); ?>">
                                                 <?php echo form_error('booking_id', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Check In Date</label>
                                                <input onkeydown="return false" type="date"  maxlength="50" id="check-in-date" class="form-control" name="check_in_date" value="<?php echo set_value('check_in_date'); ?>">
                                                 <?php echo form_error('check_in_date', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Check Out Date</label>
                                                <input onkeydown="return false" type="date"  maxlength="50" id="check-out-date" class="form-control" name="check_out_date" value="<?php echo set_value('check_out_date'); ?>">
                                                 <?php echo form_error('check_out_date', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>


                                         <div class="col-md-3">
                                            <div class="form-group">
                                              <button onClick="showSub(this);" type="button" class="btn btn-primary">Check Availablity</button>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                             <div style="color:orange;" id="err-msg"></div>
                                              <div style="color:red;" id="err-date"></div>
                                               <?php echo form_error('available_id[]', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>



                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Available Rooms(Multiple)</label>

                                        <div class="form-group" id="output1"></div> 

                                      </div>
                                    </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input readonly id="list_price" type="text"  maxlength="50" class="form-control" name="total_amount" value="<?php echo set_value('total_amount'); ?>">
                                                 <?php echo form_error('total_amount', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Discount Amount</label>
                                                <input id="discAmt" type="text"  maxlength="50" class="form-control" name="discount_amount" value="<?php echo set_value('discount_amount'); ?>">
                                                 <?php echo form_error('discount_amount', '<p class="help-block error-info">', '</p>'); ?>
                                                 <div style="color:red;" id="err-dis"></div>
                                            </div>
                                        </div>

                                           <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Balance Amount</label>
                                                <input readonly id="balAmt" type="text"  class="form-control">
                                            </div>
                                        </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Advance Amount</label>
                                                <input type="text"  maxlength="50" id="advanced_amount" class="form-control" name="advanced_amount" value="<?php echo set_value('advanced_amount'); ?>">
                                                 <?php echo form_error('advanced_amount', '<p class="help-block error-info">', '</p>'); ?>
                                                <p style="color:red;" class="help-block error-info" id="title_Err"><?php if(isset($exceed)) { echo $exceed; } ?></p>
                                            </div>
                                        </div>


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
                                          <input class="ss" type="text" name="qty[]">
                                      </div>
                                    </div>
                                     <button type="button" class="add-field btn btn-success add-cate-ad"><i class="icon wb-plus" aria-hidden="true"></i>Add</button>

                                     </div>
                                    </div>
                                  </div>

                                    
                                    </div>
                                    <div id="specname_Err" class="help-block error-info"></div>
                                    <input type="submit"  name="submit" class="btn btn-primary" value="Save">
                                    <input type="button" id="cancel" class="btn btn-warning" value="Cancel">
                                </form>


        <!-- /.box-body -->

    </div>

    <!-- /.box -->



    <!-- /.row -->

</section>

<!-- /.content -->

      </div><!-- /.content-wrapper -->

       <div class="modal fade" id="Category-view" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content model_gallery">
                                            <div class="modal-body">
                                               
                                        <!----modal calling div-->
                                        <div class="view"></div>
                                        <!----end modal calling div-->
                                    </div>
                                </div>
                            </div>
                            </div>

      <footer class="main-footer">


      </footer>



      <!-- Control Sidebar -->

     

      <!-- Add the sidebar's background. This div must be placed

           immediately after the control sidebar -->

      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->



    <!-- jQuery 2.1.4 -->

     <?php include('assets/include/footer.php'); ?>

      <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/multiselect.css">   
<script src='<?php echo base_url();?>assets/dist/js/multiselect.min.js'></script>

<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_career.js'?>"></script>
     

<script>
     
  $('#template').on('click', 'input#removespec', function () {
      $(this).parent().parent().remove();
  });
  $("#cancel").click(function () {//jquery cancel function when cancel button click
    window.location = '<?= CUSTOM_BASE_URL . "check_in" ?>';
  });

// check for selected crop region
 
 

</script>

  </body>

</html>


<script type="text/javascript">

function showSub(sel) {

  var check_in = $('#check-in-date').val();  

  var check_out = $('#check-out-date').val(); 

  if(check_in > check_out){

    document.getElementById("err-date").innerHTML = 'Check in date is Grater than checkout date';

    $("#err-msg").hide();

    return false;

  }

  $("#output1").html( "" );

  if (check_in.length && check_out.length  > 0 ) { 
 
   $.ajax({
      type: "POST",
      url: "<?= CUSTOM_BASE_URL . 'Check_in/getAvailableRoom' ?>",
      data: 'check_in=' + check_in + '&check_out=' + check_out,
      cache: false,
      beforeSend: function () { 
        $('#output1').html('<img src="loader.gif" alt="" width="24" height="24">');
      },
      success: function(html) {   

        $("#output1").html( html );
      }
    });
  } 
  else{
    document.getElementById("err-msg").innerHTML = 'Please enter both checkin checkout date';
  }
}

</script>

<script type="text/javascript">

function getval(sel) {

  var opts = [],
  opt;
  var len = sel.options.length;

  for (var i = 0; i < len; i++) {

    opt = sel.options[i];

    if (opt.selected) {

      opts.push(opt.value);
    }
  }

    $.ajax({
        
      type: 'post',
      url: '<?= CUSTOM_BASE_URL . 'Check_in/getPriceList' ?>', //Here you will fetch records 
      data: 'rowid=' + opts , //Pass $id
      success: function (data) {
          $('#list_price').val(data);
      }
    });
}
</script>

<script language="javascript">

  $(document).ready(function () {
    var dt= new Date();
    var yyyy = dt.getFullYear().toString();
    var mm = (dt.getMonth()+1).toString(); // getMonth() is zero-based
    var dd  = dt.getDate().toString();
    var min = yyyy +'-'+ (mm[1]?mm:"0"+mm[0]) +'-'+ (dd[1]?dd:"0"+dd[0]); // padding
    $('#check-in-date').prop('min',min);
    $('#check-out-date').prop('min',min);
  });

</script>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script> 

  $(document).ready(function() {

  $("#discAmt").keyup(function(event) {

    var total = $('#list_price').val();

    var discount = $(this).val();

    if(discount > total)
    {
      document.getElementById("err-dis").innerHTML = 'Discount Amount is Graterthan total Amount';

      return false;
    }
    else{

      document.getElementById("err-dis").innerHTML = '';

    }

    var balance = total - discount;

    $("#balAmt").val(balance)
 
  });
 
});
</script>