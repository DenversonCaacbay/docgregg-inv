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
        

        // #vaccine
        public function create_vaccination_record() {
            if (isset($_POST['add_vac'])) {
                $pet_id = $_GET['pet_id'];
                $owner_id = $_GET['id_user']; // Make sure owner_id is an integer
                $vac_used = $_POST['vaccine'];
                $next_vac = $_POST['next_vac'];
                // $vacc_done_check = $_POST['vacc_done_check'];

                if(empty($next_vac)){
                    $next_vac = NULL;
                }
        
                // proceed to create without picture
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_vaccination (`pet_id`, `pet_owner_id`, `vac_next`, `vac_used`) VALUES (?, ?, ?, ?)");
                $stmt->execute([$pet_id, $owner_id, $next_vac, $vac_used]);
        
                $message2 = "Pet vaccination record added!";
                echo "<script type='text/javascript'>alert('$message2');</script>";
        
                echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
            }
        }
        

        public function view_vaccine_record(){
            $connection = $this->openConn();

            $pet_id = $_GET['pet_id'];

            // $stmt = $connection->prepare("SELECT * 
            //     FROM tbl_vaccination
            //     LEFT JOIN tbl_user ON tbl_user.id_user = tbl_vaccination.pet_owner_id");

            $stmt = $connection->prepare("SELECT * 
                FROM tbl_vaccination
                LEFT JOIN tbl_user ON tbl_user.id_user = tbl_vaccination.pet_owner_id
                LEFT JOIN tbl_pet ON tbl_pet.pet_id = tbl_vaccination.pet_id
                WHERE tbl_pet.pet_id = ? AND tbl_pet.deleted_at IS NULL
            ");  
            $stmt->execute([$pet_id]);
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_single_vaccine_record(){

            $vac_id = $_GET['vac_id'];
            
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_vaccination where vac_id = '$vac_id'");
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
                $bought_date = $_POST['bought_date'];
                $exp = $_POST['exp_date'];
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
                        $stmt = $connection->prepare("INSERT INTO tbl_inventory (name, price, quantity, picture, category, expired_at, purchased_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$name, $price, $qty, $target_file, $category, $exp, $bought_date]);
        
                        $message2 = "Item created!";
                        echo "<script type='text/javascript'>alert('$message2');</script>";
                        header("refresh: 0");
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_inventory (name, price, quantity, category, expired_at, purchased_at) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $price, $qty, $category, $exp, $bought_date]);
        
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
                $category = $_POST['category'];
                $bought_date = $_POST['bought_date'];
                $exp = $_POST['exp_date'];
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
                            SET name =?, price =?, quantity = ?, category = ?,picture = ?, expired_at = ?, purchased_at = ?
                            WHERE inv_id = ?");
                        $stmt->execute([$name, $price, $qty, $category, $target_file, $exp, $bought_date,$inv_id]);
        
                        $message2 = "Item Updated";
                        echo "<script type='text/javascript'>alert('$message2');</script>";
                        header("refresh: 0");
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("UPDATE tbl_inventory
                        SET name =?, price =?, quantity = ?, category = ?, expired_at = ?, purchased_at = ?
                        WHERE inv_id = ?");
                    $stmt->execute([$name, $price, $qty, $category, $exp, $bought_date, $inv_id]);
        
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

        public function view_invoice(){
            $connection = $this->openConn();
        
            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from invoice ORDER BY created_at DESC");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
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

        // #pet
        public function create_pet($owner_id) {
            if (isset($_POST['add_pet'])) {
                $pet_name = ucfirst(strtolower($_POST['pet_name']));
                $breed = $_POST['breed'];
                $bdate = $_POST['bdate'];
                $sex = $_POST['sex'];
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
                        $stmt = $connection->prepare("INSERT INTO tbl_pet 
                            (`pet_name`, `pet_owner_id`, `pet_picture`, `breed`, `bdate`, `sex`) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$pet_name, $owner_id, $target_file, $breed, $bdate, $sex]);
        
                        $message2 = "Pet added!";
                        echo "<script type='text/javascript'>alert('$message2');</script>";
        
                        // echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    // proceed to create without picture
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_pet 
                        (`pet_name`, `pet_owner_id`, `breed`, `bdate`, `sex`) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$pet_name, $owner_id, $breed, $bdate, $sex]);
        
                    $message2 = "Pet added!";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
        
                    // echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
                }

                echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
                // return '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
            }
        }
        
        public function view_pet(){
            $id_user = $_GET['id_user'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT *, TIMESTAMPDIFF(YEAR, bdate, CURDATE()) AS age FROM tbl_pet WHERE deleted_at IS NULL AND pet_owner_id = ?");
            $stmt->execute([$id_user]);
            $view = $stmt->fetchAll();
    
            return $view;
        }

        public function view_single_pet(){
            $connection = $this->openConn();
    
            $pet_id = $_GET['pet_id'];
    
            $stmt = $connection->prepare("SELECT tbl_pet.*, 
                TIMESTAMPDIFF(YEAR, tbl_pet.bdate, CURDATE()) AS age, tbl_vaccination.*
                FROM tbl_pet
                LEFT JOIN (
                    SELECT *
                    FROM tbl_vaccination
                    WHERE pet_id = ?
                    ORDER BY created_at DESC
                    LIMIT 1
                ) AS tbl_vaccination ON tbl_pet.pet_id = tbl_vaccination.pet_id
                WHERE tbl_pet.pet_id = ?
            ");
            $stmt->execute([$pet_id, $pet_id]);
            $view = $stmt->fetch();
    
            return $view;
        }

        public function view_single_staff($id_admin){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT id_admin, email, fname, lname, mi, role, picture FROM tbl_admin where id_admin = '$id_admin'");
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
                $password = ($_POST['password']);
                $lname = ucfirst(strtolower($_POST['lname'])); // Convert to uppercase
                $fname = ucfirst(strtolower($_POST['fname'])); // Convert to uppercase
                // $mi = strtoupper(substr($_POST['mi'], 0, 1)) . '.'; // Get first letter in uppercase and add '.'
                $mi = ""; // Get first letter in uppercase and add '.'
                $role = $_POST['role'];
                $email = $_POST['email'];
        
                // Check if a new picture is uploaded
                $new_picture = $_FILES['new_picture'];
                $target_dir = "../uploads/admin/";
        
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
        
                        // Update the staff information including the new picture
                        $stmt = $connection->prepare("UPDATE tbl_admin SET lname = ?, fname = ?, mi = ?, role = ?, email = ?, picture = ? WHERE id_admin = ?");
                        $stmt->execute([$lname, $fname, $mi, $role, $email, $uploaded_file, $id_user]);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        return;
                    }
                } else {
                    // Update staff information without changing the picture
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("UPDATE tbl_admin SET lname = ?, fname = ?, mi = ?, role = ?, email = ? WHERE id_admin = ?");
                    $stmt->execute([$lname, $fname, $mi, $role, $email, $id_user]);
                }
        
                $message2 = "Admin Account Updated";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header('refresh:0');
            }
        }

        public function update_password($id_user) {
            if (isset($_POST['update_password'])) {
                $new_password = $_POST['new_password']; // New password input
                $confirm_password = $_POST['confirm_password']; // Confirm password input
        
                // Validate the new password and confirm password
                if (!empty($new_password) && $new_password === $confirm_password) {
                    // Hash the new password before storing it
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
                    // Update only the password column
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("UPDATE tbl_admin SET password = ? WHERE id_admin = ?");
                    $stmt->execute([$hashed_password, $id_user]);
        
                    $message2 = "Admin Password Updated";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                    header('refresh:0');
                } else {
                    echo "<script type='text/javascript'>alert('New password and confirm password do not match.');</script>";
                    return;
                }
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

        public function count_invoice() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) from invoice");
            $stmt->execute();
            $rescount = $stmt->fetchColumn();
            return $rescount;
        }

        // public function count_total() {
        //     $connection = $this->openConn();
        //     $stmt = $connection->prepare("SELECT COUNT(*) from invoice");
        //     $stmt->execute();
        //     $rescount = $stmt->fetchColumn();
        //     return $rescount;
        // }
        public function count_total() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT SUM(total) FROM invoice");
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

        public function recent_user() {
            $connection = $this->openConn();
            $limit = 5;

            $stmt = $connection->prepare("SELECT * FROM tbl_user 
            JOIN tbl_pet ON tbl_pet.pet_owner_id = tbl_user.id_user
            WHERE tbl_user.deleted_at IS NULL AND tbl_pet.deleted_at IS NULL
            ORDER BY tbl_pet.created_at DESC
            LIMIT ".$limit);    
            $stmt->execute();
            $view = $stmt->fetchAll();

            return $view;
        }

        public function recent_user_all() {
            $connection = $this->openConn();

            $stmt = $connection->prepare("SELECT * FROM tbl_user 
            JOIN tbl_pet ON tbl_pet.pet_owner_id = tbl_user.id_user
            WHERE tbl_user.deleted_at IS NULL AND tbl_pet.deleted_at IS NULL
            ORDER BY tbl_pet.created_at DESC");    
            $stmt->execute();
            $view = $stmt->fetchAll();

            return $view;
        }


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
