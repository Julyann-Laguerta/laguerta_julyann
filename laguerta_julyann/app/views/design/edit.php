<?php
// $student is already passed from StudentsController::update()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#192230] flex items-center justify-center min-h-screen p-6 font-sans">

  <!-- Edit User Card -->
  <div class="bg-[#2c2f38] w-full max-w-lg p-8 rounded-2xl shadow-xl">
    
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-8">
      <div class="p-3 rounded-xl bg-[#ffcd00] text-black shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5.121 17.804A9 9 0 1118.364 4.561a9 9 0 01-13.243 13.243z" />
        </svg>
      </div>
      <div>
        <h1 class="text-2xl font-bold text-white">Edit User</h1>
        <p class="text-gray-400 text-sm">Update the details of this user</p>
      </div>
    </div>

    <!-- Form -->
    <form action="<?= site_url('/students/update/' . $student['id']); ?>" method="POST" class="space-y-5">

      <!-- Hidden ID -->
      <input type="hidden" name="id" value="<?= $student['id']; ?>">

      <!-- First Name -->
      <div>
        <label for="first_name" class="block text-gray-300 text-sm font-medium mb-1">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= $student['first_name']; ?>"
          class="w-full px-4 py-2 rounded-lg bg-[#192230] text-white border border-[#3d474e] focus:outline-none focus:ring-2 focus:ring-[#ffcd00]" 
          required>
      </div>

      <!-- Last Name -->
      <div>
        <label for="last_name" class="block text-gray-300 text-sm font-medium mb-1">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= $student['last_name']; ?>"
          class="w-full px-4 py-2 rounded-lg bg-[#192230] text-white border border-[#3d474e] focus:outline-none focus:ring-2 focus:ring-[#ffcd00]" 
          required>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-gray-300 text-sm font-medium mb-1">Email</label>
        <input type="email" id="email" name="email" value="<?= $student['email']; ?>"
          class="w-full px-4 py-2 rounded-lg bg-[#192230] text-white border border-[#3d474e] focus:outline-none focus:ring-2 focus:ring-[#ffcd00]" 
          required>
      </div>

      <!-- Action buttons -->
      <div class="flex justify-end space-x-3 pt-4">
        <a href="<?= site_url('students/all'); ?>" 
           class="px-5 py-2 rounded-lg bg-[#3d474e] text-white hover:bg-[#4a545c] transition">
          Cancel
        </a>
        <button type="submit"
          class="px-5 py-2 rounded-lg text-black font-semibold shadow-lg transition duration-300"
          style="background: linear-gradient(135deg, #ffcd00, #e6b800);">
          Update User
        </button>
      </div>
    </form>
  </div>
</body>
</html>
