<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Formulaire de connexion</title>
    <style>
      label {
        display: block;
        margin-bottom: 10px;
      }
    </style>
  </head>
  <body>
    <img src="logo.png" alt="Logo">
    <form  id='login-account' action="" method="post">
      <h2>Login</h2>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <input type="submit" value="LogIn">
      <input type="hidden" name="csrf_token" value="<?php if (!empty($_POST["username"]) 
      && !empty($_POST["password"]) &&  isset($_SESSION['token'])) {
        echo $_SESSION['token'];}?>" >
      <input type="reset" value="Reset">
      <input type="button" id="create-account-button" value="Sign Up">
      
    </form>
    <script>
      var createAccountButton = document.getElementById('create-account-button');
     
      createAccountButton.addEventListener('click', function() {
        document.location.href='http://localhost/create_account.php';
      });


    </script>
 
  <?php
  if (isset($_GET['action']) && $_GET['action'] == 'New_account') {
    echo "New account created successfully";
}
  if (!empty($_POST["username"]) && !empty($_POST["password"])) {
  if (!isset($_SESSION['token'])) {  
    die("No CSRF Token");
  }
  if (!empty($_POST['csrf_token'])) {
    if (empty($_POST['csrf_token']) && $_SESSION['token'] !== $_POST['csrf_token']) {
      die("Invalid CSRF Token");
    }
  }

  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "users_db";
  
  // Connexion à la base de données
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  
  // Vérification de la connexion
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
    // Récupération des données du formulaire
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "SELECT pw FROM users WHERE un = ?");

    // Bind the parameters to the query
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      $hash = mysqli_fetch_assoc($result)["pw"];

      // Vérification du mot de passe
      if (password_verify($password, $hash)) {
        header("Location: welcome.php");
        exit();
      } else {
        echo "Incorrect Password";
      }
    } else {
      echo "Incorrect Username or  Password";
    }

    // Fermeture de la connexion
    mysqli_close($conn);
    
  }
  ?>
  </body>  
</html>
