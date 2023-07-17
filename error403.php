<?php include "dbLogic.php"; 
  session_start();
  if (isset($_SESSION['loggedin']) &&  $_SESSION['loggedin']){
    header("Location: index.php");
    exit();
  }

?> 

<?php require_once('partials/header.php') ?>
    <link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
    <title>BlogsConn - Error</title>
</head>
<body style = "background-color: #ece9e9;">
    <!-- Navbar -->
    <?php include('partials/navbar.php')?>
    <?php include('partials/menuLinks.php')?>


    <h2 class = "search__heading"> 
      <i style = "color: red;" class="fas fa-exclamation-triangle"></i>
      403, Access Prohibited!
      
    </h2>

    <div class="search__noDataFound">
      <img src="https://freefrontend.com/assets/img/403-forbidden-html-templates/403-Forbidden-HTML.png" alt="">
    </div>

<?php require_once('partials/footer.php') ?>