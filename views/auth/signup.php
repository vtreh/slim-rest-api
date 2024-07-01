<h1>Sign Up</h1>
<form action="/signup" method="POST">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required
            value="<?= htmlspecialchars($data['name'] ?? '') ?>" />
        <?= partial('error.php', ['errors' => $errors, 'field' => 'name']) ?>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required
            value="<?= htmlspecialchars($data['email'] ?? '') ?>" />
        <?= partial('error.php', ['errors' => $errors, 'field' => 'email']) ?>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
        <?= partial('error.php', ['errors' => $errors, 'field' => 'password']) ?>
    </div>
    <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
        <?= partial('error.php', ['errors' => $errors, 'field' => 'password_confirmation']) ?>
    </div>
    <div>
        <button type="submit" class="btn-primary">Sign Up</button>
    </div>
</form>