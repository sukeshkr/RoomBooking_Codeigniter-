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

            <li class="active"> edit</li>

          </ol>

        </section>

      
        <!-- Main content -->

<section class="content">

    <!--<div class="row">-->

    <div class="box box-primary">

        <div class="box-header with-border">

            <br>

        </div>

        <!-- /.box-header -->
                   <?php foreach ($room_type as $row) { ?>
    <form  role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>Room_type/update " onsubmit="return valid();"> 

                                    <div class="row">
           
                  

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Room Type</label>
                                                    <input type="text" class="form-control" name="type_name" value="<?php echo $row->type_name; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>

                                          <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" rows="3" name="description"><?php echo $row->description; ?></textarea>
                                                    <p class="help-block error-info" id="description_Err"></p>

                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                            <div class="col-md-12">
                                             <div class="box-footer">
                <input value="update" class="btn btn-primary" name="submit" type="submit">
                <input type="button" id="cancel" class="btn btn-warning" value="Cancel">
              </div>
            </div>
                                        <?php } ?>
                                           

                                        <!-- /.panel -->
                                    </div>
                                </form>

        <!-- /.box-body -->

    </div>

    <!-- /.box -->



    <!-- /.row -->

</section>

<!-- /.content -->

      </div><!-- /.content-wrapper -->



      <footer class="main-footer">



      </footer>
           
                     <!-- del modal pop up-->
                    <div id="Spec-del" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Confirmation</h4>
                                </div>
                                <div class="modal-footer">
                                    <div class="spec-del">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
    
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


      <!-- Control Sidebar -->


      <!-- Add the sidebar's background. This div must be placed

           immediately after the control sidebar -->

      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->


    <!-- jQuery 2.1.4 -->

     <?php include('assets/include/footer.php'); ?>


  </body>

</html>

