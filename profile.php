<?php 
    include "dbLogic.php";
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
        header("Location: home.php" );
        exit();
    }

    // edit user name (profile page)
    if (isset($_REQUEST['profile__btn'])){
        $id = $_SESSION['uid'];
        $name = $_REQUEST['uname'];
        $sql = "UPDATE userdetails SET bio = '$name' where user_id = $id";
        $result = mysqli_query($conn, $sql);
        header("Location: profile.php?updated");
        exit;
    }

?> 

<?php require_once('partials/header.php') ?>
<link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <title>BlogsConn - Profile</title>
</head>
<body>
    <!-- Navbar -->
    <?php include('partials/navbar.php')?>
    <?php include('partials/menuLinks.php')?>

    <div class="profile__mainContainer">

        <h2 class = "profile__heading"> <?php echo ( "Profile" )?> </h2>

        <?php 

if (isset($_REQUEST['uid'])) {
    $id = (int)$_REQUEST['uid'];
    if ($id == $_SESSION['uid']) {
        $id = $_SESSION['uid'];
    }
    $sql = "SELECT * FROM userdetails WHERE user_id = $id";
    $ans = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($ans);
    if ($result['status'] == 0) {
        header("Location: block.php");
        exit;
    } else {
        $name = $result['name'];
        $email = $result['email'];
        $bio = $result['bio'];
        $avatar = $result['avatar'];
        // Perform the normal display/profile functionality here
    }
} else {
    header("Location: index.php");
    exit;
}
        ?>

        <div class="profile__box">

            <div class="profile__container">
                

                <div class="profile__avatar">
                <img src="<?php echo $avatar ?>" alt="avatar">
                    

                            
                </div>
                <?php if ($_SESSION['uid'] == $id) { ?>
                    <button><a href="avatar.php">Change avatar</a></button>
                <?php } ?>

                <form method = "POST">

                    <label for="uname"><?php echo ( "Name" )?></label>
                        <input type="text" name = 'uname' value = "<?php echo $name ?>" disabled>

                        <input name = "profile__user_id" type="text" value = "<?php echo $id?>" hidden>
                    
                    
                    <label for="profile__bio"><?php echo ("Bio" )?></label>
                        <?php if ($_SESSION['uid'] == $id) { ?>
                            <textarea id="profile__bio" class = "profile__bio" name="profile__bio" cols="30" rows="7" placeholder = "Tell us something about you..."><?php echo $bio; ?></textarea>
                        <?php } else { ?>
                            <textarea id="profile__bio" class = "profile__bio" cols="30" rows="7" placeholder = "Tell us something about you..." disabled><?php echo $bio; ?></textarea>
                        <?php } ?>

                        

                    

                    <?php
                        $query = "SELECT id FROM blogsdata WHERE user_id = $id AND status = 1";
                        $res = mysqli_query($conn, $query); 
                        $ans = mysqli_num_rows($res);

                    ?>  

                    <p>
                        <?php echo ("Blogs")?>: <?php echo $ans; ?>
                        <?php if ($_SESSION['uid'] == $id) { ?>
                            <button name = "profile__btn" id = "add-post-btn" ><?php echo ('Update') ?></button>
                        <?php } ?>
                    </p>
                
                </form>
            
            </div>

                <?php

                    if (isset($_REQUEST['uid'])){
                        $id = (int)$_REQUEST['uid'];
                        $sql = "SELECT * FROM blogsdata WHERE user_id = $id AND status = 1";
                        $ans = mysqli_query($conn, $sql);

                    } else {
                        header("Location: index.php");
                        exit;
                    }

                
                ?>

                <div class="personal-blog-list">
                    <?php if (mysqli_num_rows($ans) == 0) { ?>
                        <h1>No Blogs to show!</h1>
                    <?php } ?>

                    <?php foreach($ans as $a) { ?>
                        <div class = 'card'>
                        
                                <div class = "card-body">
                                    <h3 class = 'heading'><?php echo ($a['title'] ); ?></h3>
                                    <div class="blog-tile-img">
                                        <img src="<?php echo $a['blog_image']?>" alt="">
                                    </div>

                                    <?php 

                                            $content = $a['content'];
                                            $stripped_content = strip_tags  ($content);
                                            $char_length = 202;

                                    ?>

                                    <p id = "content" class = "personal__content"><?php echo substr($stripped_content, 0, $char_length
                                    ) . "...."; ?></p>
                                    <div class = "read-more-btn profile-read-btn">
                                        <a href="./blogPage.php?lang='en'&id=<?php echo $a['id']?>"><?php echo 'Read More'; ?>  <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                    
                                </div>
                            
                        </div>
                    <?php } ?>
                </div>

                        
        </div>
    </div>




<?php require_once('partials/footer.php') ?>