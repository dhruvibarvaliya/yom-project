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
    $sel = "SELECT * FROM `blog` WHERE id=$id";
    $res = mysqli_query($con, $sel);
    $data = mysqli_fetch_assoc($res);
}

if (isset($_POST['submit'])) {
     $image=$_FILES['image']['name'];
    if($image==""){
      $image=$data['image'];
        }
    else{
        $image = rand(10000,99999).'blog'.$image;
        unlink('image/blog/'.$data['image']);
        $path = "image/blog/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
    }

    $title = $_POST['title'];
    $author_id = $_SESSION['userid'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $discription = $_POST['discription'];
 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE `blog` SET image='$image',title='$title',date='$date',category='$category',discription='$discription' WHERE id=$id"; 
    } else {
        $sql = "INSERT INTO `blog` (`image`,`title`,`author`,`date`,`category`,`discription`) VALUES ('$image','$title','$author_id','$date','$category','$discription')";
    }

    mysqli_query($con, $sql);
    header("location:view_blog.php");
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
            <h1>Add Recent</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Recent</li>
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
                <h3 class="card-title">Add Recent</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
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
                                <img src="image/blog/<?php echo $data['image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
                            </div>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="<?php echo @$data['title'] ?>">
                    <span style="color:red;display: none;">enter title...</span>

                  </div>
                 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" class="form-control" name="date" id="date" placeholder="Enter date" value="<?php echo @$data['date'] ?>" min="<?php echo date('Y-m-d'); ?>">
                    <span style="color:red;display: none;">enter date...</span>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail2">Category</label>
                    <select name="category" id="category" class="form-control">
                    <option value="select" selected>select</option>
                      
                      <?php
                      $cat="select * from `category`";
                      $c_sql=mysqli_query($con,$cat);
                       while ($c_data=mysqli_fetch_assoc($c_sql)) {
                       ?>
                      <option value="<?php echo $c_data['id']; ?>" <?php if(@$data['category']==@$c_data['id']){ echo "selected";} ?>>
                          <?php echo $c_data['category']; ?>
                      </option>
                    <?php } ?>
                    </select>
                    <span style="color:red;display: none;">select category...</span>
                    
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
    var image = $('#image').val(); 
    var title=$('#title').val();
    var author=$('#author').val();
    var date=$('#date').val();
    var category=$('#category').val();
    var discription=$('#discription').val();

    var isInsert = <?php echo isset($_GET['id']) ? 'false' : 'true'; ?>;
  if(isInsert) {
        if(image == '') {
            $('#image').next('span').css('display', 'inline').text('Select image...');
            return false;
        } else {
            $('#image').next('span').css('display', 'none');
        }
    }
     if(title=='')
    {
      $('#title').next('span').css('display','inline').text('Select title...');
      return false;
    }else{
      $('#title').next('span').css('display','none');
    }
     if(date=='')
    {
      $('#date').next('span').css('display','inline').text('Select date...');
      return false;
    }else{
      $('#date').next('span').css('display','none');
    }
    if(category == 'select') {
    $('#category').next('span').css('display', 'inline');
    return false;
    } else {
        $('#category').next('span').css('display', 'none');
    }
      if(discription=='')
    {
      $('#discription').next('span').css('display','inline').text('Select discription...');
      return false;
    }else{
      $('#discription').next('span').css('display','none');
    }
    
     
    

  })
  
</script>
</body>
</html>
