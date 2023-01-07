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

          <h1>Customer</h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#"> room</a></li>

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

           <form role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>customer/create" onSubmit="return checkForm()">
                                    <div class="row">

                                       <div class="col-md-6">

                                        <div class="form-group">
                                            <label>ID Proof image</label>
                                             <a class="btn btn-block btn-default cropModal" data-toggle="modal" data-target="#cropModall"><i class="fa fa-picture-o" aria-hidden="true"></i> crop Image</a>
                                            <?php echo form_error('image_file', '<p class="help-block error-info">', '</p>'); ?>
                                            <div class="error"></div>
                                            <div class="sucess" style="color:green;font-weight:bold;"></div>
                                            <p id="error_img" class="help-block error-info"></p>
                                       <img height="100" width="100" id="previews" alt="" class="img-responsive">

                                        </div>
                                       </div>

                                         <div class="modal fade" id="cropModall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Image Croping</h4>
                            
                             </div>
                        <div class="modal-body">
                                    <div class="form-group">
                                        <label>image</label>
                                        <input type="hidden" id="x1" name="x1" />
                                        <input type="hidden" id="y1" name="y1" />
                                        <input type="hidden" id="x2" name="x2" />
                                        <input type="hidden" id="y2" name="y2" />
                                        <input type="hidden" id="admin_url" name="admin_url" value=" <?= CUSTOM_BASE_URL.'assets/images/loading.gif';?> " />
                                        <div  class="form-group">
                                        <input accept="image/x-png,image/jpeg" type="file"  name="image_file" id="image_file" onChange="fileSelectHandler()"  class="form-control"/>
                                        </div>
                                                <div id="loading"></div>
                                                <div class="error"></div>
                                                <img id="preview" />  
                                        <div class="step2">
                                        <h5>Please select a crop region</h5>

                                        <div class="info">
                                         <!-- <h4><a class="btn btn-primary" data-dismiss="modal">Add Image</a></h4>   -->
                                        <input type="hidden" id="filesize" name="filesize" />
                                        <input type="hidden" id="filetype" name="filetype" />
                                        <input type="hidden" id="filedim" name="filedim" />
                                        <input type="hidden" id="w" name="w" />
                                        <input type="hidden" id="h" name="h" />
                                        <input type="hidden" id="admin_url" value="<?= CUSTOM_BASE_URL.'assets/images/loading.gif';?>">
                                    </div>
                                    <a class="btn btn-primary" data-dismiss="modal">Add Image</a>
                                </div>
                            </div>
                             </div>
                        </div>
                    </div>
                </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text"  maxlength="50" id="name" class="form-control" name="name" value="<?php echo set_value('name'); ?>">
                                                 <?php echo form_error('name', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>


                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text"  maxlength="100" id="address" class="form-control" name="address" value="<?php echo set_value('address'); ?>">
                                                 <?php echo form_error('address', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text"  maxlength="50" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone'); ?>">
                                                 <?php echo form_error('phone', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="location_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Alternate Phone</label>
                                                <input type="text"  maxlength="50" id="alternate_phone" class="form-control" name="alternate_phone" value="<?php echo set_value('alternate_phone'); ?>">
                                                 <?php echo form_error('alternate_phone', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                           <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text"  maxlength="50" id="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>">
                                                 <?php echo form_error('email', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text"  maxlength="50" id="location" class="form-control" name="location" value="<?php echo set_value('location'); ?>">
                                                 <?php echo form_error('location', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text"  maxlength="50" id="state" class="form-control" name="state" value="<?php echo set_value('state'); ?>">
                                                 <?php echo form_error('state', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                      

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text"  maxlength="50" id="country" class="form-control" name="country" value="<?php echo set_value('country'); ?>">
                                                 <?php echo form_error('country', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>


                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ID Proof Type</label>
                                                <input type="text"  maxlength="50" id="id_proof_type" class="form-control" name="id_proof_type" value="<?php echo set_value('id_proof_type'); ?>">
                                                 <?php echo form_error('id_proof_type', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>


                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ID Proof No</label>
                                                <input type="text"  maxlength="50" id="id_proof_no" class="form-control" name="id_proof_no" value="<?php echo set_value('id_proof_no'); ?>">
                                                 <?php echo form_error('id_proof_no', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>


                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Reference</label>
                                                <input type="text"  maxlength="50" id="reference" class="form-control" name="reference" value="<?php echo set_value('reference'); ?>">
                                                 <?php echo form_error('reference', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
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

<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_gallery.js'?>"></script>
     
<script type="text/javascript">
         $(document).ready(function() {
            $('.selectpicker').selectpicker({ 
              size: 6 
            });
        });

</script>
<script>
  
  $("#cancel").click(function () {//jquery cancel function when cancel button click
    window.location = '<?= CUSTOM_BASE_URL . "customer" ?>';
  });


</script>

  </body>

</html>

