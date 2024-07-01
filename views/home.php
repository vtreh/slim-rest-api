<?php if (empty($_SESSION['user_id'])) : ?>
    <nav>
        <ul>
            <li><a href="/login">Log In</a></li>
            <li><a href="/signup">Sign Up</a></li>
        </ul>
    </nav>
<?php else : ?>
    <h1>Welcome to Home Page, user: <?php echo $_SESSION['user_id'] ?></h1>
    <form action="/" method="post">
        <button type="submit">Logout</button>
    </form>
<?php endif; ?>