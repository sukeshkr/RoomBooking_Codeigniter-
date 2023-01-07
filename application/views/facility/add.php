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

          <h1>Facility</h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#"> Facility</a></li>

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

           <form role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>facility/create" onSubmit="return validForm()">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Facility</label>
                                                <input type="text"  maxlength="50" id="facility" class="form-control" name="facility" value="<?php echo set_value('facility'); ?>">
                                                 <?php echo form_error('facility', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
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

<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_career.js'?>"></script>
     

<script>
     
  $('#template').on('click', 'input#removespec', function () {
      $(this).parent().parent().remove();
  });
  $("#cancel").click(function () {//jquery cancel function when cancel button click
    window.location = '<?= CUSTOM_BASE_URL . "facility" ?>';
  });

// check for selected crop region
 
 

</script>

  </body>

</html>

