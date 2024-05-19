<!-- SweetAlert 2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

<!-- SweetAlert 2 JS (including dependencies) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<style>
    .your-custom-font-class {
        font-family: 'Nunito', sans-serif;
    }
</style>

<?php 

date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
class BMISClass {

//------------------------------------------ DATABASE CONNECTION ----------------------------------------------------
    
    protected $server = "mysql:host=localhost;dbname=dgvc";
    protected $user = "root";
    protected $pass = "";
    protected $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $con;


    public function show_404()
    {
        http_response_code(404);
        echo "Page is currently unavailable";
        die;
    }

    public function openConn() {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;
        }

        catch(PDOException $e) {
            echo "Datbase Connection Error! ", $e->getMessage();
        }
    }

    //eto yung nag c close ng connection ng db
    public function closeConn() {
        $this->con = null;
    }


    //------------------------------------------ AUTHENTICATION & SESSION HANDLING --------------------------------------------
        //authentication function para sa sa tatlong type ng accounts
        public function login() {
            if(isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
        
                $connection = $this->openConn();
        
                // Query to retrieve the user based on the email
                $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
        
                if ($user) {
                    // Verify the entered password against the stored hashed password
                    if (password_verify($password, $user['password'])) {
                        // Check the user role
                        if ($user['role'] == 'administrator') {
                            $this->set_userdata($user);
                            header('Location: admin_dashboard.php');
                            exit();
                        } elseif ($user['role'] == 'staff') {
                            $this->set_userdata($user);
                            header('Location: staff_dashboard.php');
                            exit();
                        } else {
                            // Handle other roles or scenarios
                        }
                    } else {
                        // Incorrect password
                        echo "<script type='text/javascript'>alert('Invalid Email or Password');</script>";
                    }
                } else {
                    // User not found by email
                    echo "<script type='text/javascript'>alert('Invalid Email or Password');</script>";
                }
            }
        }
        

        //Testing Login with checking is User has verified his or her account
        public function user_login() 
        {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ob_start();

            try 
            {
                // Your existing code here
                if(isset($_POST['user_login'])) 
                {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $connection = $this->openConn();

                    // Check if the email exists in tbl_user
                    $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ? AND deleted_at IS NULL");
                    $stmt->execute([$email]);
                    $user = $stmt->fetch();

                    // If the email is found in tbl_user
                    if ($user) 
                    {
                        // Check if the account is verified
                        if ($user['verified'] == 1) 
                        {
                            // If the password is correct, log in
                            if (password_verify($password, $user['password'])) 
                            {
                                $this->set_userdata($user);
                                echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Login Successfully',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        customClass: {
                                            title: 'your-custom-font-class'
                                        }
                                    });
                                });
                            </script>";
                        // Redirect after showing the alert
                            // header("refresh: 1; url=admin/admin_dashboard.php");
                            // Redirect based on user role
                            if ($user['role'] == 'administrator') {
                                // Redirect to admin dashboard
                                header("refresh: 1; url=admin/admin_dashboard.php");
                            } elseif ($user['role'] == 'Staff') {
                                // Redirect to staff services page
                                header("refresh: 1; url=admin/services.php");
                            }
                                exit();
                            } 
                            else 
                            {
                                echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Invalid Credential',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";
                        // Redirect after showing the alert
                            header("refresh: 1; url=index.php");
                            }
                        } 
                        else 
                        {
                            // Account is not verified, send verification code and redirect to verify_code.php
                            // $verificationCode = bin2hex(random_bytes(16));
                            $verificationCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

                            $this->sendVerificationEmail($email, $verificationCode);

                            // Update verification_code in tbl_user
                            $updateCodeQuery = "UPDATE tbl_admin SET verification_code = ? WHERE email = ?";
                            $updateCodeStmt = $connection->prepare($updateCodeQuery);
                            $updateCodeStmt->execute([$verificationCode, $email]);

                            header("Location: staff_verification.php?email=$email");
                            exit();
                        }
                    } 
                    else 
                    {
                        // Email not found, alert and prompt to register
                        echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Account Found, Please Register',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            });
                        </script>";
                    // Redirect after showing the alert
                        header("refresh: 1; url=index.php");
                    }
                }
            } 
            catch (Exception $e) 
            {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }

// Function to send verification email
        private function sendVerificationEmail($email, $verificationCode) {

            $mail = new PHPMailer(true);

            try {
                // Your SMTP settings here
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dgvetclinic@gmail.com';
                $mail->Password = 'uxpq syxi hxte ootg';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Set "From" address
                $mail->setFrom('dgvetclinic@gmail.com', 'DG Veterinary Clinic'); // Replace with your name

                // Set "To" address
                $mail->addAddress($email);

                // Set email subject and body
                $mail->Subject = 'Email Verification';
                $mail->Body = "Thank you for signing up! Your verification code is: $verificationCode";

                // Enable verbose debug output
                $mail->SMTPDebug = 2;

                // Send the email
                $mail->send();
            } catch (Exception $e) {
                // Log the error
                error_log("Email sending failed for $email: " . $mail->ErrorInfo, 1, "your_error_log.txt");
                echo "Email sending failed. Please try again later.";
            }
        }
        

    //eto yung function na mag e end ng session tas i l logout ka 
    public function logout(){
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userdata'] = null;
        unset($_SESSION['userdata']); 
        
    }

    // etong method na get_userdata() kukuha ng session mo na 'userdata' mo na i identify sino yung naka login sa site 
    public function get_userdata(){
    
        //i ch check niya ulit kung naka start na ba session o hindi, kapag hindi pa ay i s start niya para surebol
        if(!isset($_SESSION)) {
            session_start();
        }

        return $_SESSION['userdata'];

        //eto naman i ch check niya kung yung 'userdata' naka set na ba sa session natin
        if(!isset($_SESSION['userdata'])) {
            return $_SESSION['userdata'];
        } 

        else {
            return null;
        }
    }

    //eto yung condition na mag s set userdata na gagamiting pagkakakilala sayo sa buong session kapag nag login in ka
    public function set_userdata($array) {

        //i ch check nito kung naka set naba yung session, kapag hindi pa naka set i r run niya yung session_start();
        if(!isset($_SESSION)) {
            session_start();
        }

        //eto si userdata yung mag s set ng name mo tsaka role/access habang ikaw ay nag b browse at gumagamit ng store management
        $_SESSION['userdata'] = array(
            "id_admin" => $array['id_admin'],
            "fname" => $array['fname'],
            "lname" => $array['lname'],
            "role" => $array['role'],
        );
        return $_SESSION['userdata'];
    }
 


 //----------------------------------------------------- ADMIN CRUD ---------------------------------------------------------
 
    // public function create_admin() 
    // {

    //     if(isset($_POST['add_admin'])) {
        
    //         $email = $_POST['email'];
    //         $password = $_POST['password'];
    //         $lname = ucfirst($_POST['lname']); // Convert to uppercase
    //         $fname = ucfirst($_POST['fname']); // Convert to uppercase
    //         $mi = strtoupper(substr($_POST['mi'], 0, 1)) . '.'; // Get first letter in uppercase and add '.'
    //         $role = $_POST['role'];
    
    //             if ($this->check_admin($email) == 0 ) {

    //                 $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
    //                 $connection = $this->openConn();
    //                 $stmt = $connection->prepare("INSERT INTO tbl_admin 
    //                 (`email`,`password`,`lname`,`fname`,`mi`, `role` ) 
    //                 VALUES (?, ?, ?, ?, ?, ?)");
                    
    //                 $stmt->Execute([$email, $password_hash, $lname, $fname, $mi, $role]);
                    
    //                 $message2 = "Administrator account added, you can now continue logging in";
    //                 echo "<script type='text/javascript'>alert('$message2');</script>";
    //             }
    //         }
    
    //         else {
    //             echo "<script type='text/javascript'>alert('Account already exists');</script>";
    //         }
    // }

    public function get_single_admin($id_admin){

        $id_admin = $_GET['id_admin'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin where id_admin = ?");
        $stmt->execute([$id_admin]);
        $admin = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $admin;
        }
        else{
            return false;
        }
    }

    public function admin_changepass() {
        $id_admin = $_GET['id_admin'];
        $oldpassword = ($_POST['oldpassword']);
        $oldpasswordverify = ($_POST['oldpasswordverify']);
        $newpassword = ($_POST['newpassword']);
        $checkpassword = $_POST['checkpassword'];

        if(isset($_POST['admin_changepass'])) {

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT `password` FROM tbl_admin WHERE id_admin = ?");
            $stmt->execute([$id_admin]);
            $result = $stmt->fetch();

            if($result == 0) {
                
                echo "Old Password is Incorrect";
            }

            elseif ($oldpassword != $oldpasswordverify) {
            }

            elseif ($newpassword != $checkpassword){
                echo "New Password and Verification Password does not Match";
            }

            else {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_admin SET password =? WHERE id_admin = ?");
                $stmt->execute([$newpassword, $id_admin]);
                
                $message2 = "Password Updated";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }


        }
    }



 //  ----------------------------------------------- ANNOUNCEMENT CRUD ---------------------------------------------------------


    public function create_announcement() {
        if(isset($_POST['create_announce'])) {
            $id_announcement = $_POST['id_announcement'];
            $event = $_POST['event'];
            $start_date = $_POST['start_date'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_announcement (`id_announcement`, 
            `event`, `start_date`, `addedby`) VALUES ( ?, ?, ?, ?)");
            $stmt->execute([$id_announcement, $event, $start_date, $addedby]);

            $message2 = "Announcement Added";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header('refresh:0');
        }

        else {
        }
    }

    public function view_announcement(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_announcement");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_announcement() {
        if (isset($_POST['update_announce'])) {
            $id_announcement = $_GET['id_announcement'];
            $event = $_POST['event'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_announcement SET event =?, start_date =?, 
            end_date = ?, addedby =? WHERE id_announcement = ?");
            $stmt->execute([ $event, $start_date, $end_date, $addedby, $id_announcement]);
               
            $message2 = "Announcement Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
             header("refresh: 0");
        }

        else {
        }
    }

    public function delete_announcement(){
        $id_announcement = $_POST['id_announcement'];

        if(isset($_POST['delete_announcement'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_announcement where id_announcement = ?");
            $stmt->execute([$id_announcement]);

            header("Refresh:0");
        }
    }

    public function count_announcement() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_announcement");
        $stmt->execute();
        $ancount = $stmt->fetchColumn();
        return $ancount;
    }

    //------------------------------------------ Animal Welfare CRUD -----------------------------------------------


    public function create_animal() {
        $id_resident = $_POST['id_resident'];
        $pettype = $_POST['pettype'];
        $breed = $_POST['breed'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $purpose = $_POST['purpose'];
        $vaccination = $_POST['vaccination'];
        $owner = $_POST['owner'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $dateapply = $_POST['dateapply'];
        $addedby = $_POST['addedby'];


        $connection = $this->openConn();
        $stmt = $connection->prepare("INSERT INTO tbl_animal (`id_resident`, 
        `pettype`, `breed`, `sex`, `age`, `purpose`, `vaccination`, `owner`, `address`,
        `contact`, `dateapply`, `addedby`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$id_resident, $pettype, $breed, $sex, $age, $purpose, $vaccination,
        $owner, $address,  $contact, $dateapply,  $addedby]);

        $message2 = "Application Applied, you will be receive our text message for further details";
        echo "<script type='text/javascript'>alert('$message2');</script>";
        header("refresh: 0");
        
    }

    public function view_animal(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_animal");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_animal() {
        if (isset($_POST['update_animal'])) {
            $id_animal = $_GET['id_animal'];
            $pettype = $_POST['pettype'];
            $breed = $_POST['breed'];
            $sex = $_POST['sex'];
            $age = $_POST['age'];
            $purpose = $_POST['purpose'];
            $vaccination = $_POST['vaccination'];
            $owner = $_POST['owner'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $dateapply = $_POST['dateapply'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_animal SET pettype = ?, breed = ?, sex = ?, 
            age = ?, purpose = ?, vaccination = ?, owner = ?, address = ?, contact = ?, dateapply = ?,
            addedby = ? WHERE id_animal = ?");
            $stmt->execute([ $pettype, $breed, $sex, $age, $purpose, $vaccination, $owner, 
            $address, $contact, $dateapply, $addedby, $id_animal]);
            
            $message2 = "Animal Registry & Welfare Data Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }
    }

    public function delete_animal(){
        $id_animal = $_POST['id_animal'];

        if(isset($_POST['delete_animal'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_animal where id_animal = ?");
            $stmt->execute([$id_animal]);

            header("Refresh:0");
        }
    }

    public function get_single_animal(){

        $id_animal = $_GET['id_animal'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_animal where id_animal = ?");
        $stmt->execute([$id_animal]);
        $animal = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $animal;
        }
        else{
            return false;
        }
    }

    public function count_animal() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_animal");
        $stmt->execute();
        $animalcount = $stmt->fetchColumn();

        return $animalcount;
    }

    public function count_animal_dogs() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_animal where pettype = 'dog'");
        $stmt->execute();
        $animalcount = $stmt->fetchColumn();

        return $animalcount;
    }

    public function count_animal_cats() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_animal where pettype = 'cat'");
        $stmt->execute();
        $animalcount = $stmt->fetchColumn();

        return $animalcount;
    }

    public function count_animals() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_animal");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function count_female_animals() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_animal where sex = 'female'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function count_male_animals() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_animal where sex = 'male'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }
    


    //  --------------------------------------------------------- MEDICINE CRUD ---------------------------------------------------------


    public function create_medicine() {
        if(isset($_POST['create_medicine'])) {

            $id_medicine = $_POST['id_medicine'];
            $item = $_POST['item'];
            $dateman = $_POST['dateman'];
            $origin = $_POST['origin'];
            $datein = $_POST['datein'];
            $dateout = $_POST['dateout'];
            $stocks = $_POST['stocks'];
            $remarks = $_POST['remarks'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_medicine (`id_medicine`, 
            `item`, `dateman`, `origin`, `datein`, `dateout`, `stocks`, `remarks`, `addedby`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([$id_medicine, $item, $dateman, $origin, $datein, $dateout, $stocks, $remarks, $addedby]);

            $message2 = "Medicine Added";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            
            header('refresh:0');
        }
    }


    public function view_medicine(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_medicine");
        $stmt->execute();
        $view = $stmt->fetchAll();

        return $view;
    }

    public function update_medicine() {
        if (isset($_POST['update_medicine'])) {
            $id_medicine = $_GET['id_medicine'];
            $item = $_POST['item'];
            $dateman = $_POST['dateman'];
            $origin = $_POST['origin'];
            $datein = $_POST['datein'];
            $dateout = $_POST['dateout'];
            $stocks = $_POST['stocks'];
            $remarks = $_POST['remarks'];
            $addedby = $_POST['addedby'];


            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_medicine SET item =?, dateman =?, 
            origin = ?, datein = ?, dateout = ?, stocks = ?, remarks =?, addedby = ?
            WHERE id_medicine = ?");
            $stmt->execute([ $item, $dateman, $origin, $datein, $dateout, $stocks, $remarks, $addedby, $id_medicine]);
            
            $message2 = "Medicine Item Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");

        }
    }

    public function delete_medicine(){
        $id_medicine = $_POST['id_medicine'];

        if(isset($_POST['delete_medicine'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_medicine where id_medicine = ?");
            $stmt->execute([$id_medicine]);

            header("Refresh:0");
        }
    }

    public function get_single_medicine(){

        $id_medicine = $_GET['id_medicine'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_medicine where id_medicine = ?");
        $stmt->execute([$id_medicine]);
        $medicine = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $medicine;
        }
        else{
            return false;
        }
    }

    public function count_medicine() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_medicine");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    //------------------------------------------ TB DOTS CRUD -----------------------------------------------


    public function create_tbdots() {
        if(isset($_POST['create_tbdots'])) {
            $id_tbdots = $_POST['id_tbdots'];
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $contact = $_POST['contact'];
            $bdate = $_POST['bdate'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $philhealth = $_POST['philhealth'];
            $date_applied = $_POST['date_applied'];
            $addedby = $_POST['addedby'];



            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_tbdots (`id_tbdots`, `id_resident`, 
            `lname`, `fname`, `mi`, `age`, `sex`, `address`, `occupation`, `contact`, `bdate`, `height`, 
            `weight`, `philhealth`, `date_applied`, `addedby`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([$id_tbdots, $id_resident, $lname, $fname, $mi, $age, $sex, 
            $address, $occupation, $contact, $bdate, $height, $weight, $philhealth, $date_applied, $addedby]);

            $message2 = "Application Applied";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header('refresh:0');
        }
    }

    public function view_tbdots(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_tbdots");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_tbdots() {
        if (isset($_POST['update_tbdots'])) {
            $id_tbdots = $_GET['id_tbdots'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $contact = $_POST['contact'];
            $bdate = $_POST['bdate'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $philhealth = $_POST['philhealth'];
            $remarks = $_POST['remarks'];
            $addedby = $_POST['addedby'];


            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_tbdots SET lname =?, fname =?, 
            mi = ?, age = ?, sex = ?, `address` = ?, occupation = ?, contact = ?,
            bdate = ?, height = ?, `weight` = ?, philhealth = ? remarks =?, addedby = ?
            WHERE id_tbdots = ?");
            $stmt->execute([ $lname, $fname, $mi, $age, $sex, $address, $occupation, $contact, 
            $bdate, $height, $weight, $philhealth, $remarks, $addedby, $id_tbdots]);
            
            $message2 = "TB DOTS Data Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
             header("refresh: 0");
        }

        else {
            $message2 = "There was a problem in updating this data";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }
    }

    public function delete_tbdots(){
        $id_tbdots = $_POST['id_tbdots'];

        if(isset($_POST['delete_tbdots'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_tbdots where id_tbdots = ?");
            $stmt->execute([$id_tbdots]);

            header("Refresh:0");
        }
    }

    public function get_single_tbdots(){

        $id_tbdots = $_GET['id_tbdots'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_tbdots where id_tbdots = ?");
        $stmt->execute([$id_tbdots]);
        $tbdots = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $tbdots;
        }
        else{
            return false;
        }
    }

    public function count_tbdots() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_tbdots");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    
    public function count_male_tbdots() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_tbdots WHERE sex = 'Male'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function count_female_tbdots() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_tbdots WHERE sex = 'Female'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }


    //------------------------------------------ MOTHER CHILD CHECKUP CRUD -----------------------------------------------


    public function create_motherchild() {
        $id_resident = $_POST['id_resident'];
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mi = $_POST['mi'];
        $age = $_POST['age'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $remarks = $_POST['remarks'];
        $dateapply = $_POST['dateapply'];
        $addedby = $_POST['addedby'];


        $connection = $this->openConn();
        $stmt = $connection->prepare("INSERT INTO tbl_motherchild (`id_resident`, 
        `lname`, `fname`, `mi`, `age`, `contact`, `address`, `remarks`, `dateapply`, `addedby`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$id_resident, $lname, $fname, $mi, $age, 
        $contact, $address,  $remarks, $dateapply,  $addedby]);

        $message2 = "Application Applied, you will be receive our text message for further details";
        echo "<script type='text/javascript'>alert('$message2');</script>";
        header("refresh: 0");
        
    }

    public function view_motherchild(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_motherchild");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_motherchild() {
        if (isset($_POST['update_motherchild'])) {
            $id_motherchild = $_GET['id_motherchild'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $remarks = $_POST['remarks'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_motherchild SET lname = ?, fname = ?, mi = ?, 
            age = ?, contact = ?, address = ?, remarks = ?, addedby = ? WHERE id_motherchild = ?");
            $stmt->execute([ $lname, $fname, $mi, $age, $address, $contact, $remarks, $addedby, $id_motherchild]);
            
            $message2 = "Mother & Child Check-up Data Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
             header("refresh: 0");
        }
    }

    public function delete_motherchild(){
        $id_motherchild = $_POST['id_motherchild'];

        if(isset($_POST['delete_motherchild'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_motherchild where id_motherchild = ?");
            $stmt->execute([$id_motherchild]);

            header("Refresh:0");
        }
    }

    public function get_single_motherchild(){

        $id_motherchild = $_GET['id_motherchild'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_motherchild where id_motherchild = ?");
        $stmt->execute([$id_motherchild]);
        $motherchild = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $motherchild;
        }
        else{
            return false;
        }
    }

    public function count_motherchild() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_motherchild");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    //------------------------------------------------------- FAMILY PLAN CRUD ----------------------------------------------------------------------


    public function create_familyplan() {
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $status = $_POST['status'];
            $bdate = $_POST['bdate'];

            $spouse = $_POST['sp_lname']. " ". $_POST['sp_fname']. " ". $_POST['sp_mi'];
            $sp_age = $_POST['sp_age'];
            $sp_bdate = $_POST['sp_bdate'];
            $sp_occupation = $_POST['sp_occupation'];
            $children = $_POST['children'];
            $income = $_POST['income'];
            $id_resident = $_POST['id_resident'];
            $dateapply = $_POST['dateapply'];
            $addedby = $_POST['addedby'];

                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_familyplan (`id_resident`, 
                `lname`, `fname`, `mi`, `age`, `contact`, `address`, `occupation`, `status`, `bdate`, 
                `spouse`, `sp_age`, `sp_bdate`, `sp_occupation`, `children`, `income`, `dateapply`, 
                `addedby`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute([$id_resident, $lname, $fname, $mi, $age,
                $contact, $address, $occupation, $status, $bdate, $spouse, $sp_age, $sp_bdate, $sp_occupation,
                $children, $income, $dateapply,  $addedby]);

                $message2 = "Application Applied, you will be receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header('refresh:0');
    }

    public function view_familyplan(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_familyplan");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_familyplan() {
        if (isset($_POST['update_familyplan'])) {
            $id_familyplan = $_GET['id_familyplan'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $status = $_POST['status'];
            $bdate = $_POST['bdate'];

            $spouse = $_POST['sp_lname']. " ". $_POST['sp_fname']. " ". $_POST['sp_mi'];
            $sp_age = $_POST['sp_age'];
            $sp_bdate = $_POST['sp_bdate'];
            $sp_occupation = $_POST['sp_occupation'];
            $children = $_POST['children'];
            $income = $_POST['income'];
            $addedby = $_POST['addedby'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_familyplan SET lname = ?, fname = ?, mi = ?, 
            age = ?, contact = ?, address = ?, occupation = ?, status = ?, bdate =?, spouse = ?,
            sp_age = ?, sp_bdate = ?, sp_occupation = ?, children = ?, income = ?, addedby = ? WHERE id_familyplan = ?");
            $stmt->execute([ $lname, $fname, $mi, $age,  $contact, $address, $occupation, $status, $bdate,
            $spouse, $sp_age, $sp_bdate, $sp_occupation, $children, $income, $addedby, $id_familyplan]);
            
            $message2 = "Family Plan Data Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }
    }

    public function delete_familyplan(){
        $id_familyplan = $_POST['id_familyplan'];

        if(isset($_POST['delete_familyplan'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_familyplan where id_familyplan = ?");
            $stmt->execute([$id_familyplan]);

            header("Refresh:0");
        }
    }

    public function get_single_familyplan(){

        $id_familyplan = $_GET['id_familyplan'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_familyplan where id_familyplan = ?");
        $stmt->execute([$id_familyplan]);
        $familyplan = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $familyplan;
        }
        else{
            return false;
        }
    }

    public function count_familyplan() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_familyplan");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    //------------------------------------------ VACCINATION PROGRAM CRUD -----------------------------------------------


    public function create_vaccine() {

        if(isset($_POST['create_vaccine'])) {
            $id_resident = $_POST['id_resident'];
            $child = $_POST['child'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $bdate = $_POST['bdate'];
            $bplace = $_POST['bplace'];
            $address = $_POST['address'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $vaccine = $_POST['vaccine'];
            $vaccdate = $_POST['vaccdate'];
            $addedby = $_POST['addedby'];


            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_vaccine (`id_resident`, 
            `child`, `age`, `sex`, `bdate`, `bplace`, `address`, `height`,  `weight`,
            `lname`, `fname`, `mi`, `vaccine`, `vaccdate`, `addedby`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([$id_resident, $child, $age, $sex, $bdate, $bplace, $address, $height, $weight,
            $lname, $fname, $mi, $vaccine, $vaccdate, $addedby]);

            $message2 = "Application Applied, you will receive our text message for further details";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }
        
        
    }

    public function view_vaccine(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_vaccine");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function update_vaccine() {
        if (isset($_POST['update_vaccine'])) {
            $id_vaccine = $_GET['id_vaccine'];
            $child = $_POST['child'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            $bdate = $_POST['bdate'];
            $bplace = $_POST['bplace'];
            $address = $_POST['address'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $vaccine = $_POST['vaccine'];
            $vaccdate = $_POST['vaccdate'];
            $addedby = $_POST['addedby'];


            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_vaccine SET child = ?, age = ?, sex = ?,
            bdate = ?, bplace= ?, address = ?, height = ?, weight = ?, lname = ?, fname = ?, mi = ?, 
            vaccine = ?, vaccdate = ?, addedby = ? WHERE id_vaccine = ?");
            $stmt->execute([$child, $age, $sex, $bdate, $bplace, $address, $height, $weight,
            $lname, $fname, $mi, $vaccine, $vaccdate, $addedby, $id_vaccine]);
            
            $message2 = "Vaccination Program Data Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }
    }

    public function delete_vaccine(){
        $id_vaccine = $_POST['id_vaccine'];

        if(isset($_POST['delete_vaccine'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_vaccine where id_vaccine = ?");
            $stmt->execute([$id_vaccine]);

            header("Refresh:0");
        }
    }

    public function get_single_vaccine(){

        $id_vaccine = $_GET['id_vaccine'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_vaccine where id_vaccine = ?");
        $stmt->execute([$id_vaccine]);
        $vaccine = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $vaccine;
        }
        else{
            return false;
        }
    }

    public function count_vacc() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_vaccine");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function count_male_vacc() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_vaccine WHERE sex = 'Male'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    public function count_female_vacc() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) FROM tbl_vaccine WHERE sex = 'Female'");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();

        return $rescount;
    }

    //------------------------------------------ Certificate of Residency CRUD -----------------------------------------------
    public function get_single_certofres($id_resident){

        $id_resident = $_GET['id_resident'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_rescert where id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $resident;
        }
        else{
            return false;
        }
    }

    public function create_certofres() {
        if(isset($_POST['create_certofres'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $nationality = $_POST['nationality']; 
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $date = $_POST['date'];
            
            // purpose checker
            if($_POST['purpose'] == "Other"){
                $purpose = $_POST['otherInput'];
            } else {
                $purpose = $_POST['purpose'];
            }
    
            // Set the target directory
            $target_dir = "uploads/certofres/";
            $uploaded_file = $_FILES['certofres_photo'];
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    
            // Check if the target directory exists, and create it if not
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
    
            // Generate a unique filename based on the current timestamp
            $target_file = $target_dir . time() . '.' . $file_extension;
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['certofres_photo']["tmp_name"], $target_file)) {
                // Your database insertion code goes here
    
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_rescert (`id_resident`, `lname`, `fname`, `mi`,
                 `age`,`nationality`, `houseno`, `street`,`brgy`, `municipal`, `date`,`purpose`, `certofres_photo`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->execute([$id_resident, $lname, $fname, $mi,  $age, $nationality, $houseno,  $street, $brgy, $municipal, $date, $purpose, $target_file]);
    
                $message2 = "Application Applied, you will receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    

    public function view_certofres(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_rescert WHERE deleted_at IS NULL");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_certofres(){
        $id_rescert = $_POST['id_rescert'];

        if(isset($_POST['delete_certofres'])) {
            $connection = $this->openConn();
            // $stmt = $connection->prepare("DELETE FROM tbl_rescert where id_rescert = ?");
            $stmt = $connection->prepare("UPDATE tbl_rescert SET deleted_at = NOW() WHERE id_rescert = ?");
            $stmt->execute([$id_rescert]);

            header("Refresh:0");
        }
    }

     //------------------------------------------ CERT OF INIDIGENCY CRUD -----------------------------------------------

     public function create_certofindigency() {
        if(isset($_POST['create_certofindigency'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $nationality = $_POST['nationality']; 
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            
            // purpose checker
            if($_POST['purpose'] == "Other"){
                $purpose = $_POST['otherInput'];
            }
            else{
                $purpose = $_POST['purpose'];
            }
    
            $date = $_POST['date'];
    
            // Set the target directory
            $target_dir = "uploads/certofindigency/";
            $uploaded_file = $_FILES['certofindigency_photo'];
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    
            // Check if the target directory exists, and create it if not
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
    
            // Generate a unique filename based on the current timestamp
            $target_file = $target_dir . time() . '.' . $file_extension;
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['certofindigency_photo']["tmp_name"], $target_file)) {
                // Your database insertion code goes here
    
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_indigency (`id_resident`, `lname`, `fname`, `mi`,
                 `nationality`, `houseno`, `street`,`brgy`, `municipal`,`purpose`, `date`, `certofindigency_photo`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->execute([$id_resident, $lname, $fname, $mi,  $nationality, $houseno,  $street, $brgy, $municipal, $purpose, $date, $target_file]);
    
                $message2 = "Application Applied, you will receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }    

    

    public function view_certofindigency(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_indigency WHERE deleted_at IS NULL");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_certofindigency(){
        $id_indigency = $_POST['id_indigency'];

        if(isset($_POST['delete_certofindigency'])) {
            $connection = $this->openConn();
            // $stmt = $connection->prepare("DELETE FROM tbl_indigency where id_indigency = ?");
            $stmt = $connection->prepare("UPDATE tbl_indigency SET deleted_at = NOW() WHERE id_indigency = ?");
            $stmt->execute([$id_indigency]);

            header("Refresh:0");
        }
    }

    public function get_single_certofindigency($id_resident){

        $id_resident = $_GET['id_resident'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_indigency where id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $resident;
        }
        else{
            return false;
        }
    }


     //------------------------------------------ BRGY CLEARANCE CRUD -----------------------------------------------

     public function create_brgyclearance() {
        if(isset($_POST['create_brgyclearance'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            
            // purpose checker
            if($_POST['purpose'] == "Other"){
                $purpose = $_POST['otherInput'];
            }
            else{
                $purpose = $_POST['purpose'];
            }
            
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $status = $_POST['status'];
    
            // Set the target directory
            $target_dir = "uploads/brgyclearance/";
            $uploaded_file = $_FILES['brgyclearance_photo'];
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    
            // Check if the target directory exists, and create it if not
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
    
            // Generate a unique filename based on the current timestamp
            $target_file = $target_dir . time() . '.' . $file_extension;
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['brgyclearance_photo']["tmp_name"], $target_file)) {
                // Your database insertion code goes here
    
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_clearance (`id_resident`, `lname`, `fname`, `mi`,
                 `purpose`, `houseno`, `street`,`brgy`, `municipal`, `status`, `brgyclearance_photo`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->execute([$id_resident, $lname, $fname, $mi,  $purpose, 
                    $houseno,  $street, $brgy,   $municipal, $status, $target_file]);
    
                $message2 = "Application Applied, you will receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    

    public function get_single_clearance($id_resident){

        $id_resident = $_GET['id_resident'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_clearance where id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $resident;
        }
        else{
            return false;
        }
    }


    public function view_clearance(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_clearance WHERE deleted_at IS NULL  ");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_clearance(){
        $id_clearance = $_POST['id_clearance'];

        if(isset($_POST['delete_clearance'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_clearance SET deleted_at = NOW() where id_clearance = ?");
            $stmt->execute([$id_clearance]);

            header("Refresh:0");
        }
    }

    





    
    //------------------------------------------ EXTRA FUNCTIONS ----------------------------------------------

    public function check_admin($email) {

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
        $stmt->Execute([$email]);
        $total = $stmt->rowCount(); 

        return $total;
    }

    //eto yung function na mag bibigay restriction sa mga admin pages
    public function validate_admin() {
        $userdetails = $this->get_userdata();
    
        if (isset($userdetails)) {
            if ($userdetails['role'] == "administrator" || $userdetails['role'] == "Staff") {
                return $userdetails;
            } else {
                $this->show_404();
            }
        } else {
            // User is not logged in, display "Login First" alert
            echo '<script>alert("Login First");</script>';
            // Redirect to login page or take appropriate action if needed
            header('Location: ../index.php'); // Change 'login.php' to your login page
            exit();
        }
    }
    

    public function validate_staff() {

        if(isset($userdetails)) {
            if($userdetails['role'] != "administrator" || $userdetails['role'] != "user") {
                $this->show_404();
            }

            else {
                return $userdetails;
            }
        }
    }















    //----------------------------------------- DOCUMENT PROCESSING FUNCTIONS -------------------------------------
    //-------------------------------------------------------------------------------------------------------------

    public function create_bspermit() {
        if(isset($_POST['create_bspermit'])) {
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bsname = $_POST['bsname']; 
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $bsindustry = $_POST['bsindustry'];
            $aoe = $_POST['aoe'];
    
            // Set the target directory
            $target_dir = "uploads/bspermit/";
            $uploaded_file = $_FILES['bspermit_photo'];
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    
            // Check if the target directory exists, and create it if not
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
    
            // Generate a unique filename based on the current timestamp
            $target_file = $target_dir . time() . '.' . $file_extension;
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['bspermit_photo']["tmp_name"], $target_file)) {
                // Your database insertion code goes here
    
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_bspermit (`id_resident`, `lname`, `fname`, `mi`,
                 `bsname`, `houseno`, `street`,`brgy`, `municipal`, `bsindustry`, `aoe`, `bspermit_photo`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->execute([$id_resident, $lname, $fname, $mi, $bsname, $houseno, $street, $brgy, $municipal, $bsindustry, $aoe, $target_file]);
    
                $message2 = "Application Applied, you will receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    

    public function get_single_bspermit($id_resident){

        $id_resident = $_GET['id_resident'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_bspermit where id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $resident;
        }
        else{
            return false;
        }
    }


    public function view_bspermit(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_bspermit WHERE deleted_at IS NULL");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    // get the soft deleted data
    // public function view_deleted_bspermit(){
    //     $connection = $this->openConn();
    //     $stmt = $connection->prepare("SELECT * from tbl_bspermit WHERE deleted_at IS NOT NULL");
    //     $stmt->execute();
    //     $view = $stmt->fetchAll();
    //     return $view;
    // }


    public function delete_bspermit(){
        $id_bspermit = $_POST['id_bspermit'];

        if(isset($_POST['delete_bspermit'])) {
            $connection = $this->openConn();
            // $stmt = $connection->prepare("DELETE FROM tbl_bspermit where id_bspermit = ?");
            $stmt = $connection->prepare("UPDATE tbl_bspermit SET deleted_at = NOW() WHERE id_bspermit = ?");
            $stmt->execute([$id_bspermit]);

            header("Refresh:0");
        }
    }

    public function update_bspermit() {
        if (isset($_POST['update_bspermit'])) {
            $id_bspermit = $_GET['id_bspermit'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bsname = $_POST['bsname']; 
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $bsindustry = $_POST['bsindustry'];
            $aoe = $_POST['aoe'];


            $connection = $this->openConn();
            $stmt = $connection->prepare("UPDATE tbl_bspermit SET lname = ?, fname = ?,
            mi = ?, bsname = ?, houseno = ?, street = ?, brgy = ?, municipal = ?,
            bsindustry = ?, aoe = ? WHERE id_bspermit = ?");
            $stmt->execute([$id_bspermit, $lname, $fname, $mi,  $bsname, $houseno,  $street, $brgy, $municipal, $bsindustry, $aoe]);
            
            $message2 = "Barangay Business Permit Data Updated";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }
    }




    public function create_brgyid() {
        if(isset($_POST['create_brgyid'])) {
            $id_resident = $_POST['id_resident'];
            $lname = ucfirst(strtolower($_POST['lname']));
            $fname = ucfirst(strtolower($_POST['fname']));
            $mi = ucfirst(strtolower($_POST['mi']));
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = ucfirst(strtolower($_POST['brgy']));
            $municipal = ucfirst(strtolower($_POST['municipal']));
            $bplace = ucfirst(strtolower($_POST['bplace']));
            $bdate = $_POST['bdate'];
            
            // Process resident photo
            $res_photo = $_FILES['res_photo'];
            $uploaded_file = $_FILES['res_photo'];
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);

            $target_dir_res = "uploads/brgyid/";
            $target_file_res = $target_dir_res . time() . '.' . $file_extension;
            move_uploaded_file($res_photo['tmp_name'], $target_file_res);
            
            $inc_lname = ucfirst(strtolower($_POST['inc_lname']));
            $inc_fname = ucfirst(strtolower($_POST['inc_fname']));
            $inc_mi = ucfirst(strtolower($_POST['inc_mi']));;
            $inc_contact = $_POST['inc_contact'];
            $inc_houseno = $_POST['inc_houseno'];
            $inc_street = $_POST['inc_street'];
            $inc_brgy = $_POST['inc_brgy'];
    
            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_brgyid (`id_resident`, `lname`, `fname`, `mi`,
            `houseno`, `street`, `brgy`, `municipal`, `bplace`, `bdate`, `res_photo`, `inc_lname`,
            `inc_fname`, `inc_mi`, `inc_contact`, `inc_houseno`, `inc_street`, `inc_brgy`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
            $stmt->execute([$id_resident, $lname, $fname, $mi, $houseno, $street, $brgy, $municipal, 
                $bplace, $bdate, $target_file_res, $inc_lname, $inc_fname, $inc_mi, $inc_contact, 
                $inc_houseno, $inc_street, $inc_brgy]);
    
            $message2 = "Application Applied, you will receive our text message for further details";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header("refresh: 0");
        }  
    }
    

    public function get_single_brgyid($id_resident){

        $id_resident = $_GET['id_resident'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_brgyid where id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $resident;
        }
        else{
            return false;
        }
    }


    public function view_brgyid(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_brgyid WHERE deleted_at IS NULL");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_brgyid(){
        $id_bspermit = $_POST['id_brgyid'];

        if(isset($_POST['delete_brgyid'])) {
            $connection = $this->openConn();
            // $stmt = $connection->prepare("DELETE FROM tbl_brgyid where id_brgyid = ?");
            $stmt = $connection->prepare("UPDATE tbl_brgyid SET deleted_at = NOW() WHERE id_brgyid = ?");
            $stmt->execute([$id_bspermit]);

            header("Refresh:0");
        }
    }







    public function create_blotter() {
        if(isset($_POST['create_blotter'])) {
            // $id_blotter = $_POST['id_blotter'];
            $id_resident = $_POST['id_resident'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi']; 
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $blot_photo = $_FILES['blot_photo'];
            $contact = $_POST['contact'];
            $narrative = $_POST['narrative'];
    
            // Set the target directory
            $target_dir = "uploads/blotter/";
            $uploaded_file = $_FILES['blot_photo'];
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    
            // Check if the target directory exists, and create it if not
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
    
            // Generate a unique filename based on the current timestamp
            $target_file = $target_dir . time() . '.' . $file_extension;
    
            // Move the uploaded file to the target directory
            if (move_uploaded_file($blot_photo["tmp_name"], $target_file)) {
                // Your database insertion code goes here
    
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_blotter (`id_resident`, `lname`, `fname`, `mi`,
                `houseno`, `street`,`brgy`, `municipal`, `blot_photo`, `contact`, `narrative`)
                VALUES (    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                $stmt->execute([$id_resident, $lname, $fname, $mi, $houseno,  $street, $brgy, $municipal, 
                    $target_file, $contact, $narrative]);
    
                $message2 = "Application Applied, you will receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }  
    }

    public function get_single_blotter($id_resident){

        $id_resident = $_GET['id_resident'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_blotter where id_resident = ?");
        $stmt->execute([$id_resident]);
        $resident = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $resident;
        }
        else{
            return false;
        }
    }
   

    public function view_blotter(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_blotter WHERE deleted_at IS NULL");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_blotter(){
        $id_blotter = $_POST['id_blotter'];

        if(isset($_POST['delete_blotter'])) {
            $connection = $this->openConn();
            // $stmt = $connection->prepare("DELETE FROM tbl_blotter where id_blotter = ?");
            $stmt = $connection->prepare("UPDATE tbl_blotter SET deleted_at = NOW() WHERE id_bspermit = ?");
            $stmt->execute([$id_blotter]);

            header("Refresh:0");
        }
    }

    public function update_blotter() {
        if (isset($_POST['update_blotter'])) {
            $id_blotter = $_POST['id_blotter'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $municipal = $_POST['municipal'];
            $blot_photo = $_FILES['blot_photo'];
            $contact = $_POST['contact'];
            $narrative = $_POST['narrative'];
    
            // Check if a new image file is uploaded
            if (!empty($blot_photo['name'])) {
                // Set the target directory
                $target_dir = "uploads/blotter/";
                $file_extension = pathinfo($blot_photo['name'], PATHINFO_EXTENSION);
    
                // Check if the target directory exists, and create it if not
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
    
                // Generate a unique filename based on the current timestamp
                $target_file = $target_dir . time() . '.' . $file_extension;
    
                // Move the uploaded file to the target directory
                if (move_uploaded_file($blot_photo["tmp_name"], $target_file)) {
                    // Update the database with the new image file
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("UPDATE tbl_blotter SET lname = ?, fname = ?,
                        mi = ?, houseno = ?, street = ?, brgy = ?, municipal = ?,
                        blot_photo = ?, contact = ?, narrative = ? WHERE id_blotter = ?");
                    $stmt->execute([$lname, $fname, $mi, $houseno, $street, $brgy, $municipal,
                        $target_file, $contact, $narrative, $id_blotter]);
    
                    $message2 = "Complain/Blotter Data Updated with new photo";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    header("refresh: 0");
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                // If no new image file is uploaded, update the database without changing the photo
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_blotter SET lname = ?, fname = ?,
                    mi = ?, houseno = ?, street = ?, brgy = ?, municipal = ?,
                    contact = ?, narrative = ? WHERE id_blotter = ?");
                $stmt->execute([$lname, $fname, $mi, $houseno, $street, $brgy, $municipal,
                    $contact, $narrative, $id_blotter]);
    
                $message2 = "Complain/Blotter Data Updated without changing the photo";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }
        }
    }
    

    

}

    

$bmis = new BMISClass(); //variable to call outside of its class

?>
