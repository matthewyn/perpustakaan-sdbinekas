<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Firebase;

class UserController extends Controller
{
    private $db;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->db = $firebase->getDatabase();
    }

    public function index()
    {
        $users = $this->db->getReference('users')->getValue();
        return view('user', ['users' => $users]);
    }

    public function list()
    {
        $users = $this->db->getReference('users')->getValue();
        $result = [];
        if ($users) {
            foreach ($users as $key => $user) {
                $user['key'] = $key; // Add Firebase key
                $result[] = $user;
            }
        }
        return $this->response->setJSON([
            'success' => true,
            'users' => $result
        ]);
    }

    public function add()
    {
        // Validate the request
        $rules = [
            'nama' => 'required|min_length[3]',
            'nisn' => 'required|numeric|min_length[10]',
            'kelas' => 'required'
        ];
        $updated = false;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare the data
        $data = [
            'nama' => $this->request->getPost('nama'),
            'nisn' => $this->request->getPost('nisn'),
            'password' => $this->request->getPost('nisn'),
            'kelas' => $this->request->getPost('kelas'),
            'role' => 'murid',
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            // Store the data in Firebase
            $this->db->getReference('users')->push($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Siswa added successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Siswa not added'
            ]);
        }
    }

    public function update($key)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'nisn' => 'required|numeric|min_length[10]',
            'kelas' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'nisn' => $this->request->getPost('nisn'),
            'kelas' => $this->request->getPost('kelas'),
            'role' => 'murid'
        ];

        try {
            $this->db->getReference('users/' . $key)->update($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Siswa updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Siswa not updated'
            ]);
        }
    }
}

// <?php

// namespace App\Controllers;

// use CodeIgniter\Controller;
// use App\Libraries\Firebase;

// class UserController extends Controller
// {
//     // Delete user
//     public function delete($id)
//     {
//         $this->db->getReference('users/'.$id)->remove();
//         return redirect()->to('/user');
//     }
// }