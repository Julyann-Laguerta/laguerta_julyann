<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Student</title>
<style>
  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f3f4f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .modal {
    background: white;
    width: 520px;
    border-radius: 14px;
    padding: 28px 32px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    border: 1px solid #eaeaea;
    animation: fadeIn 0.4s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  h2 {
    margin-bottom: 20px;
    font-weight: 600;
    font-size: 20px;
    color: #2d2d2d;
  }

  .upload-section {
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 20px;
  }

  .avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 2px solid #e0e0e0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fafafa;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    overflow: hidden;
  }

  .avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  .avatar svg {
    width: 50px;
    height: 50px;
    stroke: #888;
  }

  .file-upload {
    flex: 1;
    border: 2px dashed #d1d1d1;
    border-radius: 10px;
    padding: 18px;
    text-align: center;
    background: #fcfcfc;
    transition: border-color 0.3s, background 0.3s;
  }

  .file-upload:hover {
    border-color: #ff6584;
    background: #fff7fa;
  }

  .file-upload input {
    display: none;
  }

  .file-upload label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #444;
    cursor: pointer;
    margin-bottom: 10px;
  }

  .choose-btn {
    display: inline-block;
    background: #f1f1f1;
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 500;
    color: #333;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: background 0.3s;
  }

  .choose-btn:hover {
    background: #eaeaea;
  }

  .file-upload small {
    display: block;
    font-size: 12px;
    color: #777;
    margin-top: 6px;
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
    color: #444;
    font-size: 14px;
  }

  input[type="text"],
  input[type="email"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
    background: #fafafa;
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  input[type="text"]:focus,
  input[type="email"]:focus {
    border-color: #ff6584;
    box-shadow: 0 0 6px rgba(255,101,132,0.4);
    background: #fff;
  }

  .actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 15px;
  }

  .btn-cancel {
    background: #f1f1f1;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #555;
    transition: background 0.3s;
  }

  .btn-cancel:hover {
    background: #e0e0e0;
  }

  .btn-submit {
    background: linear-gradient(45deg, #ff6584, #ffc371);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    color: white;
    transition: transform 0.2s, box-shadow 0.3s;
    box-shadow: 0 4px 10px rgba(255,101,132,0.3);
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(255,101,132,0.4);
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
  <h2>Edit Student Information</h2>

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
          <!-- Professional SVG Icon -->
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M5.121 17.804A9 9 0 1118.364 6.636 
                     9 9 0 015.121 17.804zM15 11a3 3 0 11-6 0 
                     3 3 0 016 0z" />
          </svg>
        <?php endif; ?>
      </div>
      <div class="file-upload">
        <label for="profile_pic">Drag and drop an image here</label>
        <label class="choose-btn" for="profile_pic">Choose File</label>
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
  const fileInput = document.getElementById("profile_pic");
  const avatar = document.querySelector(".avatar");

  fileInput.addEventListener("change", function() {
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        // remove default svg if any
        avatar.innerHTML = `<img src="${e.target.result}" alt="Profile">`;
      }
      reader.readAsDataURL(fileInput.files[0]);
    }
  });
</script>


</body>
</html>
