<?php 

include '../db.php';
session_start();
if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }
   $data = array(); 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sel = "SELECT * FROM `slider` WHERE id=$id";
    $res = mysqli_query($con, $sel);
    $data = mysqli_fetch_assoc($res);
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $discription = $_POST['discription'];
       $image=$_FILES['image']['name'];
        if($image==""){
          $image=$data['image'];
        }
        else{
            $image = rand(10000,99999).'slider'.$image;
            unlink('image/slider/'.$data['image']);
            $path = "image/slider/" . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
        }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE `slider` SET title='$title', discription='$discription', image='$image' WHERE id=$id"; 
    } else {
        $sql = "INSERT INTO `slider` (`title`,`discription`,`image`) VALUES ('$title', '$discription','$image')";
    }

    mysqli_query($con, $sql);
    header("location:view_slider.php");
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
            <h1>Add Slider</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Slider</li>
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
                <h3 class="card-title">Add Slider</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="<?php echo @$data['title'] ?>">
                    <span style="color:red;display: none;">enter title...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Discription</label>
                    <input type="text" class="form-control" name="discription" id="discription" placeholder="Enter Discription" value="<?php echo @$data['discription'] ?>">
                    <span style="color:red;display: none;">enter discription...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group"> 
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" attr_data="<?php echo @$data['image']; ?>">
                         <span style="color:red;display: none;margin-top: 50px;width: 150px;height: 10px;">select image...</span>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                        <?php if(isset($data['image'])): ?>
                            <div style="height:70px; width: 70px; overflow:hidden;">
                                <img src="image/slider/<?php echo $data['image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
                            </div>
                        <?php endif; ?>
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
  $('#form').submit(function(){
    var title=$('#title').val();
    var discription=$('#discription').val();
    var image=$('#image').val();
    
    
  
 var isInsert = <?php echo isset($_GET['id']) ? 'false' : 'true'; ?>;
 
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
     if(isInsert) {
  if(image == '') {
            $('#image').next('span').css('display', 'inline').text('Select image...');
            return false;
        } else {
            $('#image').next('span').css('display', 'none');
        }

      }
          

  })
  
</script>
</body>
</html>
