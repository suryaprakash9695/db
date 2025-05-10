<?php
session_start();
require_once('./config.php'); // Ensure your database connection is here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the form input
    $email = trim($_POST['email']);
    $u_name = trim($_POST['u_name']);
    $pass = $_POST['password'];
    $occupation = $_POST['occupation'];
    $uid = uniqid($u_name); // Generate a unique user ID
    
    $checkEmail = $con->prepare("SELECT * FROM `wecare_signup` WHERE email=?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $emailResult = $checkEmail->get_result();

    if ($emailResult->num_rows > 0) {
        echo "<h3 style='color:red; text-align:center; margin-top:20px;'>Email already exists. 
              <a href='login.php'>Go back to Login Page</a></h3>";
        exit();
    }
    
    $checkUsername = $con->prepare("SELECT * FROM `wecare_signup` WHERE username=?");
    $checkUsername->bind_param("s", $u_name);
    $checkUsername->execute();
    $usernameResult = $checkUsername->get_result();

    if ($usernameResult->num_rows > 0) {
        echo "<h3 style='color:red; text-align:center; margin-top:20px;'>Username already exists. 
              <a href='login.php'>Go back to Login Page</a></h3>";
        exit();
    }

    // Insert the user data into the database
    $sql = $con->prepare("INSERT INTO `wecare_signup` (`userid`, `username`, `password`, `email`, `role`) 
                          VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $uid, $u_name, $pass, $email, $occupation);

    if ($sql->execute()) {
        echo "<script type='text/javascript'>
                alert('Signup Successful! You can login now.');
                window.location.href = 'login.php'; // Redirect to login page
              </script>";
    } else {
        echo "<h3 style='color:red; text-align:center; margin-top:20px;'>ERROR: " . $con->error . "</h3>";
    }

    $sql->close();
    $con->close();
}

// Set page title and specific CSS
$page_title = "Sign Up";
$page_specific_css = "styles/login.css";

// Include header
include 'includes/header.php';
include 'navbar.php';
?>

<section class="image1 login-section" id="image1-m" style="padding:0px 10%;">
    <div class="container login">
        <div class="col-12 col-lg-6">
            <img src="assets/images/login.jpg" alt="log-in">
        </div>
        <div class="col-12 col-lg-6">
            <div class="text-wrapper align-items-right">
                <h3 class="mbr-section-title mbr-fonts-style display-5">
                    <strong style="font-family: 'Dancing Script', cursive; ">Patient Sign up</strong>
                </h3>
                <div>
                    <form method="POST" action="signup.php" id="signupForm">
                        <div class="form-floating form-field-login">
                            <label for="u_name">Name</label>
                            <input type="text" class="form-control" id="u_name" name="u_name" required>
                        </div>
                        <div class="form-floating form-field-login">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-floating form-field-login">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Two separate buttons for Patient and Doctor Signup -->
                        <button type="submit" class="btn btn-primary" name="occupation" value="patient">Sign Up As Patient</button>
                        OR
                        <button type="submit" class="btn btn-primary" name="occupation" value="doctor">Sign Up As Doctor</button>

                        <div class="form-floating form-field-login" style="text-align:center; margin:15px;">
                            <a href="login.php">Already a member? Click here to Login.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
