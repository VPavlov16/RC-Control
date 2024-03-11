<?php  
require "nav.php";
?>

<!DOCTYPE html>
<html lang="bg" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login Form</title> 
    <link rel="stylesheet" href="../CSS/reg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <style>
      .wrongInfo{
        color: red;
        font-size: 20px;
        text-align: center;
        justify-content: center;  
        display: <?php echo $_SESSION['info']; ?>;
      }
      .wrongEmail{
        color: red;
        font-size: 20px;
        text-align: center;
        justify-content: center; 
        display: <?php echo $_SESSION['emInfo']; ?>;
      }
    </style>
  </head>
  <body>
    <!-- log -->
    <div id="log" class="container">
      <div class="wrapper">
        <div class="title"><span>Login</span></div>
        <form action="../PHP/logController.php" method="POST">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="email" name="email" placeholder="Email" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="pass" id="passw" placeholder="Password" required>
          </div>
          <div class="shpass pass">
            <i class="far fa-eye-slash" id="icon" style="color: #0197f6; margin-right: 5px;"></i>
            <input id="check" type="checkbox" onclick="showPass()">
            <label for="check">Show password</label>
          </div>
          <div class="remember">
              <i class="far fa-save fa-lg" id="iconka" style="color: #0197f6; margin-right: 5px;"></i>
              <input id="rem"  name="remember_me" type="checkbox">
              <label for="rem">Remember me</label>
          </div>
          <h5 class="wrongInfo" id="wrongInfo">Wrong password/email</h5>
          <div class="row button">
            <input type="submit" value="Login">
          </div>
          <div class="signup-link"><a href="forgotpass.php">Forgot password?</a></div>
          <div class="signup-link">Not a member? <a onclick="reg()">Signup now</a></div>
        </form>
      </div>
    </div>
    <!-- reg -->
    <div id="reg" class="container">
      <div class="wrapper">
        <div class="title"><span>Register</span></div>
        <form action="../PHP/regController.php" method="POST">
          <div class="row">
            <i class="fas fa-user" id="icon"></i>
            <input type="email" name="email" placeholder="Email" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="passw2" id="passw2" min=8 max=30 placeholder="Password" required>
          </div>
          <h5 class="wrongEmail" id="wrongEmail">Email is already registered</h5>
          <div class="shpass pass">
            <i class="far fa-eye-slash" id="icon2" style="color: #0197f6; margin-right: 5px;"></i>
            <input id="check2" type="checkbox" onclick="showPass()">
            <label for="check2">Show password</label>
          </div>
          <div class="row button">
            <input type="submit"  value="Register">
          </div>
          <div class="signup-link">Already a member? <a onclick="log()">Login now</a></div>
        </form>
      </div>
    </div>
    
    <script>
      function reg(){
        document.getElementById("log").style.display = "none";
        document.getElementById("reg").style.display = "flex";
      }

      function log(){
        document.getElementById("reg").style.display = "none";
        document.getElementById("log").style.display = "flex";
      }

      function showPass() {
        let x = document.getElementById("passw");
        let y = document.getElementById("passw2");
        let icon = document.getElementById("icon");
        let icon2 = document.getElementById("icon2");
        if (x.type === "password") {
          x.type = "text";
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
          
        } else {
          x.type = "password";
          icon.classList.remove("fa-eye");
          icon.classList.add("fa-eye-slash");
          
        }
        if (y.type === "password") {
          y.type = "text";
          icon2.classList.remove("fa-eye-slash");
          icon2.classList.add("fa-eye");
        } else {
          y.type = "password";
          icon2.classList.remove("fa-eye");
          icon2.classList.add("fa-eye-slash");
        }
              


      }

    </script>
    
  </body>
</html>