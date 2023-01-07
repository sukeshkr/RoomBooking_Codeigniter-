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
                      <h1>Booking Type Report</h1>
                      <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Examples</a></li>
                      </ol>
                    </section>

                      
                    <!-- Main content -->
            <section class="content">
                <!--            <div class="row">-->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <br>
                    </div>
                                 <form id="form" role="form" action="<?= CUSTOM_BASE_URL . 'reports/booking_type' ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                   
                                     <div class="col-md-6">
                                            <div class="form-group">
                                                <label>From</label>
                                                <input onkeydown="return false" type="date"  maxlength="50" id="check-in-date" class="form-control" name="from" value="<?php echo set_value('from'); ?>">
                                                 <?php echo form_error('from', '<p class="help-block error-info">', '</p>'); ?>
                                            </div>
                                        </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label>To</label>
                                                <input onkeydown="return false" type="date"  maxlength="50" id="check-out-date" class="form-control" name="to" value="<?php echo set_value('to'); ?>">
                                                 <?php echo form_error('to', '<p class="help-block error-info">', '</p>'); ?>
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

                                    
                                </div>
                                
                                <input type="submit" name="submit" class="btn btn-success" value="Post">
                                <input type="button" id="cancel" class="btn btn-warning" value="Cancel">
                                    
                                </form>
                          </div>
    <!-- /.box -->

    <!-- /.row -->
</section>
<!-- /.content -->
      </div><!-- /.content-wrapper -->
        
       
        

      <footer class="main-footer">

      </footer>

      <!-- Control Sidebar -->
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->




    <!-- jQuery 2.1.4 -->
     <?php include('assets/include/footer.php'); ?>
<script>
        $("#datepicker").datepicker({
            dateFormat: "M dd,yy"
        });

        //jquery cancel function when cancel button click
        $("#cancel").click(function () {
            window.location = '<?= CUSTOM_BASE_URL . "user" ?>';
        });



$(document).ready(function(){
   $('#password').bind("cut copy paste",function(e) {
      e.preventDefault();
   });
});



</script>
</body>

</html>
