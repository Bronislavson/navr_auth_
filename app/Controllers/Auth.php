<?php

namespace App\Controllers;
use App\Services\Router;

class Auth
{

    private function isUsernameTaken($username)
    {
        $existingUser = \R::findOne('users', 'username = ?', [$username]);
        return $existingUser !== null;
    }

    private function isEmailTaken($email)
    {
        $existingUser = \R::findOne('users', 'email = ?', [$email]);
        return $existingUser !== null;
    }

    private function isPhoneTaken($phone)
    {
        $existingUser = \R::findOne('users', 'phone = ?', [$phone]);
        return $existingUser !== null;
    }


    /* АВТОРИЗАЦИЯ */
    public function login($data)
    {
        $login = $data["login"]; // Считываем значение из нового поля
        $password = $data["password"];

        // Поиск пользователя по email или phone
        $user = \R::findOne('users', 'email = ? OR phone = ?', [$login, $login]);

        if (!$user) {
            die('Пользователь не найден');
        }

        if (password_verify($password, $user->password)) {
            // Успешная авторизация
            $user->group = 2;
            // Сохранение изменений
            \R::store($user);
            $_SESSION["user"] = [
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "phone" => $user->phone,
                "group" => $user->group
            ];
            Router::redirect(uri:'/navr_auth/content');
        } else {
            die('Неверный логин или пароль');
        }
    }

    /* РЕГИСТРАЦИЯ */
    public function register($data)
    {
        $errors = [];

        // Валидация username
        if (empty($data["username"])) {
            $errors["username"] = "Username is required.";
        } elseif (strlen($data["username"]) < 3) {
            $errors["username"] = "Username must be at least 3 characters long.";
        } elseif ($this->isUsernameTaken($data["username"])) {
            $errors["username"] = "Username is already taken.";
        }

        // Валидация email
        if (empty($data["email"])) {
            $errors["email"] = "Email is required.";
        } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format.";
        } elseif ($this->isEmailTaken($data["email"])) {
            $errors["email"] = "Email is already registered.";
        }

        // Валидация phone
        if (empty($data["phone"])) {
            $errors["phone"] = "Phone number is required.";
        } elseif (!preg_match("/^[0-9]{10,15}$/", $data["phone"])) {
            $errors["phone"] = "Invalid phone number format.";
        } elseif ($this->isPhoneTaken($data["phone"])) {
            $errors["phone"] = "Phone number is already registered.";
        }

        // Валидация password
        if (empty($data["password"])) {
            $errors["password"] = "Password is required.";
        } elseif (strlen($data["password"]) < 8) {
            $errors["password"] = "Password must be at least 8 characters long.";
        } elseif ($data["password"] !== $data["password_confirm"]) {
            $errors["password_confirm"] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            // Если есть ошибки, можно вернуть их
            http_response_code(400);
            echo json_encode(["errors" => $errors]);
            die();
        } else {
            // Если нет ошибок, можно сохранять данные
            $username = $data["username"];
            $email = $data["email"];
            $phone = $data["phone"];
            $password = $data["password"];
            
            $user = \R::dispense('users');
            $user->username = $username;
            $user->email = $email;
            $user->phone = $phone;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            /* 
            * 1- пользователь
            * 2- авторизированный
            * 3- админ
            */
            $user->group = 1;
            \R::store($user);
            session_start();
            $_SESSION["user"] = [
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "phone" => $user->phone,
                "group" => $user->group
            ];
            Router::redirect('/navr_auth/login');

            echo json_encode(["message" => "Registration successful."]);
            die();
        }
    }

    public function change_profile($data)
    {
        // Обработка формы при отправке
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized access."]);
                die();
            }

            $userId = $_SESSION['user']['id'];
            $user = \R::findOne('users', 'id = ?', [$userId]);
            
            if (!$user) {
                http_response_code(404);
                echo json_encode(["error" => "User not found."]);
                die();
            }

            $errors = [];

            // Валидация username
            if (empty($data["username"])) {
                $errors["username"] = "Username is required.";
            } elseif (strlen($data["username"]) < 3) {
                $errors["username"] = "Username must be at least 3 characters long.";
            }
    
            // Валидация email
            if (empty($data["email"])) {
                $errors["email"] = "Email is required.";
            } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Invalid email format.";
            }
    
            // Валидация phone
            if (empty($data["phone"])) {
                $errors["phone"] = "Phone number is required.";
            } elseif (!preg_match("/^[0-9]{10,15}$/", $data["phone"])) {
                $errors["phone"] = "Invalid phone number format.";
            }
    
            // Валидация password
            if (empty($data["password"])) {
                $errors["password"] = "Password is required.";
            } elseif (strlen($data["password"]) < 8) {
                $errors["password"] = "Password must be at least 8 characters long.";
            } elseif ($data["password"] !== $data["password_confirm"]) {
                $errors["password_confirm"] = "Passwords do not match.";
            }
    
            if (!empty($errors)) {
                // Если есть ошибки, можно вернуть их
                http_response_code(400);
                echo json_encode(["errors" => $errors]);
                die();
            }
            if (!empty($errors)) {
                http_response_code(400);
                echo json_encode(["errors" => $errors]);
                die();
            }
    
            // Обновление данных
            $user->username = $data["username"];
            $user->email = $data["email"];
            $user->phone = $data["phone"];
            $user->password = $data["password"];
    
            // Хеширование пароля
            $user->password = password_hash($data["password"], PASSWORD_DEFAULT);
    
            // Сохранение изменений
            \R::store($user);

            $_SESSION["user"] = [
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "phone" => $user->phone,
                "group" => $user->group
            ];
            Router::redirect('/navr_auth/login');
            
            echo json_encode(["message" => "Profile updated successfully."]);
            die();
        }
    }


    public function logout()
    {
        unset($_SESSION["user"]);
        Router::redirect(uri:'/navr_auth/login');
    }
}