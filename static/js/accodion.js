var ele = document.getElementById('home__accordion');
var subscribe_box = document.getElementById('home__subscribeBox');
var openIcon = document.getElementById("home__accordionOpenIcon");
var closeIcon = document.getElementById("home__accordionCloseIcon");


ele.addEventListener('click', function() {
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
      openIcon.style.display = 'block';
        closeIcon.style.display = 'none';
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
      openIcon.style.display = 'none';
      closeIcon.style.display = 'block';
    } 
});