<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Management System - Login</title>
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

    .login-container {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 30px 25px;
      width: 360px;
      text-align: center;
      border: 1px solid #f8d7e2;
    }

    .login-container .logo {
      font-size: 40px;
      color: #ff4da6;
      margin-bottom: 10px;
    }

    .login-container h2 {
      margin: 0;
      font-size: 20px;
      color: #d63384;
      font-weight: 600;
    }

    .login-container p.subtitle {
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
      margin-bottom: 6px;
      display: block;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      font-size: 14px;
      transition: 0.3s;
      box-sizing: border-box; /* ✅ fixes alignment */
      display: block;
    }

    .form-group input:focus {
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

    .demo-box {
      margin-top: 20px;
      font-size: 14px;
      background: #fff0f5;
      padding: 12px;
      border-radius: 8px;
      color: #444;
      text-align: left;
    }

    .demo-box strong {
      display: block;
      margin-bottom: 4px;
      color: #2f5d31;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo">🎓</div>
    <h2>Student Management System</h2>
    <p class="subtitle">Sign in to manage student records</p>

    <form action="<?= site_url('login') ?>" method="POST">
      <?php if (!empty($error)) : ?>
        <p class="error"><?= $error ?></p>
      <?php endif; ?>

      <div class="form-group">
        <label>Email</label>
        <input type="text" name="username" placeholder="admin@school.edu" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit">Sign In</button>
    </form>

    <div class="demo-box">
      <strong>Demo Credentials:</strong>
      UserName: juljul <br>
      Password: 1234567890
    </div>
  </div>
</body>
</html>
