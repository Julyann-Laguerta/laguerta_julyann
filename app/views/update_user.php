<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user data is passed
$student = $student ?? [];
$errors  = $errors ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>🌿 Update Profile</title>
<style>
  body {
    font-family: "Poppins", sans-serif;
    background: #f0fdf4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .modal {
    background: white;
    width: 520px;
    border-radius: 12px;
    padding: 25px 30px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    animation: fadeIn 0.4s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }

  h2 {
    margin-bottom: 20px;
    font-weight: 600;
    font-size: 20px;
    color: #2e7d32;
    text-align: center;
  }

  .error-list {
    background: #ffebee;
    border-left: 5px solid #e57373;
    padding: 10px 15px;
    border-radius: 10px;
    color: #c62828;
    font-size: 14px;
    margin-bottom: 20px;
  }

  label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #2e7d32;
    font-size: 14px;
  }

  input[type="text"],
  input[type="email"],
  input[type="password"],
  input[type="file"] {
    width: 96%;
    padding: 10px 12px;
    border: 1px solid #c8e6c9;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    margin-bottom: 15px;
    transition: border-color 0.3s;
    background-color: #f9fff9;
  }

  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #43a047;
    box-shadow: 0 0 4px rgba(67,160,71,0.4);
  }

  .profile-section {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
  }

  .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 2px solid #b2dfdb;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #e8f5e9;
    overflow: hidden;
    color: #4caf50;
    font-size: 28px;
    position: relative;
  }

  .avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  .file-upload {
    flex: 1;
    border: 2px dashed #a5d6a7;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s;
  }

  .file-upload:hover {
    border-color: #388e3c;
  }

  .file-upload input {
    display: none;
  }

  .file-upload label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #2e7d32;
    cursor: pointer;
  }

  .file-upload small {
    display: block;
    font-size: 12px;
    color: #4caf50;
    margin-top: 4px;
  }

  .actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
  }

  .btn-submit {
    background: linear-gradient(45deg, #2e7d32, #66bb6a);
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: white;
    transition: transform 0.2s, opacity 0.3s;
  }

  .btn-submit:hover {
    transform: scale(1.05);
    opacity: 0.9;
  }

  .back-link {
    display: inline-block;
    background-color: #f5f5f5;
    color: #2e7d32;
    font-weight: bold;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
  }

  .back-link:hover {
    background-color: #81c784;
    color: white;
    transform: scale(1.05);
    box-shadow: 0 5px 10px rgba(0,0,0,0.15);
  }
</style>
</head>
<body>

<div class="modal">
  <h2>Update My Profile</h2>

  <?php if (!empty($errors)): ?>
    <div class="error-list">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?= site_url('/user_update/' . $student['id']); ?>" method="POST" enctype="multipart/form-data">

    <!-- Profile Picture Upload -->
    <div class="profile-section">
      <div class="avatar" id="avatarPreview">
        <?php if (!empty($student['profile_pic'])): ?>
          <img src="/upload/students/<?= $student['profile_pic']; ?>" alt="Profile">
        <?php else: ?>
          👤
        <?php endif; ?>
      </div>

      <div class="file-upload">
        <label for="profile_pic">Click or drag to change profile photo</label>
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
        <small>Supported: JPG, PNG, GIF • Max 5MB</small>
      </div>
    </div>

    <label for="first_name">First Name</label>
    <input type="text" name="first_name" id="first_name" 
           value="<?= htmlspecialchars($student['first_name']); ?>" 
           placeholder="Enter your first name">

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" 
           value="<?= htmlspecialchars($student['last_name']); ?>" 
           placeholder="Enter your last name">

    <label for="emails">Email</label>
    <input type="email" name="emails" id="emails" 
           value="<?= htmlspecialchars($student['emails']); ?>" 
           placeholder="Enter your email">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" 
           placeholder="Enter new password (leave blank to keep current)">

    <div class="actions">
      <a class="back-link" href="<?= site_url('user_panel'); ?>">Back</a>
      <button type="submit" class="btn-submit">Save Changes</button>
    </div>
  </form>
</div>

<script>
  const fileInput = document.getElementById("profile_pic");
  const avatar = document.getElementById("avatarPreview");

  fileInput.addEventListener("change", function() {
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        avatar.innerHTML = `<img src="${e.target.result}" alt="Profile">`;
      }
      reader.readAsDataURL(fileInput.files[0]);
    }
  });
</script>

</body>
</html>
