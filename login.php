<html>
  <head>
  <title>Login Form</title>
  <link rel="stylesheet" type="text/css" href="login.css">
  </head>
  <body>
  <header>
        <h1>Tour Guide Portal</h1>
        <nav class="navbar">
          <ul>
            <li>
              <a href="index.html">Home</a>
            </li>
            <li>
              <a class="active" href="login.php">Register</a>
            </li>
          </ul>
        </nav>
      </header>
  <h1>Login</h1>
  <?php
session_start(); // Start a session

$conn = mysqli_connect("localhost", "root", "", "customers");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password']; 
  
  $sql = "SELECT * FROM users WHERE email=? AND BINARY password=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ss", $email, $password);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $_SESSION['email'] = $email; // Store the email in a session variable
    $_SESSION['loggedin'] = true; // Set the loggedin flag to true
    header("Location: location.php");
  } else {
    echo '<div class="error">Invalid email or password</div>';
  }
  mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
<div class="container">
  <form method="post" onsubmit="return validateForm()">
    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Email">
      <span id="email-error" class="error"></span>
    </div>
    <div>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Password">
      <span id="password-error" class="error"></span>
    </div>
    <input type="submit" value="Login">
  </form>
</div>
<p class="sign-up">Don't have an account? <a href="registration.php">Sign up here</a></p>
<script>
function validateForm() {
  let email = document.getElementById("email").value.trim();
  let password = document.getElementById("password").value.trim();

  let emailError = document.getElementById("email-error");
  let passwordError = document.getElementById("password-error");

  if (email === "" && password === "") {
    emailError.innerHTML = "Email is required";
    passwordError.innerHTML = "Password is required";
    return false;
  }

  if (email === "") {
    emailError.innerHTML = "Email is required";
    return false;
  } else {
    emailError.innerHTML = "";
  }

  if (password === "") {
    passwordError.innerHTML = "Password is required";
    return false;
  }else {
    passwordError.innerHTML = "";
  }

  return true;
}
</script>
<footer id="footer">
<p>&copy; 2023 My Website. All rights reserved.</p>
</footer>
  </body>
</html>
