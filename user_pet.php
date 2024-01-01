<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',1);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $userdetails['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    $view = $residentbmis->view_pet($id_resident);
    
    $residentbmis->profile_update();

?>

<style>
    
    .create-btn {

    width: 60px;
    height: 60px;
    border-radius: 60% !important;
    background: #0296be !important;
    font-size: 25px !important;
    padding: 10px;
}
    /* float: right; */ /* Remove this line */
    /* color: white; */


  .create-btn:hover {
    border-radius: 50%;
    width: 70px;
    height: 70px;
    background: #0296be;
    font-size: 25px;
    padding: 10px;
    
}  
</style>

<?php 
    include('user_navbar_start.php');
?>
    
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-6"><div class="title">My Pets</div></div>
            <div class="col-md-6">
                <div class="desk-create">
                    <a class="btn desk-create-btn text-light" href="create_user_pet.php">Add Pet</a>
                </div>
            </div>
        </div>
        
        


       <!-- ... (other code) -->

<?php if(is_array($view) && count($view) > 0): ?>
    <?php foreach($view as $item): ?>
        <div class="card p-2 mt-4">
            <div class="row">
                <div class="col-md-3 text-center ">
                    <?php if (is_null($item['pet_picture'])): ?>
                        <img src="images/placeholder/pet-placeholder.png" width="100">
                    <?php else: ?>
                        <!-- Display pet image here -->
                        <img src="<?= $item['pet_picture'] ?>" class="img-fluid" alt="Modal Image" width="100">
                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <h5><?= $item['pet_name']; ?></h5>
                    <h5><?= date("F d, Y - l", strtotime($item['created_at'])); ?></h5>
                    <form method="post" class="mt-4">
                        <!-- <a href="update_user_pet.php?id_user=<?= $item['id_admin']; ?>" class="btn btn-success">Update</a> -->
                        <input type="hidden" name="id_user" value="<?= $item['id_admin']; ?>">
                        <button class="btn btn-danger" type="submit" name="delete_staff">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>

    <div class="mob-create">
        <a class="btn create-btn text-light" href="create_user_pet.php">+</a>
    </div>
</div>

<!-- ... (other code) -->
    <!-- </div> -->


        
