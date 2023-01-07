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

          <h1>Rooms</h1>

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

           <form role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>room/create" onSubmit="return validForm()">
                                    <div class="row">

                                       <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Room image</label>
                                             <a class="btn btn-block btn-default cropModal" data-toggle="modal" data-target="#cropModall"><i class="fa fa-picture-o" aria-hidden="true"></i> crop Image</a>
                                             <div id="preview"></div>
                                            <?php echo form_error('upl_files[]', '<p class="help-block error-info">', '</p>'); ?>
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
                                     <input id="file-input" class="new-text" type="file" name="upl_files[]" multiple />
                             
                            </div>
                             </div>
                        </div>
                    </div>
                </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Room No.</label>
                                                <input type="text"  maxlength="50" id="room_no" class="form-control" name="room_no" value="<?php echo set_value('room_no'); ?>">
                                                 <?php echo form_error('room_no', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Room Type</label>
                                              <select class="form-control" name="room_type">
                                                <option value="">Select</option>
                                                <?php foreach ($room_type as $key => $rows) { ?>
                                                 <option value="<?= $rows->id; ?>"><?= $rows->type_name; ?></option>
                                                 <?php } ?>
                                               
                                              </select>
                                                 <?php echo form_error('room_type', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="location_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Rate</label>
                                                <input type="text"  maxlength="50" id="rate" class="form-control" name="rate" value="<?php echo set_value('rate'); ?>">
                                                 <?php echo form_error('rate', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                           <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Extra Bed Rate</label>
                                                <input type="text"  maxlength="50" id="extra_bed_rate" class="form-control" name="extra_bed_rate" value="<?php echo set_value('extra_bed_rate'); ?>">
                                                 <?php echo form_error('extra_bed_rate', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Capacity</label>
                                                <input type="text"  maxlength="50" id="capacity" class="form-control" name="capacity" value="<?php echo set_value('capacity'); ?>">
                                                 <?php echo form_error('capacity', '<p class="help-block error-info">', '</p>'); ?>
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

                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <label>Facilities</label>

                                          <select data-width="50%" title="All categories included" name="facility[]" class="selectpicker" multiple data-actions-box="true" data-live-search="true">
                                          <?php foreach ($facility as $facilitys) { ?>
                                          <option value="<?= $facilitys->id;?>"  <?php echo set_select('facility',$facilitys->id, False); ?> ><?= $facilitys->facility ?></option>
                                          <?php } ?>
                                        </select>
                                        <?php echo form_error('facility[]', '<p class="help-block error-info">', '</p>'); ?>
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

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

     
<script type="text/javascript">
         $(document).ready(function() {
            $('.selectpicker').selectpicker({ 
              size: 6 
            });
        });

</script>
<script>

  $("#cancel").click(function () {//jquery cancel function when cancel button click
    window.location = '<?= CUSTOM_BASE_URL . "room" ?>';
  });

</script>

  </body>

</html>

<script type="text/javascript">
 function previewImages() {

  var $preview = $('#preview').empty();
  if (this.files) $.each(this.files, readAndPreview);

  function readAndPreview(i, file) {
    
    if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
      return alert(file.name +" is not an image");
    } // else...
    
    var reader = new FileReader();

    $(reader).on("load", function() {
      $preview.append($("<img/>", {src:this.result, height:100}));
    });

    reader.readAsDataURL(file);
    
  }

}

$('#file-input').on("change", previewImages);
</script>