// Alert message

  var closeButton = document.getElementById('close-btn');

// Add a click event listener to the close button
closeButton.addEventListener('click', function() {
  // Hide the alert by removing the "show" class
  var alertElement = document.getElementById('alert');
  alertElement.classList.remove('alert');
});


// hamburger menu
var bars = document.getElementById("bars_img");
var close_menu = document.getElementById("close_img");
var flag = "off";
document.getElementById("menu-box").addEventListener("click", function () {
  
  if (flag == "off"){
    document.getElementById("nav-box").style.transition = "0.4s ease-in";
    document.getElementById("nav-box").style.display = "flex";
    bars.style.display = 'none';
    close_menu.style.display = 'flex';
    flag = "on"; 
  } else if (flag == "on"){
    document.getElementById("nav-box").style.display = "none";
    bars.style.display = 'flex';
    close_menu.style.display = 'none';
    flag = "off";
  } 
});


document.getElementById("close-menu-btn").addEventListener("click", function () {
    document.getElementById("nav-box").style.display = "none";
    console.log("Hey");
  });




