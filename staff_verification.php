<?php
// Check if email is not set in the GET parameters
if (!isset($_GET['email'])) {
    // Redirect to user_registration.php
    header("Location: index.php");
    exit(); // Ensure that the script stops executing after the redirection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link href="css/user.css" rel="stylesheet" type="text/css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <style>
        .text-header{
            color: #0296be;
        }
        .bg-primary{
                background: #0296be !important;
            }
            .btn-primary {
                color: white;
                background: #0296be !important;
                padding: 10px 15px;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }
            .btn:hover {
                opacity: 1;
            }
    </style>
<nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark bg-primary">
    <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Verifying...</a>
</nav>
<div class="container mt-5">
    <div class="card p-2">
        <form method="post" class="p-2" action="staff_verify_code.php">
                <h5 class="text-header">Enter Verification code sent to your Email</h5>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingInputInvalid" placeholder="" name="verification_code" require>
                    <label for="floatingInputInvalid">Verification Code: </label>
                </div>
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>"><br>
            <button class="btn btn-primary w-100" type="submit" name="verify">Verify</button>
        </form>
    </div>
</div>


    
</body>
</html>