<?php 

include '../db.php';
session_start();
if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }

if (isset($_POST['submit'])) {
    $icon = $_POST['icon'];
    $title = $_POST['title'];
    $discription = $_POST['discription'];
 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE `service` SET icon='$icon',title='$title', discription='$discription' WHERE id=$id"; 
    } else {
        $sql = "INSERT INTO `service` (`icon`,`title`,`discription`) VALUES ('$icon','$title', '$discription')";
    }

    mysqli_query($con, $sql);
    header("location:view_service.php");
}

$data = array(); 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sel = "SELECT * FROM `service` WHERE id=$id";
    $res = mysqli_query($con, $sel);
    $data = mysqli_fetch_assoc($res);
}
?>  
<?php 
  include ("header.php");
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Service</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Service</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Icon</label>
                    <input type="text" class="form-control" name="icon" id="icon" placeholder="Enter icon" value="<?php echo @$data['icon'] ?>" dmx-html="'<i class=\'fas fa-' + icon + '\'></i>'">
                    <span style="color:red;display: none;">enter icon...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" name="title" id="exampleInputName1" placeholder="Enter title" value="<?php echo @$data['title'] ?>">
                    <span style="color:red;display: none;">enter title...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Discription</label>
                    <input type="text" class="form-control" name="discription" id="discription" placeholder="Enter Discription" value="<?php echo @$data['discription'] ?>">
                    <span style="color:red;display: none;">enter discription...</span>

                  </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include("footer.php") ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script type="text/javascript">
  $('#frm').submit(function(){
    var icon=$('#icon').val();

    var title=$('#title').val();
    var discription=$('#discription').val();
  
  if(icon=='')
    {
      $('#icon').next('span').css('display','inline');
      return false;
    }else{
      $('#icon').next('span').css('display','none');

    }
     if(title=='')
    {
      $('#title').next('span').css('display','inline');
      return false;
    }else{
      $('#title').next('span').css('display','none');
    }
   
      if(discription=='')
    {
      $('#discription').next('span').css('display','inline');
      return false;
    }else{
      $('#discription').next('span').css('display','none');
    }
    
     
    

  })
  
</script>
</body>
</html>
