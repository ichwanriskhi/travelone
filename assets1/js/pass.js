
var passwordInput = document.getElementById("yourPassword");
passwordInput.addEventListener("input", function() {
  if (passwordInput.value.length < 6) {
    passwordInput.setCustomValidity("Password must be at least 6 characters long.");
  } else {
    passwordInput.setCustomValidity("");
  }
});
