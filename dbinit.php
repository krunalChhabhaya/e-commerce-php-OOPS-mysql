<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'watchwise');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($mysqli->query($sql_create_db) === FALSE) {
    echo "Error creating database: " . $mysqli->error . "<br>";
}

$mysqli->select_db(DB_NAME);

$tables_exist = false;
$result = $mysqli->query("SHOW TABLES");
if ($result) {
    while ($row = $result->fetch_row()) {
        if (in_array($row[0], array('user', 'category', 'orders', 'order_item', 'product'))) {
            $tables_exist = true;
            break;
        }
    }
}

if (!$tables_exist) {
    $tables = [
        "CREATE TABLE IF NOT EXISTS `user` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            PRIMARY KEY (`user_id`)
        )",
        "CREATE TABLE IF NOT EXISTS `category` (
            `cat_id` int(11) NOT NULL AUTO_INCREMENT,
            `cat_name` varchar(255) NOT NULL,
            PRIMARY KEY (`cat_id`)
        )",
        "CREATE TABLE IF NOT EXISTS `orders` (
            `order_id` int(11) NOT NULL AUTO_INCREMENT,
            `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
            `total_price` decimal(10,2) NOT NULL,
            `mobile_number` varchar(20) NOT NULL,
            `address` text NOT NULL,
            `card_number` varchar(16) NOT NULL,
            `card_name` varchar(255) NOT NULL,
            `first_name` varchar(255) NOT NULL,
            `last_name` varchar(255) NOT NULL,
            `city` varchar(100) NOT NULL,
            `province` varchar(100) NOT NULL,
            `postal_code` varchar(20) NOT NULL,
            `phone_number` varchar(20) NOT NULL,
            `valid_until` varchar(7) NOT NULL,
            `cvv` varchar(4) NOT NULL,
            `user_user_id` int(11) NOT NULL,
            PRIMARY KEY (`order_id`),
            KEY `fk_orders_user1_idx` (`user_user_id`)
        )",
        "CREATE TABLE IF NOT EXISTS `order_item` (
            `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
            `quantity` int(11) NOT NULL,
            `price` decimal(10,2) NOT NULL,
            `orders_order_id` int(11) NOT NULL,
            `product_product_id` int(11) NOT NULL,
            PRIMARY KEY (`order_item_id`),
            KEY `fk_order_item_orders1_idx` (`orders_order_id`),
            KEY `fk_order_item_product1_idx` (`product_product_id`)
        )",
        "CREATE TABLE IF NOT EXISTS `product` (
            `product_id` int(11) NOT NULL AUTO_INCREMENT,
            `product_name` varchar(255) NOT NULL,
            `product_image` varchar(255) NOT NULL,
            `product_brand` varchar(255) NOT NULL,
            `price` decimal(10,2) NOT NULL,
            `description` text NOT NULL,
            `quantity_available` int(11) NOT NULL,
            `category_cat_id` int(11) NOT NULL,
            PRIMARY KEY (`product_id`),
            KEY `fk_product_category_idx` (`category_cat_id`)
        )"
    ];

    foreach ($tables as $sql) {
        if ($mysqli->query($sql) === FALSE) {
            echo "Error creating table: " . $mysqli->error . "<br>";
        }
    }

    $categories = [
        "Casual",
        "Luxury",
        "Sport",
        "Smart Watch",
        "Dress",
        "Pilot"
    ];

    foreach ($categories as $category) {
        $insert_sql = "INSERT INTO `category` (`cat_name`) VALUES ('$category')";
        if ($mysqli->query($insert_sql) === FALSE) {
            echo "Error inserting category: " . $mysqli->error . "<br>";
        }
    }

    $products = [
        [
            'product_id' => 1,
            'product_name' => 'Timex Expedition Scout Watch',
            'product_image' => 'images/products/product1.jpg',
            'product_brand' => 'Timex',
            'price' => 50.89,
            'description' => 'This mens Timex Expedition watch is made from stainless steel and is powered by a quartz movement. It is fastened with a leather strap. The watch also has a date function. Everything you need and nothing you dont.',
            'quantity_available' => 20,
            'category_cat_id' => 1
        ],
        [
            'product_id' => 3,
            'product_name' => 'Silver Stainless Steel Watch',
            'product_image' => 'images/products/product2.jpg',
            'product_brand' => 'SAPPHERO',
            'price' => 89.99,
            'description' => 'The restrained and luxurious appearance of the SAPPHERO watches for men brings you a visual feast: classic octagonal shape, calendar at three oclock, hidden button clasp, eye-catching silver stainless steel bracelet and conspicuous white grid dial. SAPPHERO, the first choice for every fashionable man who loves luxury watches for men. In addition, the light and thin watch makes you more comfortable to wear. Highly recommended.',
            'quantity_available' => 50,
            'category_cat_id' => 2
        ],
        [
            'product_id' => 4,
            'product_name' => 'Casio Illuminator Sport Watch',
            'product_image' => 'images/products/product3.jpg',
            'product_brand' => 'Casio',
            'price' => 35.99,
            'description' => 'A watch with style and functionality, plus an extra-long band for a more comfortable fit. Featuring a high-visibility, easy-read wide LCD, these watches also come with handy everyday features like stopwatch, alarm, and timer, not to mention water resistance up to 100 meters and a 10-year battery you wont have to worry about for ages.',
            'quantity_available' => 30,
            'category_cat_id' => 3
        ],
        [
            'product_id' => 5,
            'product_name' => 'Smartwatch for Android iOS Phone',
            'product_image' => 'images/products/product4.jpg',
            'product_brand' => 'IFOLO',
            'price' => 39.99,
            'description' => 'Compatible with iOS 9.0 & Android 5.0 above smartphones. IFOLO smart watch also features with many practical tools, such as alarm clocks, stopwatch, deep breather guide, music controller, weather, camera control, sedentary reminder, adjustable brightness, find phone, DIY screen.',
            'quantity_available' => 40,
            'category_cat_id' => 4
        ],
        [
            'product_id' => 6,
            'product_name' => 'Quartz Case And Black Leather Strap Watch',
            'product_image' => 'images/products/product5.jpg',
            'product_brand' => 'Citizen',
            'price' => 105.99,
            'description' => 'Be bold with this sterling silver time piece from Citizen, featuring a contrasting leather strap and a sunray dial.',
            'quantity_available' => 10,
            'category_cat_id' => 5
        ],
        [
            'product_id' => 7,
            'product_name' => 'Series Angel Wing Business Flywheel',
            'product_image' => 'images/products/product6.jpg',
            'product_brand' => 'TIME100',
            'price' => 306.38,
            'description' => 'Self-winding automatic skeleton watch Reinforced crystal, Metal case, Analog display,Luminous dial n Water resistant to 30m : In general, withstands splashes or brief immersion in water, but not suitable for swimming.Dual time zone, Angel Wing',
            'quantity_available' => 48,
            'category_cat_id' => 6
        ],
        [
            'product_id' => 8,
            'product_name' => 'Black Stainless Steel and Metal Casual',
            'product_image' => 'images/products/product7.jpg',
            'product_brand' => 'GOLDEN HOUR',
            'price' => 234.99,
            'description' => 'Stainless steel bracelets are extremely durable and can last the lifetime of a watch with proper care',
            'quantity_available' => 23,
            'category_cat_id' => 1
        ],
        [
            'product_id' => 9,
            'product_name' => 'casio watch',
            'product_image' => 'images/products/product8.jpg',
            'product_brand' => 'casio',
            'price' => 19.99,
            'description' => 'description of casio',
            'quantity_available' => 10,
            'category_cat_id' => 4
        ]
    ];
    
    foreach ($products as $product) {
        $insert_sql = "INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `product_brand`, `price`, `description`, `quantity_available`, `category_cat_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insert_sql);
        $stmt->bind_param("isssdssi", $product['product_id'], $product['product_name'], $product['product_image'], $product['product_brand'], $product['price'], $product['description'], $product['quantity_available'], $product['category_cat_id']);
        if ($stmt->execute() === FALSE) {
            echo "Error inserting product: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }    

    $constraints = [
        "ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
        "ALTER TABLE `order_item` ADD CONSTRAINT `fk_order_item_orders1` FOREIGN KEY (`orders_order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
        "ALTER TABLE `order_item` ADD CONSTRAINT `fk_order_item_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
        "ALTER TABLE `product` ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_cat_id`) REFERENCES `category` (`cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION"
    ];
        
    foreach ($constraints as $sql) {
        if ($mysqli->query($sql) === FALSE) {
            echo "Error adding foreign key constraint: " . $mysqli->error . "<br>";
        }
    }
}

function prepare_string($mysqli, $string) {
    $string_trimmed = trim($string);
    $string = $mysqli->real_escape_string($string_trimmed);
    return $string;
}
?>
