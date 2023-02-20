-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: sql_db
-- Χρόνος δημιουργίας: 15 Ιαν 2023 στις 19:51:48
-- Έκδοση διακομιστή: 5.7.40
-- Έκδοση PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `idm`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `description` text,
  `website` varchar(2000) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default',
  `gravatar` tinyint(1) DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `date_password` datetime DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  `extra` json DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `starters_tour_ended` tinyint(1) DEFAULT '0',
  `eidas_id` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `user`
--

INSERT INTO `user` (`id`, `username`, `description`, `website`, `image`, `gravatar`, `email`, `password`, `date_password`, `enabled`, `admin`, `extra`, `scope`, `starters_tour_ended`, `eidas_id`, `salt`) VALUES
('00b1a5b1-4cf6-4c8a-bc92-9616e616db05', 'dsteele', 'Dawn Steele', 'USER', 'default', 0, 'dsteele@gmail.com', '8bb9f1ab9aae1c7f0770e496a86580f7ccc55c85', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '536a56dace3993a4'),
('012c10d9-46d6-41b4-b534-0d6ed77bc286', 'kjohnson', 'Katherine Johnson', 'PRODUCTSELLER', 'default', 0, 'kjohnson@gmail.com', '837a39a6208cb76a1595d7648bb5dad9a20b62d8', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '9995c4c755bd9aaa'),
('0a394b0a-ae96-4fd7-b80a-adff2f397fa0', 'tstafford', 'Tina Stafford', 'PRODUCTSELLER', 'default', 0, 'tstafford@yahoo.com', 'ff525ecaad2023a3614f1acfe4e32996e0b81338', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '1ea047f67b5ae38b'),
('0a58ca12-9994-42e7-9bd6-4ff233462126', 'ccarr', 'Caleb Carr', 'PRODUCTSELLER', 'default', 0, 'ccarr@outlook.com', 'c88d238f69e317d8a704452fe9169a217a3c9665', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'e91c2e0426d1cc12'),
('0c984a8c-d41b-4d37-83dd-55dcd5237b78', 'byork', 'Brian York', 'PRODUCTSELLER', 'default', 0, 'byork@gmail.com', '3b2aef29148cc7af9a226ee69908c56ca503f1e3', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'ebb82fddb5e175eb'),
('0ecf3b69-c08b-4dcd-96d5-4f20cbfe52d9', 'jarmstrong', 'Joanna Armstrong', 'PRODUCTSELLER', 'default', 0, 'jarmstrong@msn.com', 'fc616847fb54441102600cfe2570f72823b0ba39', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '68e3a63eda46ef33'),
('0ed3c750-fb47-4d39-9490-d48ac17644c1', 'kalvarez', 'Kayla Alvarez', 'PRODUCTSELLER', 'default', 0, 'kalvarez@aol.com', 'b60e89e110a0f4489149359f8a0b7a5789ea9f72', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'e7a01328af799124'),
('117eff9f-e979-4da4-872c-af9fa189f6cc', 'dosborne', 'David Osborne', 'USER', 'default', 0, 'dosborne@yahoo.com', '709281d1456ee42a9a8db9e44213705cb4139835', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '067c23beb0c85d44'),
('120fa1ff-7326-4f6a-b171-db91a9bd452d', 'dsmith', 'David Smith', 'ADMIN', 'default', 0, 'dsmith@outlook.com', '7991a63c1c0b278f7c43c1cd5a8eea997c4c8a45', '2022-12-08 15:16:01', 0, 1, NULL, NULL, 0, NULL, '54ea609a3bd5a5a3'),
('162d9f3b-88c2-44e0-b6e2-44b665efaadb', 'dmiller', 'Diane Miller', 'USER', 'default', 0, 'dmiller@aol.com', 'a54c1c33ee725c9c48d44a4a3fef124a9ede5c79', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '1bc4161047cd6e42'),
('16ee7490-cc64-482e-b53e-f36bae290970', 'hharris', 'Henry Harris', 'USER', 'default', 0, 'hharris@gmail.com', 'a6b3155fd711f82be560dc026eaed54dfdfe7399', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, 'cbd41ccfdd3564ce'),
('17134dcd-b347-4565-a071-9180aa89617a', 'lstone', 'Leslie Stone', 'USER', 'default', 0, 'lstone@aol.com', 'd02d5b84665f2701cbeec6b906ce5955eed3fa6c', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '46ca7b363e12a2e3'),
('17e9f467-6c57-4051-a394-32f9d5f0f2d2', 'scrawford', 'Sarah Crawford', 'ADMIN', 'default', 0, 'scrawford@live.com', '9f1dfc8ee3cf0a9ee032e55ff3decc2300d7d3f2', '2022-12-08 15:16:02', 0, 1, NULL, NULL, 0, NULL, 'bc1ae6f09e4d318c'),
('1a81b45d-c1d2-4450-a30f-3e6a85fc4e6b', 'lmiller', 'Larry Miller', 'ADMIN', 'default', 0, 'lmiller@aol.com', 'd056ac02a29b8d6dff9a65e5df667f077e0b3a7d', '2022-12-08 15:16:02', 1, 1, NULL, NULL, 0, NULL, '934febe6dfc0858c'),
('23673bb8-a6e0-465a-9dda-1a9ac0b46776', 'aflores', 'Anthony Flores', 'ADMIN', 'default', 0, 'aflores@live.com', 'd3ce00545461780f56087d6e054caf3e7d4b8794', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '06ed3fdd37b838d2'),
('2c7aaf65-c012-4b11-a22a-0c4c3e73ed92', 'drobbins', 'Diana Robbins', 'ADMIN', 'default', 0, 'drobbins@live.com', '34ead860f908f6315f728ae4e0ab21ab3c227f61', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '5022b0812f373058'),
('2ca50c65-d48c-4fe0-9035-ba79555ab131', 'jevans', 'Jennifer Evans', 'ADMIN', 'default', 0, 'jevans@outlook.com', 'fba561281c9f1b9473e3c4fe220a9a7cab6cce04', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '1d68e3a15ec0e338'),
('2cb59b10-c5a4-475c-bcf8-e867cb2598b0', 'rcurtis', 'Rachel Curtis', 'ADMIN', 'default', 0, 'rcurtis@aol.com', '17025e292466f926f90462f6e3afa37205995a75', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '93048d97aebc5ad8'),
('2e960e5d-b1d7-4688-893d-9375bc01bbfb', 'dtaylor', 'Dana Taylor', 'ADMIN', 'default', 0, 'dtaylor@msn.com', '20fe88e19ab117d4a8efb8985f802cce11a66efe', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '31f8f7dfd19cf346'),
('2ee096b9-f92b-43e7-9254-0beb869aa2c0', 'jashley', 'Jennifer Ashley', 'ADMIN', 'default', 0, 'jashley@msn.com', 'fd57e79d6822b9a9d53c5134a554914e5462ba76', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, 'a21ed18415d3c65d'),
('3536d6ce-769f-4e92-bbbe-259cdd73b866', 'ddiaz', 'Donald Diaz', 'ADMIN', 'default', 0, 'ddiaz@aol.com', '4097fc0a5a7b0068d1e0d6400b0f31175c68b015', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '6d6b85d2b5076f68'),
('375c75b7-1da4-464d-84c8-6d1748dacb26', 'rbeck', 'Richard Beck', 'PRODUCTSELLER', 'default', 0, 'rbeck@live.com', '59560fcf86dfa9333cb4eb828df0bebc4bb41a7d', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '3d25f8934b04cd7c'),
('3a919ddf-964e-4345-ac34-1351a411c1a6', 'pclark', 'Paul Clark', 'PRODUCTSELLER', 'default', 0, 'pclark@aol.com', '7f4e4945a6549495ea973c5e5f007d8061f321e8', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'bba4eeea7d5462f2'),
('3cc92b9b-d743-444b-b7b3-3a8b862bcd26', 'mroman', 'Molly Roman', 'PRODUCTSELLER', 'default', 0, 'mroman@yahoo.com', 'e325373abe59d138c7d9d8a1f5fad3881ee68c91', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '538f1a0d99125275'),
('43b0c90d-539f-4b7f-a619-dfa146ed0eb4', 'jhernandez', 'Joshua Hernandez', 'USER', 'default', 0, 'jhernandez@outlook.com', 'fd85c53b0a265dd1372237d9f25d6212d09fdfea', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '40a5fd41f824f1a5'),
('46e63300-0a7e-4ffb-9a31-0ee3ef6060da', 'jmatthews', 'Jennifer Matthews', 'USER', 'default', 0, 'jmatthews@live.com', '55024729dc8659790402bd58bdf4cbb34cb0f59f', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '770b60bc552768d4'),
('4926bc2f-f421-48b2-bb76-ba0f6a7c2b2c', 'jbernard', 'Johnny Bernard', 'PRODUCTSELLER', 'default', 0, 'jbernard@live.com', '00f4fe28f857595ee4f88569c031e1587500750d', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, 'cbf740e7d002a40f'),
('4a129c4f-e56a-4b2c-bd6b-905e94df9aff', 'cchristensen', 'Christina Christensen', 'PRODUCTSELLER', 'default', 0, 'cchristensen@live.com', 'eedd4cd87cad36fb252097c7d01bdba8950e53e9', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '2c7419faf2d27c6c'),
('4b6f3119-180d-45e6-b694-7e42fdf5be5e', 'bchan', 'Brett Chan', 'USER', 'default', 0, 'bchan@yahoo.com', '834a717dc3f170150a1a181ef9e81968e6910361', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '10bae6e0a5410c17'),
('4cde6528-19b1-426a-9b7c-a6bb2ba9e504', 'arichardson', 'April Richardson', 'PRODUCTSELLER', 'default', 0, 'arichardson@hotmail.com', '6acc7bacf72ce77e182d79a8d8aa56e46928e407', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, 'fe4c6dd9dca39806'),
('4e826db6-509d-4ec3-9e04-67716e248331', 'vbradley', 'Victoria Bradley', 'PRODUCTSELLER', 'default', 0, 'vbradley@aol.com', 'bc190b4b7ec9a6888b175e11ac932b6efcfd7d99', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '804a1f064d340afe'),
('5393ab8f-d8b9-4269-bced-bf7c76a670fc', 'amitchell', 'Andre Mitchell', 'USER', 'default', 0, 'amitchell@yahoo.com', '3e9a6b6ad6484392601527e587ad2a20689b1f34', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '7ef07e3cc8d6158a'),
('5525c27c-26c8-4af1-b915-003f7e3eeba8', 'wgilmore', 'Wanda Gilmore', 'PRODUCTSELLER', 'default', 0, 'wgilmore@gmail.com', '261123086dacb44f4b8609bfe625395800cab654', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '6765278b36db4c66'),
('5d34370d-458b-4297-82cb-de51d6f02b1b', 'jbyrd', 'Jonathan Byrd', 'USER', 'default', 0, 'jbyrd@hotmail.com', '0e774235d18dc5795c1caf46471b2add0b6daeab', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '04ffe493b7f16407'),
('6444b229-0102-4606-85d4-1634c4c1dfda', 'dwhite', 'Donald White', 'PRODUCTSELLER', 'default', 0, 'dwhite@outlook.com', '2d04cc71a4be5fdf39b4d3f4901fe101c022faf4', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'a45ff2f43515a475'),
('64c4006b-ee15-4ef2-9e48-4ba78c700b37', 'hcollins', 'Heather Collins', 'PRODUCTSELLER', 'default', 0, 'hcollins@hotmail.com', '1f3c469c59e35a316454d76490d9aff9df5886d6', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '0defe1aec5688e76'),
('66184765-2178-4b6f-84b2-81d866c8e00f', 'jmosley', 'Jason Mosley', 'ADMIN', 'default', 0, 'jmosley@gmail.com', '4368ebf6f692a54d59fd2d15eecd052c6144f54c', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, 'a0bd5af5d5234d8d'),
('67fc32d9-00e7-487a-9c06-3ee430365df5', 'tbarker', 'Tara Barker', 'PRODUCTSELLER', 'default', 0, 'tbarker@hotmail.com', '7e09f7811bfd21d41ade9e1535e46c852e05811c', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'c23786fc5c5c57cc'),
('68e4c98f-48c1-4a31-bbb7-362a0093a886', 'evaughn', 'Elizabeth Vaughn', 'PRODUCTSELLER', 'default', 0, 'evaughn@gmail.com', '6007ba4722815fb786986e100701b90f2b0a2d1a', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'a2a0c8ba54fe7fb4'),
('69813dd9-5781-4209-abdd-5cba0aa998c3', 'kwhite', 'Kelli White', 'PRODUCTSELLER', 'default', 0, 'kwhite@aol.com', '3a54ce83c2bc986f13a4611791b418910fbf231b', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '32a6b6028ae06d70'),
('6e827840-00be-4659-ac7f-d6ecdf255701', 'sjohnson', 'Sarah Johnson', 'USER', 'default', 0, 'sjohnson@live.com', 'd36ac6e85f4ba5185748268f90da3d0c01fcf7e6', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '40765da11fa7fe54'),
('711228b4-7b3b-4c3c-9e4f-88773167ce1b', 'ningram', 'Nicole Ingram', 'ADMIN', 'default', 0, 'ningram@aol.com', 'fe1a11706bbe76887c6929e3166993c360b7f318', '2022-12-08 15:16:02', 0, 1, NULL, NULL, 0, NULL, 'e61a8494ed53afc1'),
('71959450-b302-4164-9a67-99d216a62f04', 'chenry', 'Christopher Henry', 'PRODUCTSELLER', 'default', 0, 'chenry@gmail.com', '9aa4b81530c4b9ad4b7a0cabd76209cee31c925f', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '80b73838274bd315'),
('73c12b22-b116-4a0c-938b-403fefa6cf6c', 'clee', 'Chris Lee', 'PRODUCTSELLER', 'default', 0, 'clee@gmail.com', '4cc32ab0bf4232f9fc77b534b8ad324affc20beb', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '0b15356ffbf13e29'),
('75c71f33-7ae1-4612-ab5e-a17a9bb9d1fc', 'jhobbs', 'Jordan Hobbs', 'USER', 'default', 0, 'jhobbs@live.com', '250fc5056ac6ee6e09873171d5bc228ddd0a77e7', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, 'bb64dff93dc8eb25'),
('7aefcd19-b2b3-42f9-8018-6427d5dad517', 'zvelasquez', 'Zachary Velasquez', 'PRODUCTSELLER', 'default', 0, 'zvelasquez@gmail.com', 'f17b79bab5819cbfe68ad1f925e7c78e5cfe337e', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'f94c58bd47b9eabc'),
('7c147a75-9d03-4daa-b80f-ad4835a1eae3', 'tdavid', 'Tammy David', 'USER', 'default', 0, 'tdavid@gmail.com', '124afa2c3d544f5a9e9c5cf9e8059857ea89c441', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '09da68664a0ce7d6'),
('7f1a325f-a58c-4e01-9fc6-63b536c08b41', 'pwright', 'Penny Wright', 'PRODUCTSELLER', 'default', 0, 'pwright@hotmail.com', '1e8882fdce1e25f536c1f5d82598538f0bcac2b2', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, 'd9b6477cc9901a35'),
('827bc997-67e8-4ea9-84ea-b2486d28116e', 'tgarrison', 'Troy Garrison', 'USER', 'default', 0, 'tgarrison@aol.com', '6020bcf5cdd1d7c320f7f226f97e23fec34d7c34', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '1d88c3df93762704'),
('8537c1db-77d5-4a0c-862e-80ea3bc1f417', 'smartin', 'Steven Martin', 'PRODUCTSELLER', 'default', 0, 'smartin@aol.com', 'a498336c5b29215fc6b6288b4d0f5860f1459096', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '4825cc1540f0c25e'),
('8565b3cf-bba2-4a68-ba94-4dd009d49121', 'pruiz', 'Patricia Ruiz', 'USER', 'default', 0, 'pruiz@outlook.com', '18947c17cc0112b1faf03519f9087e1567e67a91', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '2b9bf30ce166a6af'),
('86944d42-be96-4b07-8ade-683925cd6d4e', 'nkennedy', 'Natasha Kennedy', 'PRODUCTSELLER', 'default', 0, 'nkennedy@hotmail.com', '4c63393f96e6279c1fcbe85a2a2c0fa5855bed8b', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '08f416cb288e9f45'),
('8985b95c-2050-4f66-b1fc-677c4e66eee7', 'sabbott', 'Shawn Abbott', 'USER', 'default', 0, 'sabbott@msn.com', '867c98c84c3d639f9ea81b55a8517cf9c8f71f37', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '7fe7081f03848b38'),
('89cb48db-b217-4a80-9b3d-ffdacf373cca', 'ehowell', 'Elizabeth Howell', 'USER', 'default', 0, 'ehowell@outlook.com', '327e3970bf421da30e76e82225d6025a271dc856', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '09a8d5adb2ec5724'),
('89fb8f9d-e96d-4931-a707-77b17f988360', 'jfleming', 'James Fleming', 'USER', 'default', 0, 'jfleming@msn.com', '037f82bb38a3d4c2060b697e1fffd00804671c75', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, 'afdf71ec9668c80a'),
('8da11394-c777-4a2c-a4a1-cf9a15e7f153', 'aaustin', 'Amanda Austin', 'ADMIN', 'default', 0, 'aaustin@aol.com', '02756f1d0230bbb55a6090cd859ddce16f5c71a6', '2022-12-08 15:16:02', 1, 1, NULL, NULL, 0, NULL, '1cfac7b879366fc3'),
('90eb7fb5-d7dc-4ee8-8d32-02ddc000aa10', 'awhite', 'Aaron White', 'ADMIN', 'default', 0, 'awhite@live.com', '4e738ac899f60af49104fee55b90f950463193a1', '2022-12-08 15:16:01', 0, 1, NULL, NULL, 0, NULL, '63e7c2139c842078'),
('93d914e7-89eb-485b-90b4-4383c0a5fdd5', 'cpugh', 'Corey Pugh', 'PRODUCTSELLER', 'default', 0, 'cpugh@outlook.com', '4aea10ce1aca9283da8c2b564dbaa47e81871537', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'df83f24013abd97b'),
('98752039-f797-490f-97ec-0ed65b393e68', 'jfreeman', 'Jason Freeman', 'USER', 'default', 0, 'jfreeman@msn.com', '51a4d53e535fdcf9cc19644f83fc4f36ee7f8f03', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '4627b5875d926116'),
('98c4838f-8d6a-4a84-82d3-0a06480bab65', 'cramirez', 'Colleen Ramirez', 'PRODUCTSELLER', 'default', 0, 'cramirez@live.com', '0f07adc6021637ed606e3fd3a78de551511eb5bb', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '2b54e7af67679508'),
('9a19f56e-883a-4752-b535-d27d91a8071d', 'athomas', 'Arthur Thomas', 'PRODUCTSELLER', 'default', 0, 'athomas@aol.com', '4114da794e690fab59ab1a524998dd0314f9f6e9', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '6da95814329e8e34'),
('9a248283-151e-424d-b9f5-9398fde1b266', 'lturner', 'Laura Turner', 'USER', 'default', 0, 'lturner@outlook.com', '765286ced0a02917378cd24912a832bcb1ff0ec0', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'e588c00806b79e3a'),
('9c1a18bf-60c3-4aa0-b0d3-d2a3a0c63c87', 'tyoung', 'Tyler Young', 'PRODUCTSELLER', 'default', 0, 'tyoung@gmail.com', 'd9266f55e4457f3a2fdb67973f336a89951f93b0', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'dd262d00a99f6961'),
('9c46a185-2f9a-405c-90d3-a29a33073dc3', 'emaldonado', 'Ernest Maldonado', 'PRODUCTSELLER', 'default', 0, 'emaldonado@outlook.com', 'd2dac9451a6d5aa0ab4ed808d3bf2973bde7e11d', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, 'af66ba34163d331e'),
('9dd5d39a-dcf9-41af-b2b2-0f8cebf48337', 'jfitzpatrick', 'James Fitzpatrick', 'USER', 'default', 0, 'jfitzpatrick@live.com', '2c0a54f5b66c35cde3250f6d003040e085cf2d38', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '32f7a82cb05aadc0'),
('a065778f-a53d-416d-aca6-65d367b04159', 'tmoore', 'Timothy Moore', 'USER', 'default', 0, 'tmoore@hotmail.com', 'f2c1318ebcdd53005f6c441fdbba89debbf123b4', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '9e090753c8fe7b43'),
('a0797970-8990-4cab-aeb7-93418c9e456e', 'smeyer', 'Sharon Meyer', 'USER', 'default', 0, 'smeyer@gmail.com', '92cb7fac9fbbc921abc6d9cd9ca95f604be3087d', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, 'ce509112f3f7cdd7'),
('a2296835-4317-4c51-aec1-5172b4501d37', 'marias', 'Michael Arias', 'PRODUCTSELLER', 'default', 0, 'marias@live.com', '57ed1822c99b1f36042803062ceebe3cf049d457', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '91ab28e12670166d'),
('a6b817b7-2c7a-4249-92f7-044dc5238087', 'mweber', 'Megan Weber', 'PRODUCTSELLER', 'default', 0, 'mweber@outlook.com', '098b0c63429a6d4f3ecdd6df4685580ecc95e7d6', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'e3aa9efcd02290b1'),
('a8a2fdcf-3ded-40f3-8a49-bb0a34eb6c87', 'ealvarez', 'Eric Alvarez', 'PRODUCTSELLER', 'default', 0, 'ealvarez@live.com', 'bfda381e6215bfc3120d4d3316c5b9050d3b5b39', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '1bbeb677b9694040'),
('a9bf44a2-cf40-490b-82fb-9790b9e2a50d', 'cpollard', 'Courtney Pollard', 'USER', 'default', 0, 'cpollard@aol.com', 'c4df5f982d569a93d09538f97ca0aac88ec18e2e', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '8d7d9a2bbc6a8a4b'),
('abef6f54-7296-4ece-a471-71b97b087c45', 'mwilliams', 'Maria Williams', 'USER', 'default', 0, 'mwilliams@aol.com', '07271798bd9db08100f35f1b1f4014e534aed54d', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '55cbf5a29382ac54'),
('admin', 'gfrangias', NULL, NULL, 'default', 0, 'gfrangias@tuc.gr', '9305e56fad726a5cb51af4900ae15efd0b25282b', '2022-12-07 10:31:07', 1, 1, NULL, NULL, 0, NULL, '77a219bb21ea3f26'),
('aef3f830-3b51-4294-bbbd-5e00ca9e8fa3', 'eelliott', 'Elijah Elliott', 'ADMIN', 'default', 0, 'eelliott@hotmail.com', 'f3c2d46dfabd1b74026443669a5918b3aa72991b', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '5ad5bdee139ca383'),
('b1cf6ffa-48d8-47aa-b784-7fc1571e100a', 'bdavid', 'Bethany David', 'PRODUCTSELLER', 'default', 0, 'bdavid@gmail.com', 'de4bfa7fc15d2d8ba6305b974a79286aaf9ecac5', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '2936411495e7d605'),
('b499b68c-ea2a-4573-82a9-197ef81e8fd6', 'jbaldwin', 'Joshua Baldwin', 'ADMIN', 'default', 0, 'jbaldwin@aol.com', '897439cf16267c3d1c9a9145e6215b2b59278c02', '2022-12-08 15:16:01', 0, 1, NULL, NULL, 0, NULL, '1737296cb6eb5fd5'),
('bcb07617-10d2-48cb-8a74-3858b24377b1', 'rholt', 'Robert Holt', 'PRODUCTSELLER', 'default', 0, 'rholt@gmail.com', 'a7f5a8ad18cf0d68f22dbb9a93b43ce49cd6d55c', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '2ae7ad58f0a65fdd'),
('be03c809-5848-472b-8ae6-49f8e2edd367', 'achase', 'Angela Chase', 'ADMIN', 'default', 0, 'achase@live.com', '313cec34ef4cb0d9fa35b9acce30843e7b5e9498', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '7b68763c452ad535'),
('c0593267-4198-4240-ae15-593bae9f3d64', 'cbaker', 'Christina Baker', 'ADMIN', 'default', 0, 'cbaker@msn.com', '10e32616871be2a17cbce67a490ecd61179ff17b', '2022-12-08 15:16:02', 1, 1, NULL, NULL, 0, NULL, '713ce580e106893a'),
('c18709fa-021a-4969-923c-b527973afb5d', 'cevans', 'Courtney Evans', 'PRODUCTSELLER', 'default', 0, 'cevans@yahoo.com', 'fd10380b5926ef6eff454939c7896716e8170dbb', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '2d3ed29ea4f7a77a'),
('c4350c41-749e-408b-bff1-fdff91a87ffd', 'ccole', 'Connor Cole', 'PRODUCTSELLER', 'default', 0, 'ccole@msn.com', 'a6fde51902de3d52f816cc86ee2b77a143f1c215', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '0b6a722945a12ae1'),
('cfc4178f-b9bd-4abc-9d8f-2ad74ed8dd66', 'sjones', 'Sandra Jones', 'PRODUCTSELLER', 'default', 0, 'sjones@aol.com', '30d230ac5e3272a686291a2a90a931da8e141fc1', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'dfbd5755a33ae259'),
('d05d6cbc-f6fa-4847-aafe-887d771e1039', 'ajones', 'April Jones', 'USER', 'default', 0, 'ajones@yahoo.com', 'da01bc408fb63072a101ade8bd81ca4208583e42', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '0e3b2d9a238ea6e6'),
('d670c50d-46e8-4c6c-b594-f08fea57aa87', 'dgraham', 'Dave Graham', 'ADMIN', 'default', 0, 'dgraham@live.com', '899e0a06b6ab2fa9411f43350e9934316b056e34', '2022-12-08 15:16:02', 1, 1, NULL, NULL, 0, NULL, 'e9b14c7e19b75a6b'),
('db0cc215-e993-475b-9b64-60028c476222', 'esoto', 'Ebony Soto', 'PRODUCTSELLER', 'default', 0, 'esoto@hotmail.com', 'c71f2a466217ee6ade2bf880ec64b9a5fcaa455e', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, 'e813cf865ff817cb'),
('db7346ff-3223-465d-8dbb-ea0d7cdb0156', 'ccarter', 'Carlos Carter', 'PRODUCTSELLER', 'default', 0, 'ccarter@aol.com', 'b01209ec31a36a30a204fb09572ac7ebc96fb8df', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, 'a416301179c259bb'),
('de819961-9df2-47b6-996a-cef5a8ec45c9', 'jklein', 'Jennifer Klein', 'ADMIN', 'default', 0, 'jklein@live.com', 'a95779765225fa099afeea89337591d8b1e0f21e', '2022-12-08 15:16:01', 0, 1, NULL, NULL, 0, NULL, '04c50d38cd3d058d'),
('def29744-dac5-4771-bfd5-715533422892', 'rschmidt', 'Randy Schmidt', 'ADMIN', 'default', 0, 'rschmidt@gmail.com', '16c7ad0786fa869dbe2fe7c847623860a97a4013', '2022-12-08 15:16:02', 0, 1, NULL, NULL, 0, NULL, '382e026bdfab2f15'),
('e0e86ce7-7c6a-4efb-840a-f3b41259a876', 'rferguson', 'Ryan Ferguson', 'ADMIN', 'default', 0, 'rferguson@outlook.com', '0abd5cc7d8d72f15198f1d27a607858ebae6968d', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, '903b774edd590111'),
('e22cf06c-bfc2-4720-99c6-b476ef2b28c9', 'aford', 'Amanda Ford', 'PRODUCTSELLER', 'default', 0, 'aford@msn.com', '81eb33f91d8d0c5676d90bb6a1b653cdc5bf6a70', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '7f370f62f540625f'),
('e2d1f647-b5bb-4322-970d-56c574542cff', 'tphillips', 'Todd Phillips', 'USER', 'default', 0, 'tphillips@msn.com', '65c3bbb6c78fb456beac2b4ede49c0be401702ff', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '6aff9a9d1cdee77e'),
('e6d58c35-0d86-4b27-8774-b4a85da979ad', 'sevans', 'Steven Evans', 'PRODUCTSELLER', 'default', 0, 'sevans@hotmail.com', '6da8169cb24f80fbdcc5e71638ec102c7d6762ac', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, '7255ef0916eb95fe'),
('e79b4745-09c4-43d4-bc57-00906c729ea3', 'jcortez', 'Jay Cortez', 'USER', 'default', 0, 'jcortez@live.com', '228721b497f91b943534fac925bd02e9131c83db', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '1e78538c131ca030'),
('e88eb5d4-99a9-4402-9d08-2f25c0adcdcb', 'ejohnson', 'Eric Johnson', 'USER', 'default', 0, 'ejohnson@aol.com', 'c9c46b5ba627e4a6bf428e6a1b4bf84e16ba7382', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'e7413813492ba969'),
('ee0e4448-9d0e-443c-80ad-777db0681f20', 'levans', 'Lisa Evans', 'USER', 'default', 0, 'levans@gmail.com', '1daa7607b736136441220ec1088b695f824e1421', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, '2b298109c84d2390'),
('efa63f9a-877a-49ce-b5ec-dfd73dc0bfd2', 'lsmith', 'Laura Smith', 'ADMIN', 'default', 0, 'lsmith@aol.com', '8923b411d8ed67931f5e09592cf32e03477a8f3f', '2022-12-08 15:16:01', 1, 1, NULL, NULL, 0, NULL, 'f8977f65578eab09'),
('efb908f7-c09f-4189-93c5-97b6d84dfadb', 'bosborn', 'Bryan Osborn', 'USER', 'default', 0, 'bosborn@hotmail.com', 'a3709bb4efbb07aa2332aaea46c93df0fffb4cd5', '2022-12-08 15:16:01', 1, 0, NULL, NULL, 0, NULL, 'c4258355cd222e01'),
('f201da82-3120-4c56-9260-41806e4ff742', 'tmorrison', 'Tara Morrison', 'PRODUCTSELLER', 'default', 0, 'tmorrison@live.com', 'bedca343a1a8069d0c8c95c3d3747b30ebb713d1', '2022-12-08 15:16:01', 0, 0, NULL, NULL, 0, NULL, '2096c2157a952032'),
('f88d4a65-2bd5-4833-be7c-44e37a80c5e1', 'jcisneros', 'Justin Cisneros', 'USER', 'default', 0, 'jcisneros@msn.com', 'a6ecbc3bd2338c76c98aede45e783b79b21bc165', '2022-12-08 15:16:02', 1, 0, NULL, NULL, 0, NULL, 'ff5368f028855f67'),
('f9422a62-a319-4e6e-952a-afe08652659d', 'kbradford', 'Katie Bradford', 'ADMIN', 'default', 0, 'kbradford@live.com', '2520e94b1caefd23368dd23fe8e3054ec2bcaeca', '2022-12-08 15:16:02', 1, 1, NULL, NULL, 0, NULL, '088835eb87257a7a'),
('ff334991-4f06-4419-a433-7c5060832a93', 'shuang', 'Sara Huang', 'USER', 'default', 0, 'shuang@live.com', '55c9a5109c2e04f8baf9ab9272faae7884e49cf1', '2022-12-08 15:16:02', 0, 0, NULL, NULL, 0, NULL, '63c1bff6df3ba652');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
