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

          <h1>Room Check In</h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#"> Check in</a></li>

            <li class="active"> view</li>

          </ol>

        </section>



        <!-- Main content -->

          <section class="content">

            <div class="box">

                <div class="box-header">
                  <a class="btn bg-olive" href="<?php echo base_url() ?>check_in/create"><span class="glyphicon glyphicon-plus-sign"></span> Check IN</a>

                </div><!-- /.box-header -->

              <div class="box-body">

       <table width="100%" class="table table-striped table-bordered table-hover" id="table">
                                    <thead>
                                        <tr>
                                            <th>#Serial</th>
                                            <th>Customer</th>
                                            <th>Phone</th>
                                            <th>Booking type</th>
                                            <th>Check IN</th>
                                            <th>Check OUT</th>
                                            <th>Advance</th>
                                            <th>Total Amount</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>

                </div><!-- /.box-body -->

              </div><!-- /.box -->

               

          </section>

<!-- /.content -->

      </div><!-- /.content-wrapper -->






 
    <!-- VIEW MODAL BODY -->
        <div class="modal fade" id="view-modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content model_gallery">
                    <div class="modal-body">
                        <div class="row">
                            <!----modal calling div-->
                            <div class="view-modal"></div>
                 
                            <!----end modal calling div-->
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

 
          <div class="modal fade del-modal" id="del-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
               <div class="del"></div>
            </div>
        </div>
    </div>
  

    <!-- ADD MODAL BODY -->
    <div class="modal fade sucs-modal" id="add_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Added successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
     <!-- UPDATE MODAL BODY -->
    <div class="modal fade sucs-modal" id="update_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Updated successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- DELETE MODAL BODY -->
    <div class="modal fade sucs-modal" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4 class="modal-title" >Deleted successfully !</h4>
                    <button type="button" class="btn confirm-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>









      <footer class="main-footer">

        <div class="pull-right hidden-xs">

          <b>Version</b> 2.3.0

        </div>

        <strong>Copyright &copy; 2014-2015 <a target="_blank" href="http://softlinksolution.com">SoftLink</a>.</strong> All rights reserved.

      </footer>



      <!-- Control Sidebar -->

     

      <!-- Add the sidebar's background. This div must be placed

           immediately after the control sidebar -->

      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->



    <!-- jQuery 2.1.4 -->

     <?php include('assets/include/footer.php'); ?>

     <script>


    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

     <script>

    $(document).ready(function () {

        $('#view-modal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?php echo site_url('Check_in/view'); ?>',
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.view-modal').html(data);
                }
            });
        });
    });
</script> 


<script>

    $(document).ready(function () {

        $('#del-modal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');

            $.ajax({
                type: 'post',
                url: '<?php echo site_url('Check_in/delete'); ?>',
                data: 'rowid=' + rowid, //Pass $id
                success: function (data) {
                    $('.del').html(data);
                }
            });
        });
    });
</script> 



<script type="text/javascript">

    var table;

    $(document).ready(function() {

        //datatables id
        table = $('#table').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
        "url": '<?php echo site_url('Check_in/type_list'); ?>',
        "type": "POST",
        },

        });

    });

    //sucessfuly add edit delete popup with fals data
<?php if ($this->session->flashdata('add')) { ?>
    $("#add_confirm").modal('show');<?php } ?>
<?php if ($this->session->flashdata('update')) { ?>
    $("#update_confirm").modal('show');<?php } ?>
<?php if ($this->session->flashdata('delete')) { ?>
    $("#delete_confirm").modal('show');<?php } ?>



      $(function () {

        $("#example1").DataTable();

        $('#example2').DataTable({

          "paging": true,

          "lengthChange": false,

          "searching": false,

          "ordering": true,

          "info": true,

          "autoWidth": false

        });

      });


    </script>

  </body>

</html>

