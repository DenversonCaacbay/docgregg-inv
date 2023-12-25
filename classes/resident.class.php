
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

        public function create_user() {
            if(isset($_POST['add_user'])) {
                $email = $_POST['email'];
                $password = ($_POST['password']);
                $confirm_password = ($_POST['confirm_password']);
                $lname = ucfirst(strtolower($_POST['lname'])); // Convert to uppercase
                $fname = ucfirst(strtolower($_POST['fname'])); // Convert to uppercase
                // $mi = strtoupper(substr($_POST['mi'], 0, 1)) . '.'; // Get first letter in uppercase and add '.'
                $mi = ucfirst(strtolower($_POST['mi']));
                // $age = $_POST['age'];
                $sex = $_POST['sex'];
                // $status = $_POST['status'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $municipal = $_POST['municipal'];
                $contact = $_POST['contact'];

                $bdate = $_POST['bdate'];
                // Calculate age based on the provided birthdate
                $current_year = date("Y");
                $birth_year = date("Y", strtotime($bdate));
                $age = $current_year - $birth_year;

                $nationality = $_POST['nationality'];
                

                $role = $_POST['role'];

                if ($this->check_resident($email) == 0 ) {

                    // check if user is 18
                    if ($age < 18) {
                        $message = "Sorry, you are still underaged to register an account";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        return false;
                    }
                    else {
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
                        $stmt = $connection->prepare("INSERT INTO tbl_user ( `email`,`password`,`lname`,`fname`,
                            `mi`, `age`, `sex`, `houseno`, `street`, `brgy`, `municipal`, `contact`, `bdate`, 
                             `nationality`,
                            `role`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                        $stmt->Execute([ $email, $hashed_password, $lname, $fname, $mi, $age, $sex, $houseno, $street, $brgy, $municipal, $contact, $bdate,  $nationality, $role]);

                        $message2 = "Account added, you can now continue logging in";
                        echo "<script type='text/javascript'>alert('$message2');</script>";

                        echo '<script>window.location.replace("user_login.php")</script>;';
                    }
                }

                else {
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

        // public function update_resident() {
        //     if (isset($_POST['update_resident'])) {
        //         $id_resident = $_GET['id_resident'];
        //         $email = $_POST['email'];
        //         $password = ($_POST['password']);
        //         $lname = $_POST['lname'];
        //         $fname = $_POST['fname'];
        //         $mi = $_POST['mi'];
        //         $age = $_POST['age'];
        //         $sex = $_POST['sex'];
        //         $status = $_POST['status'];
        //         $houseno = $_POST['houseno'];
        //         $street = $_POST['street'];
        //         $brgy = $_POST['brgy'];
        //         $municipal = $_POST['municipal'];
        //         $contact = $_POST['contact'];
        //         $bdate = $_POST['bdate'];
        //         $bplace = $_POST['bplace'];
        //         $nationality = $_POST['nationality'];
        //         $voter = $_POST['voter'];
        //         $familyrole = $_POST['family_role'];
        //         $role = $_POST['role'];
        //         $addedby = $_POST['addedby'];

        //         $connection = $this->openConn();
        //         $stmt = $connection->prepare("UPDATE tbl_resident SET `password` =?, `lname` =?, 
        //         `fname` = ?, `mi` =?, `age` =?, `sex` =?, `status` =?, `email` =?, `houseno` =?, `street` =?,
        //         `brgy` =?, `municipal` =?, `contact` =?,
        //         `bdate` =?, `bplace` =?, `nationality` =?, `voter` =?, `family_role` =?, `role` =?, `addedby` =? WHERE `id_resident` = ?");
        //         $stmt->execute([$password, $lname, $fname, $mi, $age, $sex, $status,$email, $houseno, 
        //         $street, $brgy, $municipal,
        //         $contact, $bdate, $bplace, $nationality, $voter, $familyrole, $role, $addedby, $id_resident]);
                    
        //         $message2 = "Resident Data Updated";
        //         echo "<script type='text/javascript'>alert('$message2');</script>";
        //         header("refresh: 0");
        //     }
        // }

        // public function delete_resident(){
        //     $id_resident = $_POST['id_resident'];

        //     if(isset($_POST['delete_resident'])) {
        //         $connection = $this->openConn();
        //         $stmt = $connection->prepare("DELETE FROM tbl_resident where id_resident = ?");
        //         $stmt->execute([$id_resident]);

        //         $message2 = "Resident Data Deleted";
                
        //         echo "<script type='text/javascript'>alert('$message2');</script>";
        //         header("Refresh:0");
        //     }
        // }

    //-------------------------------- EXTRA FUNCTIONS FOR RESIDENT CLASS ---------------------------------

    


    public function get_single_resident($id_user){

        $id_user = $_GET['id_user'];
        
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

    public function count_resident() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user");
        $stmt->execute();
        $rescount = $stmt->fetchColumn();
        return $rescount;
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

    // public function count_male_resident() {
    //     $connection = $this->openConn();

    //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user where sex = 'male' ");
    //     $stmt->execute();
    //     $rescount = $stmt->fetchColumn();

    //     return $rescount;
    // }

    // public function count_female_resident() {
    //     $connection = $this->openConn();

    //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_user where sex = 'female'");
    //     $stmt->execute();
    //     $rescount = $stmt->fetchColumn();

    //     return $rescount;
    // }

    // public function count_head_resident() {
    //     $connection = $this->openConn();

    //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_resident where family_role = 'Yes'");
    //     $stmt->execute();
    //     $rescount = $stmt->fetchColumn();

    //     return $rescount;
    // }

    // public function count_member_resident() {
    //     $connection = $this->openConn();

    //     $stmt = $connection->prepare("SELECT COUNT(*) from tbl_resident where family_role = 'Family Member'");
    //     $stmt->execute();
    //     $rescount = $stmt->fetchColumn();

    //     return $rescount;
    // }

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