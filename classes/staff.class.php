<?php 

    require_once('main.class.php');

    // check if user is logged
    if(!is_null($_SESSION['userdata'])){
        if($user_role == 'administrator'){
            header('Location: admin_dashboard.php');
        }
        else if($user_role == 'staff'){
            header('Location: staff_dashboard.php');
        }
        else{
            header('Location: index.php');
        }  
    }

    class StaffClass extends BMISClass {

        /*
        //authentication method for residents to enter
        public function residentlogin() {
        if(isset($_POST['residentlogin'])) {

            $username = $_POST['email'];
            $password = $_POST['password']; 
        
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_residents WHERE email = ? AND password = ?");
            $stmt->Execute([$username, $password]);
            $user = $stmt->fetch();
            $total = $stmt->rowCount();
            
                //calls the set_userdata function 
                if($total > 0) {
                    $this->set_userdata($user);
                    header('Location: resident_homepage.php');
                }
                
                else {
                    echo '<script>alert("Email or Password is Invalid")</script>';
                }
            }
        }
        */

    //------------------------------------- CRUD FUNCTIONS FOR STAFF -----------------------------------------------

        public function create_staff() {

            if(isset($_POST['add_staff'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirm_password = ($_POST['confirm_password']);
                $lname = ucfirst(strtolower($_POST['lname'])); // Convert to uppercase
                $fname = ucfirst(strtolower($_POST['fname'])); // Convert to uppercase
                $mi = strtoupper(substr($_POST['mi'], 0, 1)) . '.'; // Get first letter in uppercase and add '.'
                $role = $_POST['role'];

                // Check password length
                if (strlen($password) < 8) {
                    // Password is too short, show an error message
                    $messageError = "Password must be at least 8 characters long.";
                    echo "<script type='text/javascript'>alert('$messageError');</script>";
                    return;
                }

                if ($this->check_staff($email) == 0 ) {

                    // Check if the password and confirm password match
                    if ($password !== $confirm_password) {
                        $message = "Password and Confirm Password do not match";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        return false;
                    }

                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_admin (`email`,`password`,`lname`,`fname`, `mi`,`role`) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->Execute([$email, $password_hash, $lname, $fname, $mi,$role]);
                    $message2 = "New Staff Adedd";
    
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    header('refresh:0');
    
                }

                else {
                    echo "<script type='text/javascript'>alert('Email Account already exists');</script>";
                }
            }
        }


        public function view_staff(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from tbl_vaccine_record");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        public function view_vaccine_record(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT *
                FROM tbl_vaccine_record
                INNER JOIN tbl_pet ON tbl_pet.pet_id = tbl_vaccine_record.pet_id
                INNER JOIN tbl_user ON tbl_user.id_user = tbl_pet.pet_owner_id;
            ");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        public function view_inventory(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from tbl_inventory");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        //View User
        public function view_user(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        public function view_single_staff(){

            $id_staff = $_GET['id_staff'];
            
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = '$id_staff'");
            $stmt->execute();
            $view = $stmt->fetch(); 
            $total = $stmt->rowCount();
 
            //eto yung condition na i ch check kung may laman si products at i re return niya kapag meron
            if($total > 0 )  {
                return $view;
            }
            else{
                return false;
            }
        }

        public function update_staff() {
            if (isset($_POST['update_staff'])) {
                $id_user = $_GET['id_user'];
                $password = ($_POST['password']);
                $lname = ucfirst(strtolower($_POST['lname'])); // Convert to uppercase
                $fname = ucfirst(strtolower($_POST['fname'])); // Convert to uppercase
                $mi = strtoupper(substr($_POST['mi'], 0, 1)) . '.'; // Get first letter in uppercase and add '.'
                $role = $_POST['role'];
                $email = $_POST['email'];
                
                    $connection = $this->openConn();

                    // Check if the provided email matches the current user's email
                    $stmtEmailCheck = $connection->prepare("SELECT email FROM tbl_admin WHERE id_admin = ?");
                    $stmtEmailCheck->execute([$id_user]);
                    $currentUserEmail = $stmtEmailCheck->fetchColumn();

                    // checks if user changes email
                    if ($email !== $currentUserEmail) {
                        // Provided email is different, check for its existence
                        $stmtEmailExist = $connection->prepare("SELECT COUNT(*) FROM tbl_admin WHERE email = ?");
                        $stmtEmailExist->execute([$_POST['email']]);
                        $emailExists = $stmtEmailExist->fetchColumn();
            
                        if ($emailExists > 0) {
                            // Email already exists, show an error message
                            $messageError = "Email already exists. Please choose a different email.";
                            echo "<script type='text/javascript'>alert('$messageError');</script>";
                            header('refresh:0');
                            return;
                        }
                    }

                    $stmt = $connection->prepare(
                        "UPDATE tbl_admin SET lname = ?, fname = ?, mi = ?, role = ?, email = ? WHERE id_admin = ?");
                    $stmt->execute([$lname, $fname, $mi, $role, $email, $id_user]);

                    $message2 = "Staff Account Updated";
    
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    header('refresh:0');

            }
        }

        public function delete_staff(){

            $id_user = $_POST['id_user'];

            if(isset($_POST['delete_staff'])) {
                $connection = $this->openConn();
                // $stmt = $connection->prepare("DELETE FROM tbl_user where id_user = ?");
                $stmt = $connection->prepare("DELETE FROM tbl_admin where id_admin = ?");
                $stmt->execute([$id_user]);
                
                $message2 = "Staff Account Deleted";
                
                echo "<script type='text/javascript'>alert('$message2');</script>";
                 header('refresh:0');
            }
        }

    //--------------------------------------------- EXTRA FUNCTIONS FOR STAFF -------------------------------------------------

            public function get_single_staff($id_user){

                $id_user = $_GET['id_user'];
                
                $connection = $this->openConn();
                // $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = ?");
                $stmt = $connection->prepare("SELECT * FROM tbl_admin where id_admin = ?");
                $stmt->execute([$id_user]);
                $user = $stmt->fetch();
                $total = $stmt->rowCount();

                if($total > 0 )  {
                    return $user;
                }
                else{
                    return false;
                }
            }


        public function check_staff($id_user) {

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
            $stmt->Execute([$id_user]);
            $total = $stmt->rowCount(); 

            return $total;
        }

        public function count_staff() {
            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_vaccine_record");
            $stmt->execute();
            $staffcount = $stmt->fetchColumn();

            return $staffcount;
        }

        //Count Users / Client
        public function count_user() {
            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
            $stmt->execute();
            $staffcount = $stmt->fetchColumn();

            return $staffcount;
        }

        public function count_vaccine_record() {
            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_vaccine_record");
            $stmt->execute();
            $staffcount = $stmt->fetchColumn();

            return $staffcount;
        }

        public function count_inventory() {
            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_inventory");
            $stmt->execute();
            $staffcount = $stmt->fetchColumn();

            return $staffcount;
        }

        // public function count_mstaff() {
        //     $connection = $this->openConn();

        //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user where sex = 'male'");
        //     $stmt->execute();
        //     $staffcount = $stmt->fetchColumn();

        //     return $staffcount;
        // }

        // public function count_fstaff() {
        //     $connection = $this->openConn();

        //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user where sex = 'female'");
        //     $stmt->execute();
        //     $staffcount = $stmt->fetchColumn();

        //     return $staffcount;
        // }


        //===================================== SCOPE CHANGED FEATURES =======================================

        public function view_staff_male(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * from tbl_user WHERE `sex` = 'Male'");
            $stmt->execute();   
            $view = $stmt->fetchAll();
            return $view;
        }
    
        public function view_staff_female(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * from tbl_user WHERE `sex` = 'Female'");
            $stmt->execute();
            $view = $stmt->fetchAll();
            return $view;
        }





    }
    $staffbmis = new StaffClass();
?>

<!-- JS and CSS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>