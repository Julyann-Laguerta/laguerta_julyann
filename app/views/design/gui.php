<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students Management</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #1e252f;
      color: #fff;
      margin: 0;
      padding: 20px;
    }

    /* Header Section */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #2c3440;
      padding: 20px 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.4);
      margin-bottom: 30px;
    }
    .header h1 {
      font-size: 24px;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .header h1 span {
      background: #facc15;
      color: #000;
      padding: 10px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-add {
      background: #facc15;
      color: #000;
      font-weight: bold;
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.3s;
    }
    .btn-add:hover {
      background: #ffde4d;
    }

    /* Search */
    .search-container {
      margin-bottom: 20px;
      text-align: right;
    }
    .search-box {
      padding: 10px 14px;
      border-radius: 8px;
      border: none;
      width: 250px;
      background: #2c3440;
      color: #fff;
    }
    .search-box:focus {
      outline: 2px solid #facc15;
    }

    /* Table Section */
    .table-wrapper {
      background: #2c3440;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }

    .table-header {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #facc15;
    }
    .table-subtitle {
      font-size: 14px;
      color: #aaa;
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }
    table thead {
      background: #3a4452;
      color: #facc15;
      font-weight: bold;
    }
    table th, table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #3a4452;
    }
    table tr:hover {
      background: rgba(250, 204, 21, 0.1);
    }

    /* Action Buttons */
    .btn {
      padding: 6px 14px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 13px;
      margin: 0 2px;
      transition: 0.2s;
    }
    .btn.edit {
      background: #facc15;
      color: #000;
    }
    .btn.edit:hover {
      background: #ffde4d;
    }
    .btn.delete {
      background: #ef4444;
      color: #fff;
    }
    .btn.delete:hover {
      background: #dc2626;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 8px;
    }
    .pagination a, .pagination span {
      padding: 8px 12px;
      border-radius: 8px;
      background: #3a4452;
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      transition: 0.2s;
    }
    .pagination a:hover {
      background: #facc15;
      color: #000;
    }
    .pagination .current {
      background: #facc15;
      color: #000;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <h1><span>👥</span> Students Management</h1>
    <a href="<?=site_url('students/create')?>"><button class="btn-add">+ Add User</button></a>
  </div>

  <!-- Search -->
  <div class="search-container">
    <input type="text" id="searchInput" class="search-box" placeholder="Search students...">
  </div>

  <!-- Table -->
  <div class="table-wrapper">
    <div class="table-header">Users (<?= count($students) ?>)</div>
    <div class="table-subtitle">A list of all students in your system</div>

    <table id="studentTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($students as $students): ?>
        <tr>
          <td><?= $students['id']; ?></td>
          <td><?= $students['first_name']; ?></td>
          <td><?= $students['last_name']; ?></td>
          <td><?= $students['email']; ?></td>
          <td>
            <a href="<?= site_url('students/update/'.$students['id']); ?>"><button class="btn edit">Edit</button></a>
            <a href="<?= site_url('students/delete/'.$students['id']); ?>" onclick="return confirm('Are you sure you want to delete this record?');">
              <button class="btn delete">Delete</button>
            </a>
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



#gui.php