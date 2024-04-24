<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- SweetAlert 2 JS (including dependencies) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

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
        echo "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please enter a quantity greater than 0',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
        // Redirect after showing the alert
        header("refresh: 1; url=admin_product_sale.php");
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
                    'item_quantity'		=>	$_POST["quantity"],
                    'item_profit'		=>	$_POST["hidden_profit"],
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
            }
            else
            {
                
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
    .inputQuantity{
        border: 1px rgba(2,150,190,1) solid;
        text-align:center;
        padding: 5px;
        width: 90%;
        border-radius: 5px;
    }
    .form--card{
        height: 750px;
        overflow: auto;
    }
    th,td{
        /* justify-content: center; */
        align-content: center;
    }
    @media screen and (max-width: 1280px) {
        .form--card{
            height: 450px;
            overflow: auto;
        }
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class=""> 
            <h4 class="text-gray">Product Sales</h4>
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
                    <div class="card form--card">
                        <table style="width:100%;" id="myTable datatableid" class="table table-light">
                            <tr>
                                <th width="40%" style="background: #0296be;color:white;">Product Name</th>
                                <th width="20%" style="background: #0296be;color:white;">Price</th>
                                <th width="20%" style="background: #0296be;color:white;">Stocks</th>
                                <th width="10%" style="background: #0296be;color:white;">Quantity</th>
                                <!-- <th width="10%" style="background: #0296be;color:white;" >Profit</th> -->
                                <th style="background: #0296be;color:white;display:none"></th>
                                <th style="background: #0296be;color:white;display:none"></th>
                                <th style="background: #0296be;color:white;display:none"></th>
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
                                        <td width="10%"><h5>₱ <?php echo $row["price"]; ?>.00</h5></td>
                                        <td width="20%"><h5><?php echo $row["quantity"]; ?> pc(s)</h5></td>
                                        
                                        <td><input type="number" name="quantity" class=" inputQuantity " value="1" /></td>
                                        <!-- <td width="20%" hidden><h5><?php echo $row["profit"]; ?></h5></td> -->
                                        <td style="display:none"><input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" /></td>
                                        <td style="display:none"><input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" /></td>
                                        <td style="display:none"><input type="hidden" name="hidden_stocks" class="hidden_stocks" value="<?php echo $row["quantity"]; ?>" /></td>
                                        <td style="display:none"><input type="hidden" name="hidden_profit" value="<?php echo $row["profit"]; ?>" /></td>
                                        
                                        <td><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-primary addToCartBtn" value="Add to Orders" /></td>
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
                <div class="table-responsive" style="height:500px;">
                    <table class="table table-light">
                        <tr class="sticky-top">
                            <th style="background: #0296be;color:white;">Name</th>
                            <th width="10%" style="background: #0296be;color:white;">Quantity</th>
                            <th style="background: #0296be;color:white;">Price</th>
                            <th style="background: #0296be;color:white;display:none">Profit</th>
                            <th width="20%" style="background: #0296be;color:white;">Total</th>
                            <th style="background: #0296be;color:white;">Action</th>
                        </tr>
                        <?php
                        if(!empty($_SESSION["shopping_cart"]))
                        {
                            $total = 0;
                            $profit = 0;
                            foreach($_SESSION["shopping_cart"] as $keys => $values)
                            {
                        ?>
                        <tr>
                            <td width="40%"><?php echo strlen($values['item_name']) > 20 ? substr($values['item_name'], 0, 20) . '...' : $values['item_name']; ?></td>
                            <td width="20%"><?php echo $values["item_quantity"]; ?></td>
                            <td width="20%">₱ <?php echo $values["item_price"]; ?></td>
                            <td style="display:none" width="20%">₱ <?php echo $values["item_quantity"] * $values["item_profit"];?></td>
                            <td width="20%">₱ <?php echo $values["item_quantity"] * $values["item_price"];?></td>
                            <td><a href="admin_product_sale.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                        </tr>
                        <?php
                                $profit = $profit + ($values["item_quantity"] * $values["item_profit"]);
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
                        <tr hidden>
                            <td colspan="3" align="right">Total Profit</td>
                            <td colspan="2" align="right">
                                <input type="number" name="processProfit" id="total_id" step="any" value="<?php echo $profit; ?>" class="form-control" placeholder="₱ " readonly>
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
                            <td colspan="3" align="right" hidden>Staff Name</td>
                            <td colspan="2" align="right">
                                <input type="hidden" step="any" name="staff_name" id="staff" value="<?= $userdetails['fname']?> <?= $userdetails['lname']?>" class="form-control" readonly>
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
                    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="orderDetails">
                                <!-- Order details will be loaded dynamically here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit Orders</button>
                                <button type="submit" class="btn btn-primary" id="proceedPaymentModal">Proceed Payment</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mb-3 ms-auto fixed-bottom" style="width: 34%; margin-right:1.5%" id="proceed" value="Proceed Payment">

                    </form>
                    <button style="width:50%;" name="updatedata" onclick="checkpayment();" class="btn btn-primary paymentbtn sticky-bottom">Calculate</button>
                    <a href="pos/pos_clear.php"><button style="width:49%;" class="btn btn-primary sticky-bottom">Clear Orders</button></a>
                    
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



<!-- Modal -->

<script>
  // JavaScript to handle displaying orders in modal
  document.getElementById('proceed').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    // Extract last table data (td) element and get its content
    var lastTDContent = document.querySelector('.table-responsive tr:last-of-type td:last-of-type').textContent;

    // Create an h5 element and set its content to the last td content
    var lastTDH5 = document.createElement('h5');
    lastTDH5.textContent = lastTDContent;

    // Extract input field values
    var customerName = document.getElementById('customer_id').value;
    var cashAmount = document.getElementById('cash_id').value;

    // Combine last td content, customer name, and cash amount into one HTML string
    var orderDetailsHTML = "<h5><strong>List of Orders:</strong><br> " + lastTDContent.split(',').join('<br>') + "</h5>";

    orderDetailsHTML += "<h5><strong>Customer Name:</strong> " + customerName + "</h5>";
    orderDetailsHTML += "<h5><strong>Cash Amount:</strong> ₱" + cashAmount + ".00</h5>";

    // Clear any existing content in the modal body
    document.getElementById('orderDetails').innerHTML = '';

    // Append the h5 elements to the modal body
    // document.getElementById('orderDetails').appendChild(lastTDH5);
    document.getElementById('orderDetails').insertAdjacentHTML('beforeend', orderDetailsHTML);

    // Show the modal
    var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    orderModal.show();
  });

  // JavaScript to handle proceeding payment within the modal
  document.getElementById('proceedPaymentModal').addEventListener('click', function(event) {
    // Here you can write code to submit the form data to your PHP script for database insertion
    // Example: document.getElementById('yourFormId').submit();
    console.log('Proceed Payment button clicked within modal');
  });
</script>


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

