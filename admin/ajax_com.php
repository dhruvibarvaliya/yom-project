<?php 
include '../db.php';

$status = $_POST['status'];
$id = $_POST['id'];

$sql="UPDATE comment SET status=$status where id=".$id;
mysqli_query($con,$sql);

 $limit = 3;

if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $limit;

if (isset($_GET['name'])) {
    $search = $_GET['name'];
    $sql_page = "SELECT * FROM comment WHERE name LIKE '%$search%' LIMIT $start, $limit";
    $sql1 = "SELECT * FROM comment WHERE name LIKE '%$search%'";
} else {
    $sql_page = "SELECT * FROM comment LIMIT $start, $limit";
    $sql1 = "SELECT * FROM comment";
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
<td> 
  <div style="height:70px; width: 70px; overflow:hidden;">
      <img src="image/single_b/<?php echo $data['image']; ?>" alt="Profile Picture" style="height: 100%; width:100%; object-fit:cover;">
  </div>
</td>
<td><?php echo $data['name']; ?></td>
<td><?php echo $data['email']; ?></td>
<td><?php echo $data['subject']; ?></td>
<td><?php echo $data['comment']; ?></td>

<td>
<input type="checkbox"  attr-value="<?php if($data['status']==0) { echo "1"; }else{ echo "0"; }?>"  class="check" attr-id="<?php echo $data['id']; ?>" <?php if($data['status']==1) { echo "checked"; } ?>>
</td>
</tr>
<?php } ?>