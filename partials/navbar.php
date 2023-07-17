<?php
include "dbLogic.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="static/css/navbar.css">
</head>

<body>
    <nav class="nav">
        
        <div class="left-div">
            <a href="home.php?" class="icon">
                <img src="static/icons/logo.png" width="30" height="30" alt="logo">
                BlogsConn
            </a>
        </div>
        <?php if (isset($_SESSION['loggedin'])) { ?>
        <div class="nav__searchContainer">
        <form action="search.php" method="GET">
            <input type="text" name='searchBar' class="nav__searchBar" placeholder="Search" autocomplete="off" required>
            <button name="nav__searchBtn"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <?php } ?>


        <div class="right-nav">
            <?php if (isset($_SESSION['loggedin'])) { ?>
                <div class="user nav-links">
                    <a href="profile.php?uid=<?php echo $_SESSION['uid'] ?>">
                        <?php
                        // Fetch the avatar from the database
                        $sql = $conn->prepare("SELECT avatar FROM userdetails WHERE user_id = ?");
                        $sql->bind_param('i', $_SESSION['uid']);
                        $sql->execute();
                        $result = $sql->get_result();
                        $row = $result->fetch_assoc();
                        $avatar = $row['avatar'];
                        ?>
                        <img src="<?php echo $avatar; ?>" alt="avatar" width="50" height="50">
                    </a>
                </div>
                <div class="nav-links">
                    <ul>
                        <li>
                        <a href="logout.php" class="logout-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48">
                                    <path d="M180 936q-24 0-42-18t-18-42V276q0-24 18-42t42-18h291v60H180v600h291v60H180Zm486-185-43-43 102-102H375v-60h348L621 444l43-43 176 176-174 174Z"></path>
                        </svg>
                        </a>
                        </li>
                    </ul>
                </div>
            <?php } ?>

            <?php if (!isset($_SESSION['loggedin'])) { ?>
                <div class="nav-links">
                    <ul>
                        <li>
                            <a href="login.php">
                                <?php echo "Login"; ?>
                            </a>
                        </li>
                        <li>
                            <a href="register.php">
                                <?php echo "Register"; ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>

            <?php if (!isset($_SESSION['loggedin'])) { ?>
                <div class="nav-links">
                    <ul>
                        <li>
                            <a href="login.php">
                                <?php echo "Login"; ?>
                            </a>
                        </li>
                        <li>
                            <a href="register.php">
                                <?php echo "Register"; ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>
</body>

</html>
