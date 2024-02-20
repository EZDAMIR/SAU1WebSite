<?php
    $Email = "";
    $Username = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="styles.css">
  </head>

<body>
  <div class="container">
    <h1>Reset Password</h1>
    <p align="center">Write new password.</p>

    <form action="/reset-password" method="post">
      <label for="Pass">Email:</label>
      <input type="email" id="email" name="email" required>

      <button type="submit">Send Reset Link</button>
    </form>

    </div>

  </body>

</html>