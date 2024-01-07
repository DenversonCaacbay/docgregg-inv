
<head>
    <title> Doc Gregg Veterinary Clinic </title>
    <!-- put css/js here for clean look -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- responsive tags for screen compatibility -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- custom css --> 
    <link href="css/pagestyle.css" rel="stylesheet" type="text/css">
    <!-- bootstrap css --> 
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <!-- fontawesome icons --> 
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
</head>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// // Include PHPMailer autoloader
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

    require_once('main.class.php');
    
    // // check if user is logged
    // if(!is_null($_SESSION['userdata'])){
    //     if($user_role == 'resident'){
    //         header('Location: resident_homepage.php');
    //     }
    //     else{
    //         header('Location: index.php');
    //     }
    // }

    class ResidentClass extends BMISClass {
        //------------------------------------ RESIDENT CRUD FUNCTIONS ----------------------------------------

        public function create_user()
{
    if (isset($_POST['add_user'])) {
        ob_start();
        $email = $_POST['email'];
        $password = ($_POST['password']);
        $confirm_password = ($_POST['confirm_password']);
        $lname = ucfirst(strtolower($_POST['lname'])); // Convert to uppercase
        $fname = ucfirst(strtolower($_POST['fname'])); // Convert to uppercase
        $mi = ucfirst(strtolower($_POST['mi']));
        $sex = $_POST['sex'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $bdate = $_POST['bdate'];
        $current_year = date("Y");
        $birth_year = date("Y", strtotime($bdate));
        $age = $current_year - $birth_year;
        $nationality = $_POST['nationality'];
        $role = $_POST['role'];

        if ($this->check_resident($email) == 0) {

            // check if the user is 18
            if ($age < 18) {
                $message = "Sorry, you are still underage to register an account";
                echo "<script type='text/javascript'>alert('$message');</script>";
                return false;
            } else {
                // Check if the password and confirm password match
                if ($password !== $confirm_password) {
                    $message = "Password and Confirm Password do not match";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    return false;
                }

                // Check if the password is at least 8 characters long
                if (strlen($password) < 8) {
                    $message = "Password must be at least 8 characters long";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    return false;
                }

                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // proceed to create
                $connection = $this->openConn();
                $verification_code = bin2hex(random_bytes(16));
                $stmt = $connection->prepare("INSERT INTO tbl_user (`email`, `password`, `lname`, `fname`, `mi`, `sex`, `contact`, `address`, `birthdate`, `nationality`, `verification_code`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->Execute([$email, $hashed_password, $lname, $fname, $mi, $sex, $contact, $address, $bdate, $nationality, $verification_code]);

                // Check if the query was successful
                if ($stmt->rowCount() > 0) {
                    // Send verification email using PHPMailer
                    $mail = new PHPMailer(true);

                    try {
                        // SMTP settings (replace with your SMTP server details)
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'dgvetclinic@gmail.com';
                        $mail->Password = 'uxpq syxi hxte ootg';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        // Set "From" address
                        $mail->setFrom('dgvetclinic@gmail.com', 'DG Veterinary Clinic');

                        // Set "To" address
                        $mail->addAddress($email);

                        // Set email subject and body
                        $mail->Subject = 'Email Verification';
                        $mail->Body = "Thank you for signing up! Your verification code is: $verification_code";

                        // Enable verbose debug output
                        $mail->SMTPDebug = 2;

                        // Send the email
                        $mail->send();

                        // Redirect to a verification page
                        header("Location: user_verification.php?email=$email");
                        ob_end_flush();
                        exit();
                    } catch (Exception $e) {
                        // Log the error
                        error_log("Email sending failed for $email: " . $mail->ErrorInfo, 1, "your_error_log.txt");
                        echo "Email sending failed. Please try again later.";
                    }
                } else {
                    $message2 = "Failed to add the account. Please try again.";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                }
            }
        } else {
            // This 'else' is associated with the 'if ($this->check_resident($email) == 0)' statement
            echo "<script type='text/javascript'>alert('Email Account already exists');</script>";
        }
    }
}


        public function view_resident(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt->execute();
            $view = $stmt->fetchAll();
            return $view;
        }

        public function update_resident($id_resident) {
            // ini_set('display_errors', 1);
            if (isset($_POST['update_resident'])) {
                $email = $_POST['email'];
                $lname = $_POST['lname'];
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                // $sex = $_POST['sex'];
                // $contact = $_POST['contact'];
                $bdate = $_POST['bdate'];
                $nationality = $_POST['nationality'];
                // $role = $_POST['role'];
        
                // Check if a new picture is uploaded
                $new_picture = $_FILES['new_picture'];
                $target_dir = "uploads/user/";

                // Function to handle image upload
                function uploadImage($new_picture, $target_dir) {
                    $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }
        
                    $target_file = $target_dir . time() . '.' . $file_extension;
        
                    if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                        return $target_file;
                    } else {
                        return false;
                    }
                }
        
                // Check if a new picture is uploaded
                if (!empty($new_picture['name'])) {
                    $uploaded_file = uploadImage($new_picture, $target_dir);
        
                    if ($uploaded_file !== false) {
                        $connection = $this->openConn();
        
                        // Update the resident information including the new picture
                        $stmt = $connection->prepare("UPDATE tbl_user SET `lname` =?, `fname` = ?, `mi` =?, `email` =?, `picture` =? WHERE `id_user` = ?");
                        $stmt->execute([$lname, $fname, $mi, $email, $uploaded_file, $id_resident]);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        return;
                    }
                } else {
                    // Update resident information without changing the picture
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("UPDATE tbl_user SET `lname` =?, `fname` = ?, `mi` =?, `email` =?
                         WHERE `id_user` = ?");
                    $stmt->execute([$lname, $fname, $mi, $email, $id_resident]);
                }
        
                $message2 = "User details updated";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }
        }
        

    //-------------------------------- EXTRA FUNCTIONS FOR RESIDENT CLASS ---------------------------------

    


    public function get_single_resident($id_user){

        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = ?");
        $stmt->execute([$id_user]);
        $id_user = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $id_user;
        }
        else{
            return false;
        }
    }
   
    public function check_resident($email) {

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE email = ?");
        $stmt->Execute([$email]);
        $total = $stmt->rowCount(); 

        return $total;
    }

    public function check_household($lname, $mi) {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE lname = ? AND mi = ?");
        $stmt->Execute([$lname, $mi]);
        $total = $stmt->rowCount(); 
        return $total;
    }

    public function view_household_list() {
        $lname = $_POST['lname'];
        $mi = $_POST['mi'];

        if(isset($_POST['search_household'])) {
            $connection = $this->openConn();
            $stmt1 = $connection->prepare("SELECT * FROM `tbl_usert` WHERE `lname` LIKE '%$lname%' and  `mi` LIKE '%$mi%'");
            $stmt1->execute();
        }
    }


    public function profile_update() {
        $id_user = $_GET['id_user'];
        $age = $_POST['age'];
        $status = $_POST['status'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        if (isset($_POST['profile_update'])) {
           
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_user SET  `age` = ?,  `status` = ?, 
            `address` = ?, `contact` = ? WHERE id_user = ?");
            $stmt->execute([ $age, $status, $address,
            $contact, $id_resident]);
               
            $message2 = "Resident Profile Updated";
                
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("Refresh:0");

        }

    }
    

    //------------------------------------- RESIDENT FILTERING QUERIES --------------------------------------

    public function view_resident_minor(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_resident WHERE `age` <= 17");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_resident_adult(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_resident WHERE `age` >= 18 AND `age` <= 59");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_resident_senior(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_resident WHERE `age` >= 60");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function count_resident_senior() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_resident WHERE `age` >= 60");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }





    //-------------------------------------- EXTRA FUNCTIONS ------------------------------------------------

    public function resident_changepass() {
        $id_resident = $_GET['id_resident'];
        
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $checkpassword = $_POST['confirm_password'];
    
        if (isset($_POST['resident_changepass'])) {
            // Check if the new password meets the minimum length requirement
            if (strlen($newpassword) < 8) {
                $message = "New Password must be at least 8 characters long";
                echo "<script type='text/javascript'>alert('$message');</script>";
                return;
            }
    
            $connection = $this->openConn();
            
            // Retrieve hashed password from the database
            $stmt = $connection->prepare("SELECT `password` FROM tbl_resident WHERE id_resident = ?");
            $stmt->execute([$id_resident]);
            $result = $stmt->fetch();
    
            // Check if old password is correct
            if (!$result || !password_verify($oldpassword, $result['password'])) {
                $message = "Old Password is Incorrect";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } elseif ($newpassword != $checkpassword) {
                $message = "New Password and Verification Password do not Match";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                // Hash the new password before updating the database
                $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt = $connection->prepare("UPDATE tbl_resident SET password = ? WHERE id_resident = ?");
                $stmt->execute([$hashedPassword, $id_resident]);
    
                $message2 = "Password Updated";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }
        }
    }
    
    // #pet
    public function view_pet($id_user){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *, 
            TIMESTAMPDIFF(YEAR, bdate, CURDATE()) - 
            (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(bdate, '%m%d')) AS age FROM tbl_pet where deleted_at IS NULL AND pet_owner_id = ?");
        $stmt->execute([$id_user]);
        $view = $stmt->fetchAll();

        return $view;
    }

    public function view_record($id_user){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_vaccination 
            INNER JOIN tbl_pet ON tbl_pet.pet_id = tbl_vaccination.pet_id
            WHERE tbl_vaccination.deleted_at IS NULL AND tbl_vaccination.pet_owner_id = ?
            ");
        $stmt->execute([$id_user]);
        $view = $stmt->fetchAll();

        return $view;
    }
    public function view_recent($id_user) {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_vaccination WHERE deleted_at IS NULL AND pet_owner_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$id_user]);
        $view = $stmt->fetchAll(); // Use fetch() instead of fetchAll()
    
        return $view;
    }
    

    public function create_pet($owner_id) {
        if (isset($_POST['add_pet'])) {
            $pet_name = ucfirst(strtolower($_POST['pet_name']));
            $owner_id = intval($owner_id); // Make sure owner_id is an integer
    
            $new_picture = $_FILES['pet_picture'];
    
            if (!empty($new_picture['name'])) {
                $target_dir = "uploads/pets/";
                $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
    
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
    
                $target_file = $target_dir . time() . '.' . $file_extension;
    
                if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                    // proceed to create with picture
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_pet (`pet_name`, `pet_owner_id`, `pet_picture`) VALUES (?, ?, ?)");
                    $stmt->execute([$pet_name, $owner_id, $target_file]);
    
                    $message2 = "Pet added!";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
    
                    echo '<script>window.location.replace("user_pet.php")</script>';
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                // proceed to create without picture
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_pet (`pet_name`, `pet_owner_id`) VALUES (?, ?)");
                $stmt->execute([$pet_name, $owner_id]);
    
                $message2 = "Pet added!";
                echo "<script type='text/javascript'>alert('$message2');</script>";
    
                echo '<script>window.location.replace("user_pet.php")</script>';
            }
        }
    }
    

    public function view_single_pet(){
        $connection = $this->openConn();

        $pet_id = $_GET['pet_id'];

        $stmt = $connection->prepare("SELECT * FROM tbl_pet where pet_id = '$pet_id'");
        $stmt->execute();
        $view = $stmt->fetchAll();

        return $view;
    }

    public function update_pet() {
        $pet_id = $_GET['pet_id'];

        if(isset($_POST['update_pet'])) {
            $pet_name = ucfirst(strtolower($_POST['pet_name']));

            // proceed to create
            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_pet (`pet_name`) VALUES (?)");
            $stmt->Execute([$pet_name]);

            $message2 = "Pet updated!";
            echo "<script type='text/javascript'>alert('$message2');</script>";

            echo '<script>window.location.replace("user_pet.php")</script>;';
        }
    }

    public function delete_pet(){
        $pet_id = $_POST['pet_id'];

        if(isset($_POST['delete_pet'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_pet set deleted_at = NOW() where pet_id = ?");
            $stmt->execute([$pet_id]);
            
            $message2 = "Pet removed";
            
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header('refresh:0');
        }
    }

    public function create_vaccination_record($owner_id) {
        if (isset($_POST['add_vac'])) {
            $pet_name = ucfirst(strtolower($_POST['pet_name']));
            $owner_id = intval($owner_id); // Make sure owner_id is an integer
    
            $new_picture = $_FILES['vac_picture'];
    
            if (!empty($new_picture['name'])) {
                $target_dir = "uploads/pets/";
                $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
    
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
    
                $target_file = $target_dir . time() . '.' . $file_extension;
    
                if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                    // proceed to create with picture
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_vaccination (`pet_id`, `pet_owner_id`, `vac_picture`) VALUES (?, ?, ?)");
                    $stmt->execute([$pet_name, $owner_id, $target_file]);
    
                    $message2 = "Vaccination Certificate added!";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
    
                    echo '<script>window.location.replace("user_record.php")</script>';
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                // proceed to create without picture
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_vaccination (`pet_name`, `pet_owner_id`) VALUES (?, ?)");
                $stmt->execute([$pet_name, $owner_id]);
    
                $message2 = "Pet added!";
                echo "<script type='text/javascript'>alert('$message2');</script>";
    
                echo '<script>window.location.replace("user_record.php")</script>';
            }
        }
    }

    public function delete_vaccination(){
        $pet_id = $_POST['vac_id'];

        if(isset($_POST['delete_vac'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_vaccination set deleted_at = NOW() where vac_id = ?");
            $stmt->execute([$pet_id]);
            
            $message2 = "Vaccination removed";
            
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header('refresh:0');
        }
    }
    





    //========================================== SCOPE CHANGED FUNCTIONS ===========================================

    public function view_resident_household(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT *
            FROM tbl_resident
            WHERE lname IN (
                SELECT lname
                FROM tbl_resident
                GROUP BY lname
                HAVING COUNT(*) >= 1
            )
            AND family_role = 'Yes'
        ");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_resident_voters(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_resident WHERE `voter` = 'Yes'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_resident_male(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_resident WHERE `sex` = 'Male'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function view_resident_female(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_resident WHERE `sex` = 'Female'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function count_voters() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_resident where `voter` = 'Yes' ");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }


    
    

    public function search_admn_voter() {
        
        $search = $_GET['search'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_resident WHERE `fname` = '$search'");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;

            


            
        
        

    }


    // #
    public function view_inventory($page = 1, $recordsPerPage = 3){
        $startFrom = ($page - 1) * $recordsPerPage;
        $connection = $this->openConn();

        // $stmt = $connection->prepare("SELECT * from tbl_user");
        $stmt = $connection->prepare("SELECT * from tbl_inventory WHERE deleted_at IS NULL LIMIT $startFrom, $recordsPerPage");
        $stmt->execute();
        $view = $stmt->fetchAll();
        //$rows = $stmt->
        return $view;
       
    }

    // #user dashboard
    public function view_low_inventory(){
        $connection = $this->openConn();
        $low_qty = 20;
        $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE quantity < ? AND deleted_at IS NULL");
        $stmt->execute([$low_qty]);
        $view = $stmt->fetchAll();
    
        return $view;
    }    




    }

    $residentbmis = new ResidentClass();
?>
        <!-- scripts -->
        <!-- purpose checker -->
        <script>
            var otherInput;
            function checkOptions(select) {
            otherInput = document.getElementById('otherInput');
            otherDiv = document.getElementById('otherDiv');

                if (select.options[select.selectedIndex].value == "Other") {
                    otherInput.style.display = 'block';
                    otherDiv.style.display = 'block';
                    otherInput.required = true;
                    
                }
                else {
                    otherInput.style.display = 'none';
                    otherDiv.style.display = 'none';
                    otherInput.value = '';
                    otherInput.required = false;
                }
            }
        </script>
        
        <!-- date checker -->
        <script>
            function checkDateValidity(dateInputId) {
                var dateInput = document.getElementById(dateInputId).value;
                var currentDate = new Date();
                var selectedDate = new Date(dateInput);

                // Check if the selected date is less than today's date
                if (selectedDate < currentDate) {
                    alert('Invalid date. Please select a date equal to or later than today.');
                    // Optionally, you can clear the input or perform any other actions here
                    document.getElementById(dateInputId).value = '';
                }
            }
        </script>

        <!-- show img before uploading -->
        <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(470)
                    .height(350);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
