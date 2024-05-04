-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2024 at 06:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `watchwise`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'Casual'),
(2, 'Luxury'),
(3, 'Sport'),
(4, 'Smart Watch'),
(5, 'Dress'),
(6, 'Pilot');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
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
  `user_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `orders_order_id` int(11) NOT NULL,
  `product_product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_brand` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `quantity_available` int(11) NOT NULL,
  `category_cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `product_brand`, `price`, `description`, `quantity_available`, `category_cat_id`) VALUES
(1, 'Timex Expedition Scout Watch', 'images/products/product1.jpg', 'Timex', 50.89, 'This mens Timex Expedition watch is made from stainless steel and is powered by a quartz movement. It is fastened with a leather strap. The watch also has a date function. Everything you need and nothing you dont.', 18, 1),
(3, 'Silver Stainless Steel Watch', 'images/products/product2.jpg', 'SAPPHERO', 89.99, 'The restrained and luxurious appearance of the SAPPHERO watches for men brings you a visual feast: classic octagonal shape, calendar at three oclock, hidden button clasp, eye-catching silver stainless steel bracelet and conspicuous white grid dial. SAPPHERO, the first choice for every fashionable man who loves luxury watches for men. In addition, the light and thin watch makes you more comfortable to wear. Highly recommended.', 50, 2),
(4, 'Casio Illuminator Sport Watch', 'images/products/product3.jpg', 'Casio', 35.99, 'A watch with style and functionality, plus an extra-long band for a more comfortable fit. Featuring a high-visibility, easy-read wide LCD, these watches also come with handy everyday features like stopwatch, alarm, and timer, not to mention water resistance up to 100 meters and a 10-year battery you wont have to worry about for ages.', 28, 3),
(5, 'Smartwatch for Android iOS Phone', 'images/products/product4.jpg', 'IFOLO', 39.99, 'Compatible with iOS 9.0 & Android 5.0 above smartphones. IFOLO smart watch also features with many practical tools, such as alarm clocks, stopwatch, deep breather guide, music controller, weather, camera control, sedentary reminder, adjustable brightness, find phone, DIY screen.', 38, 4),
(6, 'Quartz Case And Black Leather Strap Watch', 'images/products/product5.jpg', 'Citizen', 105.99, 'Be bold with this sterling silver time piece from Citizen, featuring a contrasting leather strap and a sunray dial.', 10, 5),
(7, 'Series Angel Wing Business Flywheel', 'images/products/product6.jpg', 'TIME100', 306.38, 'Self-winding automatic skeleton watch Reinforced crystal, Metal case, Analog display,Luminous dial n Water resistant to 30m : In general, withstands splashes or brief immersion in water, but not suitable for swimming.Dual time zone, Angel Wing', 48, 6),
(8, 'Black Stainless Steel and Metal Casual', 'images/products/product7.jpg', 'GOLDEN HOUR', 234.99, 'Stainless steel bracelets are extremely durable and can last the lifetime of a watch with proper care', 21, 1),
(9, 'casio watch', 'images/products/product8.jpg', 'casio', 19.99, 'description of casio', 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_user1_idx` (`user_user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_order_item_orders1_idx` (`orders_order_id`),
  ADD KEY `fk_order_item_product1_idx` (`product_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_category_idx` (`category_cat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `fk_order_item_orders1` FOREIGN KEY (`orders_order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_item_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_cat_id`) REFERENCES `category` (`cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
