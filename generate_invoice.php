<?php
require('fpdf/fpdf.php');
include 'dbinit.php';

$order_id = $_POST['order_id'];

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,'Invoice',0,1,'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$sql = "SELECT o.order_id, o.order_date, o.total_price, oi.quantity, oi.price AS item_price, p.product_name, p.product_image
        FROM orders o
        INNER JOIN order_item oi ON o.order_id = oi.orders_order_id
        INNER JOIN product p ON oi.product_product_id = p.product_id
        WHERE o.order_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$pdf->SetFont('Arial','',12);
$row = $result->fetch_assoc();
$pdf->Cell(0,10,'Order ID: '.$row['order_id'],0,1);
$pdf->Cell(0,10,'Date: '.$row['order_date'],0,1);
$pdf->Ln(10);

$sql_customer = "SELECT first_name, last_name, mobile_number, address, city, postal_code FROM orders WHERE order_id = ?";
$stmt_customer = $mysqli->prepare($sql_customer);
$stmt_customer->bind_param("i", $order_id);
$stmt_customer->execute();
$result_customer = $stmt_customer->get_result();
$customer_info = $result_customer->fetch_assoc();
$stmt_customer->close();

$pdf->Cell(0,10,'First Name: '.$customer_info['first_name'],0,1);
$pdf->Cell(0,10,'Last Name: '.$customer_info['last_name'],0,1);
$pdf->Cell(0,10,'Mobile Number: '.$customer_info['mobile_number'],0,1);
$pdf->Cell(0,10,'Address: '.$customer_info['address'],0,1);
$pdf->Cell(0,10,'City: '.$customer_info['city'],0,1);
$pdf->Cell(0,10,'Postal Code: '.$customer_info['postal_code'],0,1);

$pdf->Ln(10); 

$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,10,'Product Name',1,0,'C'); 
$pdf->Cell(40,10,'Quantity',1,0,'C');
$pdf->Cell(40,10,'Price',1,1,'C');

$pdf->SetFont('Arial','',12);
$totalPrice = 0; 
do {
    $pdf->Cell(100,10,$row['product_name'],1,0); 
    $pdf->Cell(40,10,$row['quantity'],1,0,'C');
    $pdf->Cell(40,10,'$'.$row['item_price'],1,1,'C');
    $totalPrice += $row['item_price'];
} while ($row = $result->fetch_assoc());

$pdf->Cell(140,10,'Total Price:',1,0,'R');
$pdf->Cell(40,10,'$'.$totalPrice,1,1,'C');

$stmt->close();
$pdf->Output();
?>