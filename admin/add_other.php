<?php 

include '../db.php';
session_start();
if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }

if (isset($_POST['submit'])) {
    $discription = $_POST['discription'];
    $name = $_POST['name'];
    $city = $_POST['city'];
    $country = $_POST['country'];

 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE `other` SET discription='$discription',name='$name',city='$city',country='$country' WHERE id=$id"; 
    } else {
        $sql = "INSERT INTO `other` (`discription`,`name`,`city`,`country`) VALUES ('$discription','$name','$city','$country')";
    }

    mysqli_query($con, $sql);
    header("location:view_other.php");
}

$data = array(); 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sel = "SELECT * FROM `other` WHERE id=$id";
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
            <h1>Add Other</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Other</li>
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
                <h3 class="card-title">Add Other</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Discription</label>
                    <input type="text" class="form-control" name="discription" id="discription" placeholder="Enter Discription" value="<?php echo @$data['discription'] ?>">
                    <span style="color:red;display: none;">enter discription...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">name</label>
                    <input type="text" class="form-control" name="name" id="title" placeholder="Enter name" value="<?php echo @$data['name'] ?>">
                    <span style="color:red;display: none;">enter title...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">city</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter city" value="<?php echo @$data['city'] ?>">
                    <span style="color:red;display: none;">enter city...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">country</label>
                    <input type="text" class="form-control" name="country" id="country" placeholder="Enter country" value="<?php echo @$data['country'] ?>">
                    <span style="color:red;display: none;">enter country...</span>

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

    var name=$('#name').val();
    var city=$('#city').val();
    var country=$('#country').val();
    var discription=$('#discription').val();
  
  
       if(discription=='')
    {
      $('#discription').next('span').css('display','inline');
      return false;
    }else{
      $('#discription').next('span').css('display','none');
    }
    
    if(name=='')
    {
      $('#name').next('span').css('display','inline');
      return false;
    }else{
      $('#name').next('span').css('display','none');
    }
     if(city=='')
    {
      $('#city').next('span').css('display','inline');
      return false;
    }else{
      $('#city').next('span').css('display','none');
    }
     if(country=='')
    {
      $('#country').next('span').css('display','inline');
      return false;
    }else{
      $('#country').next('span').css('display','none');
    }
   
     
    

  })
  
</script>
</body>
</html>
