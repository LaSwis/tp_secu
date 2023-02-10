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
    <title>Create account</title>
    <style>
      label {
        display: block;
        margin-bottom: 10px;
      }
      </style>
  </head>
  <body>
      <img src="logo.png" alt="Logo">
      <form  id='create_account' action="" method="post">
      <h2>Create new account</h2>
      <label for="new_username">Username:</label>
      <input type="text" id="new_username" name="new_username" required>
      <label for="new_password">Password:</label>
      <input type="password" id="new_password" name="new_password" required>
      <input type="submit" id="create" value="Create">
      <input type="hidden" name="csrf_token" value="<?php if (!empty($_POST["new_username"]) && !empty($_POST["new_password"])
       &&  isset($_SESSION['token'])) {
        echo $_SESSION['token'];}?>" >
      <input type="reset" value="Reset">
      <input type="button" id="cancel" value="Cancel">
      
      </form> 
      <script>
      const cancelButton = document.getElementById("cancel");

      cancelButton.addEventListener('click',function(){
        document.location.href='http://localhost/login.php';
      })
    </script> 
    <?php
      if (!empty($_POST["new_username"]) && !empty($_POST["new_password"])) {

      if (!isset($_SESSION['token'])) {
        die("No CSRF Token");
      }
      if (!empty($_POST['csrf_token']) && $_SESSION['token'] !== $_POST['csrf_token']) {
        die("Invalid CSRF");
      }


      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "users_db";

      // Connexion à la base de données
      $conn = mysqli_connect($servername, $username, $password, $dbname);

      // Vérification de la connexion
      if (!$conn) {
        die("<p style='color:red;'> Connection failed: " . mysqli_connect_error());
      }
      if (!empty($_POST["new_username"]) && !empty($_POST["new_password"])) {
        $new_username = htmlspecialchars($_POST["new_username"]);
        $new_password = htmlspecialchars($_POST["new_password"]);

        if (!is_string($new_username) || strlen($new_username) < 5) {
          die("<p style='color:red;'> Invalid username: must be  at least 5 characters. </p>");
        }

        if (!is_string($new_password) || strlen($new_password) < 8) {
          die("<p style='color:red;'> Invalid password: must be at least 8 characters.");
        }



      $uppercase = preg_match('@[A-Z]@', $new_password);
      $lowercase = preg_match('@[a-z]@', $new_password);
      $number = preg_match('@[0-9]@', $new_password);

      if (!$uppercase || !$lowercase || !$number) {
        die("<p style='color:red;'>  Invalid password: must contain a mix of uppercase and lowercase letters, numbers, and special characters.");
      }

      // Hash the password using password_hash function
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

      $stmt = mysqli_prepare($conn, "SELECT un FROM users WHERE un= ?");

      // Bind the parameters to the query
      mysqli_stmt_bind_param($stmt, "s", $new_username);

      // Execute the query
      mysqli_stmt_execute($stmt);

      // Get the result
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        die("<p style='color:red;'>  Invalid Username: already taken");
      }
      // Prepare the SQL statement
      $stmt = mysqli_prepare($conn, "INSERT INTO users (un, pw) VALUES (?, ?)");

      // Bind the parameters to the query
      mysqli_stmt_bind_param($stmt, "ss", $new_username, $hashed_password);


      if (mysqli_stmt_execute($stmt)) {
        echo "New account created successfully";
        header("Location: login.php?action=New_account");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          exit();
      }
    }
    mysqli_close($conn);
  }
?> 
</body>
</html>
