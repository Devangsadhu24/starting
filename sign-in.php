<?php

$server = 'localhost';
$username = 'root';
$dbpassword = '';
$dbname = "devang";
$conn = new mysqli($server, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['form_type'])) {
    if ($_POST['form_type'] === 'signup') {
      if (isset($_POST['name'], $_POST['mobile'], $_POST['date'], $_POST['email'], $_POST['password'], $_POST['address'], $_POST['city'])) {
        $name = trim($_POST['name']);
        $mobile = trim($_POST['mobile']);
        $DOB = trim($_POST['date']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $address = trim($_POST['address']);




        $dob = $_POST['date'];
        $dobDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dobDate)->y;

        if ($age < 18) {
          echo "<script>alert('You must be at least 18 years old to register.')</script>";
        } else {


          $stmt = $conn->prepare("INSERT INTO user (`name`, `mobile`,`DOB`, `email`, `password`, `address`) VALUES (?, ?, ?, ?, ?, ?)");
          if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
          }
          $stmt->bind_param("sissss", $name, $mobile, $DOB, $email, $password, $address);

          if ($stmt->execute()) {
            echo "<script>alert('✅ Sign-up successful.')</script>";
          } else {
            echo "<script>alert('❌ Error during sign-up: " . $stmt->error . "')</script>";
          }
          $stmt->close();
        }
      } elseif ($_POST['form_type'] === 'signin') {
        if (isset($_POST['Email'], $_POST['password1'], $_POST['passwordC'])) {

          $Email = trim($_POST['Email']);
          $password1 = $_POST['password1'];
          $passwordC = $_POST['passwordC'];

          if ($password1 !== $passwordC) {
            echo "<script>alert('❌ Passwords do not match. Please try again.')</script>";
          } else {
            // Prepare statement to check if user exists with given email and password
            $stmt1 = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
            if ($stmt1 === false) {
              die("Prepare failed: " . $conn->error);
            }
            $stmt1->bind_param("ss", $Email, $password1);
            echo $Email;
            echo $password1;

            $stmt1->execute();
            $result = $stmt1->get_result();

            if ($result->num_rows === 1) {
              echo "<script>alert('✅ Sign-in successful.')</script>";
            } else {
              echo "<script>alert('❌ No user found with the provided email and password.')</script>";
            }
            $stmt1->close();
          }
        }
      }
    }
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Sign In / Sign Up Page</title>
  <link rel="icon" type="image/png" href="assets\logo.png" />
  <link rel="stylesheet" href="signin.css?v=1" />
</head>

<body>
  <nav>
    <div class="container">
      <img src="assets/gradient-abstract-wireframe-background_23-2149009903.png" alt="Background Image">
      <div class="left">
        <button type="button" id="sgn">Sign in</button>
        <h2 class="txt">Welcome Back!</h2>
        <p>To keep connected with us, login with your personal information.</p>
      </div>

      <div class="box">
        <!-- Sign Up -->
        <div class="signup-form">
          <h2>Create your account</h2>
          <form action="" method="post">
            <input type="hidden" name="form_type" value="signup" />
            <input type="text" name="name" placeholder="Username" required /><br />
            <input type="tel" name="mobile" patttern="[0-9]{10}" maxlength="10" placeholder="Mobile-no" required><br />
            <input type="date" name="date" placeholder="enter your brith date" required>

            <input type="email" name="email" placeholder="Email" required /><br />

            <input type="password" name="password" id="signup-password" placeholder="Choose strong password"
              pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}" maxlength="8"
              title="Must contain at least one uppercase, one lowercase, one number, one special character and be at least 8 characters long"
              required><br />

            <select name="city">
              <option value="" disabled selected>Select Your City</option>
              <option>Kadi</option>
              <option>Ahmeadabad</option>
              <option>Patan</option>
              <option>Gandhinagar</option>
              <option>Kalol</option>
              <option>Surat</option>
              <option>Morbi</option>
              <option>Bhavnagar</option>
              <option>Vadodara</option>
              <option>Amreli</option>
              <option>Vadnagar</option>
              <option>Junagadh</option>
              <option>bharuch</option>
            </select>
            <input type="textarea" name="address" placeholder="Full-Address" /> <br />

            <h3 id="foot">Continue with below:</h3>
            <div class="logos">
              <img src="assets/ODLS.png" alt="ODLS Logo">
              <img src="assets/facebook.png" alt="Facebook Logo">
              <img src="assets/4202105_microsoft_logo_social_social media_icon.png" alt="Microsoft Logo">
              <img src="assets/6033716.png" alt="Logo">
            </div>
            <button type="submit">Sign Up</button>
          </form>
        </div>

        <!-- Sign In -->
        <div class="signin-form">
          <h2>Sign in to your account</h2>
          <img src="assets/1077012.png">
          <form action="index.html" method="post" type="submit">
            <input type="hidden" name="form_type" value="signin" />
            <input type="email" name="Email" id="signin-email" placeholder="Email" required /><br />

            <input type="password" name="password1" id="signin-password" placeholder="Password"
              pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}" maxlength="8"
              title="Must contain at least one uppercase, one lowercase, one number, one special character and be at least 8 characters long"
              required /><br />
            <input type="password" name="passwordC" id="signin-password-confirm" placeholder="Confirm Password"
              pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}" maxlength="8"
              title="Must contain at least one uppercase, one lowercase, one number, one special character and be at least 8 characters long"
              required /><br />
            <button type="submit">Sign In</button>
          </form>
        </div>
      </div>
    </div>
  </nav>
  <script src="signin.js">
  </script>
</body>

</html>