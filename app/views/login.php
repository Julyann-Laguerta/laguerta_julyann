<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Management System - Login Portal</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e0f7e9, #f9f9fb);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 40px 30px;
      width: 380px;
      text-align: center;
      border: 1px solid #bde0c9;
      position: relative;
      z-index: 10;
      animation: fadeIn 1s ease;
      overflow: hidden;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    .logo {
      font-size: 45px;
      color: #2e7d32;
      margin-bottom: 10px;
    }

    h2 {
      margin: 0;
      font-size: 20px;
      color: #388e3c;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .subtitle {
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
      box-sizing: border-box;
    }

    .form-group input:focus {
      border-color: #2e7d32;
      box-shadow: 0 0 6px rgba(46, 125, 50, 0.3);
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
      background: linear-gradient(to right, #2e7d32, #66bb6a);
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

    .toggle-link {
      margin-top: 15px;
      font-size: 13px;
      color: #2e7d32;
      cursor: pointer;
      text-decoration: underline;
      display: inline-block;
      transition: color 0.3s;
    }

    .toggle-link:hover {
      color: #1b5e20;
    }

    /* Toggle transitions */
    .hidden {
      opacity: 0;
      transform: translateY(20px);
      pointer-events: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      transition: all 0.5s ease;
    }

    .active {
      opacity: 1;
      transform: translateY(0);
      pointer-events: all;
      position: relative;
      transition: all 0.5s ease;
    }

    p.footer {
      margin-top: 15px;
      font-size: 14px;
    }

    p.footer a {
      color: #2e7d32;
      font-weight: bold;
      text-decoration: none;
    }

    p.footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="logo">🎓</div>
    <h2>Student Management System</h2>
    <p class="subtitle">Login Portal</p>

    <!-- Admin Login -->
    <form id="adminForm" class="active" action="<?= site_url('/admin_login') ?>" method="POST">
      <?php if (!empty($admin_error)) : ?>
        <p class="error"><?= $admin_error ?></p>
      <?php endif; ?>
      <div class="form-group">
        <label>Admin Username</label>
        <input type="text" name="username" placeholder="Enter admin username" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>
      </div>

      <button type="submit">Login as Admin</button>
      <div class="toggle-link" onclick="toggleForm('student')">Switch to Student Login</div>
    </form>

    <!-- Student Login -->
    <form id="studentForm" class="hidden" action="<?= site_url('/user_login') ?>" method="POST">
      <?php if (!empty($user_error)) : ?>
        <p class="error"><?= $user_error ?></p>
      <?php endif; ?>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="student@email.com" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit">Login as Student</button>

      <p class="footer">Don’t have an account? 
        <a href="register">Register here</a>
      </p>

      <div class="toggle-link" onclick="toggleForm('admin')">Switch to Admin Login</div>
    </form>
  </div>

  <script>
    const adminForm = document.getElementById('adminForm');
    const studentForm = document.getElementById('studentForm');

    function toggleForm(target) {
      if (target === 'student') {
        adminForm.classList.remove('active');
        adminForm.classList.add('hidden');
        setTimeout(() => {
          studentForm.classList.remove('hidden');
          studentForm.classList.add('active');
        }, 200);
      } else {
        studentForm.classList.remove('active');
        studentForm.classList.add('hidden');
        setTimeout(() => {
          adminForm.classList.remove('hidden');
          adminForm.classList.add('active');
        }, 200);
      }
    }
  </script>

</body>
</html>
