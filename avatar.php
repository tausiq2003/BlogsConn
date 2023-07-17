<?php include "dbLogic.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// if the user tries to modify others avatar then redirect to index.php
if (isset($_REQUEST['uid'])) {
	$id = (int)$_REQUEST['uid'];
	if ($id != $_SESSION['uid']) {
		header("Location: index.php");
		exit;
	}
}

if (isset($_POST['avatar'])) {
  $_SESSION['avatar'] = $_POST['avatar'];

  // Update the avatar in the userdetails table
  $uid = $_SESSION['uid'];
  $avatar = $_POST['avatar'];
  $sql = $conn->prepare("UPDATE userdetails SET avatar = ? WHERE user_id = ?");
  $path = 'avatar/' . $avatar;
  $sql->bind_param('si', $path, $uid);
  $sql->execute();
  $sql->close();
  if (isset($_SESSION['avatar'])) {
    header("Location: /BlogsConn/index.php");
    
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Select Avatar</title>
	
</head>
<style>
  .avatar-list label {
  display: inline-block;
  cursor: pointer;
  margin-right: 10px;
}

.avatar-list label:hover img {
  border: 2px solid #ccc;
}

.avatar-list input[type="radio"] {
  display: none;
}

.avatar-list img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 2px solid transparent;
  transition: border-color 0.3s ease;
}

.avatar-display {
  margin-top: 20px;
  text-align: center;
}

.avatar-icon img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  border: 2px solid #ccc;
}#select-btn{
  margin-top: 20px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background: #77619e;
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
}




</style>
<body>

	<div class="container">
		<div class="avatar-selection">
			<h1>Select Your Avatar</h1>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<div class="avatar-list">
					<label>
						<input type="radio" name="avatar" value="avatar1.png">
						<img src="avatar/avatar1.png" alt="Avatar 1">
					</label>
					<label>
						<input type="radio" name="avatar" value="avatar2.png">
						<img src="avatar/avatar2.png" alt="Avatar 2">
					</label>
					<label>
						<input type="radio" name="avatar" value="avatar3.png">
						<img src="avatar/avatar3.png" alt="Avatar 3">
					</label>
					<label>
						<input type="radio" name="avatar" value="avatar4.png">
						<img src="avatar/avatar4.png" alt="Avatar 4">
					</label>
					<label>
						<input type="radio" name="avatar" value="avatar5.png">
						<img src="avatar/avatar5.png" alt="Avatar 5">
					</label>
					<label>
						<input type="radio" name="avatar" value="avatar6.png">
						<img src="avatar/avatar6.png" alt="Avatar 6">
					</label>
				</div>
				<button class="btn" type="submit" id="select-btn">Select</button>
			</form>
		</div>
		<div class="avatar-display">
			<div class="avatar-icon">
            <?php if(isset($_SESSION['avatar'])) { 
				$avatar = $_SESSION['avatar'];
				$avatar_array = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png");
				if(!in_array($avatar, $avatar_array)) {
					$_SESSION['avatar'] = "avatar.png";
				}
				?>
            <?php } else { ?>
              <img src="avatar/avatar.png" alt="Default Avatar">
              <?php } ?>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="static/js/avatar.js"></script>
</body>
</html>
