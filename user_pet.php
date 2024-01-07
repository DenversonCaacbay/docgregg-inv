<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',1);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $userdetails['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    $view = $residentbmis->view_pet($id_resident);
    
    $residentbmis->profile_update();
    // $residentbmis->delete_pet();

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
            <!-- <div class="col-md-6">
                <div class="desk-create">
                    <a class="btn desk-create-btn text-light" href="create_user_pet.php">Add Pet</a>
                </div>
            </div> -->
        </div>
        
        


       <!-- ... (other code) -->

<?php if(is_array($view) && count($view) > 0): ?>
    <?php foreach($view as $item): ?>
        <div class="card p-2 mt-4">
            <div class="row">
                <div class="col-md-3 text-center ">
                    <?php if (is_null($item['pet_picture'])): ?>
                        <img src="images/placeholder/pet-placeholder.png" width="150">
                    <?php else: ?>
                        <!-- Display pet image here -->
                        <!-- <img src="<?= $item['pet_picture'] ?>" class="img-fluid" alt="Modal Image" width="150"> -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openModal('<?= $item['pet_picture'] ?>')">
                            <img src="admin/<?= $item['pet_picture'] ?>" class="img-fluid" alt="Modal Image" width="150">
                        </a>
    
                    <?php endif; ?>

                    
                </div>
                <div class="col-md-9">
                    <h5>Pet Name: <?= $item['pet_name']; ?></h5>
                    <h5>Sex:  <?= $item['sex'] = $item['sex'] ? $item['sex'] : "---"; ?></h5>
                    <h5>Breed: <?= $item['breed']= $item['breed'] ? $item['breed'] : "---"; ?></h5>
                    <?php 
                        $bdate_format = !empty($item['bdate']) ? date("M d,Y", strtotime($item['bdate'])) : "---";
                    ?>
                    <h5>Birthdate: <?= $bdate_format; ?></h5>
                    <h5>Age: <?= $item['age'] = !empty($item['age']) ? $item['age'] : 0; ?></h5>
                    <form method="post" class="mt-4">
                    <a href="view_vaccination_record.php?pet_id=<?= $item['pet_id']; ?>&id_user=<?= $_GET['id_user']; ?>" class="btn btn-primary p-2" style="width:130px;">View Records</a>
                        <!-- <a href="update_user_pet.php?id_user=<?= $item['pet_id']; ?>" class="btn btn-success">Update</a> -->
                        <!-- <input type="hidden" name="pet_id" value="<?= $item['pet_id']; ?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_pet" onclick="return confirm('Are you sure you want to remove this pet?')"> Remove </button> -->
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>

    <!-- <div class="mob-create">
        <a class="btn create-btn text-light" href="create_user_pet.php">+</a>
    </div> -->
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pet Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal image -->
                <img id="modalImage" class="img-fluid" alt="Modal Image" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to open the modal and set the image source
    function openModal(imageSrc) {
    // console.log("Opening modal with image source:", imageSrc);
    document.getElementById('modalImage').src = "admin/" + imageSrc;
}
</script>

<!-- ... (other code) -->
    <!-- </div> -->


        
