<?php

include_once 'Cart.php';

class CheckoutForm
{
    private $db;

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
    }

    public function processCheckout($formData)
    {
        $errors = $this->validateFormData($formData);

        if (!empty($errors)) {
            return $errors;
        }

        $formData = $this->sanitizeFormData($formData);

        $totalAmount = $formData['totalAmount'];

        $orderId = $this->insertOrder($formData, $totalAmount);

        if (!$orderId) {
            return false;
        }

        $cart = new Cart();
        $cartItems = $cart->getCartItems();

        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['product_id'];
            $quantity = $cartItem['quantity'];
            $price = $this->getProductPrice($productId);

            $this->updateProductQuantity($productId, $quantity);

            if (!$this->insertOrderItem($orderId, $productId, $quantity, $price)) {
                return false;
            }
        }

        $cart->clearCart();

        return true;
    }

    private function updateProductQuantity($productId, $quantity)
    {
        $sql = "UPDATE product SET quantity_available = quantity_available - ? WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $quantity, $productId);
        $stmt->execute();
        $stmt->close();
    }

    private function getProductPrice($productId)
    {
        $price = null;
        $sql = "SELECT price FROM product WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->bind_result($price);

        $stmt->fetch();

        $stmt->close();

        return $price;
    }

    private function validateFormData($formData)
    {
        $errors = [];

        $requiredFields = ['firstName', 'lastName', 'address', 'city', 'province', 'postalCode', 'phoneNumber', 'cardHolderName', 'cardNumber', 'expiryDate', 'cvv'];
        foreach ($requiredFields as $field) {
            if (empty($formData[$field])) {
                $errors[$field] = ucfirst($field) . " is required.";
            }
        }

        if (strlen($formData['phoneNumber']) !== 10 || !ctype_digit($formData['phoneNumber'])) {
            $errors['phoneNumber'] = "Phone number should be 10 digits.";
        }

        if (!preg_match("/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/", $formData['postalCode'])) {
            $errors['postalCode'] = "Invalid Canadian postal code format.";
        }

        if (!preg_match("/^\d{16}$/", $formData['cardNumber'])) {
            $errors['cardNumber'] = "Card number must be a 16-digit number.";
        }

        if (!preg_match("/^(0[1-9]|1[0-2])\/\d{4}$/", $formData['expiryDate'])) {
            $errors['expiryDate'] = "Expiry date must be in MM/YYYY format.";
        }

        if (!preg_match("/^\d{3}$/", $formData['cvv'])) {
            $errors['cvv'] = "CVV must be a 3-digit number.";
        }

        return $errors;
    }

    private function sanitizeFormData($formData)
    {
        foreach ($formData as $key => $value) {
            $formData[$key] = $this->db->real_escape_string($value);
        }
        return $formData;
    }
    private function insertOrder($formData, $totalAmount)
    {
        $user_id = $formData['user_id'];
        $firstName = $this->db->real_escape_string($formData['firstName']);
        $lastName = $this->db->real_escape_string($formData['lastName']);
        $address = $this->db->real_escape_string($formData['address']);
        $city = $this->db->real_escape_string($formData['city']);
        $province = $this->db->real_escape_string($formData['province']);
        $postalCode = $this->db->real_escape_string($formData['postalCode']);
        $phoneNumber = $this->db->real_escape_string($formData['phoneNumber']);
        $cardHolderName = $this->db->real_escape_string($formData['cardHolderName']);
        $cardNumber = $this->db->real_escape_string($formData['cardNumber']);
        $expiryDate = $this->db->real_escape_string($formData['expiryDate']);
        $cvv = $this->db->real_escape_string($formData['cvv']);

        $stmt = $this->db->prepare("INSERT INTO orders (user_user_id, first_name, last_name, address, city, province, postal_code, mobile_number, card_name, card_number, valid_until, cvv, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            error_log("Error: " . $this->db->error);
            return false;
        }

        $stmt->bind_param("isssssssssssd", $user_id, $firstName, $lastName, $address, $city, $province, $postalCode, $phoneNumber, $cardHolderName, $cardNumber, $expiryDate, $cvv, $totalAmount);

        if (!$stmt->execute()) {
            error_log("Error: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $orderId = $stmt->insert_id;
        $stmt->close();
        return $orderId;
    }

    private function insertOrderItem($orderId, $productId, $quantity, $price)
    {
        $stmt = $this->db->prepare("INSERT INTO order_item (quantity, price, orders_order_id, product_product_id) 
                                VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            error_log("Error preparing statement: " . $this->db->error);
            return false;
        }

        $stmt->bind_param("diid", $quantity, $price, $orderId, $productId);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }
}

