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
            $stmt = $connection->prepare("SELECT * from tbl_vaccination");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        // public function view_vaccine_record(){
        //     $connection = $this->openConn();
        
        //     $stmt = $connection->prepare("SELECT * FROM tbl_vaccination");
        //     $stmt->execute();
        //     $view = $stmt->fetchAll();
        
        //     return $view;
        // }
        

        //old code
        public function view_vaccine_record(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * 
                FROM tbl_vaccination
                LEFT JOIN tbl_user ON tbl_user.id_user = tbl_vaccination.pet_owner_id");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        
        

        // #inventory

        public function view_inventory(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //with pagination
        // public function view_inventory($page = 1, $recordsPerPage = 3){
        //     $startFrom = ($page - 1) * $recordsPerPage;
        //     $connection = $this->openConn();

        //     // $stmt = $connection->prepare("SELECT * from tbl_user");
        //     $stmt = $connection->prepare("SELECT * from tbl_inventory WHERE deleted_at IS NULL LIMIT $startFrom, $recordsPerPage");
        //     $stmt->execute();
        //     $view = $stmt->fetchAll();
        //     //$rows = $stmt->
        //     return $view;
           
        // }

        public function view_low_inventory(){
            // $startFrom = ($page - 1) * $recordsPerPage;
            $connection = $this->openConn();
        
            // Modify the SQL query to include a WHERE clause
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE deleted_at IS NULL AND quantity < 20");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        

        public function view_single_inventory(){

            $id_inv = $_GET['inv_id'];
            
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory where inv_id = '$id_inv'");
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

        public function create_inventory() {
            if (isset($_POST['create_inventory'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $category = $_POST['category'];
                $new_picture = $_FILES['new_picture'];

        
                if (!empty($new_picture['name'])) {
                    $target_dir = "../uploads/inventory/";
                    $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }
        
                    $target_file = $target_dir . time() . '.' . $file_extension;
        
                    if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                        $connection = $this->openConn();
                        $stmt = $connection->prepare("INSERT INTO tbl_inventory (name, price, quantity, picture, category) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$name, $price, $qty, $target_file, $category]);
        
                        $message2 = "Item created!";
                        echo "<script type='text/javascript'>alert('$message2');</script>";
                        header("refresh: 0");
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_inventory (name, price, quantity) VALUES (?, ?, ?)");
                    $stmt->execute([$name, $price, $qty]);
        
                    $message2 = "Item created";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    header("refresh: 0");
                }
            }
        }        

        public function update_inventory() {
            if (isset($_POST['update_inventory'])) {
                $inv_id = $_GET['inv_id'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $new_picture = $_FILES['new_picture'];
        
                if (!empty($new_picture['name'])) {
                    $target_dir = "../uploads/inventory/";
                    $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }
        
                    $target_file = $target_dir . time() . '.' . $file_extension;
        
                    if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                        $connection = $this->openConn();
                        $stmt = $connection->prepare("UPDATE tbl_inventory
                            SET name =?, price =?, quantity = ?, picture = ? WHERE inv_id = ?");
                        $stmt->execute([$name, $price, $qty, $target_file, $inv_id]);
        
                        $message2 = "Item Updated";
                        echo "<script type='text/javascript'>alert('$message2');</script>";
                        header("refresh: 0");
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("UPDATE tbl_inventory
                        SET name =?, price =?, quantity = ? WHERE inv_id = ?");
                    $stmt->execute([$name, $price, $qty, $inv_id]);
        
                    $message2 = "Item Updated";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    header("refresh: 0");
                }
            }
        }

        public function delete_invetory(){
            $inv_id = $_POST['inv_id'];
    
            if(isset($_POST['delete_inventory'])) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_inventory set deleted_at = NOW() where inv_id = ?");
                $stmt->execute([$inv_id]);
                
                $message2 = "Item Removed";
                
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header('refresh:0');
            }
        }
        

        //View User
        public function view_user(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from tbl_user WHERE deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        public function view_single_user(){

            $id_user = $_GET['id_user'];
            
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = '$id_user'");
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

        
        public function delete_user(){
            $id_user = $_POST['id_user'];
    
            if(isset($_POST['delete_inventory'])) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_user set deleted_at = NOW() where id_user = ?");
                $stmt->execute([$id_user]);
                
                $message2 = "User Removed";
                
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header('refresh:0');
            }
        }

        public function view_pet(){
            $id_user = $_GET['id_user'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_pet where deleted_at IS NULL AND pet_owner_id = ?");
            $stmt->execute([$id_user]);
            $view = $stmt->fetchAll();
    
            return $view;
        }

        public function view_single_staff($id_admin){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT id_admin, email, fname, lname, mi, role FROM tbl_admin where id_admin = '$id_admin'");
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

        public function update_staff($id_user) {
            if (isset($_POST['update_staff'])) {
                // $id_user = $_GET['id_user'];
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

                    $message2 = "Admin Account Updated";
    
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
            $stmt = $connection->prepare("SELECT COUNT(*)-1 from tbl_vaccination");
            $stmt->execute();
            $staffcount = $stmt->fetchColumn();

            return $staffcount;
        }

        //Count Users / Client
        // public function count_user() {
        //     $connection = $this->openConn();

        //     // $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
        //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
        //     $stmt->execute();
        //     $staffcount = $stmt->fetchColumn();

        //     return $staffcount;
        // }

        public function count_vaccine_record() {
            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_vaccination");
            $stmt->execute();
            $staffcount = $stmt->fetchColumn();

            return $staffcount;
        }

        public function count_inventory() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_low_inventory() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE deleted_at IS NULL AND quantity <= 20");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_user() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user WHERE deleted_at IS NULL");
            $stmt->execute();
            $rescount = $stmt->fetchColumn();
            return $rescount;
        }

        public function count_pet() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_pet WHERE deleted_at IS NULL");
            $stmt->execute();
            $rescount = $stmt->fetchColumn();
            return $rescount;
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
<link href="customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<link href="../css/custom.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- custom js -->
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
<?php 
    include('dashboard_sidebar_end.php');
?>
