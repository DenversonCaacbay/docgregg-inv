<?php
	// require the database connection
	require 'classes/conn.php';
	if(isset($_POST['search_clearance'])){
		$keyword = $_POST['keyword'];
?>

<table class="table table-hover text-center table-bordered table-responsive" >
    <thead class="alert-info">
        
        <tr>
            <th> Actions</th>
            <th> Resident ID </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> Purpose </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> Municipality </th>
            <th> Status </th>
            <th> Image </th>
        </tr>
    </thead>

    <tbody>
        <?php
            
            $stmnt = $conn->prepare("SELECT * FROM `tbl_clearance` WHERE `lname` LIKE '%$keyword%' or  `mi` LIKE '%$keyword%' or  `fname` LIKE '%$keyword%' 
            or  `id_resident` LIKE '%$keyword%' or  `houseno` LIKE '%$keyword%' or  `street` LIKE '%$keyword%'
            or `brgy` LIKE '%$keyword%' or `municipal` LIKE '%$keyword%' or `status` LIKE '%$keyword%' ");
            $stmnt->execute();
            
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="rescert_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                        <input type="hidden" name="id_rescert" value="<?= $view['id_rescert'];?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_clearance" onclick="return confirm('Are you sure you want to archive this data?')"> Archive </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['purpose'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['status'];?> </td>
                <td>
                    <?php if (is_null($view['brgyclearance_photo'])): ?>
                        <span>No Image Available</span>
                    <?php else: ?>
                        <a class="btn btn-success" target="_blank" href="<?php echo $view['brgyclearance_photo']; ?>">View</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>

</table>

<?php		
	}else{
?>

<table class="table table-hover text-center table-bordered table-responsive">

    <thead class="alert-info">
        <tr>
            <th> Actions</th>
            <th> Resident ID </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> Purpose </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> Municipality </th>
            <th> Status </th>
            <th> Image </th>
        </tr>
    </thead>

    <tbody>
        <?php if(is_array($view)) {?>
            <?php foreach($view as $view) {?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <a class="btn btn-success" target="blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="rescert_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                            <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                            <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_clearance" onclick="return confirm('Are you sure you want to archive this data?')"> Archive </button>
                        </form>
                    </td>
                    <td> <?= $view['id_clearance'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['purpose'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['status'];?> </td>
                    <td>
                        <?php if (is_null($view['brgyclearance_photo'])): ?>
                            <span>No Image Available</span>
                        <?php else: ?>
                            <a class="btn btn-success" target="_blank" href="<?php echo $view['brgyclearance_photo']; ?>">View</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
                }
            ?>
        <?php
            }
        ?>
    </tbody>

</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

<?php
	}
$con = null;
?>