<?php

namespace Controllers;

use Libraries\Controller;
use Models\User;

class Users extends Controller
{
    /**
     * User Model
     * 0@var User
     */
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Registers a User
     * @return void
     */
    public function register(): void
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => $_POST['role'],
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];
            // Validate Name
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter name';
            }
            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            } else {
                // Check if email exist
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email is already taken';
                }
            }
            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be at least 6 characters';
            }
            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = 'Passwords do not match';
                }
            }
            // Validate Role
            if (empty($data['role'])) {
                $data['role_error'] = 'Please enter role';
            }

            // Proceed if there are no errors
            if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['password_confirm_error'])) {
                // Form is validated
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    flash('register_success', 'Register success, please login.');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'role' => 0,
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];

            // Load view with empty data
            $this->view('users/register', $data);
        }
    }

    /**
     * Authenticates a User
     * @return void
     */
    public function login(): void
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];
            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }
            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            }
            // Check for user email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    // Incorrect login credentials
                    $data['password_error'] = 'Incorrect password';
                    $this->view('users/login', $data);
                }
            } else {
                $data['email_error'] = 'User not found';
            }

            // Proceed if there are no errors
            if (empty($data['email_error']) && empty($data['password_error'])) {
                die('success');
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    /**
     * Create user session
     * @param $user
     * @return void
     */
    public function createUserSession($user): void
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->role;
        redirect('posts');
    }

    /**
     * Logout user
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('users/login');
    }
}