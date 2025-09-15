<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentsController extends Controller {


    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('StudentsModel');
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
            'students/all',
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

        $this->call->view('design/gui', $data);

    } catch (Exception $e) {
        $error_msg = urlencode($e->getMessage());
        redirect('students/all/1?error=' . $error_msg);
    }
}

    public function test_connection()
    {
        var_dump($this->db);
    }

  
    

   
    public function create()
    {
        if ($this->form_validation->submitted()) {
            $fname = $this->io->post('first_name');
            $lname = $this->io->post('last_name');
            $email = $this->io->post('email');

            $this->StudentsModel->create($fname, $lname, $email);
            redirect('students/all');
        }
        $this->call->view('design/create');
    }

    
    public function update($id)
{
    $student = $this->StudentsModel->finds($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name'  => $_POST['last_name'],
            'email'      => $_POST['email']
        ];
        $this->StudentsModel->update($id, $data);
        redirect('students/all');
    }

    $this->call->view('design/edit', ['student' => $student]);
}


public function search()
{
    $keyword = $_GET['keyword'] ?? '';

    // call StudentsModel instead of writing SQL here
    $results = $this->StudentsModel->searchStudents($keyword);

    $catIcons = [" ", " ", " ", " ", " "];
    $i = 0;

    if (!empty($results)) {
        foreach ($results as $row) {
            echo '
            <tr>
                <td>' . htmlspecialchars($row['id']) . ' ' . $catIcons[$i % count($catIcons)] . '</td>
                <td>' . htmlspecialchars($row['first_name']) . '</td>
                <td>' . htmlspecialchars($row['last_name']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>
                    <a href="' . site_url('students/update/'.$row['id']) . '">
                        <button class="btn edit">Edit</button>
                    </a>
                    <a href="' . site_url('students/delete/'.$row['id']) . '" 
                       onclick="return confirm(\'Are you sure you want to delete this record?\');">
                        <button class="btn delete">Delete</button>
                    </a>
                </td>
            </tr>';
            $i++;
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center;'>No results found</td></tr>";
    }
}




    
    public function delete($id)
    {
        $this->StudentsModel->delete($id);
        redirect('students/all');
    }
}

#StudentsController