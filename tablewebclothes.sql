CREATE TABLE `cart_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,  -- assuming you're tracking users
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES products(`id`)  -- Assuming you have a products table
);
