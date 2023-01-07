<!DOCTYPE html>

<html>

  <head>

    <?php include('../include/header.php'); ?>

  </head>

  <body class="hold-transition skin-blue sidebar-mini">

    <!-- Site wrapper -->

    <div class="wrapper">



     

 <?php include('../include/navigation.php'); ?>

      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>Add products</h1>

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

        <!-- /.box-header -->

        <form role="form">

            <!-- text input -->

            <div class="col-md-3">

                <div class="form-group">

                    <label>Project Name</label>

                    <input type="text" class="form-control">

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">

                    <label>Select Multiple images</label>

                     <a class="btn btn-block bg-olive btn-default cropModal" data-toggle="modal" data-target="#cropModal"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Select Image</a>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">

                    <label>Category </label><br>

                    <select id="select2" name="category" class="form-control export_option"><option value="">-- Select Type --</option></select>

                    <div id="categoryErr"></div>

                </div>

            </div>



            <div class="col-md-3">

                <div class="form-group">

                    <label>Thumbnail image</label>

                     <a class="btn btn-block btn-default cropModal" data-toggle="modal" data-target="#cropModall"><i class="fa fa-picture-o" aria-hidden="true"></i> crop Image</a>

                </div>

            </div>

            

            

            <div class="col-md-12">

                

            </div>





            <div class="col-md-12">

                <div class="form-group">

                    <label>Discription</label>

                    <textarea class="form-control" rows="3" placeholder=""></textarea>

                </div>

            </div>

            <div class="box-footer">

                <input value="Submit" class="btn btn-primary" type="submit">

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

                                        <img id="preview">

                                        <div id="gif"></div>

                                    

                                        <div class="step2">

                                        <h5>Please select a crop region</h5>



                                        <div class="info">

                                         <!-- <h4><a class="btn btn-primary" data-dismiss="modal">Add Image</a></h4>   -->

                                        <input type="hidden" id="filesize" name="filesize" />

                                        <input type="hidden" id="filetype" name="filetype" />

                                        <input type="hidden" id="filedim" name="filedim" />

                                        <input type="hidden" id="w" name="w" />

                                        <input type="hidden" id="h" name="h" />

                                    </div>

                                </div>

                            </div>

                             

                                 <div class="form-group">

                                     <label>Colour</label>

                                     <input class="form-control" type="text" name="colour" value="<?php echo set_value('colour') ?>">

                                     <p class="help-block error-info" id="colourErr">

                                 </div>

                            <!--<input value="Submit" class="btn btn-primary" type="submit">--></div>

                        </div>

                    </div>

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

<!--

        <div class="pull-right hidden-xs">

          <b>Version</b> 2.3.0

        </div>

        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">SoftLink</a>.</strong> All rights reserved.

-->

      </footer>



      <!-- Control Sidebar -->

     

      <!-- Add the sidebar's background. This div must be placed

           immediately after the control sidebar -->

      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->



    <!-- jQuery 2.1.4 -->

     <?php include('../include/footer.php'); ?>

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

        var currentDate = new Date();  

        $('#cropModall').on('shown.bs.modal', function () {

            $(this).find('.modal-dialog').css({

                width:'auto',

                height:'auto', 

                'max-height':'100%'

            });

        });

      });

         

      </script>

  </body>

</html>

