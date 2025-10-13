<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->library('pagination');
        $this->call->library('session'); 
    }

    // Show user profile
    public function profile() {
        if (!isset($_SESSION['user_logged_in'])) {
            header("Location: " . site_url('login'));
            exit;
        }

        $data['user'] = $_SESSION['student'];
        $data['success'] = $_SESSION['update_success'] ?? '';
        unset($_SESSION['update_success']);

        $this->call->view('user/profile', $data);
    }

    // Show update form
    public function edit($id) {
        if (!isset($_SESSION['user_logged_in'])) {
            header("Location: " . site_url('login'));
            exit;
        }

        $data['user'] = $_SESSION['student'];
        $data['errors'] = $_SESSION['update_errors'] ?? [];
        unset($_SESSION['update_errors']);

        $this->call->view('user/update_user', $data);
    }

    // Handle update form submission
  public function update($id)
{
    // Require login
    if (!isset($_SESSION['user_logged_in'])) {
        redirect('login');
        exit;
    }

    $studentsModel = new StudentsModel();
    $student = $studentsModel->findByUsername($id); // fetch from DB

    if (!$student) {
        redirect('user_panel'); // user not found
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];

        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $emails     = trim($_POST['emails'] ?? '');
        $password   = trim($_POST['password'] ?? ''); // added this line ✅

        if ($first_name === '') $errors[] = "First name is required.";
        if ($last_name === '')  $errors[] = "Last name is required.";
        if ($emails === '' || !filter_var($emails, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email is required.";
        }

        // Keep existing data unless changed
        $data = [
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'emails'      => $emails,
            'profile_pic' => $student['profile_pic']
        ];

        // ✅ Only update password if entered
        if (!empty($password)) {
            $data['password'] = $password; // not hashed, as requested
        }

        // ✅ Handle profile picture upload
        if (!empty($_FILES['profile_pic']['name'])) {
            $upload_dir = __DIR__ . '/../../upload/students/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_tmp  = $_FILES['profile_pic']['tmp_name'];
            $file_name = time() . "_" . basename($_FILES['profile_pic']['name']);
            $target    = $upload_dir . $file_name;

            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['profile_pic']['type'], $allowed_types) && move_uploaded_file($file_tmp, $target)) {
                if (!empty($student['profile_pic']) && file_exists($upload_dir . $student['profile_pic'])) {
                    unlink($upload_dir . $student['profile_pic']);
                }
                $data['profile_pic'] = $file_name;
            }
        }

        // If there are validation errors, reload the form
        if (!empty($errors)) {
            $this->call->view('update_user', ['student' => $student, 'errors' => $errors]);
            return;
        }

        // ✅ Update student record
        $studentsModel->update($id, $data);

        // ✅ Update session info with new data
        $_SESSION['student'] = $studentsModel->findByUsername($id);

        // ✅ Redirect back to user panel
        redirect('user_panel');
    }

    // Load the edit form
    $this->call->view('update_user', ['student' => $student]);
}
public function user_panel()
{
    if (!isset($_SESSION['user_logged_in'])) {
        redirect('login');
        exit;
    }

    $studentsModel = new StudentsModel();
    $user_id = $_SESSION['user_id'];

    // Get user data from database
    $student = $studentsModel->get_student_by_email($_SESSION['email']);
    
    if (!$student) {
        echo "User not found!";
        return;
    }

    // Pass data to view
    $data['student'] = $student;

    // Load the view
    $this->call->view('user_panel', ['user' => $student]);

}


}
