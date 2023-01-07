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
                      <h1>Add Branch</h1>
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
                                 <form id="form" role="form" action="<?= CUSTOM_BASE_URL . 'branch/create' ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Branch name</label>
                                            <input class="form-control" name="branch_name" value="<?php echo set_value('branch_name'); ?>">
                                            <?php echo form_error('branch_name', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                    
              
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" class="selectpicker form-control">
                                                    <option value="" selected> - Select Category - </option>
                                                    <option value="admin" <?php echo set_select('role', 'admin'); ?>>admin</option>
                                                    <option value="blogger" <?php echo set_select('role', 'blogger'); ?>>blogger</option>
                                            </select>
                                                <?php echo form_error('role', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>


                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User ID</label>
                                            <input placeholder="User Id Should be Unique" type="userid" class="form-control" name="userid" value="<?php echo set_value('userid'); ?>">
                                            <?php echo form_error('userid', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                     

                                       <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input id="password" type="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>">
                                            <?php echo form_error('password', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="location" class="form-control" name="location" value="<?php echo set_value('location'); ?>">
                                            <?php echo form_error('location', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>

                                       <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" rows="3" id="description" name="description" ><?php echo set_value('description'); ?></textarea>
                                                 <?php echo form_error('description', '<p class="help-block error-info">', '</p>'); ?>
                                                
                                                    <p class="help-block error-info" id="description_Err"></p>
                                            </div>
                                        </div>
                                     
                                    
                                   
                                    
                                </div>
                                
                                <input type="submit" class="btn btn-success" value="Publish">
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
