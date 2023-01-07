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

          <h1>DayBook</h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#"> DayBook</a></li>

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

           <form role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>daybook/create" onSubmit="return validForm()">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input onkeydown="return false" type="date"  maxlength="50" id="check-in-date" class="form-control" name="date" value="<?php echo set_value('date'); ?>">
                                                 <?php echo form_error('date', '<p class="help-block error-info">', '</p>'); ?>
                                            </div>
                                        </div>

                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input placeholder="₹" type="text"  maxlength="50"  class="form-control" name="total_amt" value="<?php echo set_value('total_amt'); ?>">
                                                 <?php echo form_error('total_amt', '<p class="help-block error-info">', '</p>'); ?>
                                            </div>
                                        </div>

                                          <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Payment Amount</label>
                                                <input placeholder="₹" type="text"  maxlength="50" id="booking_id" class="form-control" name="payment_amt" value="<?php echo set_value('payment_amt'); ?>">
                                                 <?php echo form_error('payment_amt', '<p class="help-block error-info">', '</p>'); ?>
                                                 <p style="color:red;" class="help-block error-info" id="title_Err"><?php if(isset($amt_err)) { echo $amt_err; } ?></p>
                                            </div>
                                        </div>

                                          <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Balance Amount</label>
                                                <input readonly placeholder="₹" type="text"  maxlength="50"  class="form-control" value="">
                                            </div>
                                        </div>

                                       <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Particular</label>
                                                <textarea class="form-control" rows="3" id="particular" name="particular" ><?php echo set_value('particular'); ?></textarea>
                                                 <?php echo form_error('particular', '<p class="help-block error-info">', '</p>'); ?>
                                                
                                                    <p class="help-block error-info" id="description_Err"></p>
                                            </div>
                                        </div>
                                    
                                    </div>

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
    window.location = '<?= CUSTOM_BASE_URL . "daybook" ?>';
  });

// check for selected crop region
 
 

</script>

  </body>

</html>


<script type="text/javascript">

function showSub(sel) {

  var check_in = $('#check-in-date').val();  

   var check_out = $('#check-out-date').val(); 

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

