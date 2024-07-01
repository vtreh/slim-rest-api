<h1>Log In</h1>
<form action="/login" method="POST">
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
        <button type="submit" class="btn-primary">Log In</button>
    </div>
</form>