function verClave(ojo, input) {
  ojo = document.getElementById(ojo);
  input = document.getElementById(input);

  if (input.type == "password") {
    input.type = "text";
    ojo.className = "icon-eye-slash";
  } else {
    input.type = "password";
    ojo.className = "icon-eye";
  }
}