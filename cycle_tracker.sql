CREATE TABLE IF NOT EXISTS `cycle_tracker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `last_period` date NOT NULL,
  `cycle_length` int(11) NOT NULL,
  `mood` varchar(50) DEFAULT NULL,
  `flow` varchar(50) DEFAULT NULL,
  `symptoms` json DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `next_period` date NOT NULL,
  `fertile_start` date NOT NULL,
  `fertile_end` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 