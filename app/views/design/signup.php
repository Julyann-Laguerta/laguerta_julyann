<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f1724] min-h-screen flex items-center justify-center">
  <div class="bg-[#0b1220] w-full max-w-md p-8 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold text-white mb-2">Create an account</h1>
    <p class="text-gray-400 text-sm mb-6">Sign up to manage students and access the system</p>

    <?php if (!empty($error)): ?>
      <div class="bg-red-600 text-white p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="<?= site_url('auth/signup') ?>" method="POST" class="space-y-4">
      <div>
        <label class="text-gray-300 text-sm">Full name</label>
        <input name="name" required value="<?= htmlspecialchars($old['name'] ?? '') ?>"
          class="w-full px-4 py-2 rounded bg-[#071126] text-white border border-[#233445]" />
      </div>
      <div>
        <label class="text-gray-300 text-sm">Email</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>"
          class="w-full px-4 py-2 rounded bg-[#071126] text-white border border-[#233445]" />
      </div>
      <div>
        <label class="text-gray-300 text-sm">Password</label>
        <input type="password" name="password" required minlength="6"
          class="w-full px-4 py-2 rounded bg-[#071126] text-white border border-[#233445]" />
      </div>
      <div>
        <label class="text-gray-300 text-sm">Confirm password</label>
        <input type="password" name="password_confirm" required minlength="6"
          class="w-full px-4 py-2 rounded bg-[#071126] text-white border border-[#233445]" />
      </div>

      <div class="flex items-center justify-between">
        <a href="<?= site_url('auth/login') ?>" class="text-sm text-gray-400 hover:text-white">Already have an account?</a>
        <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded font-semibold">Sign up</button>
      </div>
    </form>
  </div>
</body>
</html>
