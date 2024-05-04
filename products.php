<?php
session_start();

include 'dbinit.php';
include 'header.php';

$category_sql = "SELECT * FROM category";
$category_result = $mysqli->query($category_sql);

$category_id = isset($_GET['category']) ? $_GET['category'] : null;

$sql = "SELECT * FROM product";
if ($category_id) {
    $sql .= " WHERE category_cat_id = $category_id";
}
$result = $mysqli->query($sql);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center filterSection mb-4">
            <form action="products.php" method="get" class="w-50">
                <div class="input-group mb-3">
                    <label for="category" class="input-group-text">Filter by Category:</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        <?php
                        while ($category_row = $category_result->fetch_assoc()) {
                            $selected = $category_id == $category_row['cat_id'] ? 'selected' : '';
                            echo "<option value='{$category_row['cat_id']}' $selected>{$category_row['cat_name']}</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-3 mb-4">
                    <form action="product_detail.php" class="h-100" method="get">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <div class="card h-100 prdCard">
                            <div class="card-body">
                                <button type="submit" class="btn btn-link card-button w-100 p-0 h-100 d-flex flex-column justify-content-between">
                                    <div class="w-100">
                                    <img src="<?php echo $row['product_image']; ?>" class="card-img-top" alt="Product Image">
                                    <h5 class="card-title prdTitle text"><?php echo $row['product_name']; ?></h5>
                                    <p class="card-text prdBrand"><?php echo $row['product_brand']; ?></p>
                                    </div>
                                    <p class="card-text text-grey prdPrice fw-bold w-100 mt-3">$<?php echo $row['price']; ?></p>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
</div>
