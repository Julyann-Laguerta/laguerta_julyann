<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: " . site_url('login'));
    exit;
}
$user = $user ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Panel 🌿</title>
<style>
/* BODY */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e8f5e9, #a5d6a7);
    margin: 0;
    padding: 0;
    color: #2e7d32;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* CONTAINER */
.container {
    background: #ffffff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 480px;
    text-align: center;
    animation: fadeIn 0.6s ease forwards;
    opacity: 0;
}

/* PROFILE IMAGE */
.profile-card img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid #66bb6a;
    object-fit: cover;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(102,187,106,0.4);
}

/* STUDENT INFO */
.profile-info p {
    margin: 8px 0;
    font-size: 15px;
    color: #2e7d32;
}

/* TABS */
.tabs {
    display: flex;
    justify-content: center;
    margin: 25px 0;
    gap: 10px;
}
.tab-btn {
    background: #a5d6a7;
    color: #1b5e20;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    border: none;
    transition: 0.3s;
}
.tab-btn.active {
    background: #43a047;
    color: white;
    transform: scale(1.05);
    box-shadow: 0 3px 10px rgba(67,160,71,0.4);
}

/* TAB CONTENT */
.tab-content {
    margin-bottom: 12px;
    margin-top: 15px;
    display: none;
    background: #f1f8e9;
    border-radius: 12px;
    padding: 20px;
    text-align: left;
    animation: fadeIn 0.5s ease forwards;
}
.tab-content.active {
    display: block;
}

/* BUTTONS */
.edit-btn, .logout-btn {
    background: #43a047;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin: 10px 8px 0 8px;
    font-weight: bold;
    transition: transform 0.2s, background 0.3s;
}
.edit-btn:hover, .logout-btn:hover {
    background: #2e7d32;
    transform: scale(1.05);
}

/* SETTINGS FORM */
.change-password input {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #81c784;
    background: #ffffff;
    color: #2e7d32;
}
.save-btn {
    background: #43a047;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
    transition: 0.3s;
}
.save-btn:hover {
    background: #2e7d32;
}

/* ANIMATION */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>
</head>
<body>

<div class="container profile-card">
    <?php if (!empty($user['profile_pic'])): ?>
        <img src="/upload/students/<?= $user['profile_pic'] ?>" alt="Profile">
    <?php else: ?>
        <img src="/upload/default.png" alt="No Profile">
    <?php endif; ?>

    <div class="profile-info">
        <p><strong>ID:</strong> <?= htmlspecialchars($user['id'] ?? 'N/A'); ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . " " . $user['last_name'] ?? 'N/A'); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['emails'] ?? 'N/A'); ?></p>
    </div>

   

    <!-- TAB CONTENT -->
    <div id="activity" class="tab-content active">
        <p><strong>Recent Activity:</strong></p>
        <ul>
            <li>Logged in today</li>
            <li>Updated profile</li>
        </ul>
    </div>

    <a href="<?= site_url('user_update/' . ($user['id'] ?? 0)); ?>">
        <button class="edit-btn">Edit Profile</button>
    </a>
    <a href="<?= site_url('logout'); ?>">
        <button class="logout-btn">Logout</button>
    </a>
</div>

<script>
function showTab(tabId, event) {
    const tabs = document.querySelectorAll('.tab-content');
    const btns = document.querySelectorAll('.tab-btn');
    tabs.forEach(t => t.classList.remove('active'));
    btns.forEach(b => b.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.currentTarget.classList.add('active');
}
</script>

</body>
</html>
