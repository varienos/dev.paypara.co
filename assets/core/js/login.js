const input = document.getElementById("password");
const toggle = document.getElementById('toggle-pw');

toggle.addEventListener("click", () => {
  input.type === "password" ? input.type = "text" : input.type = "password";
});