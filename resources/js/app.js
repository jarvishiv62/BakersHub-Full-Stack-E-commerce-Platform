require('./bootstrap');

console.log('Your custom bakery JS is loaded!');

require('./admin-orders');

// Example: Toggle mobile nav
document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.querySelector('#menu-toggle');
  const navLinks = document.querySelector('#nav-links');

  if (menuToggle) {
    menuToggle.addEventListener('click', function() {
      navLinks.classList.toggle('show');
    });
  }
});
