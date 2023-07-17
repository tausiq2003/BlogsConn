// Get the avatar selection radio buttons
const avatarRadios = document.querySelectorAll('input[name="avatar"]');

// Get the select button
const selectBtn = document.getElementById('select-btn');

// Get the avatar icon
const avatarIcon = document.querySelector('.avatar-icon img');

// Add a click event listener to the select button
selectBtn.addEventListener('click', () => {
  // Loop through the avatar selection radio buttons
  for (let i = 0; i < avatarRadios.length; i++) {
    // Check if the radio button is checked
    if (avatarRadios[i].checked) {
      // Set the source of the avatar icon to the selected avatar image
      avatarIcon.src = avatarRadios[i].nextElementSibling.src;
      // Show the avatar icon
      avatarIcon.parentElement.style.display = 'block';
      break;
    }
  }
});