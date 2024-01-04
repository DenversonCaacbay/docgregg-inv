<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();

   
?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<?php 

$connect = mysqli_connect("localhost", "root", "", "dgvc");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
        // if order qty > stocks
        if($_POST['quantity'] > $_POST['hidden_stocks']){
            echo '<script>alert("Item QTY is greater than stocks!")</script>';
            echo '<script>window.location="admin_sale_inventory.php"</script>';
        }
        else{
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            if(!in_array($_GET["id"], $item_array_id))
            {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                    'item_id'			=>	$_GET["id"],
                    'item_name'			=>	$_POST["hidden_name"],
                    'item_price'		=>	$_POST["hidden_price"],
                    'item_quantity'		=>	$_POST["quantity"]
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
            }
            else
            {
                echo '<script>alert("Item Already Added")</script>';
                echo '<script>window.location="admin_sale_inventory.php"</script>';
            }
        }
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="admin_sale_inventory.php"</script>';
			}
		}
	}
}




?>


<style>
    .input-icons i {
        position: absolute;
    }
        
    .input-icons {
        width: 30%;
        margin-bottom: 10px;
        margin-left: 34%;
    }
        
    .icon {
        padding: 10px;
        min-width: 40px;
    }
    .form-control{
        text-align: center;
        padding: 20px;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class=""> 
            <h1 class="text-gray">Sales</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="datatableid" class="table text-center">
                <tr>
                    <th scope="col"> <!--Inventory Search and Table of items-->
                        <div class="sub-btn">
                            <input type="text" class="form-control" style="width:100%;height:40px;" name="search" id="myInput" placeholder="Search Product...">
                        </div>
                         <br>
                        <table style="width:100%;" id="datatableid" class="table table-light">
                        <tr>
                            <th style="background: #0296be;color:white;">Product Name</th>
                            <th style="background: #0296be;color:white;">Price</th>
                            <th style="background: #0296be;color:white;">Stocks</th>
                            <th width="10%;" style="background: #0296be;color:white;">Quantity</th>
                            <th style="background: #0296be;color:white;"></th>
                            <th style="background: #0296be;color:white;"></th>
                            <th colspan="2" style="background: #0296be;color:white;">Add</th>
                        </tr>   
                        <?php
                            $query = "SELECT * FROM tbl_inventory ORDER BY inv_id ASC";
                            $result = mysqli_query($connect, $query);
                            if(mysqli_num_rows($result) > 0)
                            {
                                while($row = mysqli_fetch_array($result))
                                {

                                    if($row['quantity'] > 0){
                        ?>
                        <tbody id="myTable">
                        <tr>
                            <form method="post" action="admin_sale_inventory.php?action=add&id=<?php echo $row["inv_id"]; ?>">
                                <td><h5 class=""><?php echo $row["name"]; ?></h5></td>
                                <td><h5>₱ <?php echo $row["price"]; ?>.00</h5></td>
                                <td><h5><?php echo $row["quantity"]; ?> pc(s)</h5></td>
                                <td><input type="text" name="quantity" value="1" class="form-control" /></td>
                                <td><input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" /></td>
                                <td><input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" /></td>
                                <td><input type="hidden" name="hidden_stocks" value="<?php echo $row["quantity"]; ?>" /></td>
                                <td><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-primary" value="Add to Cart" /></td>
                            </form>
                        </tr>
                    
                        <?php
                            }
                        }
                    }
                ?>
                    </tbody>
                        
                <!--Order details-->
            </table>
            </th>

<th scope="col"><!--Orders and Reciept-->
<div style="clear:both"></div>
<br>
<h3>Order Details</h3>
<div class="table-responsive">
<table style="width:600px" class="table table-light">
  <tr>
      <th style="background: #0296be;color:white;">Name</th>
      <th width="10%" style="background: #0296be;color:white;">Quantity</th>
      <th style="background: #0296be;color:white;">Price</th>
      <th width="20%" style="background: #0296be;color:white;">Total</th>
      <th style="background: #0296be;color:white;">Action</th>
  </tr>
  <?php
  if(!empty($_SESSION["shopping_cart"]))
  {
      $total = 0;
      foreach($_SESSION["shopping_cart"] as $keys => $values)
      {
  ?>
  <tr>
      <td><?php echo $values["item_name"]; ?></td>
      <td><?php echo $values["item_quantity"]; ?></td>
      <td>₱ <?php echo $values["item_price"]; ?></td>
      <td>₱ <?php echo $values["item_quantity"] * $values["item_price"];?></td>
      <td><a href="admin_sale_inventory.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
  </tr>
  <?php
          $total = $total + ($values["item_quantity"] * $values["item_price"]);
      }
  ?>
  <form action="pos/pos_invoice.php" method="post">
  <tr>
      <td colspan="3" align="right">Total</td>
      <td align="right">
          <input type="number" name="processTotal" id="total_id" step="any" value="<?php echo $total; ?>" class="form-control" placeholder="₱ " readonly></td>
      <td></td>
  </tr>
  <tr>
      <td colspan="3" align="right">Enter Cash</td>
      <td align="right"><input type="number" step="any" name="processCash" id="cash_id" class="form-control" 
              placeholder="0"></td>

  </tr>
  <tr>
      <td colspan="3" align="right">Change :</td>
      <td align="right"><input type="number" step="any" name="processChange" id="resultpayment" class="form-control" readonly></td>
  </tr>
  <?php
  }
  ?>
  
  <tr>
      <td colspan="5"><textarea class='form-control' name='productAll' readonly hidden><?php
      $countItem = count($_SESSION['shopping_cart']);
      $counting = 1;

      foreach($_SESSION['shopping_cart'] as $data){
          // neatlook output
          $template = $data['item_name']." P".$data['item_price']." ".$data['item_quantity']." pc(s)";

          if($countItem > $counting){
              echo $template.", ";
              $counting++;
          }
          else{
              echo $template;
          }
      }
      ?></textarea>
      </td>
  </tr>
</table>
<input type="submit" class="btn btn-danger" id="proceed" value="PROCEED PAYMENT">
</form>

<button style="width:40%;" name="updatedata" onclick="checkpayment();" class="btn btn-danger paymentbtn">Calculate</button>
<a href="pos/pos_clear.php"><button class="btn btn-danger">Clear</button></a>
<script>
$proceed = document.getElementById("proceed").disabled = true;

function checkpayment()
{
  var total = parseFloat(document.getElementById('total_id').value);
  var cash = parseFloat(document.getElementById('cash_id').value);
   
  var acceptpayment = cash - total ;
  acceptpayment1 = parseFloat(acceptpayment);

  if (cash >= total)
  {
      document.getElementById('resultpayment').value = acceptpayment1;
      $proceed = document.getElementById("proceed").disabled = false;
  }

  else
  {
      document.getElementById('resultpayment').value = acceptpayment1;
      $proceed = document.getElementById("proceed").disabled = true;
  }

}

</script>
</div>
</th>
</tr>
</table>
        </div>
    
        
    </div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->
<script>
        $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>

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

