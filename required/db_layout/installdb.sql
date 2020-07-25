DROP TABLE IF EXISTS `group1`;
DROP TABLE IF EXISTS `group2`;
DROP TABLE IF EXISTS `group3`;
DROP TABLE IF EXISTS `groupother`;
CREATE TABLE `group1` (
  `id` int(11) NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `group2` (
  `id` int(11) NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `group3` (
  `id` int(11) NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `groupother` (
  `id` int(11) NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `group1`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `group2`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `group3`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `groupother`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `group1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `group2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `group3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `groupother`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
