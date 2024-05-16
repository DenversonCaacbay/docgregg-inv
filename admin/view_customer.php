<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();

    $view_profile = $staffbmis->view_single_customers();
    $view = $staffbmis->view_customer_services();

    $staffbmis->update_customer();
    $staffbmis->delete_customer();

?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<style>
    thead.sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .services--btn{
        display:flex;
        align-items:center;
        align-content: center;
        justify-content:end;
    }
    .service--card{
        height:100%;
        overflow-x: auto;
    }
    .form--card{
        height: 650px;
        overflow: auto;
    }
    th,td{
        /* justify-content: center; */
        align-content: center;
    }
    @media screen and (max-width: 1280px) {
        .form--card{
            height: 400px;
            overflow: auto;
        }
    }

    @media screen and (max-width: 1580px){
        .form--card{
            
            height: 490px;
            overflow: auto;
        }
        .service--card{
            height:80%;
        } 
    }
    /* @media screen and (max-width: 1280px){
        .service--card{
            height:70vh;
        } 
    } */
    @media screen and (max-width: 1024px){
        .service--card{
            height:80%;
        } 
    }
    @media screen and (max-width: 768px){
        .service--card{
            height:100%;
        } 
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid page-container">

    <div class="d-flex justify-content-between align-items-center">
        <a href="services.php" class="btn btn-primary">Back</a>
        <!-- <a href="create_service.php?id=<?= $_GET['id'] ?>" class="btn btn-primary">Avail Service</a> -->
        <div style="width: 30%">
            <div class="input-group">
                <label class="input-group-text" for="inputGroupSelect01">Avail Service:</label>
                    <select class="form-select text-center" id="selectType">
                    <option value="">-- Select Type --</option>
                    <option value="./avail_service_cat.php?id=<?= $_GET['id'] ?>">Cat</option>
                    <option value="./avail_service_dog.php?id=<?= $_GET['id'] ?>">Dog</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row"> 
        <div class="col-md-4">
            <div class="card p-3 mt-3">
                <form method="post">
                    <h3>Customer Information</h3>
                    <label>Name: </label>
                    <input class="form-control" type="text" name="customer_name" value="<?= $view_profile['customer_name'] ?>">
                    <label class="mt-3">Contact:</label>
                    <input class="form-control" type="text" name="customer_contact" value="<?= $view_profile['customer_contact'] ?>">
                    <label class="mt-3">Email:</label>
                    <input class="form-control" type="text" name="customer_email" value="<?= $view_profile['customer_email'] ?>">
                    <label class="mt-3">Address:</label>
                    <input class="form-control" type="text"  name="customer_address"  value="<?= $view_profile['customer_address'] ?>">
                    <div class="d-flex">
                        
                        <!-- <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Information</button> -->
                        <button class="btn btn-danger mt-3 w-100 me-3 " type="submit" name="delete_customer" onclick="return confirm('Are you sure you want to remove this customer?')">Remove Data</button>
                        <button class="btn btn-primary mt-3 w-100 " type="submit" name="update_customer">Update</button>
                    </div>
                    
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <h3>Availed Services</h3>
            <div class="form--card">
            <?php
            if (is_array($view) && count($view) > 0) {
                $groupedData = [];
                foreach ($view as $views) {
                    $date = date("F d, Y", strtotime($views['created_at']));
                    if (!isset($groupedData[$date])) {
                        $groupedData[$date] = [];
                    }
                    $serviceKey = $views['service_availed'];
                    $petType = $views['pet_type'];
                    if (!isset($groupedData[$date][$serviceKey])) {
                        $groupedData[$date][$serviceKey] = [];
                    }
                    if (!isset($groupedData[$date][$serviceKey][$petType])) {
                        $groupedData[$date][$serviceKey][$petType] = [];
                    }
                    $groupedData[$date][$serviceKey][$petType][] = $views;
                }
                foreach ($groupedData as $date => $services) {
                    ?>
                    <div class="card mt-3">
                        <div class="card-header sticky-top bg-primary text-light">Date: <?= $date ?>
                            <hr style="border: 1px solid #fff;" />
                            <div class="row text-center bg-primary text-light p-0" style="border-radius: 5px">
                                <div class="col-md-3">Pet Type</div>
                                <div class="col-md-4">Service Availed</div>
                                <div class="col-md-5">Type / Medicine / Equipment</div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php 
                                $servicesToHideQuantity = ['Heartworm', 'Laboratory', 'Confinement', 'Diagnostic', 'Grooming', 'Blood Chemistry Test'];
                            ?>

                            <?php foreach ($services as $service => $petTypes) : ?>
                                <?php foreach ($petTypes as $petType => $data) : ?>
                                    <div class="card border-0 p-0">
                                        <div class="card-body p-0">
                                            <div class="row text-center">
                                                <div class="col-md-3">
                                                    <p class="card-title"><?= $petType; ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="card-title"><?= $service; ?></p>
                                                </div>
                                                <div class="col-md-5">
                                                    <p class="card-text">
                                                        <?php foreach ($data as $views) : ?>
                                                            <?php foreach (json_decode($views['type_med_equip'], true) as $index => $view) : ?>
                                                                <?php
                                                                    // Trim the $view to remove everything after the hyphen
                                                                    $trimmed_view = explode('-', $view)[0];
                                                                ?>
                                                                <?php if (in_array($service, $servicesToHideQuantity)) : ?>
                                                                    <?= trim($trimmed_view); ?><br>
                                                                <?php else : ?>
                                                                    <?= $views['quantity']; ?>pcs - <?= trim($trimmed_view); ?><br>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>

                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No Data Found</p>";
            }
            ?>
        </div>
        </div>
    </div>


</div>
<script>
    // Add event listener to the select element
    document.getElementById("selectType").addEventListener("change", function() {
        // Redirect to the selected option's value
        window.location.href = this.value;
    });
</script>
