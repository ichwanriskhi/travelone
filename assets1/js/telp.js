var phoneInput = document.getElementById("yourPhone");
phoneInput.addEventListener("input", function() {
  if (phoneInput.value.length < 11 || phoneInput.value.length > 13) {
    phoneInput.setCustomValidity("Telephone number must be between 11 and 13 digits.");
  } else {
    phoneInput.setCustomValidity("");
  }
});
