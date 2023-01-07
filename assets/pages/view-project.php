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

          <h1>View Project</h1>

          <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#">Examples</a></li>

            <li class="active">Blank page</li>

          </ol>

        </section>



        <!-- Main content -->

          <section class="content">

            <div class="box">

                <div class="box-header">

                  <a class="btn bg-olive" href="add-project.php">Add Project</a>

                </div><!-- /.box-header -->

                <div class="box-body">

                  <table id="example1" class="table table-bordered table-striped">

                    <thead>

                      <tr>

                        <th>Sl No.</th>

                        <th>Project name</th>

                        <th>Category</th>

                        <th>image</th>

                        <th>Action</th>

                      </tr>

                    </thead>

                    <tbody>

                      <tr>

                        <td>1</td>

                        <td>Abcd</td>

                        <td>abcd1</td>

                       <td><img src="../dist/img/abcd_03.jpg" class="img-responsive"></td>

                        <td>

                            <a class="btn  btn-info circle"><i class="fa fa-eye"></i></a>

                            <a href="edit-project.php" class="btn  btn-warning"><i class="fa fa-edit"></i></a>

                            <a class="btn  btn-danger"><i class="fa  fa-trash-o"></i></a>

                            

                        </td>

                      </tr>

                     

                     

                    </tbody>

                    

                  </table>

                </div><!-- /.box-body -->

              </div><!-- /.box -->

               

          </section>

<!-- /.content -->

      </div><!-- /.content-wrapper -->



      <footer class="main-footer">

        <div class="pull-right hidden-xs">

          <b>Version</b> 2.3.0

        </div>

        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">SoftLink</a>.</strong> All rights reserved.

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

