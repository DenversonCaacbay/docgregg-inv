<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_user();

    $staffcount = $staffbmis->count_user();
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();

?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <h1 class="mb-4">Client List</h1>
    <!-- <button class="btn btn-primary">Add Item</button> -->

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
                            <th width="10%"> Picture </th>
                            <th width="10%"> First Name </th>
                            <th width="10%"> Middle Name </th>
                            <th width="10%"> Last Name </th>
                            <th width="10%"> Sex </th>
                            <th width="23%"> Address </th>
                            <th width="30%"> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <img src="../images/placeholder/user-placeholder.png" width="50">
                                    <?php else: ?>
                                        <img src="../<?= $view['picture'] ?>" class="" width="50" alt="Modal Image">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= $view['fname'];?> </td>
                                    <td><?= $view['mi'];?> </td>
                                    <td> <?= $view['lname'];?> </td>
                                    <td> <?= $view['sex'];?> </td>
                                    <td><?= strlen($view['address']) > 30 ? substr($view['address'], 0, 30) . '...' : $view['address']; ?></td>

                                    <td>    
                                        <form action="" method="post">
                                            <a href="admin_client_info.php?id_user=<?= $view['id_user'];?>" style="width: 100px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-primary"> View Info </a>
                                            <a href="create_client_pet.php?id_user=<?= $view['id_user'];?>" style="width: 100px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-primary"> Add Pet </a>
                                            <a href="admin_client_pet.php?id_user=<?= $view['id_user'];?>" style="width: 100px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-primary"> View Pets </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_user'];?>">
                                            <!-- <button class="btn btn-danger" type="submit" name="delete_user"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"> Remove </button> -->
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>
    </div>
</div>

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
                var fname = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                var lname = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                // var category = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

                // Check if the query matches the product name or category
                if (fname.includes(query) || lname.includes(query)) {
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
