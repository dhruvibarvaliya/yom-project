<?php 
include '../db.php';
session_start();
if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sel = "SELECT a_image FROM `admin` WHERE id = $id";
    $res = mysqli_query($con, $sel);
    $data = mysqli_fetch_assoc($res);
    if(file_exists('image/admin/'.$data['a_image']) && $data['a_image'] !="") {
        unlink("image/admin/".$data['a_image']);
    }
    $sql = "DELETE FROM `admin` WHERE id = $id";
     if (mysqli_query($con, $sql)) {
        header("location:view_admin.php");
        exit();
    } else {
             echo '<script>alert("this admin used in another table so you can not delete it.")</script>';
    }
}

$search = ''; 
$sql_p = "SELECT * FROM `admin`";
$limit = 5;

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $limit;

if (isset($_GET['name'])) {
    $search = $_GET['name'];
    $sql_page = "SELECT * FROM `admin` WHERE name LIKE '%$search%' LIMIT $start, $limit";
    $sql1 = "SELECT * FROM `admin` WHERE name LIKE '%$search%'";
} else {
    $sql_page = "SELECT * FROM `admin` LIMIT $start, $limit";
    $sql1 = "SELECT * FROM `admin`";
}

$total_rec = mysqli_query($con, $sql1);
$total_r = mysqli_num_rows($total_rec);
$total_page = ceil($total_r/$limit);
$res_page = mysqli_query($con, $sql_page);
?>

<?php include "header.php"; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Admin</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View Admin</h3>
                        </div>
                       <div class="text-center mt-3">
                            <form method="GET" class="form-inline justify-content-center">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="Search by Name" value="<?php echo $search; ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-dark">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>                  
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while($data=mysqli_fetch_assoc($res_page)){ ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['name']; ?></td>
                                        <td><?php echo $data['email']; ?></td>
                                        <td>
                                            <div style="height:70px; width: 70px; overflow:hidden;">
                                                <img src="image/admin/<?php echo $data['a_image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
                                            </div>
                                        </td>
                                             <td class="actions">
                                                <?php 
                                                if(isset($_SESSION['userid']) && $_SESSION['userid'] == $data['id']) { 
                                                ?>
                                                      <span class="btn bg-gradient-secondary" disabled>DELETE</span>
                                                <?php } else { ?>
                                                    <a href="view_admin.php?id=<?php echo $data['id']; ?>" class="btn bg-gradient-danger">DELETE</a>
                                                <?php } ?>
                                                <a href="add_admin.php?id=<?php echo $data['id']; ?>" class="btn bg-gradient-primary">EDIT</a>
                                            </td>
                                         </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                               <a class="page-link" <?php if ($page == 1) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href='view_admin.php?page=<?php echo ($page-1); ?>&name=<?php echo $search; ?>' class='button'>Previous</a>
                                <?php 
                                for($i = 1; $i <= $total_page; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='view_admin.php?page=$i&name=$search'>$i</a></li> ";
                                }
                                ?>
                                <a class="page-link" <?php if ($page == $total_page) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href='view_admin.php?page=<?php echo ($page+1); ?>&name=<?php echo $search; ?>' class='button'>Next</a>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
