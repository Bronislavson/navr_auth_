<?php

use App\Services\Page; 

?>

<!DOCTYPE html>
<html lang="en">

<?php
    Page::part(part_name:'head');
?>

<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">NavrockiyAuth</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" href="/navr_auth/home">Home</a>
            </div>
        </div>
        <div class="d-flex">
                <a class="nav-link active me-5" href="/navr_auth/login">Login</a>
                <form action="/navr_auth/auth/logout" method="post">
                    <button type="submit" class="nav-link active me-5">Logout</button>
                </form>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mt-4">Registration</h2>
    <form class="mt-4" action="/navr_auth/auth/register" method="post" enctype="multipart/form-data">
        <label for="username">Username</label>
        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control" id="username" required>
        </div>
        <label for="email">Email address</label>
        <div class="form-floating mb-3">
            <input type="tel" name="email" class="form-control" id="email" required>
        </div>
        <label for="phone">Phone number</label>
        <div class="form-floating mb-3">
            <input type="phone" name="phone" class="form-control" id="phone" required>
        </div>
        <label for="password">Password</label>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <label for="password_confirm ">Password Confirmation</label>
        <div class="form-floating mb-3">
            <input type="password" name="password_confirm" class="form-control" id="password_confirm" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>