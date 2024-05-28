<?php 
include '../db.php';

$status = $_POST['status'];
$id = $_POST['id'];

$sql="UPDATE slider SET status=$status where id=".$id;
mysqli_query($con,$sql);

 $limit = 3;

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $limit;

if (isset($_GET['title'])) {
    $search = $_GET['title'];
    $sql_page = "SELECT * FROM slider WHERE title LIKE '%$search%' LIMIT $start, $limit";
    $sql1 = "SELECT * FROM slider WHERE title LIKE '%$search%'";
} else {
    $sql_page = "SELECT * FROM slider LIMIT $start, $limit";
    $sql1 = "SELECT * FROM slider";
}

$total_rec = mysqli_query($con, $sql1);
$total_r = mysqli_num_rows($total_rec);
$total_page = ceil($total_r/$limit);
$res_page = mysqli_query($con, $sql_page);

 ?>


  <?php 
  while($data=mysqli_fetch_assoc($res_page)){ ?>
      <tr>
<td><?php echo $data['id']; ?></td>
<td><?php echo $data['title']; ?></td>
<td><?php echo $data['discription']; ?></td>
<td> 
  <div style="height:70px; width: 70px; overflow:hidden;">
      <img src="image/slider/<?php echo $data['image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
  </div>
</td>
<td>
<input type="checkbox"  attr-value="<?php if($data['status']==0) { echo "1"; }else{ echo "0"; }?>"  class="check" attr-id="<?php echo $data['id']; ?>" <?php if($data['status']==1) { echo "checked"; } ?>>
</td>
<td class="actions">
 <a href="view_slider.php?id=<?php echo $data['id']; ?>" class="btn bg-gradient-primary">DELETE</a>
<a href="add_slider.php?id=<?php echo $data['id']; ?>" class="btn bg-gradient-danger">EDIT</a>
</td>
</tr>
<?php } ?>

