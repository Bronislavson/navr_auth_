<?php

use App\Services\Page;

// Проверка на наличие пользователя в сессии
if (!isset($_SESSION['user']) ?? empty($_SESSION['user']['group'] !== 2)) {
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