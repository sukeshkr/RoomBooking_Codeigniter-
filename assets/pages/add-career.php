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

          <h1>Add Career</h1>

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

            <div class="col-md-4">

                <div class="form-group">

                    <label>Job titile</label>

                    <input type="text" class="form-control">

                </div>

            </div>

            <div class="col-md-8">

                <div class="form-group">

                    <label>Job description</label>

                    <textarea class="form-control" rows="3" placeholder=""></textarea>

                </div>

            </div>

            <div class="box-footer">

                <input value="Submit" class="btn btn-primary" type="submit">

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

        $('#cropModal').on('shown.bs.modal', function () {

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

