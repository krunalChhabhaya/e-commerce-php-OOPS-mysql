<?php
session_start();

include 'dbinit.php';
include 'header.php';
include './controllers/Cart.php'; 

$cart = new Cart();

if(isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $userId = $_POST['user_id'];
    $quantity = $_POST['quantity'];
    $cart->addToCart($productId, $userId, $quantity);
}

$cartItems = $cart->getCartItems();

if(isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo $product['product_image']; ?>" class="img-fluid" alt="Product Image">
                </div>
                <div class="col-md-8 ms-5">
                    <h2 class="lgTitle"><?php echo $product['product_name']; ?></h2>
                    <p class="mt-4"><strong>Brand:</strong> <?php echo $product['product_brand']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $product['price']; ?></p>
                    <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
                    <div class="quantity-selection">
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>"> 
                            <label for="quantity" class="mb-2">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control w-25" value="<?php echo $cart->getQuantity($productId, $cartItems); ?>" min="1" max="<?php echo $product['quantity_available']; ?>">
                            <button type="submit" class="btn btn-primary mt-5 px-4" name="add_to_cart">Add to Cart</button>
                        </form>     
                    </div>  
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "Product not found.";
    }

    $stmt->close();
} else {
    echo "Product ID is missing.";
}

?>
