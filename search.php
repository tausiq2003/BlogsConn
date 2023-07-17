<?php 
    include "dbLogic.php";
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?> 
<?php require_once('partials/header.php') ?>
    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <title>BlogsConn - Search</title>
</head>
<body>
    <!-- Navbar -->
    <?php include('partials/navbar.php')?>
    <?php include('partials/menuLinks.php')?>

    <div class="search__mainContainer">

        <?php 

            if (isset($_GET['searchBar'])) {

                $category = $_GET["searchBar"];
                $search = $category;
                $sql = "SELECT * FROM blogsdata 
                JOIN userdetails ON (blogsdata.user_id = userdetails.user_id) 
                WHERE (category LIKE '".$search."' OR soundex(category) = soundex('$search') OR content LIKE '".$search."' OR title LIKE '".$search."' OR name LIKE '".$search."')
                AND blogsdata.status = 1 AND userdetails.status = 1";
                $result = mysqli_query($conn, $sql);
            }
        ?>

        <?php if (mysqli_num_rows($result) == 0) { ?>

            <h2 class = "search__heading">No Blogs related to: <span style = "color: #0488d1;"><?php echo $category; ?></span></h2>

            <div class="search__noDataFound">
                <img src="https://image.freepik.com/free-vector/no-data-concept-illustration_114360-616.jpg" alt="">
            </div>

        <?php } else { ?>

            <h2 class = "search__heading">Showing Blogs related to: <span style = "color: #0488d1;"><?php echo $category; ?></span></h2>


                <center><div class="blog-list-box home__blogs"> 
                    <?php foreach($result as $q) { ?>
                        <div class = 'card search-card'>
                        
                                <div class = "card-body">

                                    <?php 
                                        // Query to access authorname of the blog
                                        $sql = $conn->prepare("SELECT userdetails.name FROM userdetails JOIN blogsdata WHERE (userdetails.user_id = blogsdata.user_id AND id = ?)");
                                        $sql->bind_param('i', $id);
                                        $id = $q['id'];
                                        $sql->execute();
                                        $result = $sql->get_result();
                                        $ans = $result->fetch_assoc();
                                        $blog_user_name = $ans['name'];
                                        $created_on = date('jS M Y', strtotime($q['created_on']));
                                    ?>

                                    <div class="blog-tile-img">
                                        <img src="<?php echo $q['blog_image']?>" alt="">
                                    </div>

                                    <h3 class = 'heading'><?php echo $q['title'] ?></h3>

                                    <div class="blog__details">
                                        <p id='homePage__author'><i class="fas fa-user"></i> <?php echo $blog_user_name; ?></p>
                                        <p id='homePage__author'><i class="far fa-clock"></i><?php echo $created_on; ?></p>
                                    </div>

                                    <p id = "content"><?php echo substr($q['content'], 0, 92
                                        ) . "...."; ?></p>

                                    <div class = "read-more-btn">
                                        <a href="blogPage/<?php echo $q['id']?>/<?php echo$q['user_id']?>">Read More <i class="fas fa-chevron-right"></i></a>
                                        <a href="search/<?php echo $q['category'];?>" style = 'background-color: gray;'><?php echo $q['category'];?></a>
                                    </div>
                                    
                                </div>
                            
                        </div>
                    <?php } ?>
                </div>


                

                
            </div>


            </div>

            </div></center>
        <?php } ?>
    </div>

<?php require_once('partials/footer.php') ?>
