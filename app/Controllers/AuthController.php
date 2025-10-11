<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login',
            'bodyClass' => 'login-page',
        ];

        return view('login', $data);
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Credentials for admin and teacher with name
        $credentials = [
            'admin' => [
                'password' => 'admin123',
                'name' => 'Admin'
            ],
            'teacher' => [
                'password' => 'teacher123',
                'name' => 'Guru'
            ]
        ];

        if (isset($credentials[$username]) && $credentials[$username]['password'] === $password) {
            session()->set('role', $username); // Save role in session
            session()->set('name', $credentials[$username]['name']); // Save name in session
            return redirect()->to('/');
        }

        return redirect()->back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        session()->remove('role'); // Clear the role from session
        session()->destroy();      // Destroy the session
        return redirect()->to('login');
    }
}