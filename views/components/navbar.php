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
            <?php
            if (!$_SESSION["user"]) {
                ?>
                <a class="nav-link active me-5" href="/navr_auth/login">Login</a>
                <a class="nav-link active" href="/navr_auth/register">Register</a>
                <?php
            } else {
                ?>
                <a class="nav-link active me-5" href="/navr_auth/content">Content</a>
                <form action="/navr_auth/auth/logout" method="post">
                    <button type="submit" class="nav-link active me-5">Logout</button>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</nav>