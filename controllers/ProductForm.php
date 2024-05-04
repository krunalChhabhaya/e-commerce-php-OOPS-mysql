<?php

class ProductForm {
    private $mysqli;
    public $formData = array();
    public $errors = array();

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function handleProductRegistration() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->validateFormData();
            if (empty($this->errors)) {
                $this->insertProduct();
            }
        }
    }

    private function validateFormData() {
        $this->formData['product_name'] = isset($_POST['product_name']) ? $_POST['product_name'] : '';
        $this->formData['product_brand'] = isset($_POST['product_brand']) ? $_POST['product_brand'] : '';
        $this->formData['price'] = isset($_POST['price']) ? $_POST['price'] : '';
        $this->formData['description'] = isset($_POST['description']) ? $_POST['description'] : '';
        $this->formData['quantity_available'] = isset($_POST['quantity_available']) ? $_POST['quantity_available'] : '';

        if (empty($this->formData['product_name'])) {
            $this->errors['product_name'] = "Please enter a product name.";
        }

        if (empty($this->formData['product_brand'])) {
            $this->errors['product_brand'] = "Please enter a product brand.";
        }

        if (empty($this->formData['price'])) {
            $this->errors['price'] = "Please enter a price.";
        } elseif (!is_numeric($this->formData['price']) || $this->formData['price'] < 0) {
            $this->errors['price'] = "Please enter a valid price.";
        }

        if (empty($this->formData['description'])) {
            $this->errors['description'] = "Please enter a description.";
        }

        if (empty($this->formData['quantity_available'])) {
            $this->errors['quantity_available'] = "Please enter the quantity available.";
        } elseif (!is_numeric($this->formData['quantity_available']) || $this->formData['quantity_available'] < 0) {
            $this->errors['quantity_available'] = "Please enter a valid quantity available.";
        }

        if ($_FILES["product_image"]["error"] == 4) {
            $this->errors['product_image'] = "Please select a product image.";
        } elseif ($_FILES["product_image"]["error"] != 0) {
            $this->errors['product_image'] = "Error uploading image. Please try again.";
        } else {
        }
    }

    private function insertProduct() {
        $productName = $this->formData['product_name'];
        $productBrand = $this->formData['product_brand'];
        $price = $this->formData['price'];
        $description = $this->formData['description'];
        $quantityAvailable = $this->formData['quantity_available'];
        $categoryId = $_POST["category_cat_id"];
        $productImage = $_FILES["product_image"];

        $targetDir = "images/products/";
        $targetFile = $targetDir . basename($productImage["name"]);
        move_uploaded_file($productImage["tmp_name"], $targetFile);

        $sql = "INSERT INTO product (product_name, product_brand, price, description, quantity_available, category_cat_id, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ssdssis", $productName, $productBrand, $price, $description, $quantityAvailable, $categoryId, $targetFile);
        $stmt->execute();
        $stmt->close();

        header("Location: products.php");
        exit;
    }
}

?>