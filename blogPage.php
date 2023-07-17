<?php
include "dbLogic.php";
include "like.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>
<?php require_once('partials/header.php') ?>
<!DOCTYPE html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script src="static/js/like.js"></script>

    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <title>BlogsConn - Blog</title>
</head>

<body>

    <!-- Navbar -->
    <?php include('partials/navbar.php') ?>
    <?php include('partials/menuLinks.php') ?>

    <div class="blogPage__container">

        <div class="blog-container">

            <?php foreach ($query as $q) { ?>
                <div class="">
                    <h1 id="heading">
                        <?php echo $q['title']; ?>
                    </h1>
                </div>

                <?php
                // Query to access authorname of the blog
                $sql = $conn->prepare("SELECT * FROM userdetails JOIN blogsdata WHERE (userdetails.user_id = blogsdata.user_id AND id = ?)");
                $sql->bind_param('i', $id);
                $id = $q['id'];
                $sql->execute();
                $result = $sql->get_result();
                $ans = $result->fetch_assoc();
                $blog_user_name = $ans['name'];
                $uid = $ans['user_id'];
                $created_on = $ans['created_on'];
                ?>

                <div class="blogPage__details">
                    <p id='homePage__author'><i class="fas fa-user"></i> <a href="profile.php?uid=<?php echo $uid ?>"><?php echo $blog_user_name; ?></a></p>
                    <p id='homePage__author'><i class="far fa-clock"></i>
                        <?php echo date("jS M Y", strtotime($created_on)); ?>
                    </p>
                </div>

                <?php if ($q['blog_image'] != "") { ?>
                    <div class="blog__imageContainer">
                        <img src="<?php echo $q['blog_image'] ?>" alt="">
                    </div>
                <?php } ?>


                <div class="blogPage__content">
                    <p class='blog-content'>
                        <?php echo nl2br($q['content']); ?>
                    </p>
                </div>


                <button class="blog__category">
                    <?php echo $q['category']; ?>
                </button>


                <!-- *************************** -->

                <?php if (isset($_SESSION['loggedin'])) { ?>

                    <div class="blog__likes">

                        <?php

                        $sql = $conn->prepare("SELECT id from blog_likes where blog = ?");
                        $sql->bind_param("i", $id);
                        $id = $q['id'];
                        $sql->execute();
                        $result = $sql->get_result();
                        $ans = mysqli_num_rows($result);
                        ?>

<a href="like.php?type=article&id=<?php echo $q['id']; ?>&user_id=<?php echo $q['user_id']; ?>">
    <?php if ($ans === 1) { ?>
        <i class="fas fa-heart liked"></i>
    <?php } else { ?>
        <i class="far fa-heart"></i>
    <?php } ?>
    <span name="blog__likes-count">
        <?php echo $ans; ?>
    </span>

    <?php if ($ans === 1) { ?>
        <p class="like-msg">You have liked this post</p>
    <?php } ?>
</a>

                    </div>

                <?php } ?>


                <?php if (isset($_SESSION['loggedin']) && $_SESSION['uid'] == $q['user_id']) { ?>
                    <div class='action-btns'>
                        <a href="editBlog/<?php echo $q['id'] ?>">Edit</a>
                        <form method="POST">
                            <input type='text' hidden name="id" value="<?php echo $q['id']; ?>">
                            <button name="delete" id='delete-post-btn'>Delete</button>
                        </form>
                    </div>
                <?php } ?>
                <!-- Button trigger modal -->
                <?php if(isset($_SESSION['loggedin'])) { ?>
                <button type="button" style="background-color: #f9c5d1;background-image: linear-gradient(315deg, #f9c5d1 0%, #9795ef 74%); float: right; margin-right: 1em;" class="btn" data-toggle="modal" data-target="#exampleModalLong">
                    Summarize
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle" style="text-align: center !important;">Summarize</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php
                                require 'vendor/autoload.php';

                                $text = $q['content'];
                
                                $api = new PhpScience\TextRank\TextRankFacade();
                                $stopWords = new PhpScience\TextRank\Tool\StopWords\English();
                                $api->setStopWords($stopWords);
                                $result = $api->getOnlyKeyWords($text);
                                $result = $api->getHighlights($text);
                                $result = $api->summarizeTextBasic($text);
                                
                                echo implode(', ', $result);
                                ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>





             
                <div class="blog__comments-container">

                    <?php if (isset($_SESSION['loggedin'])) { ?>
                        <h2>'Post a comment'</h2>
                    <?php } else { ?>
                        <h2>Comments</h2>
                    <?php } ?>

                    <?php if (isset($_SESSION['loggedin'])) { ?>
                        <form action="comments.php" method="POST">
                            <input type="text" name='comment-box' placeholder="Comment..." autocomplete="off" required>
                            <input type="text" name='user-id' value="<?php echo $_SESSION['uid'] ?>" hidden>
                            <input type="text" name='blog-id' value="<?php echo $q['id'] ?>" hidden>
                            <button name='comment-btn'> "Comment"</button>
                        </form>
                    <?php } ?>

                    <?php
                    include "comments.php";
                    $blog_id = $q['id'];
                    $sql_query = "SELECT userdetails.name, comment, id 
                    FROM userdetails 
                    JOIN comments ON userdetails.user_id = comments.uid 
                    WHERE comments.bid = $blog_id 
                    AND comments.status = 1";
                    $result = mysqli_query($conn, $sql_query);
                    $ans = mysqli_num_rows($result);
                    ?>

                    <div class="blog__comment-box">
                        <?php if ($ans == 0) { ?>
                            <h2>'No comments to show'</h2>
                        <?php } ?>

                        <?php foreach ($result as $r) { ?>
                            <div class="blog__comment">

                                <div class="comment__username">
                                    <h3>
                                        <?php echo $r['name'] ?>
                                    </h3>
                                </div>
                                <br>
                                <div class="comment__content">
                                    <p>
                                        <?php echo $r['comment'] ?>
                                    </p>
                                </div>

                                <div class="blog__likes">
                                    <a href="comments.php?type=comment&id=<?php echo $r['id']; ?>">
                                        <?php
                                        $sql = $conn->prepare("SELECT likes FROM comments WHERE id = ?");
                                        $sql->bind_param("i", $cid);
                                        $cid = $r['id'];
                                        $sql->execute();
                                        $result = $sql->get_result();
                                        $ans = $result->fetch_assoc();
                                        ?>
                                        <i class="far fa-star"></i>
                                        <span name="blog__likes-count">
                                            <?php echo ($ans['likes']); ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="index__bloggers hide-style quotes-container">

            <!-- ***************** Sidebar - Social Section ****************** -->
            

            <!-- ***************** Sidebar - Popular Posts ****************** -->

            <div class="popularPosts__container">
                <div class="popularPosts__title">
                    <!-- <h3 class="popularPosts__heading">Something goes here 2</h3> -->
                    <h3 class="popularPosts__heading">Popular Posts</h3>
                </div>
                <?php
                $sql = $conn->prepare("SELECT * FROM blogsdata WHERE status = 1 ORDER BY id ASC LIMIT 3");
                $sql->execute();
                $result = $sql->get_result();

                foreach ($result as $r) { ?>

                    <div class="popularPosts__content">
                        <div class="popularPosts__img">
                            <img src="<?php echo $r['blog_image']; ?>" alt="popular-post-image">
                        </div>
                        <div class="popularPosts__info">

                            <?php
                            $content = $r['content'];
                            $stripped_content = strip_tags($content);
                            $char_length = 60;
                            ?>

                            <a href="http://localhost/BlogIt/blogPage.php?id=<?php echo $r['id'] ?>">
                                <?php echo substr($stripped_content, 0, $char_length) . "..."; ?>
                            </a>

                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- *************** SideBar - Category Section ****************** -->

            <div class="category__container">
                <div class="category__title">
                    <!-- <h3 class="category__heading">Something goes here 3</h3> -->
                    <h3 class="category__heading">Tags</h3>
                </div>

                <?php
                $sql = $conn->prepare("SELECT category FROM blogsdata WHERE status=1 LIMIT 4");
                $sql->execute();
                $result = $sql->get_result();

                foreach ($result as $a) { ?>

                    <a href="search/<?php echo $a['category']; ?>">
                        <div class="category__content">
                            <div class="category__info">
                                >
                                <?php echo $a['category']; ?>
                            </div>
                            <div class="category__count">
                                <?php
                                $sql = $conn->prepare("SELECT id FROM blogsdata where category = ?");
                                $sql->bind_param("s", $category);
                                $category = $a['category'];
                                $sql->execute();
                                $result = $sql->get_result();
                                $count = mysqli_num_rows($result);
                                ?>
                                (
                                <?php echo $count; ?>)
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>

    <!-- Footer -->


   
    <script src="static/js/like.js"></script>
    <script src="static/js/cookies_lang.js"></script>


    <?php require_once('partials/footer.php') ?>