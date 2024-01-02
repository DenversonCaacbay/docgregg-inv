<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',1);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $userdetails['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    $view = $residentbmis->view_record($id_resident);
    
    $residentbmis->profile_update();
    $residentbmis->delete_vaccination();
 
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
            <div class="col-md-6"><div class="title">Vaccination Records</div></div>
            <div class="col-md-6">
                <div class="desk-create">
                    <a class="btn btn-primary text-light" href="create_user_vaccination.php">Add Vaccination Certificate</a>
                </div>
            </div>
        </div>

        <?php if(is_array($view) && count($view) > 0): ?>
    <?php foreach($view as $item): ?>
        <div class="card p-2 mt-4">
            <div class="row">
                <div class="col-md-3 text-center ">
                    <?php if (is_null($item['vac_picture'])): ?>
                        <img src="images/placeholder/pet-placeholder.png" width="150px;">
                    <?php else: ?>
                        <!-- Display pet image here -->
                        <img src="<?= $item['vac_picture'] ?>" class="img-fluid" alt="Modal Image" width="100">
                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <h5><?= $item['pet_name']; ?></h5>
                    <h5><?= date("F d, Y - l", strtotime($item['created_at'])); ?></h5>
                    <form method="post" class="mt-4">
                        <!-- <a href="update_user_pet.php?id_user=<?= $item['id_admin']; ?>" class="btn btn-success">Update</a> -->
                        <input type="hidden" name="vac_id" value="<?= $item['vac_id']; ?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_vac" onclick="return confirm('Are you sure you want to remove this Vaccination?')"> Remove </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>

<div class="mob-create">
        <a class="btn create-btn text-light" href="create_user_vaccination.php">+</a>
    </div>
</div>

