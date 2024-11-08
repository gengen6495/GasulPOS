<?php
    session_start();
    include 'config.php';

    if (!isset($_SESSION['email_address']) || $_SESSION['user_type'] !== 'cashier') {
        header('Location: login.php');
        exit();
    }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] === 'another_form') {
    $payable_amount = isset($_POST['payable_amount']) ? $_POST['payable_amount'] : 0;
    $tendered_amount = isset($_POST['tendered_amount']) ? $_POST['tendered_amount'] : 0;
    $change = isset($_POST['change']) ? $_POST['change'] : 0;

    $order_query = "INSERT INTO `order_data` (`user_id`, `order_date`, `total_amount`, `status`) VALUES (2, NOW(), ?, 'completed')";
    $order_stmt = $conn->prepare($order_query);

    $order_stmt->bind_param("s", $payable_amount);

    if ($order_stmt->execute()) {
        echo 'Order saved successfully.';
    } else {
        echo 'Error: ' . $order_stmt->error; 
    }
    $order_stmt->close();
    exit();
}

    $product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';

    if ($product_name !== '') {
        $stmt = $conn->prepare("SELECT * FROM product_data WHERE product_name LIKE ?");
        $searchTerm = '%' . $product_name . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM product_data");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customer_name = isset($_POST['customer-name']) ? $_POST['customer-name'] : 'Optional';
        $customer_number = isset($_POST['customer-number']) ? $_POST['customer-number'] : 'Optional';
        $disc_percentage = isset($_POST['disc_perc']) ? $_POST['disc_perc'] : 0;
        $disc_amount = isset($_POST['disc_amount']) ? $_POST['disc_amount'] : 0;
        $total_amount = isset($_POST['total']) ? $_POST['total'] : 0;
        $amount_tendered = isset($_POST['amount_tendered']) ? $_POST['amount_tendered'] : 0;
        $amount_change = isset($_POST['amount_change']) ? $_POST['amount_change'] : 0;
        $product_rows = $_POST['product_name'];
        $cylinder_options = $_POST['cylinder_option'];
        $total_prices = $_POST['total_price'];

        $order_query = "INSERT INTO `order_data` (cylinder_option, total_amount, order_date) VALUES (?, ?, NOW())";
        $order_stmt = $conn->prepare($order_query);
        $order_stmt->bind_param("ss", $cylinder_options[$key], $total_prices[$key]);

        $order_stmt->execute();
        $order_id = $conn->insert_id; 
        
        $quantities = $_POST['quantity'];
        

        $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $order_item_stmt = $conn->prepare($order_item_query);
        $order_item_stmt->bind_param("iii", $order_id, $product_id, $quantities[$key]);


        foreach ($product_rows as $key => $product_name) {
            $order_item_stmt->bind_param("s", $quantities[$key]);
            $order_item_stmt->execute();
        }

        $payment_query = "INSERT INTO payment_data (order_id, payment_date, payment_method, amount, tendered_amount, amount_change, discount, status) VALUES (?, NOW(), ?, ?, ?, ?, 'Paid')";
        $payment_stmt = $conn->prepare($payment_query);
        $payment_stmt->bind_param("iddds", $order_id, $amount_tendered, $amount_change, $disc_percentage, $disc_amount);

        header("Location: success_page.php");
        exit();
    }
?>


<!DOCTYPE html>
<html>
<head>
    <title>POS</title>
    <link rel="icon" type="image/x-icon" href="image/title-logo.png">
    <link rel="icon" type="image/x-icon" href="image/logo1.png">
    <link rel="stylesheet" type="text/css" href="css/pos.css">
</head>
<style>
#notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.notification {
    padding: 15px;
    border-radius: 5px;
    color: white;
    display: none;
}

.success {
    background-color: green; 
}

.error {
    background-color: red;
}
</style>

<body>
    <marquee style="background-color: skyblue; padding: 10px; color: blue;"><img style="width: 50px;" src="image/logo.png"> Get all your Orders done with just a few clicks! <img style="width: 50px;" src="image/logo.png"> Get all your Orders done with just a few clicks! <img style="width: 50px;" src="image/logo.png"> Get all your Orders done with just a few clicks! <img style="width: 50px;" src="image/logo.png">Get all your Orders done with just a few clicks! <img style="width: 50px;" src="image/logo.png"></marquee>
    <div class="container">
        <!-- <div id="header">
            <h1><img src="image/logo.png" alt="Your Logo" id="logo"></h1>
        </div> -->

<div id="notification-container">
    <div class="notification" id="notification-message"></div>
</div>

        <form action="" class="pos-form">
            <div class="card">
                <div class="card-body-wrapper">
                    <div class="column-8">
                        <div class="form-group">
                            <label for="customer-name">Customer Name</label>
                            <input type="text" autocomplete="off" class="form-control" id="customer-name" name="customer-name" value="Optional">
                            <label for="customer-number">Phone Number</label>
                            <input type="number" autocomplete="off" class="form-control" id="customer-number" name="customer-number" value="Optional">
                        </div>
                        <div class="form-group">
                            <label for="product-code">Enter Product Name</label>
                            <input type="text" autocomplete="off" autofocus class="form-control" id="product-code">
                        </div>
                        <div class="item-list">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Quantity</th>
                                        <th>Product Name</th>
                                        <th>Cylinder Option</th>
                                        <th>Service Option</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                 echo "<td class='clear-column'><button type='button' id='add-button'>Add</button></td>";
                                                echo "<td><input type='number' class='quantity' value='' placeholder='Enter quantity'></td>";
                                                echo "<td class='product_name'>".$row["product_name"]."</td>";
                                                echo "<td><select id='edit-cylinder-option' name='cylinderOption' style='padding: 5px;'>
                                                    <option value='Purchase'>with</option>
                                                    // <option value='Refill'>without</option>
                                                    </select><br></td>";
                                                echo "<td><select id='edit-service-option' name='serviceOption' style='padding: 5px;'>
                                                    <option value='Deliver'>Deliver</option>
                                                    // <option value='Walk-in Purchase'>Walk-in</option>
                                                    </select><br></td>";
                                                echo "<td class='unit-price'>".$row["product_price"]."</td>";
                                                echo "<td class='total-price'>0.00</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="column-4">
                        <div class="keyboard-shortcuts">
                            <fieldset>
                                <legend>Transaction</legend>
                                <!-- <p><button class="btn" id="productCodeBtn">Product Name Text Field</button> </p>
                                <p><button class="btn" id="discountBtn">Discount % Text Field</button></p> -->
                                <div id="added-items">
                                    <h3>Added Items</h3>
                                    <ul id="items-list"></ul>
                                </div>
                                <p><button class="btn" id="tenderAmountBtn">Payment process</button></p>
                            </fieldset>
                        </div>
                        <div class="computaion-pane">

                            <div class="w-100 d-flex align-items-end h-100">
                            <div class="col-12">
                                <div class="subtotal-row">
                                    <div class="col-3">SubTotal</div>
                                    <div class="col-9" id="sub_total">0.00</div>
                                </div>
                                <div class="discount%-row">
                                    <div class="col-3">Discount %</div>
                                    <div class="col-9" contenteditable id="disc_perc">0</div>
                                    <input type="hidden" name="disc_perc" value="0">
                                </div>
                                <div class="discount-row">
                                    <div class="col-3">Discount</div>
                                    <div class="col-9" id="disc_amount">0</div>
                                    <input type="hidden" name="disc_amount" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="grand-total">
                            <h3>Grand Total</h3>
                            <div class="total-amount">₱0.00</div>
                            <input type="hidden" name="total" value="0">
                            <input type="hidden" name="amount_tendered" value="0">
                            <input type="hidden" name="amount_change" value="0">
                        </div>
                    </div>
                    <br><br>
                    Cashier: <?php echo $_SESSION['email_address']; ?>
                </div>
            </div>
        </form>
    </div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="POST" action="">
            <input type="hidden" name="form_type" value="another_form">
            <label for="payableAmountField">Payable Amount: </label><br>
            <input type="text" id="payableAmountField" name="payable_amount" required><br><br>
            <label for="tenderedAmountField">Tender Amount:</label><br>
            <input type="text" id="tenderedAmountField" name="tendered_amount" required><br><br>
            <label for="changeField">Change: </label><br>
            <input type="text" id="changeField" name="change" required><br><br>
            <input type="submit" value="Submit">
        </form>

        <div id="notification-container">
    <div class="notification" id="notification-message" style="display: none;"></div>
</div>

    </div>
</div>



<div id="receipt" class="modal">
    <div class="modal-content-receipt">
        <span class="close-receipt">&times;</span>
        <h2>Transaction Receipt</h2>
        
         <table>
            <tr >
                <th style="padding: 50px; margin-left: 45%; display: flex;">Petron Gasul <br>Sta. Filomena, Iligan City</th>
            </tr>
            <tr>
                <th colspan="3" style="text-align: left;">Customer Name: <span id="customerName"></span></th>
                <th colspan="3" style="text-align: right;">Date: <span id="transactionDate"></span></th>
            </tr>
        </table>
        <table id="transactionDetails" style="width:100%">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </table>
        <center><button class="butt">Print Receipt</button></center>
    </div>
</div>
<script>
var modal = document.getElementById("myModal");

var btn = document.getElementById("tenderAmountBtn");

    var span = document.getElementsByClassName("close")[0];

    var form = document.querySelector('.pos-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

    });

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}
   document.querySelector('.item-list tbody').addEventListener('click', function (e) {
    if (e.target && e.target.id === 'add-button') {
        const row = e.target.closest('tr');  
        const productName = row.querySelector('.product_name').innerText;
        const quantity = row.querySelector('.quantity').value;
        const unitPrice = row.querySelector('.unit-price').innerText;
        const cylinderOption = row.querySelector('#edit-cylinder-option').value;
        const totalPrice = row.querySelector('.total-price').innerText;

        const listItem = document.createElement('li');
        listItem.textContent = `${productName} - ${quantity} pcs - ${cylinderOption} - ₱${totalPrice}`;
        document.getElementById('items-list').appendChild(listItem);
    }
});

    // window.onclick = function(event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
    //     }
    // }
    const productCodeInput = document.getElementById('product-code');
        const productRows = document.querySelectorAll('.item-list tbody tr');

        productCodeInput.addEventListener('input', function() {
            const searchTerm = productCodeInput.value.toLowerCase();
            productRows.forEach(row => {
                const productName = row.querySelector('.product_name').innerText.toLowerCase();
                if (productName.includes(searchTerm)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        const customerNameInput = document.getElementById('customer-name');
    const customerNameSpan = document.getElementById('customerName');

    customerNameInput.addEventListener('input', function () {
        customerNameSpan.innerText = customerNameInput.value || ''; 
    });
        const currentDate = new Date();
    const formattedDate = currentDate.toLocaleString('en-CA'); 

    document.getElementById('transactionDate').innerText = formattedDate;

     document.addEventListener("DOMContentLoaded", function() {
            const productRows = document.querySelectorAll('.item-list tbody tr');
            const quantityInputs = document.querySelectorAll('.quantity');
            const subTotalElement = document.getElementById('sub_total');
            const discPercElement = document.getElementById('disc_perc');
            const discAmountElement = document.getElementById('disc_amount');
            const totalAmountElement = document.querySelector('.total-amount');
            const tenderedAmountField = document.getElementById('tenderedAmountField');
            const changeField = document.getElementById('changeField');
            const payableAmountField = document.getElementById('payableAmountField');
            const modal = document.getElementById("myModal");
            const form = document.querySelector('.pos-form');
            const receiptContent = document.getElementById('transactionDetails');
            const transactionReceipt = document.getElementById('receipt');


            quantityInputs.forEach(input => {
                input.addEventListener('input', function() {
                    calculateSubTotal();
                });
            });
             const clearButtons = document.querySelectorAll('.clear-btn');
        clearButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = button.parentNode.parentNode;
                row.style.display = 'none';
                calculateSubTotal();
            });
        });

            const discountInput = document.getElementById('disc_perc');
            discountInput.addEventListener('input', function() {
                calculateDiscount();
            });

            tenderedAmountField.addEventListener('input', function() {
                calculatePayment();
            });
            const printButton = document.querySelector('.butt');
            printButton.addEventListener('click', function () {
                printReceipt();
            });

            function printReceipt() {
                window.print();
            }

            function calculateSubTotal() {
                let subTotal = 0;
                productRows.forEach(row => {
                    const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                    const unitPrice = parseFloat(row.querySelector('.unit-price').innerText) || 0;
                    const totalPriceElement = row.querySelector('.total-price');

                    const totalPrice = parseFloat((quantity * unitPrice).toFixed(2));
                    totalPriceElement.innerText = totalPrice.toFixed(2);
                    subTotal += totalPrice;
                });

                subTotalElement.innerText = subTotal.toFixed(2);
                calculateDiscount();
            }

            function calculateDiscount() {
                let subTotal = parseFloat(subTotalElement.innerText) || 0;
                const discountPercentage = parseFloat(discPercElement.innerText) || 0;
                const discountAmount = parseFloat((subTotal * discountPercentage / 100).toFixed(2));
                const discountedTotal = parseFloat((subTotal - discountAmount).toFixed(2));
                discAmountElement.innerText = discountAmount.toFixed(2);
                totalAmountElement.innerText = discountedTotal.toFixed(2);
            }


            function calculatePayment() {
                let subTotal = parseFloat(subTotalElement.innerText) || 0;
                let discountedTotal = parseFloat(totalAmountElement.innerText) || 0;
                const tenderedAmount = parseFloat(tenderedAmountField.value) || 0;
                const change = parseFloat((tenderedAmount - discountedTotal).toFixed(2));
                changeField.value = change.toFixed(2);

                const payableAmount = parseFloat(discountedTotal).toFixed(2);
                payableAmountField.value = payableAmount; 
            }

//            document.querySelector('.modal-content form').addEventListener('submit', function(event) {
//     event.preventDefault();
//     modal.style.display = "none";  // Hide the modal after submitting
//     // alert("Payment processed successfully!");  // Example alert for confirmation
// });
document.querySelector('.modal-content form').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const formData = new FormData(this); 

    fetch('', {  
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        const notificationMessage = document.getElementById("notification-message");
        notificationMessage.style.display = "block"; 
        if (data.includes("Order saved successfully.")) {
            modal.style.display = "none"; 
            notificationMessage.innerHTML = "Payment processed successfully.";
            notificationMessage.className = "notification success";
        } else {
            notificationMessage.innerHTML = "Error processing payment: " + data; 
            notificationMessage.className = "notification error";
        }
    })
    .catch(error => console.error('Error:', error));
});

const submitButton = document.querySelector('input[type="submit"]');
    submitButton.addEventListener('click', function() {
        const transactionDetails = document.getElementById('transactionDetails');
        const productRows = document.querySelectorAll('.item-list tbody tr');
        const productNames = document.querySelectorAll('.product_name');
        const quantities = document.querySelectorAll('.quantity');
        const unitPrices = document.querySelectorAll('.unit-price');
        const totalPrices = document.querySelectorAll('.total-price');
        const categories = document.querySelectorAll('#edit-cylinder-option');
        const discountPercentage = discPercElement.innerText;
        const discountAmount = discAmountElement.innerText;
        const grandTotal = totalAmountElement.innerText;

        let receiptContent = '<tr><th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Cylinder Option</th><th>Total Price</th></tr>';
        for (let i = 0; i < productRows.length; i++) {
            const quantity = quantities[i].value;
            if (quantity > 0) {
                receiptContent += `
                    <tr>
                        <td>${productNames[i].innerText}</td>
                        <td>${quantity} pcs</td>
                        <td>${unitPrices[i].innerText}</td>
                        <td>${categories[i].value}</td>
                        <td>₱${totalPrices[i].innerText}</td>
                    </tr>
                `;
            }
        }
        if (discountPercentage !== '0') {
            receiptContent += `
                <tr>
                    <td style="border: none; font-weight: bold;">Discount Percentage</td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none; font-weight: bold;">${discountPercentage}%</td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold;">Discount Amount</td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none; font-weight: bold;">${discountAmount}</td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold;">Amount Tendered</td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none; font-weight: bold;">₱${tenderedAmountField.value}</td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold;">Change</td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none; font-weight: bold;">₱${changeField.value}</td>
                </tr>
            `;
        }
        receiptContent += `
            <tr>
                <td style="border: none; font-weight: bold;">Grand Total</td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none; font-weight: bold;">₱${grandTotal}</td>
            </tr>
        `;
        transactionDetails.innerHTML = receiptContent;
        document.getElementById('receipt').style.display = "block";

        const closeReceiptButton = document.querySelector('.close-receipt');
        closeReceiptButton.onclick = function() {
            document.getElementById('receipt').style.display = "none";
        }
    }); 

        });                   ;                    
</script>

</body>
</html>                                           
<?php     $conn->close();?>