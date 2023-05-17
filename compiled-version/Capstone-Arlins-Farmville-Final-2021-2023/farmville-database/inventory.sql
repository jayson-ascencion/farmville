-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 03:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `chickenproduction`
--

CREATE TABLE `chickenproduction` (
  `chickenBatch_ID` int(10) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `age` int(5) NOT NULL,
  `coopNumber` int(5) NOT NULL,
  `batchName` varchar(50) NOT NULL,
  `breedType` varchar(50) NOT NULL,
  `batchPurpose` varchar(50) NOT NULL,
  `male` int(10) NOT NULL,
  `female` int(10) NOT NULL,
  `inStock` int(10) NOT NULL,
  `dateAcquired` date NOT NULL,
  `acquisitionType` varchar(50) NOT NULL,
  `note` varchar(100) NOT NULL DEFAULT 'no note.',
  `archive` varchar(20) NOT NULL DEFAULT 'not archived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chickenproduction`
--

INSERT INTO `chickenproduction` (`chickenBatch_ID`, `user_ID`, `age`, `coopNumber`, `batchName`, `breedType`, `batchPurpose`, `male`, `female`, `inStock`, `dateAcquired`, `acquisitionType`, `note`, `archive`) VALUES
(26, 1, 90, 917, 'Sybil Dunn', 'Rhode Island Reds    ', 'Meat', 0, 25, 25, '2023-01-01', 'Purchased', 'Ipsam et unde id vol', 'not archived'),
(27, 1, 71, 36, 'Phoebe Cummings', 'Leghorns  ', 'Meat', 205, 50, 55, '2022-10-24', 'Purchased', 'Velit cupiditate vel', 'not archived'),
(28, 1, 81, 599, 'Tasha Johnston', 'Leghorns', 'Breeding', 87, 43, 130, '2022-09-29', 'Hatched on Farm', 'Quibusdam ea quisqua', 'not archived'),
(29, 1, 64, 889, 'Wayne Haney', 'Sussex', 'Breeding', 91, 1, 92, '2023-02-03', 'Purchased', 'Est consectetur su', 'not archived'),
(30, 1, 75, 531, 'Marah Booth', 'Plymouth', 'Breeding', 33, 22, 55, '2023-04-25', 'Hatched on Farm', 'Do sint ab totam exc', 'not archived'),
(31, 1, 76, 101, 'Harper Ellis', 'new breed', 'Breeding', 18, 76, 94, '2023-03-19', 'Purchased', 'Est ea ad illo omni', 'not archived'),
(32, 1, 92, 874, 'Malachi Bright', 'maka nput user new brreed', 'Meat', 66, 75, 141, '2022-10-13', 'Hatched on Farm', 'Qui quidem incidunt', 'not archived'),
(33, 1, 63, 641, 'Tatyana Baldwin', 'user new breed type input', 'Meat', 59, 29, 88, '2023-01-21', 'Hatched on Farm', 'Qui veniam libero s', 'not archived'),
(34, 3, 75, 129, 'Lucian Mccarty', 'new breed', 'Layers', 86, 82, 168, '2022-08-03', 'Hatched on Farm', 'Et nesciunt est al', 'not archived');

-- --------------------------------------------------------

--
-- Table structure for table `chickentransaction`
--

CREATE TABLE `chickentransaction` (
  `transaction_ID` int(10) NOT NULL,
  `chickenBatch_ID` int(10) DEFAULT NULL,
  `user_ID` int(11) NOT NULL,
  `coopNumber` int(5) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `batchName` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL,
  `dispositionType` varchar(30) NOT NULL,
  `transactionDate` date NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `archive` varchar(20) NOT NULL DEFAULT 'not archived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chickentransaction`
--

INSERT INTO `chickentransaction` (`transaction_ID`, `chickenBatch_ID`, `user_ID`, `coopNumber`, `sex`, `batchName`, `quantity`, `dispositionType`, `transactionDate`, `note`, `archive`) VALUES
(49, 26, 1, 917, 'Female', 'Sybil Dunn', 25, 'Culled', '2023-05-03', NULL, 'not archived'),
(50, 26, 1, 917, 'Male', 'Sybil Dunn', 50, 'Sold', '2023-05-03', NULL, 'not archived'),
(51, 27, 1, 36, 'Female', 'Phoebe Cummings', 150, 'Death', '2023-05-03', NULL, 'not archived'),
(52, 27, 1, 36, 'Male', 'Phoebe Cummings', 5, 'allocation', '2023-05-04', 'no note.', 'not archived');

-- --------------------------------------------------------

--
-- Table structure for table `eggproduction`
--

CREATE TABLE `eggproduction` (
  `eggSize_ID` int(10) NOT NULL,
  `eggSize` char(2) NOT NULL,
  `inStock` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eggproduction`
--

INSERT INTO `eggproduction` (`eggSize_ID`, `eggSize`, `inStock`) VALUES
(1, 'XS', 0),
(2, 'S', 10),
(3, 'M', 10),
(4, 'L', 10),
(5, 'XL', 0);

-- --------------------------------------------------------

--
-- Table structure for table `eggtransaction`
--

CREATE TABLE `eggtransaction` (
  `collection_ID` int(10) NOT NULL,
  `eggSize_ID` int(10) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `eggSize` char(2) DEFAULT NULL,
  `quantity` int(10) NOT NULL,
  `dispositionType` enum('Distributed to Customer','Personal Consumption','Spoiled','Collected','Returned') NOT NULL,
  `transactionDate` date NOT NULL,
  `transactionType` enum('Collection','Reduction') NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `archive` varchar(20) NOT NULL DEFAULT 'not archived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eggtransaction`
--

INSERT INTO `eggtransaction` (`collection_ID`, `eggSize_ID`, `user_ID`, `eggSize`, `quantity`, `dispositionType`, `transactionDate`, `transactionType`, `note`, `archive`) VALUES
(28, 2, 1, 'S', 100, 'Returned', '2023-05-01', 'Collection', 'no note.', 'not archived'),
(29, 2, 1, 'S', 15, 'Collected', '2023-05-02', 'Collection', 'no note.', 'not archived'),
(30, 3, 1, 'M', 10, 'Collected', '2023-05-02', 'Collection', 'no note.', 'not archived'),
(31, 4, 1, 'L', 10, 'Collected', '2023-05-02', 'Collection', 'no note.', 'not archived'),
(32, 5, 1, 'XL', 10, 'Collected', '2023-05-02', 'Collection', 'no note.', 'not archived'),
(35, 2, 1, 'S', 5, 'Personal Consumption', '2023-05-03', 'Reduction', NULL, 'not archived'),
(36, 5, 1, 'XL', 10, 'Distributed to Customer', '2023-05-04', 'Reduction', NULL, 'not archived');

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `feed_ID` int(10) NOT NULL,
  `feedName` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `inStock` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`feed_ID`, `feedName`, `brand`, `inStock`) VALUES
(1, 'Layex 2000', 'B-MEG Integra', 15),
(2, 'Broiler 3000', 'B-MEG Integra', 0),
(3, 'Chick Booster 5000', 'B-MEG Integra', 0),
(4, 'Mixed Pellets 3000', 'B-MEG Integra', 0),
(9, 'SAMPLE DATA', 'SAMPLE DATA', 50);

-- --------------------------------------------------------

--
-- Table structure for table `feedtransaction`
--

CREATE TABLE `feedtransaction` (
  `transaction_ID` int(10) NOT NULL,
  `feed_ID` int(10) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `feedName` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL,
  `reductionType` enum('Damaged','Used') DEFAULT NULL,
  `transactionDate` date NOT NULL,
  `transactionType` enum('reduction','replenishment') NOT NULL,
  `archive` varchar(20) NOT NULL DEFAULT 'not archived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_ID` int(10) NOT NULL,
  `medicineName` varchar(60) NOT NULL,
  `medicineBrand` varchar(60) NOT NULL,
  `medicineType` enum('Vaccine','Medicine') NOT NULL,
  `medicineFor` varchar(60) NOT NULL,
  `inStock` int(10) NOT NULL,
  `expirationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_ID`, `medicineName`, `medicineBrand`, `medicineType`, `medicineFor`, `inStock`, `expirationDate`) VALUES
(10, 'Amoxicillin', 'Premoxil', 'Medicine', 'Colibacillosis', 50, '2023-09-09'),
(11, 'Chlortetracycline/vitamin A + B', 'Vetracin', 'Medicine', 'Fowl Cholera', 0, '2023-07-31'),
(12, 'Sulfa drug', 'Sulfaclozine', 'Medicine', 'Avian Flu', 100, '2023-07-02'),
(13, 'Multivitamin', 'Integra Multimax', 'Medicine', 'Immune System Booster', 0, '2023-07-31'),
(18, 'IBD + NCD', 'IBD + NCD', 'Vaccine', 'IBD + NCD', 0, '2023-07-31'),
(19, 'Mareks', 'Mareks', 'Vaccine', 'Mareks', 0, '2023-07-31'),
(20, 'Vitmin Pro', 'Vitmin Pro', 'Medicine', 'Vitmin Pro', 0, '2023-07-15'),
(21, 'NCD B1B1', 'NCD B1B1', 'Vaccine', 'NCD B1B1', 0, '2023-07-31'),
(22, 'NCD B1 Lasota', 'NCD B1 Lasota', 'Vaccine', 'NCD B1 Lasota', 0, '2023-07-31'),
(23, 'Fowl Pox', 'Fowl Pox', 'Vaccine', 'Fowl Pox', 0, '2023-07-31'),
(26, 'SAMPLE DATA - EDITED', 'SAMPLE DATA - EDITED', 'Medicine', 'Newcastle\'s Disease', 25, '2023-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `medicinetransaction`
--

CREATE TABLE `medicinetransaction` (
  `transaction_ID` int(10) NOT NULL,
  `medicine_ID` int(10) DEFAULT NULL,
  `user_ID` int(11) NOT NULL,
  `medicineName` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL,
  `reductionType` varchar(30) NOT NULL,
  `transactionDate` date NOT NULL,
  `expirationDate` date NOT NULL,
  `transactionType` enum('reduction','replenishment') NOT NULL,
  `archive` varchar(15) NOT NULL DEFAULT 'not archived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicinetransaction`
--

INSERT INTO `medicinetransaction` (`transaction_ID`, `medicine_ID`, `user_ID`, `medicineName`, `quantity`, `reductionType`, `transactionDate`, `expirationDate`, `transactionType`, `archive`) VALUES
(18, 12, 1, 'Sulfa drug', 50, 'Used', '2023-05-03', '0000-00-00', 'reduction', 'not archived'),
(19, 26, 1, 'SAMPLE DATA - EDITED', 25, 'Expired', '2023-05-03', '0000-00-00', 'reduction', 'not archived'),
(20, 10, 1, 'Amoxicillin', 50, '', '2023-05-09', '2023-09-09', 'replenishment', 'not archived');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `administration_ID` int(10) NOT NULL,
  `scheduleType` varchar(15) DEFAULT NULL,
  `chickenBatch_ID` int(10) DEFAULT NULL,
  `coopNumber` int(10) NOT NULL,
  `medicine_ID` int(10) DEFAULT NULL,
  `medicineName` varchar(30) NOT NULL,
  `methodType` varchar(20) NOT NULL,
  `dosage` int(10) NOT NULL,
  `numberHeads` int(10) NOT NULL,
  `administrationSched` date NOT NULL,
  `administeredBy` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `archive` varchar(20) NOT NULL DEFAULT 'not archived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`administration_ID`, `scheduleType`, `chickenBatch_ID`, `coopNumber`, `medicine_ID`, `medicineName`, `methodType`, `dosage`, `numberHeads`, `administrationSched`, `administeredBy`, `status`, `notes`, `archive`) VALUES
(8, 'medication', 29, 889, 12, 'Sulfa drug', 'Diluted in Water', 25, 820, '2023-05-04', 6, 'completed', 'Ea assumenda possimu', 'not archived'),
(9, 'medication', 27, 36, 10, 'Amoxicillin', 'Injected', 89, 477, '2023-05-13', 6, 'pending', 'Deserunt vel aut fac', 'not archived');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `contact_num` varchar(13) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `fname`, `lname`, `contact_num`, `role`, `username`, `status`, `password`) VALUES
(1, 'AJ', 'Ramos', '09672776655', 1, 'ajrams', 'active', '$2y$10$XGx6Mzr.QCB9CFb/mb6kkuLFO7uOWQC5RMz7N.qP7.Kedu/mBgM1C'),
(2, 'Bern', 'Bernales', '09672776656', 2, 'bern', 'active', '$2y$10$5icaqNYpByYSiYpkfF28Uun9MwIErffGkpoSqCQ0kgUvHOd32LEpC'),
(3, 'Json', 'Ramos', '09672776652', 3, 'json', 'active', '$2y$10$qlOxlkzsAUVAvWAQoYlFyu5oVMFdHuBuyxxMx2CdQYSmpT7i0ok22'),
(4, 'Jayson', 'Ascencion', '09353018816', 1, 'root', 'active', '$2y$10$GERLNRlVx9NN0KlNGUoSU.skSY2Gu3HTKLpWz5e9KKctx1xvHf1kq'),
(5, 'Fritz Brewer', 'Ashely Leblanc', '09672776611', 2, 'leblanc', 'active', '$2y$10$5Mh4MHzl9p1goQu7WIlcyOxBXaRip57NT.EYRKXca7CPt2Z4djQjy'),
(6, 'Wang Bush', 'Tucker Goff', '90875634123', 3, 'wangwang', 'active', '$2y$10$2G2NpKrxIeV4Zh8yGAZIbeDYAVgcNP6osondKuEmEjjURZifW4t0C'),
(7, 'Hyatt Cole', 'Daphne Durham', '09090909090', 1, 'bibugu', 'active', '$2y$10$eOlVbzH9ZoUvH4tlNVZm7umFxlEzFK5lkInIkaM1h9lEAyd3lHgwq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chickenproduction`
--
ALTER TABLE `chickenproduction`
  ADD PRIMARY KEY (`chickenBatch_ID`),
  ADD KEY `fk_chickenproduction_user` (`user_ID`);

--
-- Indexes for table `chickentransaction`
--
ALTER TABLE `chickentransaction`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `chickenBatch_ID` (`chickenBatch_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `eggproduction`
--
ALTER TABLE `eggproduction`
  ADD PRIMARY KEY (`eggSize_ID`);

--
-- Indexes for table `eggtransaction`
--
ALTER TABLE `eggtransaction`
  ADD PRIMARY KEY (`collection_ID`),
  ADD KEY `eggSize_ID` (`eggSize_ID`) USING BTREE,
  ADD KEY `fk_eggtransactiontable_user` (`user_ID`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`feed_ID`);

--
-- Indexes for table `feedtransaction`
--
ALTER TABLE `feedtransaction`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `feed_ID` (`feed_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_ID`);

--
-- Indexes for table `medicinetransaction`
--
ALTER TABLE `medicinetransaction`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `medicine_ID` (`medicine_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`administration_ID`),
  ADD KEY `chickenBatch_ID` (`chickenBatch_ID`),
  ADD KEY `medicine_ID` (`medicine_ID`),
  ADD KEY `administeredBy` (`administeredBy`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chickenproduction`
--
ALTER TABLE `chickenproduction`
  MODIFY `chickenBatch_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `chickentransaction`
--
ALTER TABLE `chickentransaction`
  MODIFY `transaction_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `eggproduction`
--
ALTER TABLE `eggproduction`
  MODIFY `eggSize_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eggtransaction`
--
ALTER TABLE `eggtransaction`
  MODIFY `collection_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `feed_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedtransaction`
--
ALTER TABLE `feedtransaction`
  MODIFY `transaction_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `medicinetransaction`
--
ALTER TABLE `medicinetransaction`
  MODIFY `transaction_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `administration_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chickenproduction`
--
ALTER TABLE `chickenproduction`
  ADD CONSTRAINT `fk_chickenproduction_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `chickentransaction`
--
ALTER TABLE `chickentransaction`
  ADD CONSTRAINT `chickentransaction_ibfk_1` FOREIGN KEY (`chickenBatch_ID`) REFERENCES `chickenproduction` (`chickenBatch_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chickentransaction_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `eggtransaction`
--
ALTER TABLE `eggtransaction`
  ADD CONSTRAINT `eggtransaction_ibfk_1` FOREIGN KEY (`eggSize_ID`) REFERENCES `eggproduction` (`eggSize_ID`),
  ADD CONSTRAINT `fk_eggtransactiontable_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `feedtransaction`
--
ALTER TABLE `feedtransaction`
  ADD CONSTRAINT `feedtransaction_ibfk_1` FOREIGN KEY (`feed_ID`) REFERENCES `feeds` (`feed_ID`),
  ADD CONSTRAINT `fk_feedtransactionstable_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `medicinetransaction`
--
ALTER TABLE `medicinetransaction`
  ADD CONSTRAINT `fk_medicinetransactiontable_user` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`),
  ADD CONSTRAINT `medicinetransaction_ibfk_1` FOREIGN KEY (`medicine_ID`) REFERENCES `medicines` (`medicine_ID`) ON DELETE SET NULL;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`chickenBatch_ID`) REFERENCES `chickenproduction` (`chickenBatch_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`medicine_ID`) REFERENCES `medicines` (`medicine_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`administeredBy`) REFERENCES `users` (`user_ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
