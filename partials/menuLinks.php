<div class='nav-box' id='nav-box'>
    <?php if (isset($_SESSION['loggedin'])) { ?>
        <div class="nav-links">
            <ul>
                <li>
                    <?php if (isset($_SESSION['username'])) { ?>
                        <div class="user">
                            <a href="profile.php?uid=<?php echo $_SESSION['uid'] ?>" class='nav-box-user'><?php echo $_SESSION['username'] ?></a>
                        </div>
                    <?php } ?>
                </li>
                <li>
                    <a href="bloggers">Bloggers</a>
                </li>
                <li>
                    <a href="logout">Logout</a>
                </li>
            </ul>
        </div>
    <?php } else { ?>
        <div class="nav-links">
            <ul>
                <li>
                    <a href="login">Login</a>
                </li>
                <li>
                    <a href="register">Register</a>
                </li>
            </ul>
        </div>
    <?php } ?>
</div>