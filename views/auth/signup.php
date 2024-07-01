<h1>Sign Up</h1>
<form action="/signup" method="POST">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
    </div>
    <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
    </div>
    <div>
        <button type="submit" class="btn-primary">Sign Up</button>
    </div>
</form>