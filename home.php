<?php 
    session_start();
    include "dbLogic.php";
?> 
<?php require_once('partials/header.php') ?>

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">

    <title>BlogsConn - Home</title>
</head>
<body>
    <!-- Navbar -->
    <?php include('partials/navbar.php')?>
    <?php include('partials/menuLinks.php')?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogsConn - Home</title>
    <style>
        body {
            background-image: url("static/images/backgroundimage.jpg"); /* Replace with your actual image URL */
            background-size: cover;
            background-position: center;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #content {
            /* Adjust the margin-top value based on your navbar height */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            
            padding: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-align: justify;
        }
        
        #explore-button {
            display: inline-block;
            background-color: #fff;
            color: #0488d1;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 20px;
            float: right;
        }
    </style>
</head>
<body>
    <div id="content">
        <h1>Welcome to BlogsConn</h1>
        <p>Your go-to source for informative and engaging content on a variety of topics.</p>
        <p>Here, we strive to provide you with quality articles, opinion pieces, and informative guides that will keep you entertained, educated, and up-to-date with the latest news and trends.</p>
        <p>Whether you're interested in lifestyle, health and wellness, travel, technology, or any other topic, we've got you covered.</p>
        <br>
        <p>Our team of experienced writers, editors, and contributors works tirelessly to produce content that is not only informative but also engaging and fun to read.</p>
        <p>At BlogsConn, we believe in providing our readers with a platform to express their thoughts, ideas, and opinions. We encourage you to participate in the conversation by leaving comments, sharing your own experiences, and engaging with our community of like-minded individuals.</p><br>
        <p>So why not take a look around and see what we have to offer? From helpful tips and tricks to in-depth analysis and commentary, we're confident that you'll find something here that piques your interest.</p><br>
        <p>Thank you for choosing BlogsConn, and we look forward to seeing you around!</p>
        
        <a href="index.php" id="explore-button">Explore our Blogs</a>
    </div>
</body>
</html>
