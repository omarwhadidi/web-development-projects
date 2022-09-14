-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2022 at 10:54 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `message`) VALUES
(1, 'test', 'test@dd.com', 'test', 'test'),
(2, 'new', 'new@gmail.com', 'new', 'newnwenw'),
(3, 'hgj#$%^&*(){}', 'omarwhadidi@hotmail.com', '#$%^&*{}&#39;&#39;? payload', '#$%^&*{}&#39;&#39;? payload'),
(4, 'vuy', 'omarwhadidi@hotmail.com', 'un', '/&#39;&#39;&#34;\\/h'),
(5, 'omar', 'omarwhadidi@hotmail.com', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `discount` int(10) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `coupon_code`, `discount`, `status`) VALUES
(1, 'PRJ606PWK6', 30, 'Active'),
(2, 'PRJ606PW20', 20, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0 COMMENT ' {0 / 1 / 2}',
  `group_name` varchar(100) NOT NULL COMMENT ' {admin / moderator / user }',
  `privileges` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `email`, `group_id`, `group_name`, `privileges`) VALUES
(10, 'omarwhadidi9@gmail.com', 0, 'users', NULL),
(1, 'omarwhadidi@hotmail.com', 2, 'Admins', NULL),
(11, 'test@hotmail.com', 0, 'users', NULL),
(13, 'windows@hotmail.com', 0, 'users', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mfa`
--

CREATE TABLE `mfa` (
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `products` varchar(255) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `username`, `email`, `phone`, `address`, `payment_mode`, `products`, `paid_amount`, `order_date`) VALUES
(17, 'test test', 'test', 'test@hotmail.com', '3456', 'dfbgnh', '1234123412341234', '[{\"pid\":1,\"name\":\"Sports T-shirt \",\"qty\":1},{\"pid\":2,\"name\":\"Sports Short \",\"qty\":1}]', '700', '2022-09-11'),
(19, 'test test', 'Guest', 'test@dd.com', '890', 'test', '1234123412341234', '[{\"pid\":1,\"name\":\"Sports T-shirt \",\"qty\":2},{\"pid\":2,\"name\":\"Sports Short \",\"qty\":1},{\"pid\":3,\"name\":\"Casual T-shirt \",\"qty\":1}]', '1300', '2022-09-11'),
(20, 'windows ten', 'windows', 'windows@hotmail.com', '45', 'dvsbg', '1234123412341234', '[{\"pid\":2,\"name\":\"Sports Short \",\"qty\":1}]', '450', 'September 11, 2022');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'men',
  `product_details` varchar(400) DEFAULT NULL,
  `quantity` int(20) NOT NULL,
  `price` double NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `seller_name` varchar(255) DEFAULT NULL,
  `added_date` varchar(255) DEFAULT NULL,
  `product_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `product_details`, `quantity`, `price`, `product_image`, `seller_name`, `added_date`, `product_status`) VALUES
(1, 'Sports T-shirt ', 'men', 'Sports T-shirt  From Nike Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!', 3, 250, NULL, NULL, '2022-08-26', NULL),
(2, 'Sports Short ', 'men', 'Sports Short From Nike', 5, 450, NULL, NULL, '2022-08-26', 'sale'),
(3, 'Casual T-shirt ', 'men', 'cashual T-shirt  From Tommy', 14, 350, NULL, NULL, '2022-08-26', 'hot'),
(4, 'Trousers ', 'women', 'Sports Trousers  From Nike for women All Sizes availible', 5, 200, NULL, NULL, '2022-08-26', NULL),
(5, 'Calvin Klein Cotton-Boxer', 'men', 'Calvin Klein Cotton-Boxer ', 46, 20, NULL, NULL, '2022-08-26', 'sale'),
(6, 'polo Cotton-Boxer', 'men', 'polo Cotton-Boxer ', 30, 20, NULL, NULL, '2022-08-26', NULL),
(7, 'Ray-Ban Sun Glasses', 'men', 'Ray-Ban Sun Glasses For men', 0, 175, NULL, NULL, '2022-08-26', 'sold-out'),
(8, 'playstation 5', 'electronics', 'playstation 5 with 1 joystick and 2 cd', 4, 500, NULL, NULL, '2022-08-26', 'hot'),
(9, 'vghjb', 'women', 'h bjnkm', 10, 20, '../assets/uploads/productsblind_sql_script.png', 'hbj', '0000-00-00', 'hjb'),
(10, 'women adidas socks', 'women', 'women adidas socks', 10, 40, '../assets/uploads/products/blind_sql_script.png', 'adidas', '0000-00-00', 'new'),
(11, 'women adidas shoes', 'women', 'women adidas shoes All Sizes Availible', 2, 100, '../assets/uploads/products/blind_sql_script.png', 'adidas', '2022-09-06', 'new'),
(12, 'women Casual Tshirt', 'women', 'women Casual Tshirt From Lacoste', 12, 100, '../assets/uploads/products/blind_sql_script.png', 'la coste', '2022-09-06', 'hot');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `review` varchar(400) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `review`, `username`, `product_id`, `review_date`) VALUES
(10, 'lovely Product', 'test', 1, 'September 11, 2022'),
(11, 'cool', 'test', 2, 'September 11, 2022'),
(12, 'bad product', 'windows', 7, 'September 11, 2022');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(400) NOT NULL,
  `Duration` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`email`, `token`, `Duration`) VALUES
('windows@hotmail.com', '400d55405e891c502cadf3201599e48f0b48e008a0feb3d91245e76ba91c8c03', 1662928726);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `userpic` varchar(255) DEFAULT NULL,
  `added_date` varchar(255) DEFAULT NULL,
  `Account_status` int(1) NOT NULL DEFAULT 0,
  `group_id` int(2) NOT NULL DEFAULT 0,
  `mfa` tinyint(1) NOT NULL DEFAULT 0,
  `couponused` varchar(255) DEFAULT NULL,
  `failed_login` int(11) NOT NULL DEFAULT 0,
  `last_login` bigint(11) DEFAULT NULL,
  `client_ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `gender`, `userpic`, `added_date`, `Account_status`, `group_id`, `mfa`, `couponused`, `failed_login`, `last_login`, `client_ip`) VALUES
(26, 'omar Elhadidi', 'admin', 'omarwhadidi@hotmail.com', '$2y$10$73Cf/5GZNcMVBNqXej50Teuyf5zMKKbO5U2n.ZsvR7EEqsAvqwy5y', NULL, NULL, '2022-09-11 05:07:57', 1, 2, 0, NULL, 0, NULL, '127.0.0.1'),
(27, 'omar Elhadidi', 'didi', 'omarwhadidi9@gmail.com', '$2y$10$8AGCpMa40JhQ69WxEfCcwOx.ni2RK4HAyVaI9a.ThBhOlnJ8Eh2E2', NULL, NULL, '2022-09-11 05:21:28', 1, 0, 0, NULL, 0, NULL, '127.0.0.1'),
(28, 'test', 'test', 'test@hotmail.com', '$2y$10$ICbRwqmJzhqL/grrOtKsZ.PG9S8aAH27fNUMK2qryuo44nYrU.xqW', 'Male', NULL, '2022-09-11 05:25:05', 1, 0, 0, NULL, 0, 1662871699, '127.0.0.1'),
(30, 'windows', 'windows', 'windows@hotmail.com', '$2y$10$fEPrr6ZrMfNxZOtexGyONeUHDP1NvAuYnEi6HFL39.TiYyioN5cyS', NULL, NULL, 'September 11, 2022', 1, 0, 0, NULL, 0, NULL, '127.0.0.1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`email`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `mfa`
--
ALTER TABLE `mfa`
  ADD KEY `MFA Foreign Key` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders Relationship` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `Reviews Relationship with Product Table` (`product_id`),
  ADD KEY `Reviews Relationship with Users Table` (`username`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `Token Foreign Key` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `Groups Relationship` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mfa`
--
ALTER TABLE `mfa`
  ADD CONSTRAINT `MFA Foreign Key` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `Reviews Relationship with Product Table` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Reviews Relationship with Users Table` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `Token Foreign Key` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
