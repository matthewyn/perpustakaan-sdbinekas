<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        // Dummy check, replace with real authentication
        if ($username === 'admin' && $password === 'admin') {
            // Set session or redirect as needed
            return redirect()->to('/');
        }
        return redirect()->back()->with('error', 'Login gagal');
    }
}