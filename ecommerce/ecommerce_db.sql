
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`) VALUES
(1, 'Girls Tops | Girls Dresses (5-6 Years) \r\n', 'Name : Girls Tops | Girls Dresses\r\n\r\nFabric : Cotton\r\n\r\nSleeve Length : Long Sleeves\r\n\r\nPattern : Printed\r\n\r\nNet Quantity (N) : 1\r\n\r\n1. Features a stylish and age-appropriate design, perfect for both casual and formal occasions.\r\n\r\n2. Made from high-quality materials (cotton) ensuring comfort and durability.\r\n\r\n3. Comes in a range of colors and patterns, from classic solids to playful prints and vibrant hues.\r\n\r\n4. Features user-friendly elastic waistbands for easy dressing and undressing.\r\n\r\n5. Designed to be machine washable or easy to hand wash, making maintenance simple for busy parents.\r\n\r\n ', 19.99, 'images/boys2.png', '2024-11-07 12:27:35'),
(2, 'The Children\'s Place\r\nBoys Multi-Color Sweater (5-6 Years)', 'Revamp your little ones closet with this stylish piece from The Children\'s Place. Crafted from cotton, it features full sleeves and a high neck. Complete the look with a pair of sandals.', 29.99, 'images/boys1.png', '2024-11-07 12:27:35'),
(3, 'Babyhug Knitted Full Sleeves Striped Hooded Sweater Set', 'Brand - Babyhug\r\nType - Sweater Sets\r\nSleeve Length - Full Sleeves\r\nNeck Type - Hooded Neck\r\nPattern - Stripes\r\n\r\nFabric\r\nKnitted', 39.99, 'images/boys5.png', '2024-11-07 12:27:35'),
(4, 'Babyhug Cotton Knit Lion Printed Dungaree with Full Sleeves Striped Inner Tee -  Blue', 'Brand - Babyhug\r\nType - Dungarees\r\nSilhouette - Regular\r\nSleeve Length - Full Sleeves\r\nNeck Type - Round Neck\r\nLength - Full Length\r\nPattern/Print Type - Printed, Stripes\r\nFabric - Cotton\r\nOccasion/Utility - Fashion\r\n', 36.00, 'images\\boys6.png', '2024-11-09 07:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(7, 'SANJAIRAMYA', 'sanjaigood4444@gmail.com', '$2y$10$ruF49o6ZWEa7KEVVJnZyGe9xWEEehQxxmOOfS.nuj0xzAlc/VChxy', '2024-11-09 15:12:43'),
(8, 'SANJAIRAMYA', 'sanjaigood4444@gmail.com', '$2y$10$vaUK0Z9eDh8h3muBXtYAwOFd/BvQ11PnrDv.quLZz5X9aG/g051Gy', '2024-11-09 15:50:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
