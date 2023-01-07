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
                      <h1>Edit User</h1>
                      <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Examples</a></li>
                        <li class="active">Blank page</li>
                      </ol>
                    </section>

                      
                    <!-- Main content -->
            <section class="content">
                <!--            <div class="row">-->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <br>
                    </div>
                                 <form id="form" role="form" action="<?= CUSTOM_BASE_URL . 'User/create' ?>" method="post" enctype="multipart/form-data">
                                 <?php foreach ($profile as $row) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" name="username" value="<?= set_value('username', isset($row['username']) ? $row['username'] : '') ?>">
                                            <?php echo form_error('username', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                    
              
                                    <div class="col-md-12">
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


                                      <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="<?= set_value('email', isset($row['email']) ? $row['email'] : '') ?>">
                                            <?php echo form_error('email', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                     

                                       <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input id="password" type="password" class="form-control" name="password" value="<?= set_value('password', isset($row['email']) ? $row['email'] : '') ?>">
                                            <?php echo form_error('password', '<p class="help-block error-info">', '</p>'); ?>
                                        </div>
                                    </div>
                                     
                                     
                                    
                                   
                                    
                                </div>
                                <?php } ?>
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
