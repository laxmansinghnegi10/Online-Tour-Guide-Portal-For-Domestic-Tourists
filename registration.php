<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <link rel="stylesheet" type="text/css" href="registration.css">
  <style>
    .error {
      color: red;
      font-family: 'Times New Roman', Times, serif;
    }
  </style>
</head>
<body>
  <!-- Header section -->
  <header>
    <h1>Tour Guide Portal</h1>
    <nav class="navbar">
      <ul>
        <li>
          <a href="index.html">Home</a>
        </li>
        <li>
          <a class="active" href="registration.php">Register</a>
        </li>
      </ul>
    </nav>
  </header>
  <!-- End of header section -->
  
  <center><h2>Create Account</h2></center>
 
  <?php
  // Start session and connect to database
  session_start();
  $conn = mysqli_connect("localhost", "root", "", "customers");
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Initialize error variables and form data variables
  $fullname_error = $number_error = $email_error = $password_error = $confirmpassword_error = "";
  $fullname = $number = $email = $password = $confirmpassword = "";

  // Check if form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get form data
      $fullname = trim($_POST['fullname']);
      $number = trim($_POST['number']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
      $confirmpassword = trim($_POST['confirmpassword']);

      // Validate form data
      if (empty($fullname)) {
          $fullname_error = "Full name is required.";
      } elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
          $fullname_error = "Only letters and white space allowed.";
      } elseif (strlen($fullname) > 50) {
          $fullname_error = "Full name cannot exceed 50 characters.";
      }

      if (empty($number)) {
          $number_error = "Phone number is required.";
      } elseif (!preg_match("/^[0-9]{10}$/", $number)) {
          $number_error = "Phone number must be 10 digit number.";
      }

      if (empty($email)) {
          $email_error = "Email is required.";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $email_error = "Invalid email format.";
      } else {
          // Check if email already exists
          $sql = "SELECT * FROM users WHERE email=?";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          if (mysqli_stmt_num_rows($stmt) > 0) {
              $email_error = "Email already exists.";
          }
          mysqli_stmt_close($stmt);
      }

      if (empty($password)) {
          $password_error = "Password is required.";
      } elseif (strlen($password) < 8) {
          $password_error = "Password must be at least 8 characters.";
      } elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
          $password_error = "Password must contain at least one uppercase letter, one lowercase letter, and one number.";  
      }  
      
      if (empty($confirmpassword)) {
          $confirmpassword_error = "Please confirm password.";
      } elseif ($password != $confirmpassword) {
          $confirmpassword_error = "Passwords do not match.";
      }
        
        // If there are no errors, register the user
        if (empty($fullname_error) && empty($number_error) && empty($email_error) && empty($password_error) && empty($confirmpassword_error)) {
            // Insert user into database
            $sql = "INSERT INTO users (fullname, number, email, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $fullname, $number, $email, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    
            header("Location: location.php");
            exit();
    }
  }
    ?>

    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-control">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
                <span class="error"><?php echo $fullname_error; ?></span><br><br>
            </div>
            <div class="form-control">
                <label for="number">Phone Number:</label>
                <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($number); ?>">
                <span class="error"><?php echo $number_error; ?></span><br><br>
            </div>
            <div class="form-control">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_error; ?></span><br><br>
            </div>
            <div class="form-control">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>">
                <span class="error"><?php echo $password_error; ?></span><br><br>
            </div>
            <div class="form-control">
                <label for="confirmpassword">Confirm Password:</label>
                <input type="password" id="confirmpassword" name="confirmpassword">
                <span class="error"><?php echo $confirmpassword_error; ?></span><br><br>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
    <p class="log-in">Already have an account? <a href="login.php">login here</a></p>
    <footer id="footer">
           <p>&copy; 2023 My Website. All rights reserved.</p>
    </footer>
    </body>
    </html>