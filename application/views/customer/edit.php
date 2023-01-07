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

            <li><a href="#"> Career</a></li>

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
                   <?php foreach ($customer as $row) { ?>
    <form  role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>customer/update " onsubmit="return valid();"> 

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Change ID image</label>
                        <a data-id='' data-toggle="modal" data-target="#cropModall" href="#">
                        <img src="<?= CUSTOM_BASE_URL . 'uploads/customer/crop/'.$row->prof_image; ?>" class="img-responsive" id="previews"></a>
                        <div class="help-block sucess" style="color:green;font-weight:bold;"></div>
                        <?php echo form_error('image_file', '<p class="help-block error-info">', '</p>'); ?>
                        <div class="error"></div>
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
                                                    <input type="text" class="form-control" name="name" value="<?php echo $row->name; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>

                                              <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" maxlength="50" class="form-control" id="date" name="address" value="<?php echo $row->address; ?>">
                                                 <?php echo form_error('address', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="salary_Err"></p>

                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control" name="phone" value="<?php echo $row->phone; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Alternate Phone</label>
                                                    <input type="text" class="form-control" name="phone" value="<?php echo $row->phone; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" name="email" value="<?php echo $row->email; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <input type="text" class="form-control" name="location" value="<?php echo $row->location; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input type="text" class="form-control" name="state" value="<?php echo $row->state; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <input type="text" class="form-control" name="country" value="<?php echo $row->country; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ID Proof Type</label>
                                                    <input type="text" class="form-control" name="id_proof_type" value="<?php echo $row->id_proof_type; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ID Proof No.</label>
                                                    <input type="text" class="form-control" name="id_proof_no" value="<?php echo $row->id_proof_no; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Reference</label>
                                                    <input type="text" class="form-control" name="reference" value="<?php echo $row->reference; ?>">
                                                    <p class="help-block error-info" id="title_Err"></p>
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

<script type="text/javascript" src="<?= CUSTOM_BASE_URL .'assets/plugins/crop/script_career.js'?>"></script>

    <script>
 
     $("#cancel").click(function () {//jquery cancel function when cancel button click
        window.location = '<?= CUSTOM_BASE_URL . "customer" ?>';
        });

</script>


     <script>

      $(function () {

        //Initialize Select2 Elements

        $(".select2").select2();



        //Datemask dd/mm/yyyy

        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

        //Datemask2 mm/dd/yyyy

        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

        //Money Euro

        $("[data-mask]").inputmask();

          //Colorpicker

        $(".my-colorpicker1").colorpicker();

        //color picker with addon

        $(".my-colorpicker2").colorpicker();

          

          $('#datepic').datepicker({

            format: "dd - M - yy",

            //startDate: "20-07-2017",

            //endDate: "29-07-2017" 

        });

          


         

      </script>

  </body>

</html>

