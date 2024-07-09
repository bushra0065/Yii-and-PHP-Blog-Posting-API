<!-- signup.php view -->
<form id="signup-form" method="post">
    <label>
        <input type="text" name="User[username]" placeholder="Username" required>
    </label>
    <label for="email"></label><input type="email" name="User[email]" placeholder="Email" required id="email">
    <label>
        <input type="password" name="User[password]" placeholder="Password" required>
    </label>
    <button type="submit">Sign Up</button>
</form>

<script>
    document.getElementById('email').addEventListener('blur', function() {
        var email = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'checkEmail');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200 && xhr.responseText === 'taken') {
                alert('Email is already in use');
            }
        };
        xhr.send('email=' + email);
    });
</script>
