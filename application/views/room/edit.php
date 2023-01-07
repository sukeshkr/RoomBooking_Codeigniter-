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
                   <?php foreach ($rooms as $row) { ?>
    <form  role="form" name="addform" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>room/update " onsubmit="return valid();"> 

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label>ADD image</label>

                     <a class="btn btn-block btn-default cropModal" data-toggle="modal" data-target="#cropModall"><i class="fa fa-picture-o" aria-hidden="true"></i>+</a>

                     <?php foreach ($image as $key => $rowImg) { ?>

                      <a id="<?= 'rmv_'.$rowImg->id; ?>" class="remove" sectionId="<?= $rowImg->id; ?>" href="#" class="col-xl-2 eliminar1">&times;</a>

                      <img id="<?= 'rmv1_'.$rowImg->id; ?>" height="100" width="80" src="<?= CUSTOM_BASE_URL . 'uploads/room/'.$rowImg->room_image; ?>">

                       <?php } ?>

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
                                     <input class="new-text" type="file" name="upl_files[]" multiple />
                             
                            </div>
                             </div>
                        </div>
                    </div>
                </div>



                    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Room No.</label>
                                                    <input type="text" class="form-control" name="room_no" value="<?php echo $row->room_no; ?>">
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
                                                <p class="help-block error-info" id="salary_Err"></p>

                                            </div>
                                        </div>

                                         
                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Rate</label>
                                                <input type="text"  maxlength="50" id="rate" class="form-control" name="rate" value="<?php echo $row->rate; ?>">
                                                 <?php echo form_error('rate', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                           <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Extra Bed Rate</label>
                                                <input type="text"  maxlength="50" id="extra_bed_rate" class="form-control" name="extra_bed_rate" value="<?php echo $row->extra_bed_rate; ?>">
                                                 <?php echo form_error('extra_bed_rate', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Capacity</label>
                                                <input type="text"  maxlength="50" id="capacity" class="form-control" name="capacity" value="<?php echo $row->capacity; ?>">
                                                 <?php echo form_error('capacity', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text"  maxlength="50" id="location" class="form-control" name="location" value="<?php echo $row->location; ?>">
                                                 <?php echo form_error('location', '<p class="help-block error-info">', '</p>'); ?>
                                                <p class="help-block error-info" id="title_Err"></p>
                                            </div>
                                        </div>

                                     
                 
                            <div class="col-md-8">
                                  <div class="form-group">
                                  <label>Facilities</label>

                                       <div class="page-content">


                                        <select data-width="50%" title="All categories included" name="facility[]" class="selectpicker" multiple data-actions-box="true" data-live-search="true">
                                          <?php foreach ($facility as $facilitys) { ?>
                                          <option value="<?= $facilitys->id;?>"  <?php echo set_select('facility',$facilitys->id, False); ?> ><?= $facilitys->facility ?></option>
                                          <?php } ?>
                                        </select>



                                        <?php foreach ($selected_facility as $selected) { ?>

                                        <div id="<?= 'rmv_'.$selected->selected_id; ?>" class="op-ed12">


                                        <a class="op-cat-13" href=""><?= $selected->facility; ?><a/>

                                        <a class="remove_facility" sectionId="<?= $selected->selected_id; ?>" href="#" class="col-xl-2 eliminar1">&times;</a>

                                        </div>
                                        <?php } ?>

                                        </div>


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

<script>

$('.remove').click(function() {

  var sectionId = $(this).attr('sectionId');

    $.ajax({
            type: 'post',
            url: '<?= CUSTOM_BASE_URL . 'Room/deleteImage' ?>', //Here you will fetch records 
            data: 'rowid=' + sectionId , //Pass $id
            success: function (data) {
            $('#rmv_'+sectionId).hide();
            $('#rmv1_'+sectionId).hide();
            }
        });

}); 

$('.remove_facility').click(function() {

     var sectionId = $(this).attr('sectionId');
     $.ajax({
              type: 'post',
              url: '<?= CUSTOM_BASE_URL . 'Room/deleteFacility' ?>', //Here you will fetch records 
              data: 'rowid=' + sectionId , //Pass $id
              success: function (data) {
              $('#rmv_'+sectionId).hide();
              // $('.fil-dele').html(data);//Show fetched data from database
              }
          });

}); 

$("#cancel").click(function () {//jquery cancel function when cancel button click

  window.location = '<?= CUSTOM_BASE_URL . "room" ?>';

});
    
</script>

</body>

</html>
