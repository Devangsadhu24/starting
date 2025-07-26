let signInBtn = document.querySelector("#sgn");
let container = document.querySelector(".container");
let welcomeText = document.querySelector(".txt");
let p = document.querySelector("p");

signInBtn.addEventListener("click", function () {
  container.classList.toggle("switch");
  // Change the welcome text on sign-in button click
  if (container.classList.contains("switch")) {
    welcomeText.textContent = "Hello friends!";
    p.textContent = "sign in to your account with your Email and password.";
  } else {
    welcomeText.textContent = "Welcome Back!";
  }
});


// Validation for sign-in form
const signInForm = document.querySelector(".signin-form form");
const password1Input = document.querySelector("#signin-password");
const passwordCInput = document.querySelector("#signin-password-confirm");

function validatePassword(password) {
  // At least 8 characters, one special char, one digit, one letter, one capital letter
  const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
  return pattern.test(password);
}

signInForm.addEventListener("submit", function (event) {
  const password1 = password1Input.value;
  const passwordC = passwordCInput.value;

  if (!validatePassword(password1)) {
    alert(
      "Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, one digit, and one special character."
    );
    event.preventDefault();
    return;
  }

  if (password1 !== passwordC) {
    alert("Passwords do not match. Please try again.");
    event.preventDefault();
    return;
  }
});
signInBtn.addEventListener("click",function () {
  const today = new Date();
  const year = today.getFullYear() - 18;
  const month = (today.getMonth() + 1).toString().padStart(2, "0");
  const day = today.getDate().toString().padStart(2, "0");
  document.getElementById("date").max = `${year}-${month}-${day}`;
});

function validateDOB() {
  const dob = new Date(document.getElementById("date").value);
  const today = new Date();
  const age = today.getFullYear() - dob.getFullYear();
  const m = today.getMonth() - dob.getMonth();

  if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
    age--;
  }

  if (age < 18) {
    alert("You must be at least 18 years old to register.");
    return false;
  }

  return true;
}
