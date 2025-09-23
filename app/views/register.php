<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Management System - Register</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #fde2e4, #f9f9fb);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-container {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 30px 25px;
      width: 380px;
      text-align: center;
      border: 1px solid #f8d7e2;
    }

    .register-container .logo {
      font-size: 40px;
      color: #ff4da6;
      margin-bottom: 10px;
    }

    .register-container h2 {
      margin: 0;
      font-size: 20px;
      color: #d63384;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .register-container p.subtitle {
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }

    .form-group label {
      font-size: 14px;
      color: #333;
      margin-bottom: 5px;
      display: block;
    }

    input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      font-size: 14px;
      transition: 0.3s;
    }

    input:focus {
      border-color: #ff4da6;
      box-shadow: 0 0 6px rgba(255, 77, 166, 0.3);
    }

    button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      background: linear-gradient(to right, #ff4da6, #ff8fb1);
      color: #fff;
      transition: 0.3s;
    }

    button:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .error {
      color: #d9534f;
      margin: 10px 0;
      font-weight: bold;
      font-size: 14px;
    }

    p.footer {
      margin-top: 15px;
      font-size: 14px;
    }

    p.footer a {
      color: #d63384;
      font-weight: bold;
      text-decoration: none;
    }

    p.footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="logo">🎓</div>
    <h2>Register</h2>
    <p class="subtitle">Create a new student account</p>

    <form method="POST" action="/index.php/register">
      <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
      <?php endif; ?>

      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>
      </div>

      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Re-enter password" required>
      </div>

      <button type="submit">Register</button>
    </form>

    <p class="footer">Already have an account? <a href="/index.php/login">Login here</a></p>
  </div>
</body>
</html>
