CREATE TABLE `user_data` (
                             `user_id` int NOT NULL,
                             `username` varchar(30) NOT NULL,
                             `email` varchar(255) NOT NULL,
                             `password` char(40) NOT NULL,
                             `last_login` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `user_data`
    ADD PRIMARY KEY (`user_id`);

ALTER TABLE `user_data`
    MODIFY `user_id` int NOT NULL AUTO_INCREMENT;
