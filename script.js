// PROFILE DROPDOWN
function toggleMenu(){
    document.getElementById("menu").classList.toggle("show");
}

// CLOSE DROPDOWN IF CLICKED OUTSIDE
window.onclick = function(event) {
  if (!event.target.matches('.profile img')) {
    var dropdowns = document.getElementsByClassName("dropdown");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
  // LOGIN CARD HOVER EFFECT
const loginCard = document.querySelector('.login-card');

loginCard.addEventListener('mouseenter', () => {
    loginCard.style.transform = 'translateY(-10px) scale(1.02)';
    loginCard.style.transition = '0.4s ease';
    loginCard.style.boxShadow = '0 25px 60px rgba(0,0,0,0.35)';
});

loginCard.addEventListener('mouseleave', () => {
    loginCard.style.transform = 'translateY(0) scale(1)';
    loginCard.style.transition = '0.4s ease';
    loginCard.style.boxShadow = '0 20px 45px rgba(0,0,0,0.25)';
});

// BUTTON HOVER EFFECT (OPTIONAL)
const loginButton = document.querySelector('.login-right button');

loginButton.addEventListener('mouseenter', () => {
    loginButton.style.background = '#0f2f9c';
    loginButton.style.boxShadow = '0 8px 20px rgba(0,0,0,0.3)';
    loginButton.style.transition = '0.3s ease';
});

loginButton.addEventListener('mouseleave', () => {
    loginButton.style.background = '#1a3dc1';
    loginButton.style.boxShadow = 'none';
});
// PROFILE DROPDOWN
function toggleMenu(){
    document.getElementById("menu").classList.toggle("show");
}

// CLOSE DROPDOWN IF CLICKED OUTSIDE
window.onclick = function(event) {
  if (!event.target.matches('.profile img')) {
    var dropdowns = document.getElementsByClassName("dropdown");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
}





