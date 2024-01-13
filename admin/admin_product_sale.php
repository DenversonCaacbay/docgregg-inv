<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();

   
?>
<!-- <script>
    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
</script> -->
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            var table = $("#myTable");
            var noItemRow = $("#noItemRow");

            // Filter rows based on the input value
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

            // Check if there are visible rows
            var visibleRows = table.find('tr:visible').length;

            // Toggle the "No item found" row based on visibility
            noItemRow.toggle(visibleRows === 0);
        });
    });
</script>


<?php 
    include('dashboard_sidebar_start.php');
?>
<?php 
session_start(); // Make sure to start the session

$connect = mysqli_connect("localhost", "root", "", "dgvc");

if(isset($_POST["add_to_cart"]))
{
    $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 0;
    $hiddenStocks = isset($_POST["hidden_stocks"]) ? intval($_POST["hidden_stocks"]) : 0;

    if ($quantity <= 0) {
        echo "<script>alert('Please enter a quantity greater than 0.');</script>";
    } elseif ($quantity > $hiddenStocks) {
        echo "<script>alert('The quantity entered is higher than the available stock.');</script>";
    } else {
        // Make sure to start the session
        if(!isset($_SESSION["shopping_cart"]))
        {
            $_SESSION["shopping_cart"] = array();
        }

        // if order qty > stocks
        if($quantity > $hiddenStocks){
            echo '<script>alert("Item QTY is greater than stocks!")</script>';
            echo '<script>window.location="admin_product_sale.php"</script>';
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
                echo '<script>window.location="admin_product_sale.php"</script>';
            }
        }
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
                    echo '<script>window.location="admin_product_sale.php"</script>';
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
    table td h5{
        font-size: 18px;
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
            <div class="row">
                <div class="col-md-7">
                    <div class="sub-btn">
                        <input type="text" class="form-control" style="width:100%;height:40px;" id="myInput" placeholder="Search Product..." autocomplete="off">
                    </div>
                    <br>
                    <div class="card" style="height: 500px; overflow: auto;">
                        <table style="width:100%;" id="myTable datatableid" class="table table-light">
                            <tr>
                                <th width="40%" style="background: #0296be;color:white;">Product Name</th>
                                <th width="20%" style="background: #0296be;color:white;">Price</th>
                                <th width="20%" style="background: #0296be;color:white;">Stocks</th>
                                <th width="10%" style="background: #0296be;color:white;">Quantity</th>
                                <th style="background: #0296be;color:white;"></th>
                                <th style="background: #0296be;color:white;"></th>
                                <th width="10%"colspan="2" class="text-center" style="background: #0296be;color:white;">Add</th>
                            </tr>   
                            <?php
                                $query = "SELECT * FROM tbl_inventory WHERE deleted_at IS NULL ORDER BY inv_id ASC";
                                $result = mysqli_query($connect, $query);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        if($row['quantity'] > 0)
                                        {
                            ?>
                            <tbody id="myTable">
                                <tr>
                                    <form method="post" action="admin_product_sale.php?action=add&id=<?php echo $row["inv_id"]; ?>">
                                        <td width="20%"><h5 class=""><?php echo strlen($row['name']) > 20 ? substr($row['name'], 0, 20) . '...' : $row['name']; ?></h5></td>
                                        <td width="20%"><h5>₱ <?php echo $row["price"]; ?>.00</h5></td>
                                        <td width="20%"><h5><?php echo $row["quantity"]; ?> pc(s)</h5></td>
                                        <td><input type="text" name="quantity" class="inputQuantity form-control" value="1" /></td>
                                        <td><input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" /></td>
                                        <td><input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" /></td>
                                        <td><input type="hidden" name="hidden_stocks" class="hidden_stocks" value="<?php echo $row["quantity"]; ?>" /></td>
                                        <td><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-primary addToCartBtn" value="Add to Cart" /></td>
                                    </form>
                                </tr>                   
                            <?php
                                        }
                                    }
                                }
                            ?>
                            <tr id="noItemRow" style="display: none;">
                                <td colspan="7" class="text-center">No item found</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="col-md-5">
                <div style="clear:both"></div>
                <br>
                <h3>Order Details</h3>
                <div class="table-responsive">
                    <table class="table table-light">
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
                            <td width="40%"><?php echo strlen($values['item_name']) > 20 ? substr($values['item_name'], 0, 20) . '...' : $values['item_name']; ?></td>
                            <td width="20%"><?php echo $values["item_quantity"]; ?></td>
                            <td width="20%">₱ <?php echo $values["item_price"]; ?></td>
                            <td width="20%">₱ <?php echo $values["item_quantity"] * $values["item_price"];?></td>
                            <td><a href="admin_product_sale.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                        </tr>
                        <?php
                                $total = $total + ($values["item_quantity"] * $values["item_price"]);
                            }
                        ?>
                    <form action="pos/pos_invoice.php" method="post">
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <td colspan="2" align="right">
                                <input type="number" name="processTotal" id="total_id" step="any" value="<?php echo $total; ?>" class="form-control" placeholder="₱ " readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Enter Customer Name</td>
                            <td colspan="2" align="right"><input type="text" step="any" name="processCustomer" id="customer_id" class="form-control" placeholder="" required></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Enter Cash</td>
                            <td colspan="2" align="right"><input type="number" step="any" name="processCash" id="cash_id" class="form-control" placeholder="0"></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Change :</td>
                            <td colspan="2" align="right"><input type="number" step="any" name="processChange" id="resultpayment" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Staff Name</td>
                            <td colspan="2" align="right">
                                <input type="text" step="any" name="staff_name" id="staff" value="<?= $userdetails['firstname']?> <?= $userdetails['surname']?>" class="form-control" readonly>
                            </td>
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
                    
                    <input type="submit" class="btn btn-primary w-100 mb-3" id="proceed" value="PROCEED PAYMENT">
                    </form>
                    <button style="width:50%;" name="updatedata" onclick="checkpayment();" class="btn btn-primary paymentbtn">Calculate</button>
                    <a href="pos/pos_clear.php"><button style="width:49%;" class="btn btn-primary">Clear Orders</button></a>
                    
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
            </div>
        </div>
    </div>
    
    
    <!-- /.container-fluid -->
    
</div>




<!-- End of Main Content -->


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

