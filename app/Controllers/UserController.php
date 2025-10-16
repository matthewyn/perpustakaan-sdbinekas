<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UserController extends Controller
{
    public function index()
    {
        // Fetch users from database (replace with your user source)
        $users = []; // Example: $users = $this->db->getReference('users')->getValue() ?? [];
        return view('user', ['users' => $users]);
    }

    // Add, edit, delete methods can be added here
}