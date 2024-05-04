<?php
session_start();

include 'dbinit.php';
include 'header.php';
include './controllers/CheckoutForm.php';

$checkoutForm = new CheckoutForm($mysqli);

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$totalAmount = isset($_GET['total']) ? $_GET['total'] : 0;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $_POST['user_id'] = $userId;

        $checkoutStatus = $checkoutForm->processCheckout($_POST);

        if (is_array($checkoutStatus)) {
            $errors = $checkoutStatus;
        } elseif ($checkoutStatus) {
            header('Location: orders.php');
            exit();
        }
    }
}
?>

<div class="container mt-5">
    <div class="form-container product-form mb-5 mx-auto">
        <h2 class="text-center mb-4 textPrimary">Checkout</h2>
        <p>Total Amount: $<?php echo $totalAmount; ?></p>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="post">
                    <!-- Personal Details Form Fields -->
                    <h4 class="mb-3">Personal Details</h4>
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="totalAmount" value="<?php echo $totalAmount; ?>">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
                        <?php if (isset($errors['firstName'])) echo "<p class='text-danger'>{$errors['firstName']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
                        <?php if (isset($errors['lastName'])) echo "<p class='text-danger'>{$errors['lastName']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                        <?php if (isset($errors['address'])) echo "<p class='text-danger'>{$errors['address']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                        <?php if (isset($errors['city'])) echo "<p class='text-danger'>{$errors['city']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-select" id="province" name="province">
                            <option disabled>Select Province</option>
                            <?php
                            $provinces = ['AB' => 'Alberta', 'BC' => 'British Columbia', 'MB' => 'Manitoba', 'NB' => 'New Brunswick', 'NL' => 'Newfoundland and Labrador', 'NS' => 'Nova Scotia', 'NT' => 'Northwest Territories', 'NU' => 'Nunavut', 'ON' => 'Ontario', 'PE' => 'Prince Edward Island', 'QC' => 'Quebec', 'SK' => 'Saskatchewan', 'YT' => 'Yukon'];
                            foreach ($provinces as $code => $name) {
                                $selected = isset($_POST['province']) && $_POST['province'] === $code ? 'selected' : '';
                                echo "<option value='$code' $selected>$name</option>";
                            }
                            ?>
                        </select>
                        <?php if (isset($errors['province'])) echo "<p class='text-danger'>{$errors['province']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="postalCode" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postalCode" name="postalCode" value="<?php echo isset($_POST['postalCode']) ? htmlspecialchars($_POST['postalCode']) : ''; ?>">
                        <?php if (isset($errors['postalCode'])) echo "<p class='text-danger'>{$errors['postalCode']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo isset($_POST['phoneNumber']) ? htmlspecialchars($_POST['phoneNumber']) : ''; ?>">
                        <?php if (isset($errors['phoneNumber'])) echo "<p class='text-danger'>{$errors['phoneNumber']}</p>"; ?>
                    </div>

                    <!-- Payment Details Form Fields -->
                    <h4 class="mb-3">Payment Details</h4>
                    <div class="mb-3">
                        <label for="cardHolderName" class="form-label">Card Holder Name</label>
                        <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" value="<?php echo isset($_POST['cardHolderName']) ? htmlspecialchars($_POST['cardHolderName']) : ''; ?>">
                        <?php if (isset($errors['cardHolderName'])) echo "<p class='text-danger'>{$errors['cardHolderName']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="<?php echo isset($_POST['cardNumber']) ? htmlspecialchars($_POST['cardNumber']) : ''; ?>">
                        <?php if (isset($errors['cardNumber'])) echo "<p class='text-danger'>{$errors['cardNumber']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">Expiry Date</label>
                        <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YYYY" value="<?php echo isset($_POST['expiryDate']) ? htmlspecialchars($_POST['expiryDate']) : ''; ?>">
                        <?php if (isset($errors['expiryDate'])) echo "<p class='text-danger'>{$errors['expiryDate']}</p>"; ?>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" value="<?php echo isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : ''; ?>">
                        <?php if (isset($errors['cvv'])) echo "<p class='text-danger'>{$errors['cvv']}</p>"; ?>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="submit">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>