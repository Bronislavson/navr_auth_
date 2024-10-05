<?php

use App\Services\Page;

// Проверка на наличие пользователя в сессии
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    \App\Services\Router::redirect(uri:'/navr_auth/login');
}

// Получаем идентификатор пользователя из сессии
$userId = $_SESSION['user']['id'];

// Получение пользователя из базы данных
$user = \R::findOne('users', 'id = ?', [$userId]);

// Проверяем, существует ли пользователь и его группа
if ($user && $user->group == 1) {
    \App\Services\Router::redirect(uri:'/navr_auth/login');
}


?>

<!DOCTYPE html>
<html lang="en">

<?php
    Page::part(part_name:'head');
?>

<body>

<?php
    Page::part(part_name:'navbar');
?>

<div class="container">
    <h1>CONTENT</h1>
    <h2 class="display-4">Hello, <?= $_SESSION["user"]["username"]?>!</h2>
</div>

</body>
</html>