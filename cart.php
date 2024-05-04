<?php
session_start();

include 'dbinit.php';
include 'header.php';
include './controllers/Cart.php';

$cart = new Cart();
$cartItems = $cart->getCartItems();

if (isset($_POST['remove_item'])) {
    $productId = $_POST['product_id'];
    $cart->removeCartItem($productId);
    header("Location: cart.php");
    exit();
}

if (isset($_POST['increment_quantity']) || isset($_POST['decrement_quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $cart->getQuantity($productId, $cartItems);

    if (isset($_POST['increment_quantity'])) {
        $quantity++;
    } elseif (isset($_POST['decrement_quantity']) && $quantity > 1) {
        $quantity--;
    }

    $cart->updateCartItemQuantity($productId, $quantity);
    header("Location: cart.php");
    exit();
}

$totalQuantity = 0;
$totalAmount = 0;
foreach ($cartItems as $cartItem) {
    $totalQuantity += $cartItem['quantity']; 
    $productId = $cartItem['product_id'];
    $quantity = $cartItem['quantity'];
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $totalAmount += $product['price'] * $quantity;
    }
    $stmt->close();
}
?>

<div class="container mt-5">
    <h2 class="lgTitle mb-5">Cart Items</h2>
    <div class="row">
        <div class="col-md-8">
            <?php if (!empty($cartItems)) : ?>
                <div class="row">
                    <?php foreach ($cartItems as $cartItem) : ?>
                        <?php
                        $productId = $cartItem['product_id'];
                        $quantity = $cartItem['quantity'];
                        $sql = "SELECT * FROM product WHERE product_id = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("i", $productId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $product = $result->fetch_assoc();
                            $totalPrice = $product['price'] * $quantity;
                        ?>
                            <div class="col-md-12 py-4 cartCard">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="<?php echo $product['product_image']; ?>" class="img-fluid cart-img" alt="Product Image">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="text-black"><?php echo $product['product_name']; ?></h5>
                                        <p>Price: $<?php echo $product['price']; ?></p>
                                        <div class="quantity-selection mb-3">
                                            <form action="" method="post">
                                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                                <button type="submit" class="btn btn-secondary btn-sm bg-grey text-black btnCounter" name="decrement_quantity"><i class="fas fa-minus"></i></button>
                                                <span class="quantity mx-2 fw-bold"><?php echo $quantity; ?></span>
                                                <button type="submit" class="btn btn-secondary btn-sm bg-grey text-black btnCounter" name="increment_quantity"><i class="fas fa-plus"></i></button>
                                            </form>
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                            <button type="submit" class="text-danger border-0 bg-white" name="remove_item"><i class="far fa-trash-alt me-2"></i>Remove</button>
                                        </form>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="mb-1">Total Price: <p class="totalPrice fw-bold">$<?php echo $totalPrice; ?></p></p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        $stmt->close();
                        ?>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No items in the cart.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-grey border-0">
                <div class="card-body">
                    <h5 class="card-title textPrimary mb-3">Cart Summary</h5>
                    <p class="card-text">Total Quantity: <?php echo $totalQuantity; ?></p>
                    <p class="card-text">Total Amount: $<?php echo $totalAmount; ?></p>
                    <?php if (!empty($cartItems)) : ?>
                        <a href="checkout.php?total=<?php echo $totalAmount; ?>" class="btn btn-primary">Proceed to Checkout</a>
                    <?php else : ?>
                        <button class="btn btn-primary" disabled>Proceed to Checkout</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
