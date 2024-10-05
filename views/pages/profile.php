<?php
    use App\Services\Page;

    if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
        \App\Services\Router::redirect(uri:'/navr_auth/home');
    }
    
    $userId = $_SESSION['user']['id'];
    $user = \R::findOne('users', 'id = ?', [$userId]);

    if (!$user) {
        die('User not found.');
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
    <h2>PROFILE</h2>
    <form class="mt-4" action="/navr_auth/auth/change_profile" method="post" enctype="multipart/form-data">
        <label for="username">Username</label>
        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($user->username, ENT_QUOTES); ?>" required>
        </div>
        <label for="email">Email address</label>
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user->email, ENT_QUOTES); ?>" required>
        </div>
        <label for="phone">Phone number</label>
        <div class="form-floating mb-3">
            <input type="tel" name="phone" class="form-control" id="phone" value="<?php echo htmlspecialchars($user->phone, ENT_QUOTES); ?>" required>
        </div>
        <label for="password">Password</label>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <label for="password_confirm">Password Confirmation</label>
        <div class="form-floating mb-3">
            <input type="password" name="password_confirm" class="form-control" id="password_confirm" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>