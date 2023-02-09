-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 09 fév. 2023 à 11:57
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bikeshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230110094656', '2023-01-10 09:47:21', 129),
('DoctrineMigrations\\Version20230110110305', '2023-01-10 11:03:19', 74),
('DoctrineMigrations\\Version20230112090356', '2023-01-12 09:06:56', 149),
('DoctrineMigrations\\Version20230112154051', '2023-01-12 15:41:01', 146),
('DoctrineMigrations\\Version20230112154307', '2023-01-12 15:43:14', 50);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5299398A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `price`, `creation_date`) VALUES
(1, 3, 10047, '2023-01-29 17:48:30'),
(2, 3, 6892, '2023-01-29 17:55:01'),
(3, 3, 5649, '2023-01-30 11:10:44'),
(4, 3, 12397, '2023-01-30 14:32:19'),
(5, 3, 6398, '2023-01-30 17:38:28'),
(6, 3, 3199, '2023-01-31 13:11:36'),
(7, 3, 4798, '2023-01-31 13:17:17'),
(8, 3, 5649, '2023-02-01 14:50:49'),
(9, 3, 7248, '2023-02-06 14:34:47'),
(10, 3, 11298, '2023-02-08 18:29:57');

-- --------------------------------------------------------

--
-- Structure de la table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2530ADE68D9F6D38` (`order_id`),
  KEY `IDX_2530ADE64584665A` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `unit_price`, `quantity`) VALUES
(1, 1, 6, 5649, 1),
(2, 1, 14, 2199, 2),
(3, 2, 3, 1599, 1),
(4, 2, 13, 1099, 1),
(5, 2, 5, 699, 6),
(6, 3, 6, 5649, 1),
(7, 4, 6, 5649, 2),
(8, 4, 13, 1099, 1),
(9, 5, 4, 3199, 2),
(10, 6, 4, 3199, 1),
(11, 7, 4, 3199, 1),
(12, 7, 3, 1599, 1),
(13, 8, 6, 5649, 1),
(14, 9, 6, 5649, 1),
(15, 9, 3, 1599, 1),
(16, 10, 6, 5649, 2);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `frame` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fork` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suspension` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brake_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saddle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `brand`, `picture`, `product_type`, `price`, `description`, `frame`, `fork`, `suspension`, `brake_type`, `saddle`, `is_valid`, `creation_date`, `update_date`) VALUES
(1, 'Domane AL 2', 'Trek', 'Domane-AL-2_63c5baa53e295.jpg', 'Route', '999.99', 'Le Domane AL 2 est le vélo idéal pour découvrir le cyclisme sur route en confort. Il est stable et léger, il peut être enrichi d’une multitude d’accessoires et il vous donnera le sourire. Ces caractéristiques en font le choix idéal pour tout cycliste à la recherche d’une première expérience inoubliable sur un vrai vélo de route.', 'Alpha Aluminium Série 100, fixations pour garde-boue, compatible DuoTrap S, QR 130x5 mm', 'Domane carbone, pivot droit en alliage, fixation pour garde-boue, QR 5x100 mm', NULL, 'freins sur jantes', 'Bontrager P3 Verse Comp, rails en acier, largeur de 155 mm ; Bontrager P3 Verse Comp, rails en acier, largeur de 145 mm', 1, '2023-01-12 10:06:56', '2023-02-09 09:57:05'),
(3, 'Contessa Scale 930 2022', 'Scott', 'Contessa-Scale-930-2022_63c86bcfea017.jpg', 'VTT', '1599.00', 'Sur ce Twostroke AL Three, BMC a choisi la fiabilité de la transmission Shimano Deore 1x12, un groupe qui vous permettra de vous faire plaisir sur tous les profils grâce à sa cassette 10-51 et son plateau 32 dents. Le passage de vitesses est fiable et précis.\r\nIl est associé à des performances de freinage précises et progressives avec les freins à disques hydrauliques Shimano BR-MT200. La fourche RockShox Judy TK propose 100 mm de débattement, elle amortira les chocs du terrain pour réduire votre fatigue et garder la roue avant en contact avec le sol pour un rendement optimisé et un pilotage plus fluide. La fourche est associée à une commande de blocage au guidon, qui permet de la bloquer lorsque vous évoluez sur des chemins roulants ou sur la route.', 'Twostroke AL Premium Aluminium Hydroformed SmoothweldedInternal Cable RoutingBSA Threaded Bottom BracketPost Mount Disc', 'Rockshox Judy Silver TK - PopLoc Remote', 'Semi-rigide', 'Frein à Disque Hydraulique', 'Selle Royal Seta', 1, '2023-01-12 10:06:56', '2023-02-07 09:26:26'),
(4, 'VIBE H30 EQ 2023', 'Orbea', 'VIBE-H30-EQ-2023_63c86c69b752e.jpg', 'Electrique', '3199.00', 'Le vélo électrique ORBEA de la gamme Vibe H30 EQ 2023 est équipé de garde-boue, d\'un feu avant Lezyne Ebike POWER STVZO PRO E115 de 310 lumens et d\'un feu arrière Lezyne FENDER STVZO pour rouler en toute sécurité dans la circulation urbaine, et une batterie Mahle 36V/6.9A 248Wh ANT+.', 'Orbea Vibe Top Bar Hydro 6061 Hydroform Aluminum 2021, ICR cable routing, Forged BB, 135x9 QR, Flat Mount disc, 700x45 maximun tire, 1\" 1/2 semi head set, 41x86,5 Pressfit BB, carrier and fenders compatible', 'Orbea Vibe carbon fork, full carbon, 1-1/5, 700x45 maximun tire, flat mount disc mount, Thrue Axle12x100mm, Long mudguards compatible.', NULL, 'Frein à Disque Hydraulique', 'Selle Royal Lift 1215 URN 278x145mm', 1, '2023-01-12 10:06:56', '2023-01-28 14:41:39'),
(5, 'Loft 7i EQ Step-Thru', 'Electra', 'Loft-7i-EQ-Step-Thru_63c86ce43e9cb.jpg', 'Urbain', '699.00', 'C’est votre ville. Explorez-la en vélo. Le Loft™ 7i est un vélo léger pour les trajets au quotidien qui allie à la fois plaisir et fonctionnalité. Les roues 700c et la posture bien droite, avec le pied vers l’avant, vous permettent de rouler à une vitesse optimale tout en bénéficiant d\'un confort et d’un contrôle optimum. Ce classique des temps modernes est conçu pour rouler. Il est léger. Il est durable. Il est confortable et conçu pour répondre aux exigences des rues urbaines.', 'Aluminium 6061-T6 avec technologie brevetée Flat Foot Technology', 'Fourche unicrown acier à grande résistance à la traction, fourreaux droits coniques', NULL, 'Frein double pivot', 'Simili cuir Retro, double ressort', 1, '2023-01-12 10:06:56', '2023-01-28 14:42:26'),
(6, 'Triporteur Flow Mountain', 'Babboe', 'Triporteur-Flow-Mountain_63c86edb00308.jpg', 'Cargo', '5649.00', 'Un vélo cargo à trois roues avec les caractéristiques de direction d\'un vélo normal. Le Babboe Flow Mountain est un vélo cargo électrique à trois roues, où l\'on tourne le guidon mais pas le bac. Les roues avant tournent indépendamment du bac dans un virage. Cela donne une expérience très familière.', 'Revêtement poudre anti-choc, traitement anticorrosion, avec antivol Trelock', NULL, NULL, 'Freins à disque hydrauliques', 'Réglable en hauteur', 1, '2023-01-12 10:06:56', '2023-01-28 14:42:54'),
(8, 'Teammachine SLR SIX', 'BMC', 'Teammachine-SLR-SIX_63c86f335f49c.jpg', 'Route', '3299.00', 'Le BMC Teammachine SLR Six 2023 est un vélo de route de type montagne. Il dispose de la technologie BMC Tuned Compliance Concept (TCC) qui permet d\'optimiser le rendement par 4 optimisations sans qu\'une seule ne soit négligée : l\'aérodynamisme, la rigidité du cadre, le poids et sa qualité de filtration. Le résultat est bluffant comparé à d\'autres marques qui ne se focalisent bien souvent que sur le poids et l\'aéro : maintien de la vitesse par vent violent, gain de puissance, légèreté pour les relances ou l\'ascension de cols et le confort de filtration qui réduit considérablement la fatigue ainsi que les douleurs articulaires', 'Teammachine SLR Carbon with Aerocore Design', 'Teammachine SLR Carbon', NULL, 'Frein à disque', 'Fizik Antares R7', 1, '2023-01-12 10:06:56', '2023-02-09 11:56:37'),
(9, 'Le Flexible Deore', 'Adris', 'Le-Flexible-Deore_63c86fc00d6e7.jpg', 'VTT', '2999.00', 'Conçus pour répondre aux besoins de la compétition VTT au plus haut niveau avec une expérience et des performances exceptionnelles. La nouvelle Série XTR M9100 offre le groupe le plus polyvalent pour la compétition cross-country, enduro et marathon.', 'Adris Le Flexible Carbone UHM', 'Rockshox Recon Silver TK 120mm remote', 'Tout suspendu', 'Frein à disque hydraulique', 'Selle Italia ModelX SuperFlow', 1, '2023-01-12 10:06:56', '2023-01-28 14:44:33'),
(13, 'Asphalte patins sora 9S', 'Adris', 'Asphalte-patins-sora-9S_63c985a1d6090.jpg', 'Route', '1099.00', 'Le nouveau Asphalte patins 10 vitesses offre des prestations issues des technologies haut de gamme, pour un groupe d’entrée de gamme. Des changements de vitesses encore plus intuitifs.', 'Adris l\'asphalte patins hydroformed triple butted aluminium 6061 fwt', 'Adris l\'asphalte carbon tapered', NULL, 'Shimano sora br3000', 'Selle italia novus evo boost superflow', 1, '2023-01-19 18:02:09', '2023-01-28 14:45:05'),
(14, 'URS AL THREE', 'BMC', 'URS-AL-THREE_63c98a39e26fd.jpg', 'Gravel', '2199.00', 'Tel un caméléon, l’URS AL est doté de capacités d’adaptations telles qu’il s’ajuste et s’intègre à différents environnements. Fidèle aux caractéristiques de maniabilité de la famille URS tout en présentant un aspect pratique supérieur grâce à ses fixations pour porte-bagage et à sa compatibilité avec une tige de selle télescopique, l’URS AL est véritablement votre vélo pour toutes les occasions. Équipé d’un groupe Shimano 2x10 GRX 400 pour tous les dénivelés, de pneus WTB 45 mm et de roues PRD23, l’URS Three vise à ce que chaque sortie de gravel soit la meilleure possible.', 'URS Premium Aluminium', 'URS Carbon Internal Brake & Hub Dynamo Cable', NULL, 'SHIMANO GRX 400 SM-RT64 Rotors', 'Selle Royal', 1, '2023-01-19 18:21:45', '2023-01-28 14:46:56'),
(18, 'Esprit T3', 'Gazelle', 'Esprit-T3_63e4d938d143e.jpg', 'Urbain', '679.00', 'L\'Esprit a tout ce que vous recherchez dans un vélo du quotidien. Le cadre en aluminium et les pièces robustes résistent aux chocs. Son style contemporain arbore un éclairage intégré, des câbles dissimulés et des jantes hautes. Un large choix d\'options s\'offre à vous.', 'Cadre en aluminium surdimensionné, léger et stable, avec tube de direction à 70,5° et tube de selle à 71,5° pour une conduite réactive.', 'acier', 'Sans', 'Shimano BR-C3000F', 'Selle Royal', 0, '2023-02-09 11:30:00', '2023-02-09 11:40:47');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `address`, `zip_code`, `city`, `creation_date`) VALUES
(1, 'baptiste.cornic92@gmail.com', '[]', '$2y$13$nFN7ED/ViQRjEDzqhcYjLe6zLxkMwXeTFc.b8D7SYn0xR/5PQezXy', NULL, NULL, NULL, NULL, NULL, '2023-01-13 14:45:34'),
(2, 'baptiste.cornic@free.fr', '[]', '$2y$13$IB3lQ9Wvrxorgp5zjXv.Ie04ajtq6ofV695BKef5atnoiiastJugW', NULL, NULL, NULL, NULL, NULL, '2023-01-13 14:45:40'),
(3, 'admin@admin.fr', '[\"ROLE_ADMIN\"]', '$2y$13$AOj8hLV71m/bnrMEK5BaN.2KqUijyPbuXFM0i9qiO6YrmWnydKCxK', 'baptiste', 'cornic', '10 chemin de la croix pigoreau', '77123', 'noisy sur ecole', '2023-01-13 14:45:45'),
(5, 'test@fdf', '[]', '$2y$13$8UyN8Ca3tS/T0qlb1mVdzucNSSvu4LilL75hQhfRfPm2rsTSMJA6u', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'dsf@fdsf.fr', '[]', '$2y$13$bbSCODPHOKZBtK0teuBqBuFBVsfV8ywhai7N3gq4E.jdYbcejOv3O', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'test@fdffd', '[]', '$2y$13$eXj4zoMYpmdGBQNKcD3hCu/lq0gGhkkWUDzrS/GCXwNtASvlwZlUa', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'sdq@gr.fr', '[]', '$2y$13$L0K3/HhwU/uB/xW.J8uE3upx6/MSkXgfN0EabgxlfH9AB04/1dHrW', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `FK_2530ADE64584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_2530ADE68D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
