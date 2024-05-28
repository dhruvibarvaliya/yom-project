<?php 
  include '../db.php';
   session_start();
  if (!isset($_SESSION['userid'])) {
      header("location:index.php");
    }

  $isEdit = isset($_GET['id']);


  if(isset($_GET['id']))
  {
    $id=$_GET['id'];
    $rec="select * from admin where id=".$id;
    $res=mysqli_query($con,$rec);
    $data=mysqli_fetch_assoc($res);
  }
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $image=$_FILES['a_image']['name'];
    if($image=="") {
        $image=$data['a_image'];
    } else {
        $image = rand(10000,99999).'admin'.$image;
        unlink('image/admin/'.$data['a_image']);
        $path = "image/admin/" . $image;
        move_uploaded_file($_FILES['a_image']['tmp_name'], $path);
    }
   
    if ($isEdit) {
        $sql1= "SELECT * FROM `admin` WHERE email='$email' AND id != $id";
        $res1=mysqli_query($con,$sql1);
        
        if (mysqli_num_rows($res1) == 0) {
            if ($_SESSION['userid'] == $id  && $email !== $data['email']) {
               $sql = "UPDATE admin SET email='$email' WHERE id=$id";
                mysqli_query($con, $sql);
                $_SESSION['userid'] = $id; 
                header("location:logout.php");
            } else {
              $sql = "UPDATE `admin` SET name='$name',email='$email',a_image='$image' WHERE id=$id";
            mysqli_query($con, $sql);
                header("location:view_admin.php"); 
            }
        } else {
            $msg = 'Email already exists!';
        }
    } else {
        $sql1 = "SELECT * FROM `admin` WHERE email='$email'";
        $res1 = mysqli_query($con, $sql1);
        
        if (mysqli_num_rows($res1) == 0) {
            $sql = "INSERT INTO `admin` (`name`, `email`, `password`, `a_image`) VALUES ('$name', '$email', '$password', '$image')";
            mysqli_query($con, $sql);
            header("location:view_admin.php");
        } else {
            $msg = "Email already exists!";
        }
    }
}
 ?>
<?php 
  include ("header.php");
 ?>
 <style type="text/css">
  #password_field {
        display: <?php echo $isEdit ? 'none' : 'block'; ?>;
    }
 </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Admin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Admin</li>
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
                <h3 class="card-title">Add Admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <h1 style="color:red;font-size: 20px;margin-left: 10px;"><?php echo @$msg; ?></h1>
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="<?php echo @$data['name'] ?>">
                    <span style="color:red;display: none;">enter name...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo @$data['email'] ?>">
                    <span style="color:red;display: none;">enter email...</span>

                  </div>
                  <div class="form-group" id="password_field">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo @$data['password'] ?>">
                    <span style="color:red;display: none;">The password should be at least 6 characters long with letter,special symbol...</span>

                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group"> 
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="a_image" attr_data="<?php echo @$data['a_image']; ?>">
                         <span style="color:red;display: none;margin-top: 50px;width: 150px;height: 10px;">select image...</span>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                        <?php if(isset($data['a_image'])): ?>
                            <div style="height:70px; width: 70px; overflow:hidden;">
                                <img src="image/admin/<?php echo $data['a_image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
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
$('#frm').submit(function(){
    var name = $('#name').val();
    var email = $('#email').val();
    var e_pat = /^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/;
    var password = $('#password').val();
    var p_pt=/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/;
    var image = $('#image').val(); 

    
    var isInsert = <?php echo isset($_GET['id']) ? 'false' : 'true'; ?>;

    if(isInsert) { 
        if(name === '') {
            $('#name').next('span').css('display', 'inline'); 
            return false;
        } else {
            $('#name').next('span').css('display', 'none'); 
        }

        if(e_pat.test(email) === false) {
            $('#email').next('span').css('display','inline');
            return false;
        } else {
            $('#email').next('span').css('display', 'none'); 
        }

        if(p_pt.test(password) === false) {
            $('#password').next('span').css('display', 'inline');
            return false;
        } else {
            $('#password').next('span').css('display', 'none');
        } 

        if(image === '') {
            $('#image').next('span').css('display', 'inline');
            return false;
        } else {
            $('#image').next('span').css('display', 'none'); 
        }

        var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        var fileType = $('#image')[0].files[0].type;
        if ($.inArray(fileType, validImageTypes) === -1) {
            $('#image').next('span').css('display', 'inline');
            return false;
        } else {
            $('#image').next('span').css('display', 'none'); 
        }
    }

    return true;
});
</script>

</body>
</html>
