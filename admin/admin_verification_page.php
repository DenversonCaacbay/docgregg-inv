<form method="post" action="admin_verify_code.php">
    <label>Enter Verification Code:</label>
    <input type="text" name="verification_code" required>
    <input type="text" name="email" value="<?php echo $_GET['email']; ?>">
    <button type="submit" name="verify">Verify</button>
</form>