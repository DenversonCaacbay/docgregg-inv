<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- SweetAlert 2 JS (including dependencies) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>


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
                $vac_condition = $_POST['vac_condition'];
                $next_vac = $_POST['next_vac'];
                // $vacc_done_check = $_POST['vacc_done_check'];

                if(empty($next_vac)){
                    $next_vac = NULL;
                    $is_done = 1;
                }
                else{
                    $is_done = 0;
                }
        
                // proceed to create without picture
                $connection = $this->openConn();
                $stmt = $connection->prepare("INSERT INTO tbl_vaccination (`pet_id`, `pet_owner_id`, `vac_next`,`vac_condition`, `vac_used`,`is_done`) VALUES (?,?, ?, ?, ?,?)");
                $stmt->execute([$pet_id, $owner_id, $next_vac, $vac_condition, $vac_used, $is_done]);
        
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

        public function done_vaccine(){
            $connection = $this->openConn();
            $vac_id = $_POST['vac_id'];

            if(isset($_POST['is_done_true'])){
                $stmt = $connection->prepare("UPDATE tbl_vaccination SET is_done = '1' WHERE vac_id = ?");
                $stmt->execute([$vac_id]);
                $message2 = "Vaccination marked as done";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }
        }

        // #inventory
        public function view_inventory() {
            $connection = $this->openConn();
        
            $stmt = $connection->prepare(" SELECT *  FROM tbl_inventory WHERE deleted_at IS NULL AND quantity != low_stock ORDER BY  CASE WHEN quantity <= low_stock THEN 0  ELSE 1  END, created_at DESC");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }             
        // inventory Internal
        // public function view_inventory_internal(){
        //     $connection = $this->openConn();
        
        //     $stmt = $connection->prepare("SELECT *  FROM tbl_inventory  WHERE (type='Internal') AND deleted_at IS NULL AND quantity != '0' AND (expired_at < CURDATE() OR expired_at > DATE_ADD(CURDATE(), INTERVAL 30 DAY))");
        //     $stmt->execute();
        //     $view = $stmt->fetchAll();
        
        //     return $view;
        // }
        public function view_inventory_internal() {
            $connection = $this->openConn();
        
            // Query to select internal inventory items that are not deleted, not zero quantity,
            // and either expired or expiring in more than 30 days from today
            $stmt = $connection->prepare("
                SELECT * 
                FROM tbl_inventory 
                WHERE type = 'Internal' 
                  AND deleted_at IS NULL 
                  AND quantity != low_stock 
                  AND (expired_at < CURDATE() OR expired_at > DATE_ADD(CURDATE(), INTERVAL 30 DAY))
                ORDER BY 
                  CASE 
                    WHEN quantity <= low_stock THEN 0 
                    ELSE 1 
                  END, 
                  created_at DESC
            ");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        
        // public function view_inventory($limit = 5, $offset = 0){
        //     $connection = $this->openConn();
        //     $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE deleted_at IS NULL LIMIT :limit OFFSET :offset");
        //     $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        //     $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        //     $stmt->execute();
        //     $view = $stmt->fetchAll();
            
        //     // Fetch one extra record beyond the limit to check if there are more records
        //     $stmt->fetch(PDO::FETCH_ASSOC);
        //     $moreRecords = $stmt->rowCount() > 0;
            
        //     return [$view, $moreRecords];
        // }



        // inventory all - expiring in 30 days
        public function view_inventory_expire(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * 
                FROM tbl_inventory 
                WHERE (type='Internal' OR type='External') 
                AND deleted_at IS NULL 
                AND quantity != '0'
                AND expired_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_inventory_logs(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_log_inventory ORDER BY log_date DESC");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_services_logs(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_log_services ORDER BY log_date DESC");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        

        //For Cat food
        public function view_inventory_catfood(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Cat Food' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Dog Food
        public function view_inventory_dogfood(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Dog Food' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Medicine
        public function view_inventory_medicine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Medicine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Internal Medicine
        public function view_inventory_internal_medicine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='Internal' OR type='Both') AND category = 'Medicine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Syringe
        public function view_inventory_syringe(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Syringe' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Internal Syringe
        public function view_inventory_internal_syringe(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='Internal' OR type='Both') AND category = 'Syringe' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Vaccine
        public function view_inventory_vaccine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Iternal Vaccine
        public function view_inventory_internal_vaccine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='Internal' OR type='Both') AND category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For Shampoo
        public function view_inventory_shampoo(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Shampoo' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_vaccine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_single_customers(){
            $id_user = $_GET['id'];
            $connection = $this->openConn();
        
            // Retrieve user information
            $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE id_user = ?");
            $stmt->execute([$id_user]);
            $view = $stmt->fetch();

            return $view;
        }

        
        // public function view_customer_services(){
        //     $id_user = $_GET['id'];
        //     $connection = $this->openConn();
        
        //     // get pets
        //     $stmt_pets = $connection->prepare("SELECT serv_id FROM tbl_services WHERE cli_id = ?");
        //     $stmt_pets->execute([$id_user]);
        //     $pets = $stmt_pets->fetchAll(PDO::FETCH_COLUMN);

        //     // Convert pets array into comma-separated string
        //     $pet_ids_str = implode(',', $pets);

        //     // get pet services
        //     if(!empty($pet_ids_str)) {
        //         $stmt_services = $connection->prepare("SELECT * FROM tbl_pet
        //             JOIN tbl_services ON tbl_pet.pet_id = tbl_services.pet_id
        //             WHERE tbl_pet.pet_id IN ($pet_ids_str)");
        //         $stmt_services->execute();
        //         $view = $stmt_services->fetchAll();
        //     } else {
        //         // If no pets found, return an empty array
        //         $view = [];
        //     }

        //     return $view;
        // }

        public function view_customer_services(){
            $id_user = $_GET['id'];
            $connection = $this->openConn();
        
            // get pet services
            $stmt_services = $connection->prepare("SELECT * FROM tbl_services WHERE cli_id = ?");
            $stmt_services->execute([$id_user]);
            $view = $stmt_services->fetchAll(PDO::FETCH_ASSOC);
        
            return $view;
        }
        

        public function view_customer_pets(){
            $id_user = $_GET['id'];
            $connection = $this->openConn();
        
            // get pets
            $stmt_pets = $connection->prepare("SELECT * FROM tbl_pet WHERE pet_owner_id = ?");
            $stmt_pets->execute([$id_user]);
            $view = $stmt_pets->fetchAll();

            return $view;
        }
        

        public function view_customers(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE deleted_at IS NULL ORDER BY created_at DESC");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        // public function view_customers($limit = 5, $offset = 0){
        //     $connection = $this->openConn();
        //     $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE deleted_at IS NULL LIMIT :limit OFFSET :offset");
        //     $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        //     $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        //     $stmt->execute();
        //     $view = $stmt->fetchAll();
            
        //     // Fetch one extra record beyond the limit to check if there are more records
        //     $stmt->fetch(PDO::FETCH_ASSOC);
        //     $moreRecords = $stmt->rowCount() > 0;
            
        //     return [$view, $moreRecords];
        // }
        

        public function update_customer(){
            $id_user = $_GET['id'];

            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            if (isset($_POST['update_customer'])) {
                $connection = $this->openConn();

                $stmt = $connection->prepare("UPDATE tbl_user SET  
                    `customer_name` = ?,  `customer_contact` = ?, 
                    `customer_email` = ?,  `customer_address` = ?
                WHERE id_user = ?");

                $stmt->execute([ $customer_name, $customer_contact, $customer_email, 
                $customer_address, $id_user]);
                
                echo "
                    <script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated Sucessfully',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                    </script>
                ";

                        // Redirect after showing the alert
                header("refresh: 1; url=view_customer.php?id=$id_user");
                // echo "<script type='text/javascript'>alert('Customer updated!');</script>";
                // header("Refresh:0");
            }
        }

        public function delete_customer(){
            $id_user = $_GET['id'];
    
            if(isset($_POST['delete_customer'])) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_user set deleted_at = NOW() where id_user = ?");
                $stmt->execute([$id_user]);
                
                echo "<script type='text/javascript'>
                    alert('Customer removed!');
                    location.href = 'services.php';
                </script>";
            }
        }

        public function view_services_all(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT s.*, t.treatment_name 
                                  FROM tbl_services s 
                                  LEFT JOIN tbl_treatment t ON s.serv_id = t.serv_id 
                                  WHERE s.deleted_at IS NULL 
                                  ORDER BY s.created_at DESC");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        public function view_services_consultation(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Consultation', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }

        public function view_services_vaccination(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Vaccination', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_deworming(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Deworming', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_heartworm(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Heartworm', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_treatment(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Treatment', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_surgery(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Surgery', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_laboratory(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Laboratory', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_confinement(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Confinement', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_diagnostic(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Diagnostic', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_grooming(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Grooming', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_cesarian(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Cesarian Section Surgery', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }
        public function view_services_bloodchem(){
            $connection = $this->openConn();
    
            $stmt = $connection->prepare("SELECT * FROM tbl_services WHERE FIND_IN_SET('Blood Chemistry Test', REPLACE(service_availed, ', ', ',')) > 0");
            $stmt->execute();
            $view = $stmt->fetchAll();
            
            return $view;
        }

// ------------------------------------------------------------------------START EXTERNAL INVENTORY --------------------------------------- //
        // Inventory External
        // public function view_inventory_external(){
        //     $connection = $this->openConn();

        //     // $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND deleted_at IS NULL AND quantity !='0'");
        //     $stmt = $connection->prepare("SELECT * 
        //         FROM tbl_inventory 
        //         WHERE (type='External') 
        //         AND deleted_at IS NULL 
        //         AND quantity != '0'
        //         AND (expired_at < CURDATE() OR expired_at > DATE_ADD(CURDATE(), INTERVAL 30 DAY))");
        //     $stmt->execute();
        //     $view = $stmt->fetchAll();

        //     return $view;
        // }
        public function view_inventory_external() {
            $connection = $this->openConn();
        
            // Query to select internal inventory items that are not deleted, not zero quantity,
            // and either expired or expiring in more than 30 days from today
            $stmt = $connection->prepare("
                SELECT * 
                FROM tbl_inventory 
                WHERE type = 'External' 
                  AND deleted_at IS NULL 
                  AND quantity != low_stock 
                  AND (expired_at < CURDATE() OR expired_at > DATE_ADD(CURDATE(), INTERVAL 30 DAY))
                ORDER BY 
                  CASE 
                    WHEN quantity <= low_stock THEN 0 
                    ELSE 1 
                  END, 
                  created_at DESC
            ");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        

        //For External Cat food
        public function view_inventory_external_catfood(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND category = 'Cat Food' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For External Dog Food
        public function view_inventory_external_dogfood(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND category = 'Dog Food' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        //For External Medicine
        public function view_inventory_external_medicine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND category = 'Medicine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
 
        //For External Syringe
        public function view_inventory_external_syringe(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND category = 'Syringe' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        //For External Vaccine
        public function view_inventory_external_vaccine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For External Shampoo
        public function view_inventory_external_shampoo(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE (type='External' OR type='Both') AND category = 'Shampoo' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

// ------------------------------------------------------------------------ END EXTERNAL INVENTORY --------------------------------------- //

// ------------------------------------------------------------------------START BOTH INVENTORY --------------------------------------- //
        // Inventory External
        public function view_inventory_both(){
            $connection = $this->openConn();

            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND deleted_at IS NULL AND quantity !='0'");
            $stmt->execute();
            $view = $stmt->fetchAll();

            return $view;
        }

        //For External Cat food
        public function view_inventory_both_catfood(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND category = 'Cat Food' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For External Dog Food
        public function view_inventory_both_dogfood(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND category = 'Dog Food' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        //For External Medicine
        public function view_inventory_both_medicine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND category = 'Medicine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
 
        //For External Syringe
        public function view_inventory_both_syringe(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND category = 'Syringe' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        //For External Vaccine
        public function view_inventory_both_vaccine(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }
        //For External Shampoo
        public function view_inventory_both_shampoo(){
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE type='Both' AND category = 'Shampoo' AND deleted_at IS NULL");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

// ------------------------------------------------------------------------ END BOTH INVENTORY --------------------------------------- //

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
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE deleted_at IS NULL AND quantity <= low_stock ORDER BY quantity ASC");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_low_inventory_external(){
            // $startFrom = ($page - 1) * $recordsPerPage;
            $connection = $this->openConn();
        
            // Modify the SQL query to include a WHERE clause
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory WHERE deleted_at IS NULL 
                AND quantity <= 20 ORDER BY quantity ASC LIMIT 3");
            $stmt->execute();
            $view = $stmt->fetchAll();
        
            return $view;
        }

        public function view_low_stock_internal(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT * FROM tbl_inventory_internal WHERE deleted_at IS NULL 
                AND quantity <= 20  ORDER BY quantity ASC LIMIT 3");
            $stmt->execute();   
            $view = $stmt->fetchAll();
            return $view;
        }

        // public function view_stock_most_sold(){
        //     $connection = $this->openConn();
        //     $stmt = $connection->prepare("SELECT *, SUM(total) AS total_sum FROM invoice");
        //     $stmt->execute();   
        //     $view = $stmt->fetchAll();
        //     return
        //      $view;
        // }
        public function view_stock_most_sold(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT product, SUM(total) AS total_sum FROM invoice GROUP BY product ORDER BY total_sum DESC");
            $stmt->execute();   
            $view = $stmt->fetchAll();
            return $view;
        }
        

        // public function view_stock_least_sold(){
        //     $connection = $this->openConn();
        //     $stmt = $connection->prepare("SELECT *, SUM(totalQty) AS total_quantity 
        //         FROM invoice GROUP BY prod_id ORDER BY total_quantity ASC LIMIT 3");
        //     $stmt->execute();   
        //     $view = $stmt->fetchAll();
        //     return $view;
        // }
        public function view_stock_least_sold(){
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT product, SUM(total) AS total_sum FROM invoice GROUP BY product ORDER BY total_sum ASC");
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
                $type = $_POST['type'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $capital = $_POST['input_capital'];
                $profit = $_POST['input_profit'];
                $qty = $_POST['qty'];
                $low_stock = $_POST['low_stock'];
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
        
                        // Insert into tbl_inventory
                        $stmt_inventory = $connection->prepare("INSERT INTO tbl_inventory (type, name, price, profit, capital, quantity, picture, category, expired_at, purchased_at, low_stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt_inventory->execute([$type, $name, $price, $profit, $capital, $qty , $target_file, $category, $exp, $bought_date, $low_stock]);
        
                        // Insert into tbl_inventory_logs
                        $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                        $stmt_logs->execute([$name,  'Added']); // Assuming 'create' is the log type for creating an item
        
                        // Show success alert
                        echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Created',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";
        
                        // Redirect based on type
                        if ($type === "Both") {
                            header("refresh: 1; url=admin_inventory.php");
                        }
                        elseif ($type === "Internal") {
                            header("refresh: 1; url=admin_inventory_internal.php");
                        } elseif ($type === "External") {
                            header("refresh: 1; url=admin_inventory_external.php");
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                    $stmt_inventory = $connection->prepare("INSERT INTO tbl_inventory (type, name, price, profit, capital, quantity, picture, category, expired_at, purchased_at, low_stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt_inventory->execute([$type, $name, $price, $profit, $capital, $qty, $target_file , $category, $exp, $bought_date, $low_stock,]);
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                    $stmt_logs->execute([$name,  'Added']); // Assuming 'create' is the log type for creating an item
        
                    echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item Created',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                      </script>";
        
                    // Redirect based on type
                    if ($type === "Internal") {
                        header("refresh: 1; url=admin_inventory_internal.php");
                    } elseif ($type === "External") {
                        header("refresh: 1; url=admin_inventory_external.php");
                    }
                }
            }
        }

        public function create_inventory_all() {
            if (isset($_POST['create_inventory'])) {
                $type = $_POST['type'];
                $code = $_POST['code'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $capital = $_POST['input_capital'];
                $profit = $_POST['input_profit'];
                $qty = $_POST['qty'];
                $low_stock = $_POST['low_stock'];
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
        
                        // Insert into tbl_inventory
                        $stmt_inventory = $connection->prepare("INSERT INTO tbl_inventory (type,code, name, price, profit, capital, quantity, picture, category, expired_at, purchased_at, low_stock) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt_inventory->execute([$type,$code, $name, $price, $profit, $capital, $qty, $target_file, $category, $exp, $bought_date, $low_stock]);
        
                        // Insert into tbl_inventory_logs
                        $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                        $stmt_logs->execute([$name,  'Added']); // Assuming 'create' is the log type for creating an item
        
                        // Show success alert
                        echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Created',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";
        
                         // Redirect based on type
                         header("refresh: 1; url=admin_inventory.php");
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                     $stmt_inventory = $connection->prepare("INSERT INTO tbl_inventory (type,code, name, price, profit, capital, quantity, picture, category, expired_at, purchased_at, low_stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt_inventory->execute([$type ,$code ,$name, $price, $profit, $capital, $qty, $target_file, $category, $exp, $bought_date, $low_stock]);
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                    $stmt_logs->execute([$name,  'Added']); // Assuming 'create' is the log type for creating an item
        
                    echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item Created',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                      </script>";
        
                        // Redirect based on type
                        header("refresh: 1; url=admin_inventory.php");

                }
            }
        }
        public function update_inventory() {
            if (isset($_POST['update_inventory'])) {
                $inv_id = $_GET['inv_id'];
                $type = $_POST['type'];
                $code = $_POST['code'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $category = $_POST['category'];
                $bought_date = $_POST['bought_date'];
                $exp = $_POST['exp_date'];
                $new_picture = $_FILES['new_picture'];
        
                // Fetch the old quantity from the database
                $connection = $this->openConn();
                $stmt = $connection->prepare("SELECT quantity FROM tbl_inventory WHERE inv_id = ?");
                $stmt->execute([$inv_id]);
                $oldQuantity = $stmt->fetchColumn();
        
                // Compare old quantity with new quantity
                if ($qty >= $oldQuantity) {
                    if (!empty($new_picture['name'])) {
                        $target_dir = "../uploads/inventory/";
                        $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }
        
                        $target_file = $target_dir . time() . '.' . $file_extension;
        
                        if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                            $stmt_inventory = $connection->prepare("UPDATE tbl_inventory
                                SET code=?, name =?, price =?, quantity = ?, category = ?, picture = ?, expired_at = ?, purchased_at = ?
                                WHERE inv_id = ?");
                            $stmt_inventory->execute([$code,$name, $price, $qty, $category, $target_file, $exp, $bought_date, $inv_id]);
        
                            $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name,remarks, log_type) VALUES (?,  ?, ?)");
                            $stmt_logs->execute([$name,'Item has been updated',  'Updated']);
        
                            echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Updated',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";
                            // Redirect after showing the alert
                            if ($type === "Both") {
                                header("refresh: 1; url=admin_inventory.php");
                            } 
                            elseif ($type === "Internal") {
                                header("refresh: 1; url=admin_inventory_internal.php");
                            } elseif ($type === "External") {
                                header("refresh: 1; url=admin_inventory_external.php");
                            }
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $stmt_inventory = $connection->prepare("UPDATE tbl_inventory
                            SET code=?, name =?, price =?, quantity = ?, category = ?, expired_at = ?, purchased_at = ?
                            WHERE inv_id = ?");
                        $stmt_inventory->execute([$code ,$name, $price, $qty, $category, $exp, $bought_date, $inv_id]);
                        $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name,remarks, log_type) VALUES (?,  ?, ?)");
                        $stmt_logs->execute([$name,'Item has been updated',  'Updated']);
        
                        echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Item Updated',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            });
                        </script>";
                        // Redirect after showing the alert
                        if ($type === "Internal") {
                            header("refresh: 1; url=admin_inventory_internal.php");
                        } elseif ($type === "External") {
                            header("refresh: 1; url=admin_inventory_external.php");
                        }
                    }
                } else {
                    // Quantity is lower than the previous quantity, show an alert
                    $message = "Cannot update! Quantity is lower than the previous quantity.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }

        
        // For Internal Inventory
        public function create_inventory_internal() {
            if (isset($_POST['create_inventory_internal'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $capital = $_POST['input_capital'];
                $profit = $_POST['input_profit'];
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

                        // Insert into tbl_inventory
                        $stmt_inventory = $connection->prepare("INSERT INTO tbl_inventory (name, price, profit, capital, quantity, picture, category, expired_at, purchased_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt_inventory->execute([$name, $price, $profit, $capital, $qty, $target_file, $category, $exp, $bought_date]);

                        // Insert into tbl_inventory_logs
                        $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                        $stmt_logs->execute([$name,  'Added']); // Assuming 'create' is the log type for creating an item

                        // Show success alert
                        echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Created',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";

                        // Redirect after showing the alert
                        header("refresh: 1; url=admin_inventory.php");
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $connection = $this->openConn();
                    $stmt_inventory = $connection->prepare("INSERT INTO tbl_inventory (name, price, profit, capital, quantity, picture, category, expired_at, purchased_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt_inventory->execute([$name, $price, $profit, $capital, $qty, $target_file, $category, $exp, $bought_date]);
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                    $stmt_logs->execute([$name,  'Added']); // Assuming 'create' is the log type for creating an item
        
                    echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item Created',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                      </script>";
                // Redirect after showing the alert
                header("refresh: 1; url=admin_inventory.php");
                }
            }
        }    

        public function deduct_inventory() {
            if (isset($_POST['deduct_inventory'])) {
                $inv_id = $_GET['inv_id'];
                $quantity = $_POST['total_quantity'];
                $qty = $_POST['qty'];
                $remarks = $_POST['remarks'];
                $name = $_POST['name'];
                $type = $_POST['type'];

                // Compare old quantity with new quantity
                if (!($qty > $quantity)) {
                    $qty_new = $quantity - $qty;
                    // $remarks_data = "The quantity of item {$name} has been reduced by {$qty} from {$quantity}. It now has {$qty_new} pieces left.";
                    $remarks_data = "The quantity of item {$name} has been reduced by {$qty} from {$quantity}.";

                    $connection = $this->openConn();
                    $stmt_inventory = $connection->prepare("UPDATE tbl_inventory SET quantity = ? WHERE inv_id = ?");
                    $stmt_inventory->execute([$qty_new, $inv_id]);
        
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, remarks, log_type) VALUES (?, ?, ?)");
                    $stmt_logs->execute([$name, $remarks_data, 'Deduction']);
        
                    echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item Deducted',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                    </script>";
                    // Redirect after showing the alert
                    if ($type === "Internal") {
                        header("refresh: 1; url=deduct_item.php");
                    } elseif ($type === "External") {
                        header("refresh: 1; url=deduct_item.php");
                    }
                } else {
                    // Quantity is lower than the previous quantity, show an alert
                    // $message = "Cannot update! Quantity is lower than the previous quantity.";
                    // echo "<script type='text/javascript'>alert('$message');</script>";
                    echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cannot Deduct Item',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                </script>";
                }
            }
        }

        public function report_inventory() {
            if (isset($_POST['report_inventory'])) {
                $inv_id = $_GET['inv_id'];
                $remarks = $_POST['remarks'];
                $name = $_POST['name'];
                $type = $_POST['type'];
        
                // Compare old quantity with new quantity
                if (!($qty > $quantity)) {
                    $qty_new = $quantity - $qty;
                    // $remarks_data = "The quantity of item {$name} has been reduced by {$qty} from {$quantity}. It now has {$qty_new} pieces left.";
                    $remarks_data = "The item {$name} has expired.";
        
                    $connection = $this->openConn();
                    $stmt_inventory = $connection->prepare("UPDATE tbl_inventory SET deleted_at = NOW() WHERE inv_id = ?");
                    $stmt_inventory->execute([$inv_id]);
        
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, remarks, log_type) VALUES (?, ?, ?)");
                    $stmt_logs->execute([$name, $remarks_data, 'Expired']);
        
                    echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item added in Logs',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = 'admin_notification.php';
                            });
                        });
                    </script>";
                } else {
                    // Quantity is lower than the previous quantity, show an alert
                    $message = "Cannot update! Quantity is lower than the previous quantity.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
        

        public function update_expiring_inventory() {
            if (isset($_POST['expiring_inventory'])) {
                $inv_id = $_GET['inv_id'];
                $quantity = $_POST['total_quantity'];
                $qty = $_POST['qty'];
                $remarks = $_POST['remarks'];
                $name = $_POST['name'];
                $type = $_POST['type'];
                $old_expiration = new DateTime($_POST['old_expiration']);
                $new_expiration = new DateTime($_POST['new_expiration']);
                $currentDate = new DateTime();

                // check if item is aboutu to expire
                if ($new_expiration < $old_expiration || $currentDate->diff($new_expiration)->days <= 30) {
                    $message = "Cannot update! Item will expire soon.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }

                // Compare old quantity with new quantity
                if (!($qty > $quantity)) {
                    $qty_new = $quantity + $qty;
                    $remarks_data = "The quantity of item {$name} has been increased by {$qty} from {$quantity}.";

                    $connection = $this->openConn();
                    $stmt_inventory = $connection->prepare("UPDATE tbl_inventory SET quantity = ?, expired_at = ?
                         WHERE inv_id = ?");
                    $stmt_inventory->execute([$qty_new, $new_expiration, $inv_id]);
        
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, remarks, log_type) VALUES (?, ?, ?)");
                    $stmt_logs->execute([$name, $remarks_data, 'Expiring']);
        
                    echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Item Deducted',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                    </script>";
                    // Redirect after showing the alert
                    if ($type === "Internal") {
                        header("refresh: 1; url=deduct_item.php");
                    } elseif ($type === "External") {
                        header("refresh: 1; url=deduct_item.php");
                    }
                } 
                else {
                    // Quantity is lower than the previous quantity, show an alert
                    $message = "Cannot update! Quantity is lower than the previous quantity.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
        
        

        // Update Internal Inventory
        public function update_inventory_internal() {
            if (isset($_POST['update_inventory_internal'])) {
                $inv_id = $_GET['inv_id'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $category = $_POST['category'];
                $bought_date = $_POST['bought_date'];
                $exp = $_POST['exp_date'];
                $new_picture = $_FILES['new_picture'];
        
                // Fetch the old quantity from the database
                $connection = $this->openConn();
                $stmt = $connection->prepare("SELECT quantity FROM tbl_inventory WHERE inv_id = ?");
                $stmt->execute([$inv_id]);
                $oldQuantity = $stmt->fetchColumn();
        
                // Compare old quantity with new quantity
                if ($qty >= $oldQuantity) {
                    if (!empty($new_picture['name'])) {
                        $target_dir = "../uploads/inventory/";
                        $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }
        
                        $target_file = $target_dir . time() . '.' . $file_extension;
        
                        if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                            $stmt_inventory = $connection->prepare("UPDATE tbl_inventory
                                SET name =?, price =?, quantity = ?, category = ?, picture = ?, expired_at = ?, purchased_at = ?
                                WHERE inv_id = ?");
                            $stmt_inventory->execute([$name, $price, $qty, $category, $target_file, $exp, $bought_date, $inv_id]);

                            $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                            $stmt_logs->execute([$name,  'Updated']); // Assuming 'create' is the log type for creating an item
        
                            echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Updated',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";
                        // Redirect after showing the alert
                        header("refresh: 1; url=admin_inventory.php");
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $stmt_inventory = $connection->prepare("UPDATE tbl_inventory
                            SET name =?, price =?, quantity = ?, category = ?, expired_at = ?, purchased_at = ?
                            WHERE inv_id = ?");
                        $stmt_inventory->execute([$name, $price, $qty, $category, $exp, $bought_date, $inv_id]);
                        $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES ( ?, ?)");
                        $stmt_logs->execute([$name,  'Updated']); // Assuming 'create' is the log type for creating an item
        
                        echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Item Updated',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            });
                        </script>";
                    // Redirect after showing the alert
                    header("refresh: 1; url=admin_inventory.php");
                    }
                } else {
                    // Quantity is lower than the previous quantity, show an alert
                    $message = "Cannot update! Quantity is lower than the previous quantity.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        } 

        // Update for Low Inventory
        public function update_inventory_low() {
            if (isset($_POST['update_inventory'])) {
                $inv_id = $_GET['inv_id'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $total_quantity = $_POST['total_quantity'];
                $qty = $_POST['qty'];
                $quantity_total = $total_quantity + $qty;
                $category = $_POST['category'];
                $bought_date = $_POST['bought_date'];
                $exp = $_POST['exp_date'];
                $new_picture = $_FILES['new_picture'];


        
                // Fetch the old quantity from the database
                $connection = $this->openConn();
                $stmt = $connection->prepare("SELECT quantity FROM tbl_inventory WHERE inv_id = ?");
                $stmt->execute([$inv_id]);
                $oldQuantity = $stmt->fetchColumn();
        
                // Compare old quantity with new quantity
                if ($qty >= $oldQuantity) {
                    if (!empty($new_picture['name'])) {
                        $target_dir = "../uploads/inventory/";
                        $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }
        
                        $target_file = $target_dir . time() . '.' . $file_extension;
        
                        if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
                            $stmt_inventory = $connection->prepare("UPDATE tbl_inventory
                                SET name =?, price =?, quantity = ?, category = ?, picture = ?, expired_at = ?, purchased_at = ?
                                WHERE inv_id = ?");
                            $stmt_inventory->execute([$name, $price, $quantity_total, $category, $target_file, $exp, $bought_date, $inv_id]);

                            $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name,remarks, log_type) VALUES (?, ?, ?)");
                            $stmt_logs->execute([$name,"Added $quantity_total",  'Added Stocks']); // Assuming 'create' is the log type for creating an item
        
                            echo "<script type='text/javascript'>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Item Updated',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>";
                        // Redirect after showing the alert
                        header("refresh: 1; url=admin_inventory.php");
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $stmt_inventory = $connection->prepare("UPDATE tbl_inventory
                            SET name =?, price =?, quantity = ?, category = ?, expired_at = ?, purchased_at = ?
                            WHERE inv_id = ?");
                        $stmt_inventory->execute([$name, $price, $quantity_total, $category, $exp, $bought_date, $inv_id]);
                        $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name,remarks, log_type) VALUES (?, ?, ?)");
                            $stmt_logs->execute([$name,"Added $quantity_total",  'Added Stocks']); // Assuming 'create' is the log type for creating an item
        
                        echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Item Updated',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            });
                        </script>";
                    // Redirect after showing the alert
                    header("refresh: 1; url=admin_inventory.php");
                    }
                } else {
                    // Quantity is lower than the previous quantity, show an alert
                    $message = "Cannot update! Quantity is lower than the previous quantity.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }

        public function delete_invetory() {
            $inv_id = $_POST['inv_id'];
            $name = $_POST['name'];
            if (isset($_POST['delete_inventory'])) {
                $connection = $this->openConn();
        
                // Update tbl_inventory to set deleted_at
                $stmt_inventory = $connection->prepare("UPDATE tbl_inventory SET deleted_at = NOW() WHERE inv_id = ?");
                $stmt_inventory->execute([$inv_id]);
        
                // Insert into tbl_log_inventory for the delete
                $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES (?, ?)");
                $stmt_logs->execute([$name, 'Deleted']); // Assuming 'Deleted' is the log type for deleting an item
        
                echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Removed',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                </script>";
        
                // Refresh the page after displaying the alert
                header('refresh:1');
            }
        }
        // Delete item in inventory Internal 
        public function delete_invetory_internal() {
            $inv_id = $_POST['inv_id'];
            $name = $_POST['name'];
            if (isset($_POST['delete_inventory_internal'])) {
                $connection = $this->openConn();
        
                // Update tbl_inventory to set deleted_at
                $stmt_inventory = $connection->prepare("UPDATE tbl_inventory_internal SET deleted_at = NOW() WHERE inv_id = ?");
                $stmt_inventory->execute([$inv_id]);
        
                // Insert into tbl_log_inventory for the delete
                $stmt_logs = $connection->prepare("INSERT INTO tbl_log_inventory (name, log_type) VALUES (?, ?)");
                $stmt_logs->execute([$name, 'Deleted']); // Assuming 'Deleted' is the log type for deleting an item
        
                echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Removed',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                </script>";
        
                // Refresh the page after displaying the alert
                header('refresh:1');
            }
        }
        

        // public function delete_services(){
        //     $serv_id = $_POST['serv_id'];
    
        //     if(isset($_POST['delete_services'])) {
        //         $connection = $this->openConn();
        //         $stmt = $connection->prepare("UPDATE tbl_services set deleted_at = NOW() WHERE serv_id = ?");
        //         $stmt->execute([$serv_id]);
                
        //         $message2 = "Item Removed";
                
        //         echo "<script type='text/javascript'>alert('$message2');</script>";
        //         header('refresh:0');
        //     }
        // }

        public function delete_services() {
            $serv_id = $_POST['serv_id'];
            $customer_name = $_POST['customer_name'];
            $service_availed = $_POST['service_availed'];
            $staff_name = $_POST['staff_name'];
            
        
            if(isset($_POST['delete_services'])) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_services SET deleted_at = NOW() WHERE serv_id = ?");
                $stmt->execute([$serv_id]);

                try {
                    $stmt_logs = $connection->prepare("INSERT INTO tbl_log_services (customer_name, service_availed, log_type, staff_name) VALUES (?, ?, ?, ?)");
                    $stmt_logs->execute([$customer_name, $service_availed, 'Deleted', $staff_name]);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
        
                // Use SweetAlert for the confirmation message
                echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Availed Service Removed',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                </script>";
                      
                // Refresh the page after displaying the alert
                header('refresh:1');
            }
        }

        public function delete_staff(){
            $id_admin = $_POST['id_admin'];
        
            if(isset($_POST['delete_staff'])) {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_admin SET deleted_at = NOW() WHERE id_admin = ?");
                $stmt->execute([$id_admin]);
                
                $message2 = "Staff Removed";
                
                echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Staff Removed',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                </script>";
                      
                // Refresh the page after displaying the alert
                header('refresh:1');
            }
        }
        
        

        //View User
        public function view_user(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from tbl_admin WHERE deleted_at IS NULL ");
            $stmt->execute();
            $view = $stmt->fetchAll();
            //$rows = $stmt->
            return $view;
           
        }

        public function view_staff_report(){

            $connection = $this->openConn();

            // $stmt = $connection->prepare("SELECT * from tbl_user");
            $stmt = $connection->prepare("SELECT * from loggin_logs ORDER BY created_at DESC ");
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
        public function create_pet($owner_id) {
            if (isset($_POST['add_pet'])) {
                $pet_name = ucfirst(strtolower($_POST['pet_name']));
                $pet_type = $_POST['pet_type'];
                $bdate = $_POST['bdate'];
                $sex = $_POST['sex'];
                $owner_id = intval($owner_id); // Make sure owner_id is an integer
        
                // Determine the breed based on user input
                if ($_POST['pet_breed'] === 'Other') {
                    $breed = ucfirst(strtolower($_POST['other_breed']));
                } else {
                    $breed = $_POST['pet_breed'];
                }
        
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
                            (`pet_name`, `pet_owner_id`, `pet_picture`,   `pet_type`, `breed`, `bdate`, `sex`) VALUES (?,?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$pet_name, $owner_id, $target_file, $pet_type, $breed, $bdate, $sex]);
        
                        $message2 = "Pet added!";
                        echo "<script type='text/javascript'>alert('$message2');</script>";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    // proceed to create without picture
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_pet 
                        (`pet_name`, `pet_owner_id`, `pet_type`,`breed`, `bdate`, `sex`) VALUES (?,?, ?, ?, ?, ?)");
                    $stmt->execute([$pet_name, $owner_id, $pet_type, $breed, $bdate, $sex]);
        
                    $message2 = "Pet added!";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                }
        
                echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
            }
        }
        

        // #pet
        // public function create_pet($owner_id) {
        //     if (isset($_POST['add_pet'])) {
        //         $pet_name = ucfirst(strtolower($_POST['pet_name']));
        //         $pet_type = $_POST['pet_type'];
        //         $breed = $_POST['breed'];
        //         $bdate = $_POST['bdate'];
        //         $sex = $_POST['sex'];
        //         $owner_id = intval($owner_id); // Make sure owner_id is an integer

        //         $new_picture = $_FILES['pet_picture'];
        
        //         if (!empty($new_picture['name'])) {
        //             $target_dir = "uploads/pets/";
        //             $file_extension = pathinfo($new_picture['name'], PATHINFO_EXTENSION);
        
        //             if (!is_dir($target_dir)) {
        //                 mkdir($target_dir, 0755, true);
        //             }
        
        //             $target_file = $target_dir . time() . '.' . $file_extension;
        
        //             if (move_uploaded_file($new_picture["tmp_name"], $target_file)) {
        //                 // proceed to create with picture
        //                 $connection = $this->openConn();
        //                 $stmt = $connection->prepare("INSERT INTO tbl_pet 
        //                     (`pet_name`, `pet_owner_id`, `pet_picture`,   `pet_type`, `breed`, `bdate`, `sex`) VALUES (?,?, ?, ?, ?, ?, ?)");
        //                 $stmt->execute([$pet_name, $owner_id, $target_file,$pet_type, $breed, $bdate, $sex]);
        
        //                 $message2 = "Pet added!";
        //                 echo "<script type='text/javascript'>alert('$message2');</script>";
        
        //                 // echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
        //             } else {
        //                 echo "Sorry, there was an error uploading your file.";
        //             }
        //         } else {
        //             // proceed to create without picture
        //             $connection = $this->openConn();
        //             $stmt = $connection->prepare("INSERT INTO tbl_pet 
        //                 (`pet_name`, `pet_owner_id`, `pet_type`,`breed`, `bdate`, `sex`) VALUES (?,?, ?, ?, ?, ?)");
        //             $stmt->execute([$pet_name, $owner_id, $pet_type, $breed, $bdate, $sex]);
        
        //             $message2 = "Pet added!";
        //             echo "<script type='text/javascript'>alert('$message2');</script>";
        
        //             // echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
        //         }

        //         echo '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
        //         // return '<script>window.location.replace("admin_client_pet.php?id_user='.$owner_id.'")</script>';
        //     }
        // }
        
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
            $stmt = $connection->prepare("SELECT id_admin, email, fname, lname, mi,position, role, picture FROM tbl_admin where id_admin = '$id_admin'");
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
                $mi = ""; // Assuming you're not using this field
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
                        // Include Cropper.js to handle image cropping
                        // require 'path/to/cropperjs/cropper.min.php';
            
                        // Get the cropped image data from the form submission
                        $cropped_image_data = $_POST['cropped_image'];
                        
                        // Convert base64 encoded cropped image data to image file
                        $cropped_image = base64_decode(str_replace('data:image/png;base64,', '', $cropped_image_data));
            
                        // Save the cropped image to the uploads directory
                        $cropped_file = $target_dir . 'cropped_' . time() . '.png';
                        file_put_contents($cropped_file, $cropped_image);
            
                        $connection = $this->openConn();
            
                        // Update the staff information including the new picture
                        $stmt = $connection->prepare("UPDATE tbl_admin SET lname = ?, fname = ?, mi = ?, role = ?, email = ?, picture = ? WHERE id_admin = ?");
                        $stmt->execute([$lname, $fname, $mi, $role, $email, $cropped_file, $id_user]);
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
        
        

        // public function delete_staff(){

        //     $id_user = $_POST['id_user'];

        //     if(isset($_POST['delete_staff'])) {
        //         $connection = $this->openConn();
        //         // $stmt = $connection->prepare("DELETE FROM tbl_user where id_user = ?");
        //         $stmt = $connection->prepare("DELETE FROM tbl_admin where id_admin = ?");
        //         $stmt->execute([$id_user]);
                
        //         $message2 = "Staff Account Deleted";
                
        //         echo "<script type='text/javascript'>alert('$message2');</script>";
        //          header('refresh:0');
        //     }
        // }

    //--------------------------------------------- EXTRA FUNCTIONS FOR STAFF -------------------------------------------------

            public function get_single_staff($id_user){

                $id_user = $_GET['id_user'];
                
                $connection = $this->openConn();
                // $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = ?");
                $stmt = $connection->prepare("SELECT * FROM tbl_admin where id_admin = ?");
                $stmt->execute([$id_user]);
                $user = $stmt->fetch();
                $total = $stmst->rowCount();

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

        //this is for reports vaccinations
        public function count_vaccine_report() {
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("SELECT * FROM tbl_pet
                                          INNER JOIN tbl_vaccination ON tbl_pet.pet_id = tbl_vaccination.pet_id");
        
            $stmt->execute();
        
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $result;
        }

        // public function count_services_report() {
        //     $connection = $this->openConn();
        
        //     $stmt = $connection->prepare("SELECT * FROM tbl_services");
        
        //     $stmt->execute();
        
        //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //     return $result;
        // }
        public function count_services_report() {
            $connection = $this->openConn();
        
            $stmt = $connection->prepare("
                SELECT * 
                FROM tbl_services 
                INNER JOIN tbl_user ON tbl_services.cli_id = tbl_user.id_user
            ");
        
            $stmt->execute();
        
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $result;
        }
        
        

        public function count_inventory() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_inventory_internal() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count Cat food
        public function count_inventory_catfood() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Cat Food' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count dogfood
        public function count_inventory_dogfood() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Dog Food' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count medicine
        public function count_inventory_medicine() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Medicine' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count Internal medicine
        public function count_inventory_internal_medicine() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Medicine' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count syringe
        public function count_inventory_syringe() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Syringe' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count Internal syringe
        public function count_inventory_internal_syringe() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Syringe' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count shampoo
        public function count_inventory_shampoo() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Shampoo' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count vaccine
        public function count_inventory_vaccine() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        //Count Internal vaccine
        public function count_inventory_internal_vaccine() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE category = 'Vaccine' AND deleted_at IS NULL");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_low_inventory() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_inventory WHERE deleted_at IS NULL AND quantity <= low_stock");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_expired_inventory() {
            $connection = $this->openConn();
            
            $stmt = $connection->prepare("
                SELECT COUNT(*) as count 
                FROM tbl_inventory 
                WHERE (type='Internal' OR type='External') 
                AND deleted_at IS NULL 
                AND quantity != '0'
                AND expired_at BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
            ");
            
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

        public function count_services_all() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_services_consultation() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Consultation', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_services_vaccination() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Vaccination', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }

        public function count_services_deworming() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Deworming', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_heartworm() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Heartworm', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_treatment() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Treatment', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_surgery() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Surgery', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_laboratory() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Laboratory', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_confinement() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Confinement', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_diagnostic() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Diagnostic', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_grooming() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Grooming', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_cesarian() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Cesarian Section Surgery', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        public function count_services_bloodchem() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE FIND_IN_SET('Blood Chemistry Test', REPLACE(service_availed, ', ', ','))");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'];
        }
        
        // public function count_services_consultation() {
        //     $connection = $this->openConn();
        //     $stmt = $connection->prepare("SELECT COUNT(*) as count FROM tbl_services WHERE deleted_at IS NULL");
        //     $stmt->execute();
        //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        //     return $result['count'];
        // }

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

        public function count_vac() {
            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT COUNT(*) from tbl_vaccination WHERE deleted_at IS NULL");
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

            $stmt = $connection->prepare("SELECT * FROM tbl_services ORDER BY created_at DESC
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
        public function create_service(){
            if (isset($_POST['create_service'])) {
                $staff_name = $_POST['staff_name'];
                $quantity = $_POST['quantity'];
                $services_list = $_POST['services_list'];
                $pet = $_POST['chosen_pet'];
                $customer = $_GET['id'];
                $service_get = '';
                $treatment_check = false;
        
                foreach($services_list as $item){
                    $service_get .= $item . ', ';

                    // Check if the current item contains the string "Treatment"
                    if (strpos($item, 'Treatment') !== false) {
                        $treatment_check = true;
                    }
                }
        
                // Remove the trailing comma and space
                $service_get = rtrim($service_get, ', ');
        
                $connection = $this->openConn();
                $stmt_services = $connection->prepare("INSERT INTO tbl_services (id_user, pet_id, service_availed,quantity, staff_name, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt_services->execute([$customer, $pet, $service_get,  $quantity ,$staff_name]);

                // temporary
                $stmt_get_user = $connection->prepare("SELECT * FROM tbl_user WHERE id_user = ?");
                $stmt_get_user->execute([$customer]);
                $user_result = $stmt_get_user->fetch(PDO::FETCH_ASSOC);

                // check if treatment has content
                if($treatment_check){
                    $treatmet_get = "Treatment".": ".$_POST['treatment_input'];
                    $treatmet_list = $_POST['treatment_list'];
                    // $treatmet_get = '';
                    $service_last_id = $connection->lastInsertId(); // get id from last created services

                    // foreach($treatmet_list as $item){
                    //     $treatmet_get .= $item . ', ';
                    // }

                    // Remove the trailing comma
                    $treatmet_get = rtrim($treatmet_get, ', ');

                    $stmt_treatment = $connection->prepare("INSERT INTO tbl_treatment (serv_id, treatment_name) VALUES (?, ?)");
                    $stmt_treatment->execute([$service_last_id, $treatmet_get]);
                }
                $stmt_logs = $connection->prepare("INSERT INTO tbl_log_services (customer_name,customer_contact,customer_address, service_availed, log_type, staff_name) VALUES (?,?,?, ?, ?, ?)");
                $stmt_logs->execute([$user_result['customer_name'], $user_result['customer_contact'],
                    $user_result['customer_address'], $service_get, 'Added', $staff_name]);


                // Insert into tbl_inventory_logs
                // try {
                //     $stmt_logs = $connection->prepare("INSERT INTO tbl_log_services (customer_name,customer_contact,customer_address, service_availed, log_type, staff_name) VALUES (?,?,?, ?, ?, ?)");
                //     $stmt_logs->execute([$customer_name,$customer_contact,$customer_address, $treatmet_get, 'Added', $staff_name]);
                // } catch (PDOException $e) {
                //     echo "Error: " . $e->getMessage();
                // }
                
                // Use SweetAlert for the alert
                echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Service Created',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                      </script>";
                // Redirect after showing the alert
                header("refresh: 1; url=services.php");
            }
        }

        public function create_customer(){
            if (isset($_POST['create_customer'])) {
                $customer_name = ucwords(strtolower($_POST['customer_name']));
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = ucwords(strtolower($_POST['customer_address']));
                $staff_name = $_POST['staff_name'];

                $connection = $this->openConn();
                $stmt_services = $connection->prepare("INSERT INTO tbl_user (customer_name,customer_contact,customer_email,customer_address, staff_name, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt_services->execute([$customer_name,$customer_contact,$customer_email,$customer_address,  $staff_name]);

                // Use SweetAlert for the alert
                echo "<script type='text/javascript'>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Customer Added',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                      </script>";
                // Redirect after showing the alert
                header("refresh: 1; url=services.php");
            }
        }
        
        //Using Alert
        // public function create_service(){
        //     if (isset($_POST['create_service'])) {
        //         $customer_name = ucwords(strtolower($_POST['customer_name']));
        //         $staff_name = $_POST['staff_name'];
        //         $services_list = $_POST['services_list'];
        //         $service_get = '';
        
        //         foreach($services_list as $item){
        //             $service_get .= $item . ', ';
        //         }
        
        //         // Remove the trailing comma and space
        //         $service_get = rtrim($service_get, ', ');
        
        //         // echo $service_get;
        //         $connection = $this->openConn();
        //         $stmt = $connection->prepare("INSERT INTO tbl_services (customer_name, service_availed, staff_name, created_at) VALUES (?, ?, ?,NOW())");
        //         $stmt->execute([$customer_name, $service_get, $staff_name]);
        
        //         $message2 = "Service created";
        //         echo "<script type='text/javascript'>alert('$message2');</script>";
        //         header("refresh: 0");
        //     }
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
<!-- <link href="customcss/regiformstyle.css" rel="stylesheet" type="text/css"> -->
<link href="../css/custom.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<!-- <script src="bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

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
