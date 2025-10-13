<?php
// Protect page: only logged in users can access
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: " . site_url('login'));
    exit;
}

// Fetch current user info
$user_id = $_SESSION['user_id'];
$query = $this->db->get_where('students', ['id' => $user_id]);
$user = $query->row_array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f7f4;
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Header */
    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: linear-gradient(to right, #2f5d31, #4a7a42);
      padding: 16px 24px;
      color: white;
      font-weight: bold;
    }
    .header-bar a {
      color: white;
      text-decoration: none;
      background: #3f6f3f;
      padding: 8px 16px;
      border-radius: 6px;
      transition: 0.3s;
    }
    .header-bar a:hover {
      background: #365f36;
    }

    /* Profile Container */
    .profile-container {
      width: 90%;
      max-width: 700px;
      margin: 40px auto;
      background: #d6e8d2;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .profile-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .profile-header img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #4a7a42;
    }

    h2 {
      margin-top: 10px;
      color: #2f5d31;
    }

    /* Profile Info Form */
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: bold;
      color: #2f5d31;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"] {
      padding: 10px;
      border: 1px solid #9bbf9b;
      border-radius: 6px;
      font-size: 14px;
      width: 100%;
    }

    button {
      background: #2f5d31;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #3a703c;
    }

    .success {
      background-color: #bde7b8;
      color: #2f5d31;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="header-bar">
    <div>👋 Welcome, <?= htmlspecialchars($_SESSION['username']); ?></div>
    <div><a href="<?= site_url('logout'); ?>">Logout</a></div>
  </div>

  <div class="profile-container">
    <div class="profile-header">
      <img src="<?= !empty($user['profile_pic']) ? '/upload/students/'.$user['profile_pic'] : '/upload/default.png' ?>" alt="Profile Picture">
      <h2><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
    </div>

    <?php if (isset($_SESSION['update_success'])): ?>
      <div class="success"><?= $_SESSION['update_success']; unset($_SESSION['update_success']); ?></div>
    <?php endif; ?>

    <form action="<?= site_url('user/update_profile'); ?>" method="POST" enctype="multipart/form-data">
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>" required>

      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['emails']); ?>" required>

      <label for="profile_pic">Profile Picture:</label>
      <input type="file" id="profile_pic" name="profile_pic">

      <button type="submit">💾 Save Changes</button>
    </form>
  </div>

</body>
</html>
