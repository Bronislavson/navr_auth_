<?php
    use App\Services\Page;
?>

<!DOCTYPE html>
<html lang="en">

<?php
    Page::part(part_name:'head');
?>

<body>

<div class="container">
    <h2>Welcome!</h2>
    <form class="mt-4">
        <div class="d-flex">
            <a class="nav-link active me-5" href="/navr_auth/content">Content</a>
            <a class="nav-link active me-5" href="/navr_auth/login">Login</a>
            <a class="nav-link active me-5" href="/navr_auth/register">Register</a>
            <a class="nav-link active me-5" href="/navr_auth/profile">Profile</a>
        </div>
    </form>
</div>

</body>
</html>