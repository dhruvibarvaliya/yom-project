<?php 
include 'db.php';

$total_blog = "select * from blog";
$total = mysqli_query($con,$total_blog);
	$total_cnt = mysqli_num_rows($total); 
$data1=mysqli_fetch_assoc($total);



$id = $_GET['id'];
$pnumber = $id;
// echo $pnumber;die;
$nnumber = $id;
$sel="select admin.name , blog.* , category.category from `blog` inner join category on blog.category=category.id inner join admin on blog.author=admin.id order by blog.id desc limit $id,1"; 
$res=mysqli_query($con,$sel);	
$data=mysqli_fetch_assoc($res);
$cnt = mysqli_num_rows($res);

if($total_cnt-1<$pnumber){
	$last_record = $total_cnt-1;
	header("location:single_blog.php?id=$last_record");
}




$comments = 0;

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $comment = $_POST['comment'];
    $image = $_FILES['image']['name'];
    $path = "admin/image/single_b/".$image;
    move_uploaded_file($_FILES['image']['tmp_name'], $path);

    $b_id = $data['id'];
    

   	$sql = "INSERT INTO `comment` (`name`,`email`,`subject`,`comment`,`image`,`b_id`) VALUES ('$name', '$email','$subject','$comment','$image','$b_id')";

    mysqli_query($con, $sql);
   
}
if(isset($_GET['id']))
{
	$b_id=$data['id'];
  $query = "SELECT COUNT(*) AS comments FROM `comment` WHERE b_id = $b_id AND status = 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $comments = $row['comments'];
}









?>

<!DOCTYPE html>
<!--[if IE 9]>
<html class="ie ie9" lang="en-US">
<![endif]-->
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<title>YOM- Multipurpose HTML Theme</title>
	<style type="text/css">
		.even {
    margin-left: 100px;
}
span{
	color: red;
	display: none;
}
.img{
	color: red;
	display: none;
	margin-top: 50px;
	height: 10px;
	width: 150px;
}
	</style>


	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>

	

	<link rel="stylesheet" href="files/css/bootstrap.css">
	<link rel="stylesheet" href="files/css/animate.css">
	<link rel="stylesheet" href="files/css/simple-line-icons.css">
	<link rel="stylesheet" href="files/css/font-awesome.min.css">
	<link rel="stylesheet" href="files/css/style.css">

	<link rel="stylesheet" href="files/rs-plugin/css/settings.css">

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

</head>
<body>

	
	<div class="sidebar-menu-container" id="sidebar-menu-container">

		<div class="sidebar-menu-push">

			<div class="sidebar-menu-overlay"></div>

			<div class="sidebar-menu-inner">

	<header class="site-header">
					<div id="main-header" class="main-header header-sticky">
						<div class="inner-header clearfix">
							<div class="logo">
								<a href="index.php">YOM</a>
							</div>
							<div class="header-right-toggle pull-right hidden-md hidden-lg">
								<a href="javascript:void(0)" class="side-menu-button"><i class="fa fa-bars"></i></a>
							</div>
							<nav class="main-navigation pull-right hidden-xs hidden-sm">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li><a href="#" class="has-submenu">Pages</a>
										<ul class="sub-menu">
											<li><a href="service.php">Services</a></li>
											<li><a href="clients.php">Clients</a></li>
										</ul>
									</li>
									<li><a href="blog.php" class="has-submenu">Blog</a>
									</li>
									<li><a href="about.php">About</a></li>
									<li><a href="#" class="has-submenu">Work</a>
										<ul class="sub-menu">
											<li><a href="work_3columns.php">Three Columns</a></li>
											<li><a href="work_4columns.php">Four Columns</a></li>
										</ul>
									</li>
									<li><a href="contact.php">Contact</a></li>
								</ul>
							</nav>
						</div>
					</div>
				</header>


				<section class="page-heading wow fadeIn" data-wow-duration="1.5s" style="background-image: url(files/images/01-heading.jpg)">
					<div class="container">
						<div class="page-name">
							<h1>Single Post</h1>
							<span>Lovely layout of heading</span>
						</div>
					</div>
				</section>
				
				<section class="blog-single">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<div class="blog-single-item">
									<img src="admin/image/blog/<?php echo $data['image']; ?>" alt="" style="height: 100%; width:100%; object-fit:cover;">
									<div class="blog-single-content">	
										<h3><a href="#"><?php echo $data['title']; ?></a></h3>
										<span><a href="#"><?php echo $data['name']; ?></a> / <a href="#"><?php echo $data['date']; ?></a> / <a href="#"><?php echo $data['category']; ?></a></span>
										<p><?php echo $data['discription']; ?></p>
										<div class="share-post">
											<span>Share on: <a href="#">facebook</a>, <a href="#">twitter</a>, <a href="#">linkedin</a>, <a href="#">instagram</a></span>
										</div>
									</div>
									<div class="prev-btn col-md-6 col-sm-6 col-xs-6">
									    	<?php if($pnumber>0): ?>
									        <a <?php if ($pnumber == 0) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href="single_blog.php?id=<?php echo --$pnumber; ?>"><i class="fa fa-angle-left"></i> Previous</a>
									    <?php endif; ?>
									</div>
									<div class="next-btn col-md-6 col-sm-6 col-xs-6">
									    <?php if ($nnumber<$total_cnt-1): ?>
									        <a  href="single_blog.php?id=<?php echo ++$nnumber; ?>">Next <i class="fa fa-angle-right"></i></a>

									    <?php endif; ?>
									</div>
								</div>
							
									<div class="blog-comments">
										<h2><?php echo $comments.'comments' ?></h2>
										<ul class="coments-content">
												<?php 
											 $sel1="select * from `comment` where b_id=".$data['id']." and status = 1"; 
	         						$res1=mysqli_query($con,$sel1);
	         						$cnt=0;
											while($data=mysqli_fetch_assoc($res1)){ 
											$cnt++;
										?>
											<li class="first-comment-item <?php echo ($cnt % 2 == 0) ? 'even' : ''; ?>">
												<img src="admin/image/single_b/<?php echo $data['image'];?>" alt="">
												<span class="author-title"><a href=""><?php echo $data['name']; ?></a></span>
												<span class="comment-date">10 May 2015 / <a href="">Reply</a>
												</span>
												<p><?php echo $data['comment']; ?></p>
											</li>
										<?php } ?>
										</ul>
									</div>
									<div class="submit-comment col-sm-12" id="comments_section">
										<h2>Leave A Comment</h2>
										<form  method="POST" enctype="multipart/form-data" id="contact_form">
											<div class=" col-md-4 col-sm-4 col-xs-6">
												<input type="text" class="blog-search-field" name="name" placeholder="Your name" value="" id="name">
	                    <span>enter name...</span>

											</div>
											<div class="col-md-4 col-sm-4 col-xs-6">
												<input type="text" class="blog-search-field" name="email" placeholder="Your email" value="" id="email">
	                    <span>enter email...</span>

											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="blog-search-field" name="subject" placeholder="Subject" value="" id="subject">
	                    <span>enter subject...</span>

											</div>
											<div class="col-md-12 col-sm-12">
												<textarea class="blog-search-field" id="comment" name="comment" placeholder="Comment"></textarea>
	                    <span>enter comment...</span>

											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<label>Image:</label>
												<input type="file" class="blog-search-field" name="image" value="" id="image">
												<span class="img">select image...</span>
											</div>
											<div class="submit-coment col-md-12">
												<div class="btn-black">
												 <button type="submit" name="submit">Submit</button>
												</div>
											</div>
										</form>		
									</div>
							</div>
							<div class="col-md-4">
								<div class="widget-item">
									<h2>Search here</h2>
									<div class="dec-line"></div>
									<form method="get" id="blog-search" class="blog-search">
										<input type="text" class="blog-search-field" name="s" placeholder="Type keyword..." value="">
									</form>
								</div>
								<div class="widget-item">
									<h2>About Us</h2>
									<div class="dec-line">	
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique earum quod iste, natus quaerat facere a rem dolor sit amet, et placeat nemo.</p>
									<div class="social-icons">
										<ul>
											<li><a href="#"><i class="fa fa-facebook"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter"></i></a></li>
											<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
											<li><a href="#"><i class="fa fa-instagram"></i></a></li>
											<li><a href="#"><i class="fa fa-rss"></i></a></li>
										</ul>
									</div>
								</div>
								<div class="widget-item">
									<h2>Recent Posts</h2>
									<div class="dec-line"></div>
									<ul class="recent-item">
										<?php 
										$id=$id+1;
									$sel2="select admin.name , blog.* , category.category from `blog` inner join category on blog.category=category.id inner join admin on blog.author=admin.id order by blog.id desc limit $id,3";
         						$res2=mysqli_query($con,$sel2);
										while($data=mysqli_fetch_assoc($res2)){ 
									?>
									<li class="recent-post-item" style="display: flex; align-items: center;margin-top: 0px;margin-bottom: 0px;">
										    <a href="single_blog.php?id=<?php echo $id++; ?>">
										        <img src="admin/image/blog/<?php echo $data['image']; ?>" alt="">
										    </a>
										    <div class="post-details">
										        <span class="post-info" style="display: block; margin-bottom: 5px; font-size: 15px; color: #333;"><?php echo $data['name']; ?></span>
										        <span class="post-info" style="display: block; margin-bottom: 5px; font-size: 15px; color: #333;"><?php echo $data['title']; ?></span>
										        <span class="post-info" style="display: block; margin-bottom: 5px; font-size: 15px; color: #333;"><?php echo $data['date']; ?></span>
										    </div>
										</li>
										<br>
									<?php } ?>
									</ul>
								</div>
								<div class="widget-item">
									<h2>From Flickr</h2>
									<div class="dec-line"></div>
									<div class="flickr-feed">
							        	<ul class="flickr-images">
							        	</ul>
							        </div>
								</div>
							</div>
						</div>
					</div>	
				</section>
<footer class="footer">
      <div class="three spacing"></div>
	  <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h1>
            <a href="index.html">
             YOM
            </a>
          </h1>
          <p>©2015 Yom. All rights reserved.</p>
          <div class="spacing"></div>
          <ul class="socials">
            <li>
              <a href="http://facebook.com">
                <i class="fa fa-facebook"></i>
              </a>
            </li>
            <li>
              <a href="http://twitter.com">
                <i class="fa fa-twitter"></i>
              </a>
            </li>
            <li>
              <a href="http://dribbble.com">
                <i class="fa fa-dribbble"></i>
              </a>
            </li>
            <li>
              <a href="http://tumblr.com">
                <i class="fa fa-tumblr"></i>
              </a>
            </li>
          </ul>
          <div class="spacing"></div>
        </div>
        <div class="col-md-3">
          <div class="spacing"></div>
          <div class="links">
            <h4>Some pages</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">View some works here</a></li>
              <li><a href="#">Follow our blog</a></li>
              <li><a href="#">Contact us</a></li>
              <li><a href="#">Our services</a></li>
            </ul>
          </div>
          <div class="spacing">
          	
          </div>
        </div>
        <div class="col-md-3">
          <div class="spacing"></div>
          <div class="links">
            <h4>Recent posts</h4>
            <ul>
              <li><a href="#">Hello World!</a></li>
              <li><a href="#">This is the post title here</a></li>
              <li><a href="#">Our happy day</a></li>
              <li><a href="#">The first works done</a></li>
              <li><a href="#">The cats and dogs</a></li>
            </ul>
          </div>
          <div class="spacing"></div>
        </div>
        <div class="col-md-3">
          <div class="spacing"></div>
          <h4>Email updats</h4>
          <p>We want to share our latest trends, news and insights with you.</p>
          <form>
            <input class="email-address" placeholder="Your email address" type="text">
            <input class="button boxed small" type="submit">
          </form>
          <div class="spacing"></div>
        </div>
      </div>
	  </div>
      <div class="two spacing"></div>
    </footer>
				

				<a href="#" class="go-top"><i class="fa fa-angle-up"></i></a>

			</div>

		</div>

		<nav class="sidebar-menu slide-from-left">
			<div class="nano">
				<div class="content">
					<nav class="responsive-menu">
						<ul>
							<li><a href="index-2.html">Home</a></li>
							<li class="menu-item-has-children"><a href="#">Pages</a>
								<ul class="sub-menu">
									<li><a href="services.html">Services</a></li>
									<li><a href="clients.html">Clients</a></li>
								</ul>
							</li>
							<li class="menu-item-has-children"><a href="#">Blog</a>
								<ul class="sub-menu">
									<li><a href="blog.html">Blog Classic</a></li>
									<li><a href="blog-grid.html">Blog Grid</a></li>
									<li><a href="blog-single.html">Single Post</a></li>
								</ul>
							</li>
							<li><a href="about.html">About</a></li>
							<li class="menu-item-has-children"><a href="#">Works</a>
								<ul class="sub-menu">
									<li><a href="work-3columns.html">Three Columns</a></li>
									<li><a href="work-4columns.html">Four Columns</a></li>
									<li><a href="single-project.html">Single Project</a></li>
								</ul>
							</li>
							<li><a href="contact.html">Contact</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</nav>

	</div>


	

	<script type="text/javascript" src="files/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="files/js/bootstrap.min.js"></script>
	<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script src="files/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script src="files/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

	<script type="text/javascript" src="files/js/plugins.js"></script>
	<script type="text/javascript" src="files/js/custom.js"></script>
	<script type="text/javascript">
  $('#contact_form').submit(function(){

    var name=$('#name').val();
    var email=$('#email').val();
    var e_pt=/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/;
    var subject=$('#subject').val();
    var comment=$('#comment').val();
    var image=$('#image').val();

  
 
    
    if(name=='')
    {
      $('#name').next('span').css('display','inline');
      return false;
    }else{
      $('#name').next('span').css('display','none');
    }
    if(e_pt.test(email)==false)
    {
      $('#email').next('span').css('display','inline');
      return false;
    }else{
      $('#email').next('span').css('display','none');
    }
     if(subject=='')
    {
      $('#subject').next('span').css('display','inline');
      return false;
    }else{
      $('#subject').next('span').css('display','none');
    }
     if(comment=='')
    {
      $('#comment').next('span').css('display','inline');
      return false;
    }else{
      $('#comment').next('span').css('display','none');
    }
     

     if(image=='')
    {
      $('#image').next('span').css('display','inline');
      return false;
    }else{
      $('#image').next('span').css('display','none');

    }
    
     
    

  })
  
</script>

</body>

</html>