<?php 
    include "dbLogic.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?> 

<?php require_once('partials/header.php') ?>
<link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <title>BlogsConn - Feed</title>
    <style>
        #create-blog-button{
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .alert {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
  background-color: #fff;
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
  max-width: 300px; /* Adjust the max-width as needed */
  text-align: center;
}

.alert.show {
  opacity: 1;
  visibility: visible;
}

.alert.success-dialog {
  background-color: #28a745;
  color: #fff;
}

.alert #close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}



    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include('partials/sidebar.php')?>
    
    <?php include('partials/menuLinks.php')?>



    <?php

        $sql = $conn->prepare("SELECT * FROM blogsdata WHERE status = 1 ORDER BY id ASC LIMIT 1");
        $sql->execute();
        $result = $sql->get_result();
        $ans = $result->fetch_assoc();
        ?>


        <div class = "index__container" style="padding: 60px">

            <div class="index__btns">

            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                    <div id="create-blog-button">
                        <a href="createPost">Create a new Blog</a>
                </div>

                <?php } ?>

            </div>
        <hr>
        <?php if (isset($_REQUEST['info'])){ ?>

            <?php if($_REQUEST['info'] == 'added') { ?>
                <div class="alert success-dialog show" id="alert">
                    Post has been published Successfully!
                    <svg id="close-btn" onclick= "closeFunction()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>
                </div>
            <?php } elseif ($_REQUEST['info'] == 'deleted') { ?>
                <div class="alert success-dialog show" id="alert">
                    Post has been deleted Successfully!
                    <svg id="close-btn" onclick= "closeFunction()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>
                </div>    
            <?php } elseif ($_REQUEST['info'] == 'updated') { ?>
                <div class="alert success-dialog show" id="alert">
                    Post has been updated Successfully!
                    <svg id="close-btn" onclick= "closeFunction()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>
                </div>
            <?php } elseif ($_REQUEST['info'] == 'login') { ?>
                <div class="alert success-dialog show" id="alert">
                    Login successful, Welcome <?php echo $_SESSION['username'] ?>!
                    <svg id="close-btn" onclick= "closeFunction()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>
                </div>



            <?php } ?>

        <?php } ?>


        <div class = "index__main" style="width: 100%" >

            <div class="blog-list-box" style="width: 100%">
                 
                <?php foreach($query as $q) { ?>
                    <div class = 'card'>
                        <div>
                            <div class = "card-body">
                                

                                <?php 
                                // Query to access authorname of the blog
                                 $sql = $conn->prepare("SELECT * FROM userdetails JOIN blogsdata WHERE (userdetails.user_id = blogsdata.user_id AND id = ?)");
                                 $sql->bind_param('i', $id);
                                 $id = $q['id'];
                                 $sql->execute();
                                 $result = $sql->get_result();
                                 $ans = $result->fetch_assoc();
                                 $blog_user_name = $ans['name'];
                                 $created_on = $ans['created_on'];
                                ?>

                                <div class="blog-tile-img">
                                    <img src="<?php echo $q['blog_image']?>" alt="">
                                </div>

                                <div class="blog__details">
                                    <p id='homePage__author'><i class="fas fa-user"></i> <?php echo $blog_user_name; ?></p>
                                    <p id='homePage__author'><i class="far fa-clock"></i>
                                    <?php echo date("jS M Y", strtotime($created_on)); ?></p>
                                </div>

                                <?php 
                                  
                                        $content = $q['content'];
                                        $stripped_content = strip_tags($content);
                                        $char_length = 92;
                            
                                ?>

                                <p id = "content"><?php echo substr($stripped_content, 0, $char_length) . "...."; ?></p>


                                <div class = "read-more-btn">
                                    <a href="blogPage.php?&id=<?php echo $q['id']?>"> <?php echo 'Read More'; ?> <i class="fas fa-chevron-right"></i></a>
                                    <a href="search.php?&searchBar=<?php echo $q['category'];?>" style = 'background-color: gray;'><?php echo $q['category'];?></a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php } ?>

             </div>

             
            

             </div>


        </div>

    </div>
<script>
    function closeFunction() {
  var alert = document.getElementById('alert');
  alert.style.opacity = 0;
  alert.style.visibility = 'hidden';
}

window.onload = function() {
  var closeBtn = document.getElementById('close-btn');
  closeBtn.addEventListener('click', closeFunction);
};
</script>

                </body>
                </html>