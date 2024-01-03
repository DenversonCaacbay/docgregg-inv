<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_vaccine_record();
    // print_r($view);
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_vaccine_record();
    
?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
<div class="row">
    <div class="col-md-6"><h1 class="mb-4">Vaccination Record</h1></div>
    <!-- <div class="col-md-6"><a href="create_vaccination_record.php" style="float:right;padding: 10px" class="btn btn-primary">Add Vaccination Record</a></div> -->
</div>
    

    <div class="row"> 
        <div class="col-md-12">
        <div class="form-group">
                <label> Search </label>
                <input type="text" class="form-control" id="searchInput" name="name"  value="" required>
            </div>
           <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                           
                            <th> Pet Owner </th>
                            <th> Pet Name </th>
                            <th> Vaccine Certificate </th>
                            <th> Date Vaccinated </th>
                            <!-- <th> Actions </th> -->
                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    
                                    <td> <?= $view['fname'];?> <?= $view['lname'];?></td>
                                    <td> <?= $view['pet_name'];?> </td>
                                    <td>
                                        <?php if (empty($view['vac_picture'])): ?>
                                            <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Item Picture" width="150">
                                        <?php else: ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openModal('<?= $view['vac_picture'] ?>')">
                                                <img src="../<?= $view['vac_picture'] ?>" class="img-fluid" alt="Modal Image" width="50">
                                            </a>

                                        <?php endif; ?>
                                    </td>
                                    <td> <?= date("F d, Y - l", strtotime($view['vac_date'])); ?> </td>
                                    <!-- <td>    
                                        <form action="" method="post">
                                            <a href="update_vaccination_record_form.php?id_user=<?= $view['id_admin'];?>" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_admin'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_staff"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"> Archive </button>
                                        </form>
                                    </td> -->
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Vaccination Certificate</h1>
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
        // Set the image source for the modal image
        document.getElementById('modalImage').src = "../" + imageSrc;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the input field and table
        var input = document.getElementById('searchInput');
        var table = document.querySelector('.table');

        // Add an event listener to the input field
        input.addEventListener('input', function () {
            // Get the search query and convert it to lowercase
            var query = input.value.toLowerCase();

            // Get all table rows in the tbody
            var rows = table.querySelectorAll('tbody tr');

            // Loop through each row and hide/show based on the search query
            rows.forEach(function (row) {
                var name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                var petName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                // Check if the query matches the product name or category
                if (name.includes(query) || petName.includes(query)) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        });
    });
</script>

<!-- End of Main Content -->
<?php 
    include('dashboard_sidebar_end.php');
?>