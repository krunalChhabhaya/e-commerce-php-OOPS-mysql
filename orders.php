<?php
session_start();

include 'dbinit.php';
include 'header.php';
include './controllers/Order.php';

$order = new Order($mysqli);

$currentUserId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$orders = $order->getUserOrders($currentUserId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clearHistory'])) {
        $success = $order->clearUserOrders($currentUserId);
        if ($success) {
            header('Location: orders.php');
        } else {
            echo "<script>alert('Failed to clear order history.');</script>";
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Orders</h2>
    <?php if (!empty($orders)) : ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-danger mb-3" name="clearHistory">Clear History</button>
        </form>
        <?php foreach ($orders as $orderId => $orderDetails) : ?>
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="textPrimary mt-4">Order ID: <?php echo $orderId; ?></h3>
                        <p>Date: <?php echo date('jS F Y - h:i A', strtotime($orderDetails[0]['order_date'])); ?></p>
                        <p>Total Amount: $<?php echo $orderDetails[0]['total_price']; ?></p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <form action="generate_invoice.php" method="post" target="_blank">
                            <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
                            <button type="submit" class="btn btn-primary">Invoice</button>
                        </form>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderDetails as $item) : ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $item['product_image']; ?>" class="me-3" alt="<?php echo $item['product_name']; ?>" style="max-width: 50px; max-height: 50px;">
                                        <?php echo $item['product_name']; ?>
                                    </td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>$<?php echo $item['item_price']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>