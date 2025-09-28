<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Student</title>
<style>
  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f3f7f3;
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
    color: #2d6a4f;
  }

  .upload-section {
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 20px;
  }

  .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 2px solid #b7e4c7;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    color: #40916c;
    background: #f4fdf7;
    overflow: hidden;
  }

  .avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  .file-upload {
    flex: 1;
    border: 2px dashed #95d5b2;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s;
  }

  .file-upload:hover {
    border-color: #52b788;
  }

  .file-upload input {
    display: none;
  }

  .file-upload label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #2d6a4f;
    cursor: pointer;
  }

  .file-upload small {
    display: block;
    font-size: 12px;
    color: #555;
    margin-top: 4px;
  }

  .form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 18px;
  }

  label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #1b4332;
    font-size: 14px;
  }

  input[type="text"],
  input[type="email"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
  }

  input[type="text"]:focus,
  input[type="email"]:focus {
    border-color: #52b788;
    box-shadow: 0 0 4px rgba(82,183,136,0.4);
  }

  .actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
  }

  .btn-cancel {
    background: #f5f5f5;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #444;
    transition: background 0.3s;
  }

  .btn-cancel:hover {
    background: #e5e5e5;
  }

  .btn-submit {
    background: linear-gradient(45deg, #40916c, #74c69d);
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

  .errors {
    color: red;
    font-size: 13px;
    margin-bottom: 15px;
  }
</style>
</head>
<body>

<div class="modal">
  <h2>Update Student</h2>

  <?php if (!empty($errors)): ?>
    <div class="errors">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
  <?php endif; ?>

  <form action="<?=site_url('/update/'.segment(3));?>" method="POST" enctype="multipart/form-data">

    <!-- Profile Picture Upload -->
    <div class="upload-section">
      <div class="avatar">
        <?php if (!empty($student['profile_pic'])): ?>
          <img src="/upload/students/<?=$student['profile_pic'];?>" alt="Profile">
        <?php else: ?>
          👤
        <?php endif; ?>
      </div>
      <div class="file-upload">
        <label for="profile_pic">Drag and drop an image here, or click to browse</label>
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
        <small>Supported: JPG, PNG, GIF • Max 5MB</small>
      </div>
    </div>

    <!-- First and Last Name side by side -->
    <div class="form-row">
      <div style="flex:1;">
        <label for="first_name">First Name *</label>
        <input type="text" id="first_name" name="first_name" value="<?=$student['first_name'];?>" placeholder="Enter first name">
      </div>
      <div style="flex:1;">
        <label for="last_name">Last Name *</label>
        <input type="text" id="last_name" name="last_name" value="<?=$student['last_name'];?>" placeholder="Enter last name">
      </div>
    </div>

    <!-- Email -->
    <label for="emails">Email Address *</label>
    <input type="email" id="emails" name="emails" value="<?=$student['emails'];?>" placeholder="you@example.com">

    <!-- Buttons -->
    <div class="actions">
      <button type="button" class="btn-cancel" onclick="window.location.href='<?=site_url('get_all')?>'">Cancel</button>
      <button type="submit" class="btn-submit">Update Student</button>
    </div>
  </form>
</div>

<script>
  // Preview selected image inside avatar
  const fileInput = document.getElementById("profile_pic");
  const avatar = document.querySelector(".avatar");

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
