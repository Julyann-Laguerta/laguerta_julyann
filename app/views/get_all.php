<?php
// 🔒 Protect page: only logged in users can access
if (!isset($_SESSION['user_id'])) {
    header("Location: " . site_url('login'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f7f4;
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Header Bar */
    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: linear-gradient(to right, #2f5d31, #4a7a42);
      padding: 16px 24px;
      color: white;
      font-weight: bold;
    }
    .header-bar .welcome {
      font-size: 18px;
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

    /* Main Container */
    .container {
      width: 95%;
      margin: 20px auto;
      background: #d6e8d2;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Top row (search + add button) */
    .top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    /* Search Box */
    .search-box {
      width: 300px;
      padding: 10px 14px;
      border: 1px solid #9bbf9b;
      border-radius: 6px;
      font-size: 14px;
      outline: none;
      background-color: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .search-box:focus {
      border-color: #2f5d31;
    }

    /* Add Button */
    .btn-add {
      background: #2f5d31;
      color: white;
      border: none;
      padding: 10px 18px;
      font-size: 14px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn-add:hover {
      background: #3a703c;
    }

    /* Table */
    .table-wrapper {
      width: 100%;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead {
      background: #4a7a42;
      color: #fff;
    }
    thead th {
      padding: 12px;
      text-align: center;
      font-weight: 600;
      font-size: 14px;
    }
    tbody td {
      padding: 12px;
      text-align: center;
      font-size: 14px;
      border-bottom: 1px solid #eee;
    }
    tbody tr:hover {
      background-color: #f0faf0;
    }

    /* Profile Images */
    td img {
      border-radius: 50%;
      object-fit: cover;
    }

    /* Action Buttons */
    .btn {
      display: inline-block;
      padding: 6px 12px;
      margin: 2px;
      font-size: 13px;
      font-weight: 500;
      text-decoration: none;
      border-radius: 6px;
      transition: 0.3s;
    }
    .btn.update {
      background: #2f5d31;
      color: #fff;
    }
    .btn.update:hover {
      background: #3a703c;
    }
    .btn.delete {
      background: #c94f4f;
      color: #fff;
    }
    .btn.delete:hover {
      background: #a33b3b;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin: 20px 0 0;
    }
    .pagination a,
    .pagination span {
      display: inline-block;
      padding: 8px 14px;
      background-color: #4a7a42;
      border-radius: 6px;
      color: white;
      font-size: 14px;
      font-weight: bold;
      text-decoration: none;
    }
    .pagination a:hover {
      background-color: #2f5d31;
    }
    .pagination .current {
      background-color: #2f5d31;
    }
  </style>
</head>
<body>

  <div class="header-bar">
    <div class="welcome">Hi! <?= htmlspecialchars($_SESSION['username']); ?></div>
    <div><a href="<?= site_url('logout'); ?>">Logout</a></div>
  </div>

  <div class="container">
    <!-- Top Row -->
    <div class="top-row">
      <input type="text" id="searchInput" class="search-box" placeholder="Search">
      <a href="<?=site_url('create')?>"><button class="btn-add">+ Add Student</button></a>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
      <table id="studentTable">
        <thead>
          <tr>
            <th>Profile Pic</th>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($students as $students): ?>
          <tr>
            <td>
              <?php if (!empty($students['profile_pic'])): ?>
                <img src="/upload/students/<?= $students['profile_pic'] ?>" alt="Profile" width="50" height="50">
              <?php else: ?>
                <img src="/upload/default.png" alt="No Profile" width="50" height="50">
              <?php endif; ?>
            </td>
            <td><?= $students['id']; ?></td>
            <td><?= $students['first_name']; ?></td>
            <td><?= $students['last_name']; ?></td>
            <td><?= $students['emails']; ?></td>
            <td class="actions">
              <a href="<?= site_url('/update/'.$students['id']); ?>" class="btn update">Update</a>
              <a href="<?= site_url('/delete/'.$students['id']); ?>" class="btn delete"
                 onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <?= isset($pagination_links) ? $pagination_links : '' ?>
    </div>
  </div>

  <script>
  let typingTimer;
  document.getElementById("searchInput").addEventListener("keyup", function() {
    clearTimeout(typingTimer);
    let keyword = this.value;

    typingTimer = setTimeout(() => {
      fetch("<?= site_url('students/search') ?>?keyword=" + keyword)
        .then(res => res.text())
        .then(data => {
          document.querySelector("#studentTable tbody").innerHTML = data;
        });
    }, 300);
  });
  </script>

</body>
</html>
