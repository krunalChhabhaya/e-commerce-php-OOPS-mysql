<?php
session_start();

include 'dbinit.php';
include 'header.php';
include './controllers/ProductForm.php';

$productForm = new ProductForm($mysqli);

$productForm->handleProductRegistration();

?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="form-container product-form mb-5">
        <h2 class="product-form-title textPrimary">Add Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group product-form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control product-form-control" id="product_name" name="product_name" value="<?php echo isset($productForm->formData['product_name']) ? $productForm->formData['product_name'] : ''; ?>">
                <span class="text-danger"><?php echo isset($productForm->errors['product_name']) ? $productForm->errors['product_name'] : ''; ?></span>
            </div>
            <div class="form-group product-form-group">
                <label for="product_image">Product Image:</label><br>
                <input type="file" id="product_image" name="product_image">
                <span class="text-danger"><?php echo isset($productForm->errors['product_image']) ? $productForm->errors['product_image'] : ''; ?></span>
            </div>
            <div class="form-group product-form-group mt-3">
                <label for="product_brand">Product Brand:</label>
                <input type="text" class="form-control product-form-control" id="product_brand" name="product_brand" value="<?php echo isset($productForm->formData['product_brand']) ? $productForm->formData['product_brand'] : ''; ?>">
                <span class="text-danger"><?php echo isset($productForm->errors['product_brand']) ? $productForm->errors['product_brand'] : ''; ?></span>
            </div>
            <div class="form-group product-form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" min="0" class="form-control product-form-control" id="price" name="price" value="<?php echo isset($productForm->formData['price']) ? $productForm->formData['price'] : ''; ?>">
                <span class="text-danger"><?php echo isset($productForm->errors['price']) ? $productForm->errors['price'] : ''; ?></span>
            </div>
            <div class="form-group product-form-group">
                <label for="description">Description:</label>
                <textarea class="form-control product-form-control" id="description" name="description" rows="3"><?php echo isset($productForm->formData['description']) ? $productForm->formData['description'] : ''; ?></textarea>
                <span class="text-danger"><?php echo isset($productForm->errors['description']) ? $productForm->errors['description'] : ''; ?></span>
            </div>
            <div class="form-group product-form-group">
                <label for="quantity_available">Quantity Available:</label>
                <input type="number" min="0" class="form-control product-form-control" id="quantity_available" name="quantity_available" value="<?php echo isset($productForm->formData['quantity_available']) ? $productForm->formData['quantity_available'] : ''; ?>">
                <span class="text-danger"><?php echo isset($productForm->errors['quantity_available']) ? $productForm->errors['quantity_available'] : ''; ?></span>
            </div>
            <div class="form-group product-form-group">
                <label for="category">Category:</label>
                <select class="form-control product-form-control" id="category" name="category_cat_id">
                    <option value="" disabled selected>-- Select Category --</option>
                    <?php 
                        $sql = "SELECT cat_id, cat_name FROM category";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["cat_id"] . "'>" . $row["cat_name"] . "</option>";
                            }
                        }
                    ?>
                </select>
                <span class="text-danger"><?php echo isset($productForm->errors['category_cat_id']) ? $productForm->errors['category_cat_id'] : ''; ?></span>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</div>
