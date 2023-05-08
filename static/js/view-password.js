/* View Password*/
document.getElementById("login__eye").addEventListener("click", function () {
    pwd = document.getElementById("login__pwd");
    if (pwd.type == "password") {
      pwd.type = "text";
    } else {
      pwd.type = "password";
    }
  });