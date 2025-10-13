<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: StudentsController
 * 
 * Automatically generated via CLI.
 */
class StudentsController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->library('pagination');
        $this->call->library('session'); 
    }


  public function get_all($page = 1)
{
    try {
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $allowed_per_page = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed_per_page)) $per_page = 10;

        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        // Total rows (search-aware)
        $total_rows = $this->StudentsModel->count_filtered_records($keyword);

        $page = max(1, (int)$page);
        $offset = ($page - 1) * $per_page;
        $limit_clause = "LIMIT {$offset}, {$per_page}";

        // Pagination setup
        $pagination_data = $this->pagination->initialize(
            $total_rows,
            $per_page,
            $page,
            'get_all',
            5
        );

        // If searching, use searchStudents with LIMIT
        if ($keyword !== '') {
            $data['students'] = $this->StudentsModel->searchStudents($keyword, $limit_clause);
        } else {
            $data['students'] = $this->StudentsModel->get_records_with_pagination($limit_clause);
        }

        $data['total_records'] = $total_rows;
        $data['pagination_data'] = $pagination_data;
        $data['pagination_links'] = $this->pagination->paginate();
        $data['keyword'] = $keyword;

        $this->call->view('get_all', $data);

    } catch (Exception $e) {
        $error_msg = urlencode($e->getMessage());
        redirect('get_all/1?error=' . $error_msg);
    }
}


  // Require login function (put this in a helper or base controller)
function requireLogin() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) {
        redirect('/user_login');
        exit;
    }
}


public function create() {
    $this->requireLogin(); // 🔐 check authentication

    if ($this->form_validation->submitted()) {
        $errors = [];

        // Validate required fields
        $first_name = trim($this->io->post('first_name'));
        $last_name  = trim($this->io->post('last_name'));
        $emails     = trim($this->io->post('emails'));

        if (empty($first_name)) $errors[] = "First name is required.";
        if (empty($last_name))  $errors[] = "Last name is required.";
        if (empty($emails) || !filter_var($emails, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email is required.";
        }

        $profile_pic = null;

        // Handle profile picture upload
        if (!empty($_FILES['profile_pic']['name'])) {
            $upload_dir = __DIR__ . '/../../upload/students/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_tmp  = $_FILES['profile_pic']['tmp_name'];
            $file_name = time() . "_" . basename($_FILES['profile_pic']['name']);
            $target    = $upload_dir . $file_name;

            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['profile_pic']['type'], $allowed_types)) {
                $errors[] = "Only JPG, PNG, GIF files are allowed.";
            } elseif (!move_uploaded_file($file_tmp, $target)) {
                $errors[] = "❌ Failed to upload file.";
            } else {
                $profile_pic = $file_name;
            }
        }

        // If validation fails → reload form with errors
        if (!empty($errors)) {
            $this->call->view('create', ['errors' => $errors]);
            return;
        }

        // Save data into DB
        $data = [
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'emails'      => $emails,
            'profile_pic' => $profile_pic
        ];

        $this->StudentsModel->insert($data);
        redirect('get_all');
    }

    $this->call->view('create');
}

public function update($id) {
    $this->requireLogin(); // 🔐 check authentication
    $student = $this->StudentsModel->find($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];

        // Validate fields
        $first_name = trim($_POST['first_name']);
        $last_name  = trim($_POST['last_name']);
        $emails     = trim($_POST['emails']);

        if (empty($first_name)) $errors[] = "First name is required.";
        if (empty($last_name))  $errors[] = "Last name is required.";
        if (empty($emails) || !filter_var($emails, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email is required.";
        }

        $data = [
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'emails'      => $emails,
            'profile_pic' => $student['profile_pic'] // keep old picture by default
        ];

        // Handle new upload if provided
        if (!empty($_FILES['profile_pic']['name'])) {
            $upload_dir = __DIR__ . '/../../upload/students/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_tmp  = $_FILES['profile_pic']['tmp_name'];
            $file_name = time() . "_" . basename($_FILES['profile_pic']['name']);
            $target    = $upload_dir . $file_name;

            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['profile_pic']['type'], $allowed_types)) {
                $errors[] = "Only JPG, PNG, GIF files are allowed.";
            } elseif (!move_uploaded_file($file_tmp, $target)) {
                $errors[] = "❌ Failed to upload file.";
            } else {
                // Delete old file
                if (!empty($student['profile_pic']) && file_exists($upload_dir . $student['profile_pic'])) {
                    unlink($upload_dir . $student['profile_pic']);
                }
                $data['profile_pic'] = $file_name;
            }
        }

        // If validation fails → reload form with errors
        if (!empty($errors)) {
            $this->call->view('/update', ['student' => $student, 'errors' => $errors]);
            return;
        }

        $this->StudentsModel->update($id, $data);
        redirect('get_all');
    }

    $this->call->view('/update', ['student' => $student]);
}


    function delete($id) {
         $this->StudentsModel->delete($id);
         redirect('get_all');
    }

public function search()
{
    $keyword = $_GET['keyword'] ?? '';

    // call StudentsModel instead of writing SQL here
    $results = $this->StudentsModel->searchStudents($keyword);

    $catIcons = ["", "", "", "", ""];
    $i = 0;
    if (!empty($results)) {
        foreach ($results as $row) {
            echo '
            <tr>
                <td>';
            // ✅ Profile picture check
            if (!empty($row['profile_pic'])) {
                echo '<img src="/upload/students/' . htmlspecialchars($row['profile_pic']) . '" 
                          alt="Profile" width="60" height="60" style="border-radius:50%;">';
            } else {
                echo '<img src="/upload/default.png" 
                          alt="No Profile" width="60" height="60" style="border-radius:50%;">';
            }
            echo '</td>
                <td>' . htmlspecialchars($row['id']) . ' ' . $catIcons[$i % count($catIcons)] . '</td>
                <td>' . htmlspecialchars($row['first_name']) . '</td>
                <td>' . htmlspecialchars($row['last_name']) . '</td>
                <td>' . htmlspecialchars($row['emails']) . '</td>
                <td class="actions">
                    <a href="' . site_url('/update/'.$row['id']) . '" class="btn update">✏️ Update</a>
                    <a href="' . site_url('/delete/'.$row['id']) . '" 
                       class="btn delete"
                       onclick="return confirm(\'Are you sure you want to delete this record?\');">
                       🗑️ Delete
                    </a>
                </td>
            </tr>';
            $i++;
        }
    } else {
        echo "<tr><td colspan='6' style='text-align:center;'>No results found</td></tr>";
    }
}


public function login() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Get user from DB
        $user = $this->StudentsModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            redirect('get_all'); // go to students page
        } else {
            $this->call->view('login', ['error' => 'Invalid username or password']);
            return;
        }
    }

    $this->call->view('login');
}

public function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header("Location: " . site_url('user_login'));
    exit;
}


public function register()
{
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = $this->io->post('first_name');
        $last_name  = $this->io->post('last_name');
        $emails     = $this->io->post('emails');
        $password   = $this->io->post('password'); // plain text password

        $profile_pic = null;
        if (!empty($_FILES['profile_pic']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $file_name = time() . '_' . basename($_FILES["profile_pic"]["name"]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $target_file;
            } else {
                $errors[] = "Failed to upload the file.";
            }
        }

        if (empty($first_name)) $errors[] = "First name is required.";
        if (empty($last_name))  $errors[] = "Last name is required.";
        if (empty($emails))     $errors[] = "Email is required.";
        if (empty($password))   $errors[] = "Password is required.";

        if (empty($errors)) {
            $this->StudentsModel->insert([
                'first_name'  => $first_name,
                'last_name'   => $last_name,
                'emails'      => $emails,
                'password'    => $password, // ✅ not hashed
                'profile_pic' => $profile_pic
            ]);
            
            redirect('user_login');
            return;
        }
    }

    $this->call->view('register', ['errors' => $errors]);
}
public function user_panel()
{
    // Ensure only logged-in users can access
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . site_url('login'));
        exit;
    }

    // Load model
    $studentsModel = new StudentsModel();

    // ✅ Fetch the logged-in user's record
    $user_id = $_SESSION['user_id'];
    $student = $studentsModel->findByUsername($user_id); // fetch single record

    // ✅ Pass it to the view
    $data['user'] = $student;

    // ✅ Load view
    $this->call->view('user_panel', $data);
}

public function admin_login()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if ($username === 'admin' && $password === 'admin123') {

            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'admin';
            $_SESSION['admin_logged_in'] = true;

            // ✅ Use the route name, not file path
            redirect('get_all');
            return;
        }

        $this->call->view('login', ['admin_error' => '❌ Invalid admin username or password']);
        return;
    }

    $this->call->view('login');
}

public function user_login()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $studentsModel = new StudentsModel();

        // 🔍 Check user by email and plain password
        $sql = "SELECT * FROM students WHERE emails = ? AND password = ?";
        $stmt = $studentsModel->db->raw($sql, [$email, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // ✅ Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email']   = $user['emails'];
            $_SESSION['user_logged_in'] = true;

            // ✅ Redirect to student panel
            redirect('/user_panel');
        } else {
            // ❌ Wrong credentials
            $this->call->view('login', [
                'user_error' => '❌ Invalid email or password'
            ]);
        }
    } else {
        $this->call->view('login');
    }
}



}
