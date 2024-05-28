<?php 
include '../db.php';
session_start();
if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }
$search = ''; 
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sel = "SELECT image FROM blog WHERE id = $id";
    $res = mysqli_query($con, $sel);
    if ($res) {
        $data = mysqli_fetch_assoc($res);
        if(file_exists('image/blog/'.$data['image']) && $data['image'] !="") {
            unlink("image/blog/".$data['image']);
        }
        $sql = "DELETE FROM blog WHERE id = $id";
        if (mysqli_query($con, $sql)) {
            header("location:view_blog.php");
            exit();
        } else {
            echo '<script>alert("this blog used in another table so you can not delete it.")</script>';
        }
    } else {
        echo "Error fetching image data: " . mysqli_error($con);
    }
}

$sql_p = "SELECT * FROM `blog`";
$res_p = mysqli_query($con, $sql_p);
$limit = 10;

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $limit;

if (isset($_GET['title'])) {
    $search = $_GET['title'];
    $sql_page = "SELECT * FROM blog WHERE title LIKE '%$search%' LIMIT $start, $limit";
    $sql1 = "SELECT * FROM blog WHERE title LIKE '%$search%'";
} else {
    $sql_page = "SELECT * FROM blog LIMIT $start, $limit";
    $sql1 = "SELECT * FROM blog";
}

$total_rec = mysqli_query($con, $sql1);
$total_r = mysqli_num_rows($total_rec);
$total_page = ceil($total_r/$limit);
$res_page = mysqli_query($con, $sql_page);
?>

<?php 
include "header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Blog</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View Blog</h3>
                        </div>
                       <div class="text-center mt-3">
                            <form method="GET" class="form-inline justify-content-center">
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control" placeholder="Search by title" value="<?php echo $search; ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-dark">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>date</th>
                                        <th>Discription</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while($data=mysqli_fetch_assoc($res_page)){ ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td>
                                            <div style="height:70px; width: 70px; overflow:hidden;">
                                                <img src="image/blog/<?php echo $data['image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
                                            </div>
                                        </td>
                                        <td><?php echo $data['title']; ?></td>
                                        <td><?php echo $data['date']; ?></td>
                                        <td><?php echo $data['discription']; ?></td>
                                        
                                        
                                        <td class="actions">
                                            <a href="view_blog.php?id=<?php echo $data['id']; ?>" class="btn bg-gradient-primary">DELETE</a>
                                            <a href="add_blog.php?id=<?php echo $data['id']; ?>" class="btn bg-gradient-danger">EDIT</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card-footer clearfix">
                      <ul class="pagination pagination-sm m-0 float-right">
                    <a class="page-link" <?php if ($page == 1) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href='view_blog.php?page=<?php echo ($page-1); ?>&title=<?php echo $search; ?>' class='button'>Previous</a>

                  <?php 
                  for($i = 1; $i <= $total_page; $i++) {
                      echo "<li class='page-item'><a class='page-link' href='view_blog.php?page=$i&title=$search'>$i</a></li> ";
                  }
                  ?>
                  <a class="page-link" <?php if ($page == $total_page) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href='view_blog.php?page=<?php echo ($page+1); ?>&title=<?php echo $search; ?>' class='button'>Next</a>
                </ul>
                </div>

                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php 
include 'footer.php';
?>

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
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  
</script>
</body>
</html>