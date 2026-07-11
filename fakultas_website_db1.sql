-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 11 Jul 2026 pada 06.43
-- Versi server: 8.0.40
-- Versi PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fakultas_website`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `mission` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `secondary_image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `subtitle`, `description`, `vision`, `mission`, `image_url`, `video_url`, `video_title`, `video_description`, `is_active`, `created_at`, `updated_at`, `secondary_image_url`) VALUES
(1, 'Tentang Fakultas Pertambangan dan Perminyakan', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Omnis esse eius suscipit accusantium officiis, sapiente fugiat facilis distinctio recusandae, fugit laboriosam, veritatis reprehenderit earum asperiores quibusdam? Similique consequuntur provident ratione.', '<p>FLorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae eveniet modi incidunt, placeat blanditiis odit nam mollitia voluptas delectus praesentium aperiam? Eum voluptates dolorum inventore, quis deserunt quae, fuga cum expedita totam quos repellat culpa iusto. Sit fuga tenetur voluptate excepturi iste nobis possimus repellendus ipsa. Omnis at, molestias perspiciatis ratione impedit ea architecto fuga aperiam perferendis blanditiis possimus nisi similique quasi! Quidem nulla quos a consequuntur, earum culpa provident sint enim officia, et repellat. Excepturi culpa deserunt repudiandae neque dolor impedit harum modi, quam nobis accusantium beatae. Consequuntur magnam dolore sint, eaque dolorum ratione voluptas unde optio incidunt corporis!</p>', 'Menjadi fakultas teknologi informasi terdepan di Asia Tenggara yang menghasilkan lulusan berkualitas tinggi dan berkontribusi pada pengembangan teknologi informasi.', 'Menyelenggarakan pendidikan, penelitian, dan pengabdian masyarakat di bidang teknologi informasi yang inovatif, relevan, dan berkelanjutan untuk memajukan peradaban bangsa.', 'assets/img/about/main_1754122850_688dca625dc60.jpeg', 'https://youtu.be/AaXxzW8RJHU?si=rhIxFfutL67T0GcX', 'Profil Fakultas Teknologi Informasi', 'Tonton video profil lengkap tentang fasilitas, program studi, dan kehidupan kampus di Fakultas Teknologi Informasi', 1, '2025-07-17 09:20:04', '2025-08-02 01:56:11', 'assets/img/about/secondary_1754122850_688dca625dd93.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `academic_periods`
--

CREATE TABLE `academic_periods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int NOT NULL,
  `semester` enum('ganjil','genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `academic_periods`
--

INSERT INTO `academic_periods` (`id`, `name`, `year`, `semester`, `academic_year`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Semester Ganjil 2023/2024', 2023, 'ganjil', '2023/2024', 0, '2023-08-01', '2024-01-31', '2025-08-12 08:56:54', '2025-08-12 08:56:54'),
(2, 'Semester Genap 2023/2024', 2024, 'genap', '2023/2024', 0, '2024-02-01', '2024-07-31', '2025-08-12 08:56:54', '2025-08-12 08:56:54'),
(3, 'Semester Ganjil 2024/2025', 2024, 'ganjil', '2024/2025', 0, '2024-08-01', '2025-01-31', '2025-08-12 08:56:54', '2025-08-12 08:56:54'),
(4, 'Semester Genap 2024/2025', 2025, 'genap', '2024/2025', 1, '2025-02-01', '2025-07-31', '2025-08-12 08:56:54', '2025-08-12 08:56:54'),
(5, 'Semester Ganjil 2025/2026', 2025, 'ganjil', '2025/2026', 0, '2025-08-01', '2026-01-31', '2025-08-12 08:56:54', '2025-08-12 08:56:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('site_setting_contact_email', 's:14:\"info@fti.ac.id\";', 1775704218),
('site_setting_contact_phone', 's:16:\"+62 21 7918 1234\";', 1775704218),
('site_setting_facebook_url', 's:35:\"https://facebook.com/fti.university\";', 1775704218),
('site_setting_instagram_url', 's:36:\"https://instagram.com/fti_university\";', 1775704218),
('site_setting_site_description', 's:52:\"Fakultas Teknik Perminyakan dan Pertambangan - UNIPA\";', 1775704218),
('site_setting_site_logo', 's:46:\"http://localhost:8000/storage//images/logo.png\";', 1775704218),
('site_setting_site_title', 's:4:\"FTPP\";', 1775704218),
('site_setting_theme_color', 's:7:\"#3B82F6\";', 1775704218),
('site_setting_twitter_url', 'N;', 1775704267),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:85:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"manage users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:20:\"manage program-studi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:16:\"manage kurikulum\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:18:\"manage mata-kuliah\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"manage news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:13:\"manage events\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"manage gallery\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:19:\"manage testimonials\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:14:\"manage clients\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"manage teams\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:23:\"manage contact-messages\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"manage settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:10:\"view admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:4;i:2;i:5;i:3;i:6;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:10:\"users.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"roles.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:18:\"users.manage-roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:4;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:10:\"about.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"about.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:10:\"about.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"about.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:19:\"about.toggle-status\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:18:\"program-studi.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:20:\"program-studi.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:18:\"program-studi.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:20:\"program-studi.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:9:\"news.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"news.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:9:\"news.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:11:\"news.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:21:\"contact-messages.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:22:\"contact-messages.reply\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:23:\"contact-messages.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:13:\"settings.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:13:\"settings.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:14:\"kurikulum.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:16:\"kurikulum.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:14:\"kurikulum.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:16:\"kurikulum.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:16:\"mata-kuliah.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:18:\"mata-kuliah.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:16:\"mata-kuliah.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:18:\"mata-kuliah.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:8:\"rps.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:10:\"rps.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:8:\"rps.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:10:\"rps.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:18:\"jadwal-kuliah.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:20:\"jadwal-kuliah.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:18:\"jadwal-kuliah.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:20:\"jadwal-kuliah.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:22:\"dosen-mata-kuliah.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:24:\"dosen-mata-kuliah.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:22:\"dosen-mata-kuliah.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:24:\"dosen-mata-kuliah.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:20:\"penjaminan-mutu.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:22:\"penjaminan-mutu.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:20:\"penjaminan-mutu.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:22:\"penjaminan-mutu.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:24:\"penjaminan-mutu.download\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:18:\"site-settings.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:18:\"site-settings.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:25:\"site-settings.bulk-update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:10:\"stats.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:12:\"stats.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:10:\"stats.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:12:\"stats.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:17:\"stats.set-current\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:9:\"team.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:11:\"team.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:9:\"team.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:11:\"team.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:17:\"team.update-order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:18:\"team-position.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:20:\"team-position.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:18:\"team-position.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:20:\"team-position.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:15:\"parent.view-khs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:6;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:10:\"api.access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:6:\"editor\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"petugas_umum\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:9:\"orang_tua\";s:1:\"c\";s:3:\"web\";}}}', 1764983379);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partnership_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `clients`
--

INSERT INTO `clients` (`id`, `name`, `logo_url`, `website_url`, `partnership_type`, `description`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 'Pertamina', 'assets/img/clients/client1.png', 'https://telkom.co.id', 'Industri Partner', 'Kerjasama dalam program magang dan penelitian telekomunikasi', 1, 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(2, 'BP', 'assets/img/clients/client2.png', 'https://bca.co.id', 'Recruitment Partner', 'Rekrutmen lulusan untuk divisi IT dan digital banking', 1, 2, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(3, 'PT. Freeport Indonesia', 'assets/img/clients/client3.png', 'https://gojek.com', 'Startup Partner', 'Kolaborasi dalam pengembangan teknologi dan inovasi digital', 1, 3, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(4, 'Pertamina', 'assets/img/clients/client1.png', 'https://microsoft.com/id-id', 'Technology Partner', 'Program sertifikasi dan lisensi software untuk pendidikan', 1, 4, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(5, 'BP', 'assets/img/clients/client2.png', 'https://tokopedia.com', 'E-commerce Partner', 'Penelitian bersama dalam bidang e-commerce dan fintech', 1, 5, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(6, 'PT. Freeport Indonesia', 'assets/img/clients/client3.png', 'https://oracle.com/id', 'Database Partner', 'Program pelatihan database dan cloud computing', 1, 6, '2025-07-17 09:20:05', '2025-07-17 09:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact_infos`
--

CREATE TABLE `contact_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('address','phone','email','social_media','fax','website') COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contact_infos`
--

INSERT INTO `contact_infos` (`id`, `type`, `label`, `value`, `icon`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 'address', 'Alamat Kampus', 'Jl. Pendidikan No. 123, Jakarta Selatan 12950, Indonesia', 'map-pin', 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'phone', 'Telepon Utama', '+62 21 7918 1234', 'phone', 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'phone', 'Admisi', '+62 21 7918 1235', 'phone', 1, 2, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'fax', 'Fax', '+62 21 7918 1236', 'printer', 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 'email', 'Email Umum', 'info@fti.ac.id', 'envelope', 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'email', 'Admisi', 'admisi@fti.ac.id', 'envelope', 1, 2, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 'email', 'Akademik', 'akademik@fti.ac.id', 'envelope', 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 'social_media', 'Facebook', 'https://facebook.com/fti.university', 'facebook', 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 'social_media', 'Instagram', 'https://instagram.com/fti_university', 'instagram', 1, 2, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(10, 'social_media', 'YouTube', 'https://youtube.com/@fti-university', 'youtube', 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(11, 'social_media', 'LinkedIn', 'https://linkedin.com/school/fti-university', 'linkedin', 1, 4, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(12, 'website', 'Website Utama', 'https://fti.ac.id', 'globe', 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('unread','read','replied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `read_at` timestamp NULL DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dean_greetings`
--

CREATE TABLE `dean_greetings` (
  `id` bigint UNSIGNED NOT NULL,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sambutan',
  `section_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dekan FTPP UNIPA',
  `greeting_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dean_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dean_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dean_degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dean_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dean_greetings`
--

INSERT INTO `dean_greetings` (`id`, `section_title`, `section_subtitle`, `greeting_text`, `dean_name`, `dean_title`, `dean_degree`, `dean_photo`, `is_active`, `display_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sambutan', 'Dekan FTPP UNIPA', 'Assalamualaikum Warahmatullahi Wabarakatuh, Shalom, Salam Sejahtera bagi kita semua. Puji syukur ke hadirat Tuhan Yang Maha Esa, saya selaku Dekan merasa bangga dan terhormat menyambut seluruh civitas akademika, khususnya para mahasiswa baru, di Fakultas Pertambangan dan Perminyakan (FTPP) Universitas Papua. Kami berkomitmen penuh untuk menjadi lembaga terdepan dalam mencetak sumber daya manusia yang unggul, profesional, dan berintegritas di sektor energi dan mineral, dengan tetap berpijak pada kearifan lokal dan pengelolaan sumber daya alam yang berkelanjutan di Tanah Papua. Oleh karena itu, saya mengajak seluruh mahasiswa untuk belajar dengan giat, dan segenap dosen serta staf untuk terus bersinergi meningkatkan kualitas pendidikan, demi mengukir prestasi bagi kemajuan fakultas, universitas, dan bangsa. Terima kasih.', 'Eko A. Martanto', 'Prof. Dr. Ir.', 'MP', 'assets/img/team1.png', 1, 1, '2025-10-14 20:48:38', '2025-11-01 09:13:14', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `documents`
--

CREATE TABLE `documents` (
  `id` bigint UNSIGNED NOT NULL,
  `program_studi_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `document_type` enum('rps','brosur','peraturan','panduan','profil','other') NOT NULL,
  `file_url` varchar(500) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` bigint UNSIGNED DEFAULT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `order_index` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `documents`
--

INSERT INTO `documents` (`id`, `program_studi_id`, `title`, `description`, `document_type`, `file_url`, `file_name`, `file_size`, `file_type`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(16, 2, 'RPS Matematika Dasar', 'Rencana Pembelajaran Semester untuk mata kuliah Matematika Dasar', 'rps', 'storage/documents/rps/rps-matematika-dasar.pdf', 'rps-matematika-dasar.pdf', 2048000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(17, 2, 'RPS Fisika Dasar', 'Rencana Pembelajaran Semester untuk mata kuliah Fisika Dasar', 'rps', 'storage/documents/rps/rps-fisika-dasar.pdf', 'rps-fisika-dasar.pdf', 1876000, 'application/pdf', 1, 2, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(18, 2, 'RPS Kimia Dasar', 'Rencana Pembelajaran Semester untuk mata kuliah Kimia Dasar', 'rps', 'storage/documents/rps/rps-kimia-dasar.pdf', 'rps-kimia-dasar.pdf', 1654000, 'application/pdf', 1, 3, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(19, 2, 'Brosur Teknik Pertambangan', 'Brosur informasi Program Studi Teknik Pertambangan', 'brosur', 'storage/documents/brosur/brosur-teknik-pertambangan.pdf', 'brosur-teknik-pertambangan.pdf', 5120000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(20, 2, 'Peraturan Akademik FTPP', 'Peraturan akademik Fakultas Teknik Pertambangan Perminyakan', 'peraturan', 'storage/documents/peraturan/peraturan-akademik-ftpp.pdf', 'peraturan-akademik-ftpp.pdf', 3456000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(21, 2, 'Panduan Akademik Mahasiswa', 'Panduan akademik untuk mahasiswa baru dan aktif', 'panduan', 'storage/documents/panduan/panduan-akademik-mahasiswa.pdf', 'panduan-akademik-mahasiswa.pdf', 4200000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(22, 2, 'Profil Lulusan Teknik Pertambangan', 'Profil dan kompetensi lulusan Program Studi Teknik Pertambangan', 'profil', 'storage/documents/profil/profil-lulusan-tp.pdf', 'profil-lulusan-tp.pdf', 1234000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(23, 3, 'RPS Mineralogi', 'Rencana Pembelajaran Semester untuk mata kuliah Mineralogi', 'rps', 'storage/documents/rps/rps-mineralogi.pdf', 'rps-mineralogi.pdf', 1765000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(24, 3, 'RPS Petrologi', 'Rencana Pembelajaran Semester untuk mata kuliah Petrologi', 'rps', 'storage/documents/rps/rps-petrologi.pdf', 'rps-petrologi.pdf', 2100000, 'application/pdf', 1, 2, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(25, 3, 'Brosur Teknik Geologi', 'Brosur informasi Program Studi Teknik Geologi', 'brosur', 'storage/documents/brosur/brosur-teknik-geologi.pdf', 'brosur-teknik-geologi.pdf', 5234000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(26, 3, 'Profil Lulusan Teknik Geologi', 'Profil dan kompetensi lulusan Program Studi Teknik Geologi', 'profil', 'storage/documents/profil/profil-lulusan-tg.pdf', 'profil-lulusan-tg.pdf', 1678000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(31, 6, 'RPS Termodinamika', 'Rencana Pembelajaran Semester untuk mata kuliah Termodinamika', 'rps', 'storage/documents/rps/rps-termodinamika.pdf', 'rps-termodinamika.pdf', 1987000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(32, 6, 'RPS Mekanika Fluida', 'Rencana Pembelajaran Semester untuk mata kuliah Mekanika Fluida', 'rps', 'storage/documents/rps/rps-mekanika-fluida.pdf', 'rps-mekanika-fluida.pdf', 2234000, 'application/pdf', 1, 2, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(33, 6, 'RPS Reservoir Engineering', 'Rencana Pembelajaran Semester untuk mata kuliah Reservoir Engineering', 'rps', 'storage/documents/rps/rps-reservoir-engineering.pdf', 'rps-reservoir-engineering.pdf', 2456000, 'application/pdf', 1, 3, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(34, 6, 'Brosur Teknik Perminyakan', 'Brosur informasi Program Studi Teknik Perminyakan', 'brosur', 'storage/documents/brosur/brosur-teknik-perminyakan.pdf', 'brosur-teknik-perminyakan.pdf', 4890000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15'),
(35, 6, 'Profil Lulusan Teknik Perminyakan', 'Profil dan kompetensi lulusan Program Studi Teknik Perminyakan', 'profil', 'storage/documents/profil/profil-lulusan-tpm.pdf', 'profil-lulusan-tpm.pdf', 1456000, 'application/pdf', 1, 1, '2025-09-07 16:47:15', '2025-09-07 16:47:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen_mata_kuliahs`
--

CREATE TABLE `dosen_mata_kuliahs` (
  `id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `mata_kuliah_id` bigint UNSIGNED NOT NULL,
  `role` enum('koordinator','pengampu','asisten') COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dosen_mata_kuliahs`
--

INSERT INTO `dosen_mata_kuliahs` (`id`, `dosen_id`, `mata_kuliah_id`, `role`, `academic_year`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 24, 'pengampu', '2025/2026', 1, '2025-08-08 08:54:44', '2025-08-08 08:54:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluations`
--

CREATE TABLE `evaluations` (
  `id` bigint UNSIGNED NOT NULL,
  `student_nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questionnaire_id` bigint UNSIGNED NOT NULL,
  `semester_taken` int NOT NULL,
  `lecturer_count` int NOT NULL,
  `lecturer_1_id` bigint UNSIGNED NOT NULL,
  `lecturer_2_id` bigint UNSIGNED DEFAULT NULL,
  `attendance_lecturer_1` enum('0','1-4','5-8','>9') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance_lecturer_2` enum('0','1-4','5-8','>9') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_suggestion` text COLLATE utf8mb4_unicode_ci,
  `suggestion_lecturer_1` text COLLATE utf8mb4_unicode_ci,
  `suggestion_lecturer_2` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `evaluations`
--

INSERT INTO `evaluations` (`id`, `student_nim`, `student_email`, `student_name`, `questionnaire_id`, `semester_taken`, `lecturer_count`, `lecturer_1_id`, `lecturer_2_id`, `attendance_lecturer_1`, `attendance_lecturer_2`, `general_suggestion`, `suggestion_lecturer_1`, `suggestion_lecturer_2`, `submitted_at`, `created_at`, `updated_at`) VALUES
(1, '2025001', 'parent@example.com', 'Test Student', 1, 3, 2, 9, 10, '>9', '>9', NULL, NULL, NULL, '2025-12-04 22:10:55', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(2, '2025001', 'parent@example.com', 'Test Student', 2, 1, 2, 9, 10, '1-4', '1-4', NULL, NULL, NULL, '2025-12-04 19:21:14', '2025-12-04 19:21:14', '2025-12-04 19:21:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluation_answers`
--

CREATE TABLE `evaluation_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `evaluation_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED DEFAULT NULL,
  `answer_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `evaluation_answers`
--

INSERT INTO `evaluation_answers` (`id`, `evaluation_id`, `question_id`, `lecturer_id`, `answer_value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 9, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(2, 1, 1, 10, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(3, 1, 2, 9, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(4, 1, 2, 10, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(5, 1, 3, 9, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(6, 1, 3, 10, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(7, 1, 4, 9, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(8, 1, 4, 10, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(9, 1, 5, 9, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(10, 1, 5, 10, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(11, 1, 6, 9, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(12, 1, 6, 10, '4', '2025-08-31 22:10:55', '2025-08-31 22:10:55'),
(13, 2, 15, 9, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(14, 2, 15, 10, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(15, 2, 16, 9, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(16, 2, 16, 10, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(17, 2, 17, 9, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(18, 2, 17, 10, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(19, 2, 18, 9, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14'),
(20, 2, 18, 10, '4', '2025-12-04 19:21:14', '2025-12-04 19:21:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `organizer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `registration_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `end_date`, `location`, `image_url`, `prodi_id`, `status`, `organizer`, `requirements`, `registration_url`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Tech Conference 2024: Future of AI in Indonesia', '<p>Konferensi teknologi tahunan terbesar di Indonesia yang membahas perkembangan terbaru dalam bidang Artificial Intelligence dan Machine Learning. Acara ini akan menghadirkan keynote speakers dari Google, Microsoft, dan startup teknologi terkemuka.</p>\n\n<p><strong>Agenda Acara:</strong></p>\n<ul>\n<li>09:00 - 10:00: Registration & Welcome Coffee</li>\n<li>10:00 - 11:30: Keynote: \"AI Revolution in Southeast Asia\"</li>\n<li>11:45 - 12:30: Panel Discussion: \"Ethics in AI Development\"</li>\n<li>13:30 - 15:00: Workshop: \"Hands-on Machine Learning\"</li>\n<li>15:15 - 16:30: Startup Pitch Competition</li>\n<li>16:30 - 17:00: Networking Session</li>\n</ul>\n\n<p>Acara ini terbuka untuk mahasiswa, dosen, profesional IT, dan umum.</p>', '2025-08-31 09:00:00', '2025-08-31 17:00:00', 'Auditorium Utama FTI, Lantai 3', 'https://picsum.photos/800/600?random=80', NULL, 'upcoming', 'Fakultas Teknologi Informasi', 'Registrasi wajib melalui website. Mahasiswa aktif mendapat diskon 50%. Bawa laptop untuk workshop.', 'https://event.fti.ac.id/tech-conference-2024', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(2, 'Workshop Web Development dengan React & Next.js', '<p>Workshop intensif selama 2 hari untuk mempelajari pengembangan web modern menggunakan React.js dan Next.js. Workshop ini dirancang untuk mahasiswa yang sudah memiliki dasar HTML, CSS, dan JavaScript.</p>\n\n<p><strong>Materi yang akan dipelajari:</strong></p>\n<ul>\n<li>React Fundamentals: Components, State, Props</li>\n<li>React Hooks: useState, useEffect, useContext</li>\n<li>Next.js: Routing, API Routes, SSR/SSG</li>\n<li>Styling dengan Tailwind CSS</li>\n<li>Deployment ke Vercel</li>\n</ul>\n\n<p>Setiap peserta akan membuat project portfolio website dan e-commerce sederhana.</p>', '2025-08-11 08:00:00', '2025-08-12 16:00:00', 'Lab Programming 1 & 2, Gedung FTI', 'https://picsum.photos/800/600?random=81', NULL, 'upcoming', 'Program Studi Teknik Informatika & React Indonesia Community', 'Mahasiswa TIF semester 3+, menguasai HTML/CSS/JavaScript dasar, membawa laptop dengan specs minimal RAM 8GB', 'https://event.fti.ac.id/react-workshop-2024', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(3, 'Job Fair IT 2024: Career Opportunities in Digital Era', '<p>Job fair khusus untuk mahasiswa dan alumni bidang teknologi informasi. Acara ini menghadirkan 50+ perusahaan teknologi terkemuka yang membuka lowongan untuk fresh graduate dan experienced professionals.</p>\n\n<p><strong>Perusahaan yang berpartisipasi:</strong></p>\n<ul>\n<li>Unicorn Companies: Gojek, Tokopedia, Bukalapak, Traveloka</li>\n<li>Tech Giants: Google Indonesia, Microsoft Indonesia, Amazon</li>\n<li>Banks: BCA, Mandiri, BNI Digital</li>\n<li>Startups: Xendit, Midtrans, Halodoc, Ruangguru</li>\n<li>Consulting: Accenture, Deloitte, EY Digital</li>\n</ul>\n\n<p>Selain job fair, akan ada talk show \"Career Path in Tech Industry\" dan workshop \"Resume & Interview Tips\".</p>', '2025-08-16 09:00:00', '2025-08-16 16:00:00', 'Exhibition Hall FTI & Virtual Platform', 'https://picsum.photos/800/600?random=82', NULL, 'upcoming', 'Career Development Center FTI', 'Mahasiswa semester 6+, alumni, atau professional. Bawa CV dalam bahasa Indonesia dan Inggris. Dress code: business casual.', 'https://jobfair.fti.ac.id/2024', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(4, 'Seminar Nasional: \"Cybersecurity in the Age of IoT\"', '<p>Seminar nasional yang membahas tantangan keamanan siber di era Internet of Things (IoT). Menghadirkan praktisi keamanan siber dari dalam dan luar negeri.</p>\n\n<p><strong>Pembicara:</strong></p>\n<ul>\n<li>Dr. Ahmad Zaki (Cybersecurity Expert, BSSN)</li>\n<li>Sarah Chen (Security Architect, Singapore GovTech)</li>\n<li>Prof. Budi Rahardjo (ITB)</li>\n<li>Remy Phan (Penetration Tester, DEFCON Speaker)</li>\n</ul>\n\n<p>Seminar ini diakui oleh BNSP sebagai kegiatan CPD untuk sertifikasi cybersecurity.</p>', '2025-08-06 13:00:00', '2025-08-06 17:00:00', 'Auditorium FTI + Live Streaming YouTube', 'https://picsum.photos/800/600?random=83', NULL, 'upcoming', 'Program Studi Teknik Informatika & ID-SIRTII', 'Mahasiswa, dosen, profesional IT. Sertifikat 4 SKP untuk yang hadir penuh.', 'https://seminar.fti.ac.id/cybersecurity-iot', 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(5, 'Hackathon FTI 2024: Smart City Solutions', '<p>Kompetisi hackathon 48 jam untuk mengembangkan solusi smart city. Peserta akan berkompetisi untuk menciptakan aplikasi yang dapat menyelesaikan masalah urban seperti traffic management, waste management, atau energy efficiency.</p>\n\n<p><strong>Hadiah:</strong></p>\n<ul>\n<li>Juara 1: Rp 15.000.000 + Inkubasi Startup</li>\n<li>Juara 2: Rp 10.000.000</li>\n<li>Juara 3: Rp 5.000.000</li>\n<li>Best UI/UX: Rp 2.500.000</li>\n<li>Most Innovative: Rp 2.500.000</li>\n</ul>\n\n<p>Semua peserta mendapat sertifikat, merchandise, dan akses ke mentor dari industry.</p>', '2025-08-21 18:00:00', '2025-08-23 16:00:00', 'Innovation Lab FTI (24/7 Access)', 'https://picsum.photos/800/600?random=84', NULL, 'upcoming', 'Himpunan Mahasiswa FTI & Google Developer Student Club', 'Tim 3-5 orang, minimal 1 mahasiswa FTI per tim. Bawa laptop, charger, sleeping bag optional 😄', 'https://hackathon.fti.ac.id/2024', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(6, 'Guest Lecture: \"Data Science Applications in Banking\"', '<p>Kuliah tamu dengan tema penerapan data science di industri perbankan. Pembicara: Dr. Andi Susanto, Senior Data Scientist dari Bank Central Asia (BCA).</p>\n\n<p>Topik yang dibahas meliputi credit scoring, fraud detection, customer segmentation, dan risk management menggunakan machine learning.</p>', '2025-07-02 10:00:00', '2025-07-02 12:00:00', 'Ruang Kelas SI-201', 'https://picsum.photos/800/600?random=85', 2, 'completed', 'Program Studi Sistem Informasi', 'Mahasiswa SIF yang mengambil mata kuliah Data Mining atau Business Intelligence', NULL, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(7, 'Workshop Mobile App Development dengan Flutter', '<p>Workshop pengembangan aplikasi mobile cross-platform menggunakan Flutter. Peserta belajar membuat aplikasi mobile dari basic hingga publish ke Play Store.</p>\n\n<p>Setiap peserta berhasil membuat dan publish 1 aplikasi mobile sederhana.</p>', '2025-06-17 08:00:00', '2025-06-18 16:00:00', 'Lab Mobile Development', 'https://picsum.photos/800/600?random=86', NULL, 'completed', 'Program Studi Teknik Informatika & Flutter Indonesia', 'Mahasiswa TIF dengan basic programming knowledge', NULL, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(8, 'Open House FTI 2024: \"Discover Your Tech Future\"', '<p>Acara open house tahunan untuk calon mahasiswa baru dan orang tua. Acara meliputi tour fasilitas, presentasi program studi, demo project mahasiswa, dan talkshow dengan alumni sukses.</p>\n\n<p>Acara dihadiri oleh 500+ calon mahasiswa dan orang tua dari seluruh Indonesia.</p>', '2025-05-18 08:00:00', '2025-05-18 15:00:00', 'Seluruh Area Fakultas Teknologi Informasi', 'https://picsum.photos/800/600?random=87', NULL, 'completed', 'Panitia Penerimaan Mahasiswa Baru FTI', 'Siswa SMA/SMK kelas 11-12 dan orang tua', NULL, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(9, 'Kompetisi UI/UX Design Championship 2024', '<p>Kompetisi desain UI/UX tingkat nasional untuk mahasiswa. Tema tahun ini: \"Designing Inclusive Digital Experiences\". Peserta berkompetisi merancang aplikasi yang accessibility-friendly.</p>\n\n<p>Kompetisi diikuti 150 tim dari 50 universitas se-Indonesia.</p>', '2025-06-02 08:00:00', '2025-06-04 18:00:00', 'Design Lab FTI & Online Platform', 'https://picsum.photos/800/600?random=88', NULL, 'completed', 'Himpunan Mahasiswa Teknik Informatika & UXID', 'Mahasiswa aktif S1/D3, tim 2-3 orang', NULL, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(10, 'Webinar Series: \"Women in Tech Leadership\"', '<p>Seri webinar yang menghadirkan women leaders di industri teknologi untuk berbagi inspirasi dan tips berkarir di bidang teknologi.</p>\n\n<p>Pembicara: CEO Kata.ai, CTO Bukalapak, VP Engineering Gojek, dan lainnya.</p>', '2025-06-27 19:00:00', '2025-06-27 21:00:00', 'Virtual Event (Zoom + YouTube Live)', 'https://picsum.photos/800/600?random=89', NULL, 'completed', 'Women in Tech Indonesia x FTI', 'Terbuka untuk umum, khususnya mahasiswi dan women professionals', NULL, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(11, 'Monthly Tech Talk: \"Microservices Architecture\"', '<p>Tech talk bulanan dengan topik arsitektur microservices. Pembahasan meliputi design patterns, deployment strategies, dan monitoring.</p>', '2025-07-27 15:00:00', '2025-07-27 17:00:00', 'Auditorium FTI', 'https://picsum.photos/800/600?random=90', NULL, 'upcoming', 'Tech Community FTI', 'Basic understanding of software architecture', 'https://techtalk.fti.ac.id/microservices', 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(12, 'Study Visit to AWS Indonesia Office', '<p>Kunjungan studi ke kantor AWS Indonesia untuk melihat langsung infrastruktur cloud computing dan berinteraksi dengan cloud engineers.</p>', '2025-09-05 09:00:00', '2025-09-05 15:00:00', 'AWS Indonesia Office, Menara BCA', 'https://picsum.photos/800/600?random=91', 3, 'upcoming', 'Program Studi Teknologi Informasi', 'Mahasiswa TI semester 4+, kuota terbatas 30 orang', 'https://studyvisit.fti.ac.id/aws', 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` json DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `slug`, `description`, `short_description`, `image`, `gallery`, `location`, `capacity`, `area`, `features`, `contact_person`, `contact_phone`, `contact_email`, `is_available`, `is_active`, `display_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Laboratorium Teknologi Pangan', 'laboratorium-teknologi-pangan', 'Laboratorium lengkap untuk praktikum teknologi pangan dengan peralatan modern dan standar industri. Dilengkapi dengan berbagai instrumen analisis kimia, mikrobiologi, dan pengujian sensori.', 'Lab modern untuk praktikum teknologi pangan', 'assets/img/fasilitas/tambang.jpg', NULL, 'Gedung A, Lantai 2', '40 mahasiswa', '150 m²', '[\"Peralatan analisis kimia lengkap\", \"Inkubator mikrobiologi\", \"Alat pengujian sensori\", \"AC dan ventilasi baik\", \"Safety equipment lengkap\"]', 'Dr. Ahmad Fauzi', '0274-1234567', 'labpangan@unipa.ac.id', 1, 1, 1, '2025-10-22 03:26:24', '2025-10-22 03:26:24', NULL),
(2, 'Perpustakaan Fakultas', 'perpustakaan-fakultas', 'Perpustakaan fakultas dengan koleksi buku, jurnal, dan referensi terkini di bidang teknologi pertanian dan pangan. Menyediakan ruang baca yang nyaman dengan akses internet gratis.', 'Perpustakaan dengan koleksi lengkap', 'assets/img/fasilitas/perpus-001.jpg', NULL, 'Gedung B, Lantai 1', '100 orang', '300 m²', '[\"Koleksi buku 5000+ judul\", \"Akses jurnal internasional\", \"WiFi gratis\", \"Ruang baca ber-AC\", \"Area diskusi kelompok\"]', 'Dra. Siti Nurjanah', '0274-1234568', 'perpus@unipa.ac.id', 1, 1, 2, '2025-10-22 03:26:24', '2025-10-22 03:26:24', NULL),
(3, 'Greenhouse', 'greenhouse', 'Greenhouse untuk penelitian dan praktikum budidaya tanaman dengan sistem kontrol iklim otomatis. Cocok untuk penelitian pertanian dan hortikultura.', 'Fasilitas budidaya tanaman modern', 'assets/img/fasilitas/greenhouse.png', NULL, 'Area Belakang Kampus', '30 mahasiswa', '500 m²', '[\"Sistem irigasi otomatis\", \"Kontrol suhu dan kelembaban\", \"Media tanam steril\", \"Sistem pencahayaan\", \"Area pembibitan\"]', 'Ir. Budi Santoso, M.Si', '0274-1234569', 'greenhouse@unipa.ac.id', 1, 1, 3, '2025-10-22 03:26:24', '2025-10-22 03:26:24', NULL),
(4, 'Aula Serbaguna', 'aula-serbaguna', 'Ruang aula yang dapat digunakan untuk berbagai kegiatan seperti seminar, workshop, wisuda, dan acara kemahasiswaan lainnya. Dilengkapi dengan sound system dan proyektor.', 'Aula untuk berbagai acara', 'assets/img/fasilitas/aula.jpg', NULL, 'Gedung C, Lantai 1', '500 orang', '600 m²', '[\"Sound system profesional\", \"Proyektor HD\", \"AC central\", \"Panggung dan backdrop\", \"Kursi auditorium\"]', 'Drs. Eko Prasetyo', '0274-1234570', 'aula@unipa.ac.id', 1, 1, 4, '2025-10-22 03:26:24', '2025-10-22 03:26:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `features`
--

CREATE TABLE `features` (
  `id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `features`
--

INSERT INTO `features` (`id`, `prodi_id`, `title`, `description`, `icon`, `image_url`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(4, 2, 'Business Intelligence Lab', 'Laboratorium khusus untuk analisis data bisnis', 'chart-bar', NULL, 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 2, 'Enterprise Systems', 'Pembelajaran sistem enterprise seperti SAP dan Oracle', 'building-office', NULL, 1, 2, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 2, 'Project Management', 'Pelatihan manajemen proyek IT dengan metodologi Agile', 'clipboard-document-list', NULL, 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 3, 'Praktikum Intensif', '70% praktikum dan 30% teori untuk kesiapan kerja', 'wrench-screwdriver', NULL, 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 3, 'Magang Industri', 'Program magang wajib di perusahaan teknologi', 'building-office-2', NULL, 1, 2, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 3, 'Sertifikasi Vendor', 'Pelatihan sertifikasi Cisco, Microsoft, dan lainnya', 'shield-check', NULL, 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `prodi_id` bigint UNSIGNED DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image_url`, `caption`, `category`, `prodi_id`, `event_date`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 'Wisuda Sarjana Teknik Informatika 2024', 'https://picsum.photos/800/600?random=50', 'Acara wisuda sarjana periode I tahun 2024 yang dihadiri oleh 150 lulusan', 'wisuda', NULL, '2024-03-15', 1, 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(2, 'Laboratorium Programming Baru', 'https://picsum.photos/800/600?random=51', 'Fasilitas laboratorium programming dengan 50 komputer terbaru', 'fasilitas', NULL, '2024-02-01', 1, 2, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(3, 'Seminar Teknologi AI dan Machine Learning', 'https://picsum.photos/800/600?random=52', 'Seminar nasional tentang perkembangan AI yang dihadiri 300 peserta', 'seminar', NULL, '2024-01-20', 1, 3, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(4, 'Praktikum Database Management', 'https://picsum.photos/800/600?random=53', 'Mahasiswa Sistem Informasi sedang praktikum database management', 'akademik', 2, '2024-01-10', 1, 4, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(5, 'Kunjungan Industri ke Google Indonesia', 'https://picsum.photos/800/600?random=54', 'Mahasiswa mengunjungi kantor Google Indonesia untuk industrial visit', 'kunjungan', NULL, '2023-12-15', 1, 5, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(6, 'Hackathon FTI 2023', 'https://picsum.photos/800/600?random=55', 'Kompetisi hackathon internal yang diikuti 20 tim mahasiswa', 'kompetisi', NULL, '2023-11-25', 1, 6, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(7, 'Pameran Tugas Akhir Mahasiswa', 'https://picsum.photos/800/600?random=56', 'Pameran hasil tugas akhir mahasiswa semester genap 2023', 'pameran', NULL, '2023-11-10', 1, 7, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(8, 'Workshop Cloud Computing dengan AWS', 'https://picsum.photos/800/600?random=57', 'Workshop praktis penggunaan Amazon Web Services untuk mahasiswa', 'workshop', 3, '2023-10-20', 1, 8, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(9, 'Kegiatan 9: Et sit culpa.', 'https://picsum.photos/800/600?random=60', 'Et amet rem veniam earum et cupiditate fugit. Quas tempore et vel aliquid quasi qui est.', 'kegiatan', 2, '2023-08-07', 1, 10, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(10, 'Kegiatan 10: Odit facilis recusandae fuga.', 'https://picsum.photos/800/600?random=61', 'Eum quisquam repellat eius ut.', 'kompetisi', 3, '2025-04-17', 1, 11, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(11, 'Kegiatan 11: Voluptate aliquid aut qui facilis recusandae.', 'https://picsum.photos/800/600?random=62', 'Occaecati aut eligendi ex quos.', 'kegiatan', NULL, '2023-11-20', 1, 12, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(12, 'Kegiatan 12: Modi ab esse veritatis.', 'https://picsum.photos/800/600?random=63', 'Vel officiis enim aut cum qui.', 'fasilitas', NULL, '2024-09-06', 1, 13, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(13, 'Kegiatan 13: Necessitatibus animi asperiores unde non quod.', 'https://picsum.photos/800/600?random=64', 'Tenetur hic a earum debitis id.', 'kompetisi', NULL, '2024-08-25', 1, 14, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(14, 'Kegiatan 14: Exercitationem fuga ea.', 'https://picsum.photos/800/600?random=65', 'Culpa omnis officiis cupiditate corporis. Recusandae quae repudiandae rem quasi tenetur.', 'kompetisi', 3, '2025-06-21', 1, 15, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(15, 'Kegiatan 15: Nemo quis fugiat consequuntur.', 'https://picsum.photos/800/600?random=66', 'Quasi quia ratione quas omnis atque. Dolores fugiat voluptatem quam quia et et sapiente id.', 'kegiatan', NULL, '2024-12-28', 1, 16, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(16, 'Kegiatan 16: Quas ipsa officia voluptatum ut.', 'https://picsum.photos/800/600?random=67', 'Blanditiis qui laborum facere sint fugiat. Eius ipsa qui eaque voluptas ex voluptas qui aut.', 'akademik', NULL, '2023-11-02', 1, 17, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(17, 'Kegiatan 17: Aut et odio.', 'https://picsum.photos/800/600?random=68', 'Molestiae vitae aliquam qui est quam illo deserunt rem.', 'kegiatan', 2, '2023-10-06', 1, 18, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(18, 'Kegiatan 18: Enim voluptatem vitae magni quibusdam repellendus.', 'https://picsum.photos/800/600?random=69', 'Laboriosam animi nesciunt quia est quidem nesciunt.', 'fasilitas', NULL, '2023-12-21', 1, 19, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(19, 'Kegiatan 19: Beatae voluptates cupiditate dignissimos ut.', 'https://picsum.photos/800/600?random=70', 'Qui magni enim fugit tempora sunt aut consectetur ducimus. Vel voluptatem aut pariatur possimus voluptate eos nam et.', 'kompetisi', 2, '2023-08-11', 1, 20, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(20, 'Kegiatan 20: Amet qui dolore est aperiam error.', 'https://picsum.photos/800/600?random=71', 'Impedit id voluptatum fuga. Amet voluptatem iure eveniet ut.', 'kompetisi', 2, '2023-07-24', 1, 21, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(21, 'Kegiatan 21: Ut facilis qui dignissimos quaerat dolorum.', 'https://picsum.photos/800/600?random=72', 'Et animi qui sequi dicta et aperiam. Sit sint quaerat sequi adipisci delectus distinctio quidem.', 'kompetisi', 3, '2024-07-06', 1, 22, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(22, 'Kegiatan 22: Hic neque facilis sunt voluptas.', 'https://picsum.photos/800/600?random=73', 'Ex atque aut recusandae qui veniam qui corporis. Tenetur id maiores iusto id pariatur.', 'seminar', NULL, '2024-06-19', 1, 23, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(23, 'Kegiatan 23: Non repudiandae nam quis.', 'https://picsum.photos/800/600?random=74', 'Voluptas pariatur magni odit nulla esse et vel.', 'akademik', 2, '2024-09-02', 1, 24, '2025-07-17 09:20:05', '2025-07-17 09:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gdrive_folders`
--

CREATE TABLE `gdrive_folders` (
  `id` bigint UNSIGNED NOT NULL,
  `folder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gdrive_folder_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_folder_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_type` enum('root','academic_year','semester','program_studi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_period_id` bigint UNSIGNED DEFAULT NULL,
  `program_studi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_dokumen_spmi`
--

CREATE TABLE `gpm_dokumen_spmi` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` enum('standar','manual','formulir','sop') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standar',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint NOT NULL DEFAULT '0',
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pdf',
  `document_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '1.0',
  `published_date` date DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `download_count` int NOT NULL DEFAULT '0',
  `view_count` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gpm_dokumen_spmi`
--

INSERT INTO `gpm_dokumen_spmi` (`id`, `title`, `slug`, `description`, `category`, `file_path`, `file_name`, `file_size`, `file_type`, `document_code`, `version`, `published_date`, `effective_date`, `review_date`, `download_count`, `view_count`, `is_published`, `published_at`, `uploaded_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test', 'test', 'Test', 'standar', 'storage/assets/gpm/dokumen/1770134173_irregular-verbs.pdf', 'Irregular Verbs.pdf', 32318, 'pdf', 'Test', '1.0', NULL, NULL, NULL, 0, 0, 1, '2026-02-03 08:56:13', 13, '2026-02-03 08:56:13', '2026-02-03 08:56:13', NULL),
(2, 'Test123', 'test123', 'Test123', 'standar', 'storage/assets/gpm/dokumen/1770134443_irregular-verbs.pdf', 'Irregular Verbs.pdf', 32318, 'pdf', 'Test123', '1.0', NULL, NULL, NULL, 0, 1, 0, '2026-02-03 09:00:43', 13, '2026-02-03 09:00:43', '2026-02-05 07:14:45', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_edom_periods`
--

CREATE TABLE `gpm_edom_periods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('ganjil','genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `require_all_courses` tinyint(1) NOT NULL DEFAULT '1',
  `show_results_to_students` tinyint(1) NOT NULL DEFAULT '0',
  `total_students` int NOT NULL DEFAULT '0',
  `total_lecturers` int NOT NULL DEFAULT '0',
  `total_courses` int NOT NULL DEFAULT '0',
  `total_submissions` int NOT NULL DEFAULT '0',
  `completion_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gpm_edom_periods`
--

INSERT INTO `gpm_edom_periods` (`id`, `name`, `semester`, `academic_year`, `start_date`, `end_date`, `description`, `instructions`, `is_active`, `is_published`, `require_all_courses`, `show_results_to_students`, `total_students`, `total_lecturers`, `total_courses`, `total_submissions`, `completion_percentage`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'EDOM Ganjil 2025/2026', 'ganjil', '2025/2026', '2026-02-05', '2026-02-19', 'EDOM Ganjil 2025/2026', NULL, 1, 0, 1, 0, 0, 0, 0, 0, 0.00, 13, '2026-02-05 07:27:07', '2026-02-05 07:27:07', NULL),
(2, 'EDOM Genap 2026/2027', 'genap', '2026/2027', '2026-02-12', '2026-02-19', 'EDOM Genap 2026/2027', NULL, 1, 0, 1, 0, 0, 0, 0, 0, 0.00, 13, '2026-02-05 07:43:05', '2026-02-05 07:43:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_edom_questions`
--

CREATE TABLE `gpm_edom_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `category` enum('penguasaan_materi','metode_pengajaran','interaksi','penilaian','kedisiplinan','komunikasi','motivasi','umum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `type` enum('rating','yes_no','text','textarea') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rating',
  `rating_min` int DEFAULT '1',
  `rating_max` int DEFAULT '5',
  `rating_min_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_max_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gpm_edom_questions`
--

INSERT INTO `gpm_edom_questions` (`id`, `question`, `help_text`, `category`, `type`, `rating_min`, `rating_max`, `rating_min_label`, `rating_max_label`, `is_required`, `order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 'Dosen menguasai materi yang diajarkan dengan baik', 'Nilai kemampuan dosen dalam menguasai materi perkuliahan', 'penguasaan_materi', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 1, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(20, 'Dosen mampu menjelaskan materi dengan jelas dan sistematis', NULL, 'penguasaan_materi', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 2, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(21, 'Dosen memberikan contoh-contoh yang relevan dengan materi', NULL, 'penguasaan_materi', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 3, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(22, 'Metode pengajaran yang digunakan dosen memudahkan pemahaman materi', 'Nilai efektivitas metode pengajaran dosen', 'metode_pengajaran', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 4, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(23, 'Dosen menggunakan media pembelajaran yang membantu pemahaman', 'Contoh: PPT, video, simulasi, dll', 'metode_pengajaran', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 5, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(24, 'Dosen memberikan kesempatan mahasiswa untuk berdiskusi dan bertanya', NULL, 'metode_pengajaran', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 6, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(25, 'Dosen bersikap ramah dan mudah dihubungi', 'Nilai keterbukaan dan aksesibilitas dosen', 'interaksi', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 7, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(26, 'Dosen memberikan respon yang baik terhadap pertanyaan mahasiswa', NULL, 'interaksi', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 8, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(27, 'Dosen memotivasi mahasiswa untuk aktif dalam pembelajaran', NULL, 'interaksi', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 9, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(28, 'Sistem penilaian yang diterapkan dosen adil dan transparan', 'Nilai kejelasan kriteria dan proses penilaian', 'penilaian', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 10, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(29, 'Dosen memberikan feedback yang konstruktif terhadap tugas/ujian', NULL, 'penilaian', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 11, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(30, 'Dosen mengembalikan hasil penilaian tepat waktu', NULL, 'penilaian', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 12, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(31, 'Dosen hadir tepat waktu dalam perkuliahan', 'Nilai ketepatan waktu dosen', 'kedisiplinan', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 13, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(32, 'Dosen menyelesaikan materi sesuai dengan RPS yang telah ditetapkan', 'RPS = Rencana Pembelajaran Semester', 'kedisiplinan', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 14, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(33, 'Dosen memberikan kompensasi jika tidak dapat hadir mengajar', NULL, 'kedisiplinan', 'rating', 1, 5, 'Sangat Tidak Setuju', 'Sangat Setuju', 1, 15, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(34, 'Hal positif apa yang Anda rasakan dari pembelajaran dengan dosen ini?', 'Berikan feedback positif yang konstruktif', 'umum', 'textarea', NULL, NULL, NULL, NULL, 0, 16, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(35, 'Apa saran Anda untuk perbaikan proses pembelajaran dengan dosen ini?', 'Berikan saran yang konstruktif untuk perbaikan', 'umum', 'textarea', NULL, NULL, NULL, NULL, 0, 17, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL),
(36, 'Secara keseluruhan, bagaimana penilaian Anda terhadap dosen ini?', 'Berikan penilaian keseluruhan', 'umum', 'rating', 1, 5, 'Sangat Tidak Puas', 'Sangat Puas', 1, 18, 1, '2026-02-02 23:35:53', '2026-02-02 23:35:53', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_edom_submissions`
--

CREATE TABLE `gpm_edom_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `period_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sks` int DEFAULT NULL,
  `evaluation_data` json NOT NULL,
  `total_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `average_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_questions_answered` int NOT NULL DEFAULT '0',
  `category_scores` json DEFAULT NULL,
  `suggestions` text COLLATE utf8mb4_unicode_ci,
  `positive_feedback` text COLLATE utf8mb4_unicode_ci,
  `improvement_areas` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_settings`
--

CREATE TABLE `gpm_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gpm_settings`
--

INSERT INTO `gpm_settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 'edom_auto_close', 'true', 'boolean', 'edom', 'Auto Close EDOM Period', 'Automatically close EDOM period after end date', 0, '2026-02-02 23:33:53', '2026-02-02 23:33:53'),
(2, 'survey_require_login', 'false', 'boolean', 'survey', 'Require Login for Surveys', 'Require users to login before filling surveys', 0, '2026-02-02 23:33:53', '2026-02-02 23:33:53'),
(3, 'dokumen_max_size', '10240', 'integer', 'dokumen', 'Maximum Document Size (KB)', 'Maximum file size for document upload', 0, '2026-02-02 23:33:53', '2026-02-02 23:33:53'),
(4, 'gpm_contact_email', 'gpm@ftpp.unipa.ac.id', 'string', 'general', 'GPM Contact Email', 'Email contact for GPM inquiries', 1, '2026-02-02 23:33:53', '2026-02-02 23:33:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_struktur_organisasi`
--

CREATE TABLE `gpm_struktur_organisasi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tugas_fungsi` text COLLATE utf8mb4_unicode_ci,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gpm_struktur_organisasi`
--

INSERT INTO `gpm_struktur_organisasi` (`id`, `nama`, `nip`, `jabatan`, `email`, `phone`, `photo`, `tugas_fungsi`, `bio`, `order`, `is_active`, `is_featured`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mozes Sapari', '098765431234567890', 'Ketua GPM', 'mozessapari@unipa.ac.id', '0987654321234567', 'storage/assets/gpm/struktur/1770131805_newmjr.jpeg', 'Hahahahah', '404', 1, 1, 1, '2026-02-03 08:16:45', '2026-02-03 08:16:45', NULL),
(2, 'asdasdaaa', '123123123', '123123', 'ahmad@unipa.ac.id', '123123123123', NULL, '1231231', '123123', 2, 1, 0, '2026-02-03 08:26:43', '2026-02-03 08:44:27', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_surveys`
--

CREATE TABLE `gpm_surveys` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `introduction` text COLLATE utf8mb4_unicode_ci,
  `closing_message` text COLLATE utf8mb4_unicode_ci,
  `target_respondent` enum('mahasiswa','dosen','alumni','stakeholder') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '1',
  `allow_multiple_responses` tinyint(1) NOT NULL DEFAULT '0',
  `show_results` tinyint(1) NOT NULL DEFAULT '0',
  `require_login` tinyint(1) NOT NULL DEFAULT '0',
  `target_responses` int DEFAULT NULL,
  `total_responses` int NOT NULL DEFAULT '0',
  `total_questions` int NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gpm_surveys`
--

INSERT INTO `gpm_surveys` (`id`, `title`, `slug`, `description`, `introduction`, `closing_message`, `target_respondent`, `start_date`, `end_date`, `is_active`, `is_anonymous`, `allow_multiple_responses`, `show_results`, `require_login`, `target_responses`, `total_responses`, `total_questions`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test asdasda123', 'test-asdasda123', 'Test asdasda', NULL, NULL, 'mahasiswa', '2026-02-04', '2026-02-05', 1, 1, 0, 0, 0, NULL, 0, 0, 13, '2026-02-03 09:57:11', '2026-02-03 09:57:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_survey_questions`
--

CREATE TABLE `gpm_survey_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `survey_id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `type` enum('text','textarea','rating','multiple_choice','checkbox','yes_no','scale','dropdown') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `options` json DEFAULT NULL,
  `rating_min` int DEFAULT '1',
  `rating_max` int DEFAULT '5',
  `rating_min_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_max_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `min_length` int DEFAULT NULL,
  `max_length` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpm_survey_responses`
--

CREATE TABLE `gpm_survey_responses` (
  `id` bigint UNSIGNED NOT NULL,
  `survey_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `respondent_identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respondent_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respondent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `answer_data` json DEFAULT NULL,
  `rating_value` int DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hero_sections`
--

CREATE TABLE `hero_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `background_video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `explanation_video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hero_sections`
--

INSERT INTO `hero_sections` (`id`, `title`, `subtitle`, `background_video_url`, `explanation_video_url`, `background_image_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fakultas Teknik Pertambangan dan Perminyakan', 'Website Resmi Fakultas Teknik Pertambangan dan Perminyakan Universitas Papua', 'https://www.youtube.com/embed/Mx2gyJZWw_c?si=NGRY9DYgKuUBROS7', 'https://www.youtube.com/watch?v=Mx2gyJZWw_c', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&h=1080&fit=crop', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kuliahs`
--

CREATE TABLE `jadwal_kuliahs` (
  `id` bigint UNSIGNED NOT NULL,
  `mata_kuliah_id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `academic_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('ganjil','genap','pendek') COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` enum('senin','selasa','rabu','kamis','jumat','sabtu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL DEFAULT '0',
  `enrolled_students` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_kuliahs`
--

INSERT INTO `jadwal_kuliahs` (`id`, `mata_kuliah_id`, `dosen_id`, `academic_year`, `semester`, `class_name`, `day`, `start_time`, `end_time`, `room`, `capacity`, `enrolled_students`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 24, 1, '2025/2026', 'ganjil', 'A, B', 'senin', '08:00:00', '10:30:00', 'Ruangan 101', 20, 18, 1, '2025-08-08 08:57:30', '2025-08-08 08:57:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `khs_access_logs`
--

CREATE TABLE `khs_access_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `khs_file_id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `access_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'view',
  `accessed_at` timestamp NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `khs_access_logs`
--

INSERT INTO `khs_access_logs` (`id`, `khs_file_id`, `parent_id`, `access_type`, `accessed_at`, `user_agent`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 5, 4, 'download', '2025-11-01 09:09:11', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '127.0.0.1', '2025-11-01 09:09:11', '2025-11-01 09:09:11'),
(2, 5, 4, 'view', '2025-11-01 09:09:46', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '127.0.0.1', '2025-11-01 09:09:46', '2025-11-01 09:09:46'),
(3, 5, 4, 'view', '2025-11-01 11:25:09', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '127.0.0.1', '2025-11-01 11:25:09', '2025-11-01 11:25:09'),
(4, 5, 4, 'view', '2025-12-04 18:10:33', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '192.168.65.1', '2025-12-04 18:10:33', '2025-12-04 18:10:33'),
(5, 5, 4, 'view', '2025-12-04 18:46:43', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '192.168.65.1', '2025-12-04 18:46:43', '2025-12-04 18:46:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `khs_files`
--

CREATE TABLE `khs_files` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `academic_period_id` bigint UNSIGNED NOT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL DEFAULT '0',
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'application/pdf',
  `gdrive_file_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gdrive_folder_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gdrive_url` text COLLATE utf8mb4_unicode_ci,
  `gdrive_download_url` text COLLATE utf8mb4_unicode_ci,
  `upload_status` enum('uploading','ready','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uploading',
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_accessed_at` timestamp NULL DEFAULT NULL,
  `access_count` int NOT NULL DEFAULT '0',
  `semester_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_nim` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `khs_files`
--

INSERT INTO `khs_files` (`id`, `student_id`, `academic_period_id`, `original_filename`, `file_size`, `mime_type`, `gdrive_file_id`, `gdrive_folder_id`, `gdrive_url`, `gdrive_download_url`, `upload_status`, `uploaded_by`, `upload_date`, `last_accessed_at`, `access_count`, `semester_name`, `student_nim`, `student_name`, `created_at`, `updated_at`) VALUES
(5, 3, 4, 'KHS-Genap24-25-MozesMarkusSapari-.pdf', 67872, 'application/pdf', '1h2GIuYzQMW4iadfUn9qdGf3dNxkoqWZa', NULL, 'https://drive.google.com/file/d/1h2GIuYzQMW4iadfUn9qdGf3dNxkoqWZa/view?usp=drivesdk', 'https://drive.google.com/uc?id=1h2GIuYzQMW4iadfUn9qdGf3dNxkoqWZa&export=download', 'ready', 13, '2025-08-18 04:02:16', '2025-12-04 18:46:43', 8, 'Semester Genap 2024/2025', '2025001', 'Test Student', '2025-08-18 04:02:16', '2025-12-04 18:46:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kurikulums`
--

CREATE TABLE `kurikulums` (
  `id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_credits` int NOT NULL,
  `document_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kurikulums`
--

INSERT INTO `kurikulums` (`id`, `prodi_id`, `name`, `academic_year`, `total_credits`, `document_url`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 2, 'Kurikulum Sistem Informasi 2024', '2024/2025', 144, '/documents/kurikulum-sif-2024.pdf', 'Kurikulum terbaru yang disesuaikan dengan kebutuhan industri dan perkembangan teknologi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 2, 'Kurikulum Sistem Informasi 2020', '2020/2021', 140, '/documents/kurikulum-sif-2020.pdf', 'Kurikulum periode 2020-2024', 0, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 3, 'Kurikulum Teknologi Informasi 2024', '2024/2025', 110, '/documents/kurikulum-ti-2024.pdf', 'Kurikulum terbaru yang disesuaikan dengan kebutuhan industri dan perkembangan teknologi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 3, 'Kurikulum Teknologi Informasi 2020', '2020/2021', 108, '/documents/kurikulum-ti-2020.pdf', 'Kurikulum periode 2020-2024', 0, '2025-07-17 09:20:04', '2025-07-17 09:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_kuliahs`
--

CREATE TABLE `mata_kuliahs` (
  `id` bigint UNSIGNED NOT NULL,
  `kurikulum_id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credits` int NOT NULL,
  `semester` int NOT NULL,
  `category` enum('wajib','pilihan','mkdu','mkk','mkb','mbb') COLLATE utf8mb4_unicode_ci NOT NULL,
  `prerequisite` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `learning_outcomes` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mata_kuliahs`
--

INSERT INTO `mata_kuliahs` (`id`, `kurikulum_id`, `code`, `name`, `credits`, `semester`, `category`, `prerequisite`, `description`, `learning_outcomes`, `is_active`, `created_at`, `updated_at`) VALUES
(24, 3, 'SIF101', 'Pengantar Sistem Informasi', 3, 1, 'wajib', NULL, 'Pengenalan konsep dasar sistem informasi, komponen sistem informasi, dan peran sistem informasi dalam organisasi.', 'Mahasiswa memahami konsep dasar sistem informasi dan dapat mengidentifikasi kebutuhan sistem informasi dalam organisasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(25, 3, 'SIF102', 'Algoritma dan Pemrograman', 3, 1, 'wajib', NULL, 'Konsep dasar algoritma dan pemrograman menggunakan bahasa pemrograman modern untuk pemecahan masalah bisnis.', 'Mahasiswa mampu membuat program sederhana untuk menyelesaikan masalah bisnis', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(26, 3, 'SIF103', 'Matematika Bisnis', 3, 1, 'wajib', NULL, 'Konsep matematika yang digunakan dalam analisis bisnis, termasuk fungsi, limit, turunan, dan aplikasinya.', 'Mahasiswa mampu menerapkan konsep matematika dalam analisis dan pemecahan masalah bisnis', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(27, 3, 'SIF104', 'Pengantar Manajemen', 2, 1, 'wajib', NULL, 'Pengenalan konsep dasar manajemen, fungsi-fungsi manajemen, dan prinsip-prinsip organisasi.', 'Mahasiswa memahami konsep dasar manajemen dan dapat mengidentifikasi fungsi manajemen dalam organisasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(28, 3, 'SIF201', 'Basis Data', 3, 2, 'wajib', '[\"SIF102\"]', 'Konsep basis data, model data relasional, normalisasi, SQL, dan implementasi basis data untuk sistem informasi.', 'Mahasiswa mampu merancang dan mengimplementasikan basis data untuk sistem informasi bisnis', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(29, 3, 'SIF202', 'Analisis dan Perancangan Sistem', 3, 2, 'wajib', '[\"SIF101\"]', 'Metodologi analisis dan perancangan sistem informasi, teknik pemodelan sistem, dan dokumentasi sistem.', 'Mahasiswa mampu melakukan analisis kebutuhan dan merancang sistem informasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(30, 3, 'SIF203', 'Pemrograman Berorientasi Objek', 3, 2, 'wajib', '[\"SIF102\"]', 'Konsep pemrograman berorientasi objek, class, object, inheritance, polymorphism, dan implementasinya.', 'Mahasiswa mampu membuat program menggunakan paradigma pemrograman berorientasi objek', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(31, 3, 'SIF204', 'Statistika', 3, 2, 'wajib', '[\"SIF103\"]', 'Konsep statistika deskriptif dan inferensial, distribusi probabilitas, pengujian hipotesis, dan aplikasinya dalam bisnis.', 'Mahasiswa mampu melakukan analisis statistik untuk mendukung pengambilan keputusan bisnis', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(32, 3, 'SIF301', 'Sistem Informasi Manajemen', 3, 3, 'wajib', '[\"SIF202\"]', 'Konsep SIM, peran SI dalam mendukung fungsi manajemen, dan implementasi SIM dalam organisasi.', 'Mahasiswa memahami peran sistem informasi dalam mendukung manajemen organisasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(33, 3, 'SIF401', 'E-Business', 3, 4, 'wajib', '[\"SIF301\"]', 'Konsep e-business, e-commerce, model bisnis digital, dan implementasi teknologi dalam bisnis.', 'Mahasiswa memahami konsep e-business dan mampu merancang strategi bisnis digital', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(34, 3, 'SIF501', 'Business Intelligence', 3, 5, 'pilihan', '[\"SIF204\", \"SIF201\"]', 'Konsep business intelligence, data warehouse, data mining, dan dashboard untuk mendukung pengambilan keputusan.', 'Mahasiswa mampu merancang dan mengimplementasikan sistem business intelligence', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(35, 3, 'SIF801', 'Tugas Akhir', 6, 8, 'wajib', '[\"SIF401\"]', 'Proyek akhir berupa penelitian atau pengembangan sistem informasi yang menerapkan ilmu yang telah dipelajari.', 'Mahasiswa mampu melakukan penelitian mandiri di bidang sistem informasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(36, 5, 'TI101', 'Pengantar Teknologi Informasi', 3, 1, 'wajib', NULL, 'Pengenalan dasar teknologi informasi, komputer, dan aplikasinya dalam berbagai bidang.', 'Mahasiswa memahami konsep dasar teknologi informasi dan dapat mengoperasikan komputer', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(37, 5, 'TI102', 'Algoritma dan Pemrograman', 4, 1, 'wajib', NULL, 'Konsep algoritma dan pemrograman dengan fokus pada implementasi praktis dan pemecahan masalah.', 'Mahasiswa mampu membuat program sederhana untuk menyelesaikan masalah praktis', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(38, 5, 'TI103', 'Matematika Komputer', 3, 1, 'wajib', NULL, 'Konsep matematika yang digunakan dalam komputasi, termasuk logika, aljabar boolean, dan sistem bilangan.', 'Mahasiswa memahami konsep matematika yang mendasari komputasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(39, 5, 'TI104', 'Sistem Operasi', 3, 1, 'wajib', NULL, 'Pengenalan sistem operasi, instalasi, konfigurasi, dan administrasi sistem operasi.', 'Mahasiswa mampu menginstal dan mengkonfigurasi sistem operasi', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(40, 5, 'TI201', 'Pemrograman Web', 4, 2, 'wajib', '[\"TI102\"]', 'Pengembangan aplikasi web menggunakan HTML, CSS, JavaScript, PHP, dan database.', 'Mahasiswa mampu membuat aplikasi web yang dinamis dan interaktif', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(41, 5, 'TI301', 'Jaringan Komputer', 3, 3, 'wajib', '[\"TI104\"]', 'Instalasi, konfigurasi, dan maintenance jaringan komputer untuk skala kecil dan menengah.', 'Mahasiswa mampu merancang dan mengimplementasikan jaringan komputer', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(42, 5, 'TI601', 'Proyek Akhir', 4, 6, 'wajib', '[\"TI201\", \"TI301\"]', 'Proyek akhir berupa pengembangan aplikasi atau sistem yang menerapkan ilmu yang telah dipelajari.', 'Mahasiswa mampu mengembangkan sistem teknologi informasi secara mandiri', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(48, 3, 'TEST123', 'Test Matkul', 3, 3, 'wajib', '[]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, aut nobis, nisi itaque quaerat est fugiat quas pariatur officiis vel, excepturi quo ut fugit totam provident? Ut mollitia recusandae in perspiciatis doloribus, nam similique? Illum culpa voluptas cum nostrum aperiam. Illo asperiores repellendus repudiandae veniam tenetur maxime aspernatur optio adipisci fuga veritatis necessitatibus officiis sequi ut, ipsum doloremque magni reiciendis dolor enim vero eveniet quia dignissimos! Aut delectus nam quisquam placeat? Soluta, magni voluptates iusto a unde laborum quia laboriosam tempore nulla amet. Praesentium necessitatibus ipsa sed tenetur aliquam, reiciendis quis sapiente suscipit. Minus quis eveniet dolore facilis. Sapiente, dolores!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, aut nobis, nisi itaque quaerat est fugiat quas pariatur officiis vel, excepturi quo ut fugit totam provident? Ut mollitia recusandae in perspiciatis doloribus, nam similique? Illum culpa voluptas cum nostrum aperiam. Illo asperiores repellendus repudiandae veniam tenetur maxime aspernatur optio adipisci fuga veritatis necessitatibus officiis sequi ut, ipsum doloremque magni reiciendis dolor enim vero eveniet quia dignissimos! Aut delectus nam quisquam placeat? Soluta, magni voluptates iusto a unde laborum quia laboriosam tempore nulla amet. Praesentium necessitatibus ipsa sed tenetur aliquam, reiciendis quis sapiente suscipit. Minus quis eveniet dolore facilis. Sapiente, dolores!', 1, '2025-08-08 09:05:22', '2025-08-08 09:05:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0001_01_01_000003_create_telescope_entries_table', 1),
(5, '0001_01_01_000004_1_create_hero_sections_table', 1),
(6, '0001_01_01_000005_2_create_abouts_table', 1),
(7, '0001_01_01_000006_3_create_stats_table', 1),
(8, '0001_01_01_000007_4_create_program_studis_table', 1),
(9, '0001_01_01_000008_5_create_kurikulums_table', 1),
(10, '0001_01_01_000009_6_create_mata_kuliahs_table', 1),
(11, '0001_01_01_000010_7_create_team_positions_table', 1),
(12, '0001_01_01_000011_8_create_teams_table', 1),
(13, '0001_01_01_000012_9_create_jadwal_kuliahs_table', 1),
(14, '0001_01_01_000013_10_create_rps_table', 1),
(15, '0001_01_01_000014_11_create_rps_weekly_plans_table', 1),
(16, '0001_01_01_000015_12_create_dosen_mata_kuliahs_table', 1),
(17, '0001_01_01_000016_13_create_penjaminan_mutus_table', 1),
(18, '0001_01_01_000017_14_create_clients_table', 1),
(19, '0001_01_01_000018_15_create_features_table', 1),
(20, '0001_01_01_000019_16_create_testimonials_table', 1),
(21, '0001_01_01_000020_17_create_news_categories_table', 1),
(22, '0001_01_01_000021_18_create_news_table', 1),
(23, '0001_01_01_000022_19_create_contact_infos_table', 1),
(24, '0001_01_01_000023_20_create_contact_messages_table', 1),
(25, '0001_01_01_000024_21_create_site_settings_table', 1),
(26, '0001_01_01_000025_22_create_galleries_table', 1),
(27, '0001_01_01_000026_23_create_events_table', 1),
(28, '0001_01_01_000027_create_permission_tables', 1),
(29, '2025_07_17_161728_add_is_active_to_users_table', 1),
(30, '2025_08_12_143715_create_students_table', 2),
(31, '2025_08_12_143720_create_parents_table', 2),
(32, '2025_08_12_154255_create_academic_periods_table', 3),
(33, '2025_08_12_154255_create_gdrive_folders_table', 3),
(34, '2025_08_12_154255_create_khs_files_table', 3),
(35, '2025_08_12_154255_create_parent_khs_access_logs_table', 3),
(36, 'create_khs_access_logs_table', 1),
(37, 'create_khs_access_logs_table', 1),
(38, '2025_08_18_102343_create_khs_access_logs_table', 4),
(39, '2025_08_23_154534_create_questionnaires_table', 4),
(40, '2025_08_23_154545_create_questionnaire_categories_table', 4),
(41, '2025_08_23_154604_create_questionnaire_questions_table', 4),
(42, '2025_08_23_154616_create_questionnaire_scale_options_table', 4),
(43, '2025_08_23_154631_create_evaluations_table', 4),
(44, '2025_08_23_154659_create_evaluation_answers_table', 4),
(45, '2025_09_01_043314_add_prodi_id_to_students_table', 5),
(46, '2025_09_07_150823_add_certificate_url_to_program_studis_table', 6),
(47, '2025_09_07_150920_add_additional_fields_to_teams_table', 6),
(48, '2025_10_15_032711_dean_greetings', 7),
(49, '2025_10_22_094945_facilities', 8),
(50, '2024_01_01_000001_create_gpm_struktur_organisasi_table', 9),
(51, '2024_01_01_000002_create_gpm_dokumen_spmi_table', 9),
(52, '2024_01_01_000003_create_gpm_surveys_table', 9),
(53, '2024_01_01_000004_create_gpm_survey_questions_table', 9),
(54, '2024_01_01_000005_create_gpm_survey_responses_table', 9),
(55, '2024_01_01_000006_create_gpm_edom_periods_table', 9),
(56, '2024_01_01_000007_create_gpm_edom_questions_table', 9),
(57, '2024_01_01_000008_create_gpm_edom_submissions_table', 9),
(58, '2024_01_01_000009_create_gpm_settings_table', 10),
(59, '01_create_gpm_struktur_organisasi_table', 11),
(60, '02_create_gpm_dokumen_spmi_table', 11),
(61, '03_create_gpm_surveys_table', 11),
(62, '04_create_gpm_survey_questions_table', 11),
(63, '05_create_gpm_survey_responses_table', 11),
(64, '06_create_gpm_edom_periods_table', 11),
(65, '07_create_gpm_edom_questions_table', 11),
(66, '08_create_gpm_edom_submissions_table', 11),
(67, '09_create_gpm_settings_table', 12),
(68, '2026_02_06_042230_add_questionnaire_link_to_program_studis_table', 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13),
(1, 'App\\Models\\User', 14),
(5, 'App\\Models\\User', 15),
(6, 'App\\Models\\User', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `views_count` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `tags` json DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `category_id`, `author_id`, `status`, `published_at`, `views_count`, `is_featured`, `tags`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(2, 'Mahasiswa FTI Juara 1 Kompetisi Programming Nasional 2024', 'mahasiswa-fti-juara-1-kompetisi-programming-nasional-2024', 'Tim mahasiswa Fakultas TI berhasil meraih juara 1 dalam kompetisi programming tingkat nasional.', '<p>Tim mahasiswa Fakultas Teknologi Informasi yang terdiri dari Ahmad Rizki (TIF 2021), Sarah Putri (TIF 2021), dan David Chen (TIF 2020) berhasil meraih juara 1 dalam Kompetisi Programming Nasional 2024 yang diselenggarakan di Jakarta.</p>\n\n<p>Kompetisi yang diikuti oleh 200 tim dari seluruh Indonesia ini menguji kemampuan algorithmic thinking dan problem solving para peserta. Tim FTI berhasil mengungguli peserta lain dengan menyelesaikan 8 dari 10 soal dalam waktu 5 jam.</p>\n\n<p>Prestasi ini semakin memperkuat reputasi Fakultas TI sebagai salah satu fakultas teknologi informasi terbaik di Indonesia.</p>', 'assets/img/blog2.jpg', 5, 4, 'published', '2025-07-08 09:20:05', 332, 1, '[\"mahasiswa\", \"programming\", \"kompetisi\"]', 'Mahasiswa FTI Juara 1 Kompetisi Programming Nasional 2024', 'Tim mahasiswa Fakultas TI berhasil meraih juara 1 dalam kompetisi programming tingkat nasional.', '2025-07-17 09:20:05', '2025-07-25 22:38:04'),
(3, 'Kerjasama dengan Google untuk Program Sertifikasi Cloud Computing', 'kerjasama-dengan-google-untuk-program-sertifikasi-cloud-computing', 'Fakultas TI menjalin kerjasama strategis dengan Google untuk program sertifikasi cloud computing bagi mahasiswa.', '<p>Fakultas Teknologi Informasi telah menandatangani memorandum of understanding (MoU) dengan Google Indonesia untuk program sertifikasi cloud computing. Kerjasama ini bertujuan mempersiapkan mahasiswa menghadapi era digital yang semakin berkembang.</p>\n\n<p>Program ini akan memberikan akses kepada mahasiswa untuk mendapatkan sertifikasi Google Cloud Platform (GCP) yang diakui secara internasional. Selain itu, mahasiswa juga akan mendapat pelatihan langsung dari certified trainers Google.</p>\n\n<p>\"Kerjasama ini sejalan dengan visi kami untuk menghasilkan lulusan yang siap kerja dan memiliki kompetensi yang dibutuhkan industri,\" kata Wakil Dekan I, Dr. Siti Nurhaliza, M.Kom.</p>', 'assets/img/blog3.jpg', 4, 3, 'published', '2025-07-11 09:20:05', 92, 0, '[\"google\", \"cloud computing\", \"sertifikasi\"]', 'Kerjasama dengan Google untuk Program Sertifikasi Cloud Computing', 'Fakultas TI menjalin kerjasama strategis dengan Google untuk program sertifikasi cloud computing bagi mahasiswa.', '2025-07-17 09:20:05', '2025-07-25 22:57:18'),
(4, 'Penelitian AI untuk Smart City Mendapat Hibah Kemendikbud', 'penelitian-ai-untuk-smart-city-mendapat-hibah-kemendikbud', 'Tim peneliti Fakultas TI meraih hibah penelitian untuk pengembangan AI dalam konsep smart city.', '<p>Tim peneliti dari Fakultas Teknologi Informasi yang dipimpin oleh Prof. Dr. Ahmad Dahlan, M.T. berhasil meraih hibah penelitian fundamental dari Kementerian Pendidikan dan Kebudayaan untuk proyek \"Pengembangan Artificial Intelligence untuk Smart City Management\".</p>\n\n<p>Penelitian ini akan mengembangkan sistem AI yang dapat mengoptimalkan pengelolaan kota pintar, mulai dari traffic management, waste management, hingga energy efficiency. Dana hibah sebesar Rp 500 juta akan digunakan untuk penelitian selama 2 tahun.</p>\n\n<p>Tim peneliti terdiri dari 5 dosen senior dan melibatkan 10 mahasiswa S1 dan S2 sebagai research assistant.</p>', 'assets/img/blog1.jpg', 2, 6, 'published', '2025-07-11 09:20:05', 165, 0, '[\"AI\", \"smart city\", \"hibah penelitian\"]', 'Penelitian AI untuk Smart City Mendapat Hibah Kemendikbud', 'Tim peneliti Fakultas TI meraih hibah penelitian untuk pengembangan AI dalam konsep smart city.', '2025-07-17 09:20:05', '2025-07-25 22:57:18'),
(6, 'Berita 6: Rerum sit facere et dolor dolores a rem.', 'berita-6-magni-vel-cumque', 'Omnis blanditiis repellendus ut aut. Qui ut reprehenderit ipsam et corporis earum.', '<p>Voluptatibus fugiat omnis eveniet sapiente hic at et. Non consequuntur amet blanditiis. Nemo perspiciatis perspiciatis hic autem blanditiis qui. Eius voluptates vel eveniet placeat similique. Ratione pariatur non dolor.</p><p>Quis vel enim similique saepe autem dolorem. Asperiores eos similique quam veniam. Possimus quia est nobis ipsa recusandae sunt dolorum veritatis. Minus ad sequi ab aliquam. Veritatis sit iusto velit earum tenetur animi rerum.</p><p>Facilis occaecati exercitationem placeat omnis. Cumque ut officiis dolor voluptatibus commodi. Ipsa omnis et alias culpa sunt est.</p>', 'assets/img/blog3.jpg', 6, 1, 'published', '2025-04-24 09:20:05', 170, 0, '[\"quia\", \"vel\", \"voluptas\"]', 'In quo nulla maxime alias suscipit perferendis voluptatibus repellendus architecto aut assumenda.', 'Saepe voluptas unde sed impedit nihil cupiditate atque. Consequatur possimus ducimus odit explicabo recusandae at.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(7, 'Berita 7: Commodi aliquid laboriosam rem veniam mollitia voluptate enim.', 'berita-7-iure-molestiae-eius', 'Optio voluptate quae nam et in. Aut exercitationem possimus corporis. Quo commodi et veritatis eligendi.', '<p>Est est ipsam inventore facilis error. Omnis sint magnam saepe. Commodi inventore eum perferendis iusto corporis sequi. Sit doloribus nam saepe magni voluptatem enim. Repudiandae temporibus consequatur voluptatem praesentium sapiente esse quis. Et ipsum in laboriosam non reiciendis nam. Rem aut fuga sint.</p><p>Provident laudantium praesentium dolor ut. Id consequuntur laborum consequatur ut corporis autem hic. Quae fuga quas voluptatem quia mollitia et ipsam. Neque et corporis possimus facilis. Ut quia odio velit qui.</p><p>Provident sint quod harum. Consequuntur sit debitis et corrupti. Ratione quia quibusdam dolorum sunt rerum labore.</p>', 'assets/img/blog1.jpg', 1, 8, 'published', '2025-06-29 09:20:05', 80, 0, '[\"voluptas\", \"quo\", \"rerum\"]', 'Nihil debitis sapiente quisquam sed aut.', 'Laborum eos quis quo tenetur distinctio. Repellat aut nam necessitatibus et eaque saepe.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(8, 'Berita 8: Neque tempore nesciunt quo doloribus id.', 'berita-8-repudiandae-aut-nesciunt', 'Adipisci ratione qui architecto accusantium fugiat ipsa. Ut enim assumenda tempore molestias est expedita.', '<p>Quaerat et voluptas alias odio. Qui deleniti enim error sint nulla omnis aut. Earum et dicta minima sapiente aspernatur expedita ducimus est. Quasi sed saepe rerum qui voluptas. Amet reprehenderit ea enim amet. Ducimus voluptatibus perspiciatis nobis minus est ipsum consequatur velit.</p><p>Rerum modi modi rerum ut commodi voluptate tempora. Sunt sed minima sequi maiores vitae sint eius repellat. Non sint qui nemo et asperiores eum repellat. Ut fuga recusandae amet asperiores.</p><p>Dolor quidem laborum iure quam. Et dolores neque molestias et. Porro incidunt eos quidem dolor. Culpa et animi est adipisci doloremque temporibus.</p>', 'assets/img/blog2.jpg', 4, 1, 'published', '2025-05-07 09:20:05', 202, 1, '[\"aut\", \"autem\", \"et\"]', 'Aut itaque facilis fugiat est commodi accusantium est.', 'Et vitae blanditiis aliquam corrupti maiores eaque. Vel aut maiores minima corrupti quis et eum.', '2025-07-17 09:20:05', '2025-07-25 22:37:46'),
(9, 'Berita 9: Aut reiciendis totam ullam laboriosam earum itaque temporibus.', 'berita-9-cumque-distinctio-architecto', 'Autem et ipsum ut recusandae provident dignissimos inventore. Veritatis est et dolorem quia excepturi laboriosam numquam. Qui cupiditate ut qui dicta ullam dolores.', '<p>Ratione beatae voluptas aut laudantium voluptatum est ea velit. Velit rerum harum possimus suscipit aut. Doloremque ipsum commodi et aspernatur eos. Fugit laborum officiis ullam perferendis veritatis. Veniam accusamus accusantium non accusamus dolorem voluptatibus totam. Optio rerum distinctio quisquam natus maxime veritatis.</p><p>Voluptas nihil eos possimus qui. Est labore odio nisi cumque id. Voluptas magnam reiciendis eos praesentium magni quos. Cupiditate quisquam tempore molestias dignissimos ducimus. Praesentium illo explicabo saepe quod et cupiditate consequatur. Sit incidunt facere dignissimos laborum nihil.</p><p>Nulla est nisi et. Doloribus aperiam omnis voluptatem rem omnis. Eos repellat enim suscipit. Beatae nobis soluta sunt reiciendis eligendi aut.</p>', 'assets/img/blog3.jpg', 1, 1, 'draft', '2025-07-09 09:20:05', 293, 0, '[\"qui\", \"dolor\", \"autem\"]', 'Molestiae sit sed similique autem magni illum.', 'Ea quibusdam earum sapiente adipisci. Placeat quis voluptatibus odio accusamus.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(10, 'Berita 10: Rerum eos ducimus ut deserunt vero exercitationem id.', 'berita-10-odio-et-ipsam', 'Eius quos dolorum maxime. Eligendi asperiores amet illo est.', '<p>Ex at aliquam in cumque est alias. Non unde omnis ex provident. Iusto nisi in numquam. Non rerum mollitia corporis dolores saepe. Optio doloremque corrupti dolorem ut. Commodi quidem adipisci ad amet. Vel in sint minima dolores voluptas dolores nostrum culpa.</p><p>Consectetur voluptatum et non ea. Dolore qui adipisci molestiae harum. Qui et odio totam harum et dolore quia. Rem voluptatibus beatae est ut quisquam.</p><p>Culpa vitae quis ab fugit. Aut qui ut non qui voluptate veniam sed. Et et qui dicta pariatur ut a.</p>', 'assets/img/blog1.jpg', 3, 7, 'published', '2025-06-05 09:20:05', 278, 0, '[\"cupiditate\", \"error\", \"enim\"]', 'Hic natus velit aut tempora iusto necessitatibus doloribus.', 'Voluptatibus autem iste illo ut reiciendis odio non. Minus qui reiciendis qui.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(11, 'Berita 11: Architecto quidem eos quae esse.', 'berita-11-nemo-mollitia-magnam', 'Ut est voluptatibus expedita nulla illum reiciendis. Perspiciatis et placeat ea unde. Nulla voluptate repellendus nihil dolorem aut odit ut vero.', '<p>Maiores aut quos non aliquid consequatur sed eaque. Sit alias quibusdam ad veniam culpa consequatur itaque. Dicta aut inventore quia. Facere ut perferendis natus tempora quis itaque ea.</p><p>Repellendus id esse voluptatem error delectus. Vel laudantium architecto omnis hic dolore harum enim. Sapiente id quis assumenda voluptatum. Rerum consectetur ut consequatur molestiae magnam temporibus. Amet et voluptate aut veniam qui sequi.</p><p>Et sint labore beatae excepturi numquam nemo. Maxime dolore ratione similique id. Non blanditiis nobis laborum rerum ut cum quis debitis. Laudantium velit recusandae tempora ipsum repellendus earum.</p>', 'assets/img/blog2.jpg', 5, 1, 'published', '2025-04-27 09:20:05', 175, 0, '[\"molestias\", \"placeat\", \"a\"]', 'Ipsam aliquam porro possimus corrupti vitae cupiditate rerum.', 'Nulla blanditiis beatae aspernatur exercitationem earum. Natus voluptas voluptatem ipsum dolor omnis magnam.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(12, 'Berita 12: Nihil sunt vero non recusandae.', 'berita-12-aliquid-totam-in', 'Qui voluptatum vel consequuntur quo. Vel deserunt voluptatem consequatur aut est est cupiditate tenetur. Eius tempore eos quos cum delectus.', '<p>Perferendis voluptatem voluptates et exercitationem tempore expedita. Perferendis ea non ipsum earum facilis. Ullam voluptatem expedita ut nobis modi hic. Officiis et non ut fuga possimus. Sed omnis iusto quod dolorum dicta. Deleniti voluptatum voluptas nobis sed consectetur corrupti quisquam est. Eum nesciunt enim dolor maiores nesciunt sunt qui.</p><p>Ipsam consequatur rerum est distinctio. Voluptas quia error ipsa ullam qui vel. Quas pariatur odit ab. Ut sed eligendi saepe quasi.</p><p>Et et numquam consectetur sit. Quam praesentium qui ipsa ducimus. In dicta dolorem sit dolorem doloremque ullam.</p>', 'assets/img/blog3.jpg', 6, 5, 'published', '2025-05-30 09:20:05', 91, 0, '[\"soluta\", \"et\", \"commodi\"]', 'Molestiae quo veniam repudiandae molestiae dicta placeat eum quia.', 'Quae et ipsam quidem nisi et eum.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(13, 'Berita 13: Voluptate repellendus et aut sint aliquid sed.', 'berita-13-aut-autem-dolorum', 'Alias eveniet facilis sed dolor nostrum. Amet fugit doloribus aut ullam. Officiis qui blanditiis sunt nisi quasi optio eum rerum.', '<p>Mollitia fuga ad beatae assumenda qui voluptas. Molestias aut incidunt vel minima distinctio et exercitationem. A excepturi quibusdam reprehenderit saepe eaque. Omnis ducimus eius voluptatem excepturi saepe qui. Esse facilis porro possimus qui illum provident officia.</p><p>Porro magnam quia omnis perspiciatis nihil. Velit corporis unde dolores tempore ipsam doloribus voluptate. Repudiandae molestiae quaerat aut aut ab quidem non. Veniam tenetur hic fugit asperiores earum non.</p><p>Consequatur nemo provident aliquid odio. Dignissimos quia et consequuntur officia quo. Voluptatem quis officia cupiditate quod totam iusto eum.</p>', 'assets/img/blog1.jpg', 1, 3, 'draft', '2025-07-06 09:20:05', 170, 0, '[\"est\", \"odit\", \"rerum\"]', 'Dolores atque fugiat quos ratione omnis in magni.', 'Doloremque qui doloremque recusandae reiciendis molestiae non id. Ducimus alias dolore architecto et numquam fuga.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(14, 'Berita 14: Aliquam recusandae dolores quis expedita eos.', 'berita-14-maxime-quas-impedit', 'Velit adipisci eos laborum sint doloribus velit accusantium aut. Hic corrupti expedita facilis consequatur veritatis.', '<p>Dolorem et neque maiores aperiam cupiditate explicabo ipsum odit. Repudiandae quia perspiciatis quas ut ea. Consequatur consequatur perspiciatis qui dolor tenetur delectus repellendus. Dolore commodi natus est esse nulla voluptatum.</p><p>Blanditiis ea voluptatibus pariatur et neque enim. Reiciendis reiciendis architecto est consequuntur eos. Voluptatem fuga enim dolore blanditiis unde perspiciatis tempora. Distinctio dolor hic optio voluptate consequatur.</p><p>Et saepe ut adipisci aut sapiente dolores eveniet. Rerum culpa ullam dolore velit dolorum. Earum sed aut unde corrupti. Ad inventore suscipit ratione repellendus aliquid vero.</p>', 'assets/img/blog2.jpg', 2, 8, 'draft', '2025-06-11 09:20:05', 74, 0, '[\"vero\", \"et\", \"aut\"]', 'Est tempore velit ut eum quo voluptatem sit.', 'Dolore ea maiores molestiae. Quis modi natus sunt inventore qui molestiae.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(15, 'Berita 15: Beatae voluptate eum error facere laboriosam.', 'berita-15-voluptates-quis-labore', 'Eveniet deleniti natus dolor. Aliquam quaerat consectetur accusamus quod. Id aut et aliquid.', '<p>Saepe dolore itaque omnis. Dolore saepe voluptatem voluptatem dolorem. Nostrum hic accusamus alias accusamus est quia facilis. Ea qui minus blanditiis fuga iste. Quasi incidunt blanditiis unde tenetur sunt ducimus eum perspiciatis.</p><p>Sit earum asperiores autem consectetur voluptatem ipsam nam. Quas voluptate nesciunt nesciunt aut voluptatem perferendis. Et facilis odio voluptatem vitae laboriosam qui. Quidem et sunt est delectus.</p><p>Voluptatum non cum accusantium quam. Nesciunt neque placeat eum animi fuga voluptate quod. Facilis dicta facilis dolorem qui aut provident possimus nesciunt.</p>', 'assets/img/blog3.jpg', 4, 6, 'published', '2025-04-20 09:20:05', 197, 0, '[\"ducimus\", \"sit\", \"et\"]', 'Aperiam nostrum rerum voluptas dolor.', 'Laudantium fugiat quibusdam provident dicta quasi mollitia dolor ducimus. Ducimus consequatur dolorem suscipit recusandae in ipsam.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(16, 'Berita 16: Similique omnis possimus laudantium illo.', 'berita-16-numquam-animi-voluptatum', 'Deleniti sint et ab ipsam veritatis. Cum tempore harum aut inventore nostrum. Numquam ab asperiores eveniet provident.', '<p>Magnam magnam provident rem odit quas ut praesentium. Ipsa ullam dignissimos ut ea. Quas quod quis repellendus non et nobis vel. Est asperiores corporis velit veritatis aut qui. Et dolor totam ut ab. Dolores similique autem ad est est. Ullam voluptates dolor et cumque ut adipisci atque velit.</p><p>Autem magni autem sed tempora necessitatibus est velit impedit. Dolores qui sed qui. Ut aut ea porro quo minus hic qui. Non odit alias praesentium occaecati.</p><p>Qui quis quas fuga nobis illum non. Saepe veniam minima dolorem est exercitationem. Sit nulla quam quibusdam. Sit qui aperiam eligendi suscipit ab.</p>', 'assets/img/blog1.jpg', 4, 3, 'published', '2025-06-25 09:20:05', 25, 0, '[\"aut\", \"ut\", \"sed\"]', 'Architecto magni eveniet et facere fugit voluptatem asperiores quam.', 'Cum aut qui fuga et voluptas dolore facere. Iusto nisi officia sint in est dolor numquam.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(17, 'Berita 17: Inventore magnam qui facere sit quod.', 'berita-17-repellat-numquam-voluptas', 'Cupiditate eligendi eos in sed vero recusandae beatae. Earum minima consequatur nostrum quia sed animi impedit repudiandae.', '<p>Enim culpa placeat animi itaque perspiciatis rem. Nobis earum quidem placeat qui saepe quaerat voluptatem. Est eum est eos ea at consequatur sit provident. Omnis laudantium ipsa facere eius iusto ea. Cum velit quas explicabo. Sunt aut facere optio. Eum mollitia non saepe sint maiores minus est.</p><p>Quod dolor voluptatem tempora odio ut qui dolores. Similique rem voluptatem voluptatem. Eius dolorum similique quis assumenda iure sint. Atque delectus cumque amet sit. Laboriosam voluptate nam omnis maiores. Dolore recusandae fugiat non cumque cumque id.</p><p>Aperiam doloremque ut minus unde mollitia illum fugiat aliquid. Illum provident consectetur esse fuga et architecto. Nisi rem non dicta est consequatur sed libero.</p>', 'assets/img/blog2.jpg', 4, 6, 'published', '2025-07-10 09:20:05', 186, 0, '[\"sint\", \"molestias\", \"illum\"]', 'Impedit qui iusto et ab qui sed iure porro ullam.', 'Quisquam magnam et quia quam illum ut doloremque.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(18, 'Berita 18: Quasi fugit sunt aliquid rerum temporibus facere vel.', 'berita-18-dolore-est-repudiandae', 'Quia cumque dolorem vel sapiente. Consequatur sint aut reiciendis numquam tenetur. Tempora rerum quia ex ex et pariatur quaerat quasi.', '<p>Praesentium amet culpa quam voluptatem. Officia in repellendus enim quis sequi. Velit architecto omnis voluptatem enim quibusdam. Ut inventore rerum qui sunt vel. Voluptatem est assumenda ea dolores perferendis. Ratione nulla cupiditate reprehenderit expedita et. Rerum numquam aut tempora id omnis earum.</p><p>Aut iusto hic est voluptas et. Eos hic consequatur corrupti omnis. Aut atque eius aut. Suscipit id est aut aliquam.</p><p>Est nihil sint laboriosam corporis ipsam et repudiandae quidem. Quos qui sed laboriosam corporis et. Debitis et ut possimus et.</p>', 'assets/img/blog3.jpg', 6, 6, 'draft', '2025-06-12 09:20:05', 99, 0, '[\"voluptatem\", \"est\", \"aut\"]', 'Culpa eaque architecto deleniti repellat blanditiis dolor adipisci voluptatum.', 'Reiciendis adipisci soluta velit quis nihil saepe.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(19, 'Berita 19: Aspernatur tempora sed quia ullam et.', 'berita-19-debitis-ex-libero', 'Itaque et libero voluptatem ea in quia. Quia et tenetur cum maiores.', '<p>Sequi vel laudantium dignissimos magni perferendis soluta. Autem nobis sint iusto ad occaecati officia sit odit. Laborum non possimus ipsum qui. Eius dolore ex repellendus. Voluptates maiores consequatur eos corrupti.</p><p>Quis sed et magnam assumenda minus ab. Natus molestiae et dolorum et iure. Sint mollitia expedita possimus. Neque vel est dolorem rerum doloribus corrupti voluptatem.</p><p>Omnis soluta tenetur iste provident provident natus recusandae. Magni optio vero amet voluptatum. Alias nihil quos et incidunt perferendis velit. Impedit sed aut sequi explicabo similique molestias commodi et.</p>', 'assets/img/blog1.jpg', 1, 1, 'published', '2025-07-09 09:20:05', 69, 0, '[\"a\", \"perspiciatis\", \"dolores\"]', 'Et dignissimos consectetur quia consequatur excepturi et.', 'Ipsam laboriosam aspernatur error aut.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(20, 'Berita 20: Itaque quo velit reiciendis.', 'berita-20-eos-ut-quasi', 'Esse rerum excepturi id quibusdam velit eum adipisci. Debitis pariatur est sequi dolorem et et numquam incidunt.', '<p>Tempore eos ratione nesciunt nobis quia sunt ipsam. Et dicta ea similique odit odio dolorem aut. Nisi qui similique odit ullam. Tempora sed harum est sapiente. Ex quidem et quo dolorem cum tenetur dolorem adipisci. Ut adipisci asperiores voluptas iusto hic laboriosam at. Explicabo nesciunt quia aliquam sequi est.</p><p>Praesentium tempora non vel sed enim esse. Non quae consequatur molestiae animi ullam molestias veritatis. Doloremque qui dolor recusandae nisi dolores doloribus. Sunt dolorem ut voluptatum neque. Perferendis temporibus cum itaque omnis.</p><p>Quia quia officiis laborum. Ut voluptatem debitis aut iusto.</p>', 'assets/img/blog2.jpg', 5, 8, 'published', '2025-05-22 09:20:05', 13, 0, '[\"libero\", \"nesciunt\", \"at\"]', 'Aut voluptas doloremque nihil ut error blanditiis optio sint.', 'Eius iste eius velit eum dolor nam dolorem. Iure saepe ut voluptas veritatis dolorem est aut a.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(21, 'Berita 21: Quasi consequatur deserunt tempora ut est illo.', 'berita-21-nihil-provident-voluptatem', 'Pariatur consequatur praesentium veniam sit. Et id possimus nihil cumque mollitia.', '<p>Ratione numquam dolore aliquam fugiat molestias molestias deserunt. Provident dolore debitis eos provident sit sed. Nostrum aut vel beatae optio. Hic iste sapiente laboriosam dolorum ut voluptatem est.</p><p>Deserunt qui et ipsam sunt ea sit repudiandae. Quos aut ad asperiores qui aliquid quam dolorem. Est odio dolorem ea aspernatur odio eos fugiat. Nemo eum ut sint voluptatum rerum perspiciatis omnis fugit. Exercitationem et quidem dolorem praesentium.</p><p>Fuga inventore nemo harum modi. Sed eligendi et adipisci et. Alias eos cupiditate quia quod. Qui quis atque inventore ad suscipit.</p>', 'assets/img/blog3.jpg', 1, 3, 'published', '2025-07-15 09:20:05', 93, 1, '[\"error\", \"tenetur\", \"soluta\"]', 'Suscipit dolores facilis distinctio ut neque animi et iusto et quae.', 'Magni tenetur dolor numquam perspiciatis nemo fugit.', '2025-07-17 09:20:05', '2025-07-25 22:57:15'),
(22, 'Berita 22: Sunt aut in quaerat qui tempora recusandae sunt.', 'berita-22-quae-quos-architecto', 'Ducimus aliquam dignissimos explicabo reprehenderit aut minus qui illum. Hic mollitia perferendis aut optio.', '<p>Vero blanditiis id numquam vero exercitationem voluptatem. Voluptate consequatur et earum sunt molestiae libero vel. Rerum consequatur repudiandae nobis temporibus beatae quos. Delectus enim unde alias velit quidem ipsa beatae. Eaque explicabo laborum eum expedita est recusandae quam. Rem dolorem aut vel est rerum consequatur non. Voluptatem officia maiores similique aliquam.</p><p>Cupiditate fugiat aut magnam iste. Quia consequuntur voluptatibus optio. Neque earum sit nemo.</p><p>Quod officiis quia fugit at. Incidunt unde quo consequatur reprehenderit unde eius placeat.</p>', 'assets/img/blog1.jpg', 5, 4, 'published', '2025-05-19 09:20:05', 163, 0, '[\"optio\", \"natus\", \"nam\"]', 'Commodi fugiat fugit et qui aut id saepe vitae dolore.', 'Non unde sequi officia alias ratione sed.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(23, 'Berita 23: Aut odio non quod nesciunt nam itaque aspernatur autem.', 'berita-23-rerum-at-incidunt', 'Facere et ut debitis. Quis officia aliquam totam aut dolores quidem vitae. Dolorem culpa earum consequuntur totam nulla et odit.', '<p>Corporis ullam ut rerum voluptatem molestias. Ex officiis aut quo non iure quis aut. Odio alias nam est. Ut quidem sequi vel. Delectus voluptate qui dolores eos. Qui aut veniam omnis eos id nisi doloremque. Vero autem eum facilis illo dolor asperiores quae.</p><p>Nesciunt quaerat ut aut quis veniam dolorum. Possimus et voluptatum sunt consectetur. Dolores hic quia voluptatem omnis soluta necessitatibus harum. Incidunt voluptate earum neque maiores qui molestiae.</p><p>Consequuntur molestias itaque veniam maxime est vel. Voluptas tempore eum dignissimos nobis consequatur repudiandae repellat. Voluptatum aut provident sed eum voluptas quo. Rerum sit natus doloremque.</p>', 'assets/img/blog2.jpg', 1, 1, 'published', '2025-07-02 09:20:05', 29, 0, '[\"nostrum\", \"non\", \"atque\"]', 'Quos consectetur laudantium quis odit itaque est ipsam sunt ut voluptatibus ut.', 'Sint aperiam aut placeat sequi est ut.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(24, 'Berita 24: Et quaerat aut maxime impedit numquam dolores.', 'berita-24-reiciendis-et-quis', 'Corporis beatae at veritatis aspernatur nulla id eos delectus. Facilis reiciendis deleniti velit velit. Aut harum aliquid quia praesentium et.', '<p>Illum occaecati perspiciatis sed accusamus sit. Voluptatem mollitia beatae omnis maiores voluptatem. Qui neque ut modi nulla qui assumenda officiis et. Ratione cupiditate aut est consequuntur sunt et dolorem. Vero quisquam perspiciatis voluptatem tempora dicta repellendus et.</p><p>Similique ipsam libero exercitationem culpa aut animi laboriosam. Error sunt quasi tempora velit nesciunt voluptas rerum. Amet quos ut vero consequatur ratione ducimus labore.</p><p>Qui hic soluta eos pariatur eius. Nam quo nulla praesentium rem voluptas vel. Maxime quo ut et. Qui eligendi ex fugiat atque et.</p>', 'assets/img/blog3.jpg', 6, 8, 'draft', '2025-07-10 09:20:05', 149, 1, '[\"est\", \"rerum\", \"accusantium\"]', 'Officia aut aut repellat amet est sit necessitatibus.', 'Rem ratione eius iste expedita. Nemo est possimus magnam asperiores.', '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(25, 'Berita 25: Harum illum dolores ratione corporis perspiciatis.', 'berita-25-voluptas-ut-non', 'Error doloremque facere dolorem autem unde. Molestiae aliquam dignissimos et dolor vel saepe quidem.', '<p>Harum sunt impedit ut perspiciatis dolorem quaerat exercitationem. Quaerat eligendi est consequatur sint. Quo rerum quo accusantium quaerat sapiente consequatur eum. Numquam inventore nam ut alias itaque. Quia omnis repellat enim. Unde nihil pariatur doloribus quos incidunt.</p><p>In dolores est expedita nam consequatur quisquam ipsum. Explicabo tempora placeat minus delectus. Vel porro sint veniam ut.</p><p>Qui reprehenderit quibusdam ut cum. Sint rem omnis fuga est corrupti laudantium. Cum dolorem ratione autem blanditiis iusto ut harum sequi. Et atque inventore quod ut nam quo.</p>', 'assets/img/blog1.jpg', 5, 3, 'published', '2025-06-07 09:20:05', 127, 0, '[\"quo\", \"ipsam\", \"atque\"]', 'Qui explicabo enim sunt dolorem et nesciunt dolores facere.', 'Consequatur optio libero qui eligendi aspernatur hic et id. Saepe praesentium animi odit id enim voluptatem enim.', '2025-07-17 09:20:05', '2025-07-17 09:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `color`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Akademik', 'akademik', 'Berita seputar kegiatan akademik', '#3B82F6', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(2, 'Penelitian', 'penelitian', 'Berita tentang penelitian dan publikasi', '#10B981', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(3, 'Kemahasiswaan', 'kemahasiswaan', 'Kegiatan dan prestasi mahasiswa', '#F59E0B', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(4, 'Kerjasama', 'kerjasama', 'Kerjasama dengan industri dan institusi', '#8B5CF6', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(5, 'Prestasi', 'prestasi', 'Prestasi civitas akademika', '#EF4444', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(6, 'Event', 'event', 'Acara dan kegiatan fakultas', '#06B6D4', 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `parents`
--

CREATE TABLE `parents` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation` enum('ayah','ibu','wali') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ayah',
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `parents`
--

INSERT INTO `parents` (`id`, `student_id`, `username`, `password`, `name`, `email`, `phone`, `relation`, `occupation`, `address`, `is_active`, `last_login_at`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, '2023001', '$2y$12$ETH/1csRGhgcbRyxNPs2jeEWC97o7GcNRZupLUMlWPaq2edyrrwhC', 'Budi Santoso', 'budi@email.com', '08198765432', 'ayah', 'Wiraswasta', 'Jl. Merdeka No. 1', 1, NULL, NULL, NULL, '2025-08-12 08:09:11', '2025-08-12 08:09:11'),
(2, 2, '2023002', '$2y$12$aQmOzIFRPJ4nsuSMn0Auf.yFc89oLZX837Pyg8aIxo4NNOd6eoEni', 'Sari Dewi', 'sari@email.com', '08198765433', 'ibu', 'Guru', 'Jl. Pahlawan No. 5', 1, NULL, NULL, NULL, '2025-08-12 08:09:11', '2025-08-12 08:09:11'),
(4, 3, '2025001', '$2y$12$ZmNop6vYrmIxys6KMydF/u96TwuoOKNfy8O.6lhRv5L/VWAqQFQTe', 'Test Parent', 'parent@example.com', '081234567890', 'ayah', 'Test Job', 'Test Address', 1, '2025-12-04 18:46:32', NULL, NULL, '2025-08-16 08:42:00', '2025-12-04 18:46:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `parent_khs_access_logs`
--

CREATE TABLE `parent_khs_access_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED NOT NULL,
  `khs_file_id` bigint UNSIGNED NOT NULL,
  `access_type` enum('view','download') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `accessed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjaminan_mutus`
--

CREATE TABLE `penjaminan_mutus` (
  `id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `document_type` enum('borang_akreditasi','evaluasi_diri','sop','panduan','laporan_penjaminan_mutu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `document_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `status` enum('draft','active','obsolete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjaminan_mutus`
--

INSERT INTO `penjaminan_mutus` (`id`, `prodi_id`, `document_type`, `title`, `description`, `document_url`, `version`, `effective_date`, `review_date`, `status`, `created_by`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'panduan', 'Test Dokumen', 'Test Dokumen', 'documents/penjaminan-mutu/1754723494_Kartu Hasil Studi Semester Genap 2024-2025.pdf', '1.0', '2025-08-09', '2025-08-09', 'draft', 'Administrator', NULL, NULL, '2025-08-09 00:11:34', '2025-08-09 00:11:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage users', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'manage program-studi', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'manage kurikulum', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'manage mata-kuliah', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 'manage news', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'manage events', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 'manage gallery', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 'manage testimonials', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 'manage clients', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(10, 'manage teams', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(11, 'manage contact-messages', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(12, 'manage settings', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(13, 'view admin', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(14, 'dashboard.view', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(15, 'users.view', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(16, 'users.create', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(17, 'users.edit', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(18, 'users.delete', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(19, 'roles.view', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(20, 'roles.create', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(21, 'roles.edit', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(22, 'roles.delete', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(23, 'users.manage-roles', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(24, 'about.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(25, 'about.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(26, 'about.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(27, 'about.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(28, 'about.toggle-status', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(29, 'program-studi.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(30, 'program-studi.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(31, 'program-studi.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(32, 'program-studi.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(33, 'news.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(34, 'news.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(35, 'news.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(36, 'news.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(37, 'contact-messages.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(38, 'contact-messages.reply', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(39, 'contact-messages.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(40, 'settings.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(41, 'settings.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(42, 'kurikulum.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(43, 'kurikulum.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(44, 'kurikulum.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(45, 'kurikulum.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(46, 'mata-kuliah.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(47, 'mata-kuliah.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(48, 'mata-kuliah.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(49, 'mata-kuliah.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(50, 'rps.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(51, 'rps.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(52, 'rps.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(53, 'rps.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(54, 'jadwal-kuliah.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(55, 'jadwal-kuliah.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(56, 'jadwal-kuliah.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(57, 'jadwal-kuliah.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(58, 'dosen-mata-kuliah.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(59, 'dosen-mata-kuliah.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(60, 'dosen-mata-kuliah.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(61, 'dosen-mata-kuliah.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(62, 'penjaminan-mutu.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(63, 'penjaminan-mutu.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(64, 'penjaminan-mutu.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(65, 'penjaminan-mutu.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(66, 'penjaminan-mutu.download', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(67, 'site-settings.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(68, 'site-settings.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(69, 'site-settings.bulk-update', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(70, 'stats.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(71, 'stats.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(72, 'stats.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(73, 'stats.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(74, 'stats.set-current', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(75, 'team.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(76, 'team.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(77, 'team.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(78, 'team.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(79, 'team.update-order', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(80, 'team-position.view', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(81, 'team-position.create', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(82, 'team-position.edit', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(83, 'team-position.delete', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(84, 'parent.view-khs', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(85, 'api.access', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_studis`
--

CREATE TABLE `program_studis` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree_level` enum('D3','S1','S2','S3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `mission` text COLLATE utf8mb4_unicode_ci,
  `questionnaire_link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `graduate_competencies` text COLLATE utf8mb4_unicode_ci,
  `overview` longtext COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accreditation` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accreditation_date` date DEFAULT NULL,
  `accreditation_expire` date DEFAULT NULL,
  `head_of_program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_year` year DEFAULT NULL,
  `certificate_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `program_studis`
--

INSERT INTO `program_studis` (`id`, `name`, `code`, `degree_level`, `description`, `vision`, `mission`, `questionnaire_link`, `graduate_competencies`, `overview`, `image_url`, `accreditation`, `accreditation_date`, `accreditation_expire`, `head_of_program`, `established_year`, `certificate_url`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Teknik Pertambangan', 'TPT', 'S1', 'Program studi yang fokus pada perancangan dan pengelolaan sistem informasi untuk mendukung proses bisnis.', 'Menjadi program studi unggulan di bidang teknik pertambangan yang menghasilkan lulusan berkualitas tinggi, melakukan penelitian inovatif, dan berkontribusi nyata dalam pengembangan sumber daya mineral secara berkelanjutan di Indonesia Timur pada tahun 2030.', 'Menyelenggarakan pendidikan tinggi berkualitas di bidang teknik pertambangan yang sesuai dengan perkembangan IPTEK dan kebutuhan industri. Melakukan penelitian dan pengembangan teknologi pertambangan yang ramah lingkungan dan berkelanjutan. Mengabdi kepada masyarakat melalui penerapan ilmu pengetahuan dan teknologi pertambangan untuk kesejahteraan rakyat. Menjalin kerjasama dengan berbagai pihak untuk meningkatkan kualitas pendidikan, penelitian, dan pengabdian masyarakat.', NULL, 'Mampu merancang dan menganalisis sistem pertambangan dengan mempertimbangkan aspek teknis, ekonomis, lingkungan, dan keselamatan kerja. Menguasai teknologi eksplorasi, eksploitasi, dan pengolahan bahan galian sesuai dengan perkembangan teknologi terkini. Memiliki kemampuan manajemen proyek pertambangan dan dapat bekerja dalam tim multidisiplin. Mampu berkomunikasi efektif dan memiliki jiwa kepemimpinan. Memahami dan menerapkan prinsip-prinsip pembangunan berkelanjutan dalam industri pertambangan.', '<p>Program Studi Sistem Informasi menggabungkan bidang teknologi informasi dengan manajemen bisnis. Program ini mempersiapkan mahasiswa untuk menjadi profesional yang mampu menganalisis kebutuhan bisnis dan merancang solusi teknologi informasi yang tepat.</p>', '/storage/assets/img/service2.jpg', 'A', '2019-06-20', '2024-06-20', 'Dr. Sari Indrawati, M.SI.', '1998', '', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'Teknik Geologi', 'TG', 'S1', 'Program diploma yang fokus pada implementasi dan maintenance teknologi informasi.', 'Menjadi program studi unggul di bidang teknik geologi yang menghasilkan ahli geologi berkompeten tinggi, melakukan penelitian geosains inovatif, dan berkontribusi dalam mitigasi bencana geologi serta eksplorasi sumber daya alam berkelanjutan pada tahun 2030.', 'Menyelenggarakan pendidikan tinggi berkualitas di bidang teknik geologi dengan pendekatan pembelajaran yang mengintegrasikan teori dan praktik lapangan. Melakukan penelitian multidisiplin dalam geologi struktur, geologi lingkungan, dan geologi sumber daya alam. Mengabdi kepada masyarakat melalui kajian geologi untuk mitigasi bencana dan konservasi lingkungan. Menjalin kerjasama dengan lembaga penelitian dan industri untuk pengembangan ilmu geologi terapan.', NULL, 'Mampu melakukan pemetaan geologi, analisis struktur geologi, dan interpretasi data geofisika untuk eksplorasi sumber daya alam. Menguasai teknik analisis batuan, mineral, dan fosil serta interpretasi sejarah geologi. Memiliki kemampuan dalam kajian geologi lingkungan dan mitigasi bencana geologi. Mampu menggunakan teknologi GIS, remote sensing, dan software geologi modern. Memiliki kemampuan penelitian dan dapat bekerja di lingkungan yang menantang.', '<p>Program Diploma III Teknologi Informasi adalah program vokasi yang menekankan pada keterampilan praktis dalam bidang teknologi informasi. Program ini mempersiapkan tenaga ahli madya yang siap kerja di industri.</p>', '/storage/assets/img/service3.jpg', 'B', '2021-03-10', '2026-03-10', 'Ir. Ahmad Fauzi, M.T.', '2005', '', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'Teknik Perminyakan', 'TPR', 'S1', 'Program studi yang mempelajari pengembangan perangkat lunak, sistem informasi, dan teknologi komputer.', 'Menjadi program studi terdepan di bidang teknik perminyakan yang menghasilkan lulusan kompeten, melakukan penelitian inovatif dalam teknologi migas, dan berkontribusi pada pengembangan energi berkelanjutan di Indonesia pada tahun 2030.', 'Menyelenggarakan pendidikan berkualitas tinggi di bidang teknik perminyakan yang mengintegrasikan teknologi modern dan praktik industri terbaik. Melakukan penelitian dan pengembangan teknologi eksplorasi dan produksi migas yang efisien dan ramah lingkungan. Mengabdi kepada masyarakat melalui transfer teknologi dan pemberdayaan sumber daya manusia di bidang energi. Membangun kemitraan strategis dengan industri migas dan institusi pendidikan internasional.', NULL, 'Mampu merancang dan mengoptimalkan sistem produksi minyak dan gas bumi dengan mempertimbangkan aspek reservoir, drilling, dan production engineering. Menguasai teknologi Enhanced Oil Recovery (EOR) dan teknologi energi terbarukan. Memiliki kemampuan analisis ekonomi proyek migas dan manajemen risiko. Mampu bekerja dalam lingkungan multikultural dan memiliki kemampuan komunikasi yang baik. Memahami regulasi dan standar keselamatan industri migas internasional.', '<p>Program Studi Teknik Informatika adalah program studi yang mempelajari dan menerapkan prinsip-prinsip ilmu komputer dan analisis matematis dalam perancangan, pengujian, pengembangan, dan evaluasi sistem operasi, perangkat lunak, dan kinerja komputer.</p>\r\n\r\n<p>Lulusan program studi ini diharapkan mampu merancang, mengimplementasi, dan memelihara sistem perangkat lunak yang kompleks, serta memiliki kemampuan untuk beradaptasi dengan perkembangan teknologi yang cepat.</p>', '/storage/assets/img/program-studi/prodi_1754276638_6890231eadc5c.jpg', 'A', '2025-08-04', '2029-08-04', 'Mozes Sapari', '2000', '', 1, '2025-08-03 20:03:58', '2025-08-03 20:03:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `questionnaires`
--

CREATE TABLE `questionnaires` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `title`, `description`, `prodi_id`, `semester`, `academic_year`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'EDOM Semester Ganjil 2025/2026', 'EDOM Semester Ganjil 2025/2026', 3, 'Ganjil', '2025/20251', 1, '2025-08-27', '2025-10-08', '2025-08-27 03:35:17', '2025-08-27 03:35:17'),
(2, 'Test Kuesioner', 'Test Kuesioner', 3, 'Ganjil', '2025/20251', 1, '2025-12-04', '2025-12-31', '2025-12-04 19:15:57', '2025-12-04 19:20:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `questionnaire_categories`
--

CREATE TABLE `questionnaire_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `questionnaire_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `questionnaire_categories`
--

INSERT INTO `questionnaire_categories` (`id`, `questionnaire_id`, `name`, `description`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 1, 'Penilaian Dosen', 'Penilaian Dosen', 1, '2025-08-27 03:35:17', '2025-08-27 03:35:17'),
(2, 1, 'Penilaian Matakuliah', 'Penilaian Matakuliah', 2, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(7, 2, 'Test Kuesioner', 'Test Kuesioner', 1, '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(8, 2, 'Test Kuesioner', 'Test Kuesioner', 2, '2025-12-04 19:20:32', '2025-12-04 19:20:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `questionnaire_questions`
--

CREATE TABLE `questionnaire_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` enum('radio','textarea','select') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'radio',
  `options` json DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `is_for_lecturer` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `questionnaire_questions`
--

INSERT INTO `questionnaire_questions` (`id`, `category_id`, `question_text`, `input_type`, `options`, `is_required`, `is_for_lecturer`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 1, 'Penilaian Dosen A', 'radio', '[1, 2, 3, 4]', 1, 1, 1, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(2, 1, 'Penilaian Dosen B', 'radio', '[1, 2, 3, 4]', 1, 1, 2, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(3, 1, 'Penilaian Dosen C', 'radio', '[1, 2, 3, 4]', 1, 1, 3, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(4, 2, 'Penilaian Matakuliah A', 'radio', '[1, 2, 3, 4]', 1, 1, 1, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(5, 2, 'Penilaian Matakuliah B', 'radio', '[1, 2, 3, 4]', 1, 1, 2, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(6, 2, 'Penilaian Matakuliah C', 'radio', '[1, 2, 3, 4]', 1, 1, 3, '2025-08-27 03:35:18', '2025-08-27 03:35:18'),
(15, 7, 'Test Kuesioner', 'radio', '[1, 2, 3, 4]', 1, 1, 1, '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(16, 7, 'Test Kuesioner', 'radio', '[1, 2, 3, 4]', 1, 1, 2, '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(17, 8, 'Test Kuesioner', 'radio', '[1, 2, 3, 4]', 1, 1, 1, '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(18, 8, 'Test Kuesioner', 'radio', '[1, 2, 3, 4]', 1, 1, 2, '2025-12-04 19:20:32', '2025-12-04 19:20:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `questionnaire_scale_options`
--

CREATE TABLE `questionnaire_scale_options` (
  `id` bigint UNSIGNED NOT NULL,
  `questionnaire_id` bigint UNSIGNED NOT NULL,
  `value` int NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `questionnaire_scale_options`
--

INSERT INTO `questionnaire_scale_options` (`id`, `questionnaire_id`, `value`, `label`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Tidak Memuaskan', '2025-08-27 03:35:17', '2025-08-27 03:35:17'),
(2, 1, 2, 'Cukup Memuaskan', '2025-08-27 03:35:17', '2025-08-27 03:35:17'),
(3, 1, 3, 'Memuaskan', '2025-08-27 03:35:17', '2025-08-27 03:35:17'),
(4, 1, 4, 'Sangat Memuaskan', '2025-08-27 03:35:17', '2025-08-27 03:35:17'),
(13, 2, 1, 'Tidak Memuaskan', '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(14, 2, 2, 'Cukup Memuaskan', '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(15, 2, 3, 'Memuaskan', '2025-12-04 19:20:32', '2025-12-04 19:20:32'),
(16, 2, 4, 'Sangat Memuaskan', '2025-12-04 19:20:32', '2025-12-04 19:20:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'editor', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'user', 'web', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'super_admin', 'web', '2025-08-09 10:27:40', '2025-08-09 10:27:40'),
(5, 'petugas_umum', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(6, 'orang_tua', 'web', '2025-08-09 10:30:00', '2025-08-09 10:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(14, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(85, 1),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(13, 2),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 4),
(38, 4),
(39, 4),
(40, 4),
(41, 4),
(42, 4),
(43, 4),
(44, 4),
(45, 4),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 4),
(52, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(58, 4),
(59, 4),
(60, 4),
(61, 4),
(62, 4),
(63, 4),
(64, 4),
(65, 4),
(66, 4),
(67, 4),
(68, 4),
(69, 4),
(70, 4),
(71, 4),
(72, 4),
(73, 4),
(74, 4),
(75, 4),
(76, 4),
(77, 4),
(78, 4),
(79, 4),
(80, 4),
(81, 4),
(82, 4),
(83, 4),
(84, 4),
(85, 4),
(14, 5),
(24, 5),
(29, 5),
(33, 5),
(34, 5),
(35, 5),
(37, 5),
(38, 5),
(42, 5),
(46, 5),
(50, 5),
(54, 5),
(56, 5),
(58, 5),
(62, 5),
(66, 5),
(67, 5),
(70, 5),
(75, 5),
(80, 5),
(85, 5),
(14, 6),
(84, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rps`
--

CREATE TABLE `rps` (
  `id` bigint UNSIGNED NOT NULL,
  `mata_kuliah_id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `academic_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('ganjil','genap','pendek') COLLATE utf8mb4_unicode_ci NOT NULL,
  `learning_objectives` text COLLATE utf8mb4_unicode_ci,
  `learning_outcomes` text COLLATE utf8mb4_unicode_ci,
  `assessment_methods` text COLLATE utf8mb4_unicode_ci,
  `references` text COLLATE utf8mb4_unicode_ci,
  `document_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','approved','revision') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rps`
--

INSERT INTO `rps` (`id`, `mata_kuliah_id`, `dosen_id`, `academic_year`, `semester`, `learning_objectives`, `learning_outcomes`, `assessment_methods`, `references`, `document_url`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 24, 1, '2025/2026', 'ganjil', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, aut nobis, nisi itaque quaerat est fugiat quas pariatur officiis vel, excepturi quo ut fugit totam provident? Ut mollitia recusandae in perspiciatis doloribus, nam similique? Illum culpa voluptas cum nostrum aperiam. Illo asperiores repellendus repudiandae veniam tenetur maxime aspernatur optio adipisci fuga veritatis necessitatibus officiis sequi ut, ipsum doloremque magni reiciendis dolor enim vero eveniet quia dignissimos! Aut delectus nam quisquam placeat? Soluta, magni voluptates iusto a unde laborum quia laboriosam tempore nulla amet. Praesentium necessitatibus ipsa sed tenetur aliquam, reiciendis quis sapiente suscipit. Minus quis eveniet dolore facilis. Sapiente, dolores!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, aut nobis, nisi itaque quaerat est fugiat quas pariatur officiis vel, excepturi quo ut fugit totam provident? Ut mollitia recusandae in perspiciatis doloribus, nam similique? Illum culpa voluptas cum nostrum aperiam. Illo asperiores repellendus repudiandae veniam tenetur maxime aspernatur optio adipisci fuga veritatis necessitatibus officiis sequi ut, ipsum doloremque magni reiciendis dolor enim vero eveniet quia dignissimos! Aut delectus nam quisquam placeat? Soluta, magni voluptates iusto a unde laborum quia laboriosam tempore nulla amet. Praesentium necessitatibus ipsa sed tenetur aliquam, reiciendis quis sapiente suscipit. Minus quis eveniet dolore facilis. Sapiente, dolores!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, aut nobis, nisi itaque quaerat est fugiat quas pariatur officiis vel, excepturi quo ut fugit totam provident? Ut mollitia recusandae in perspiciatis doloribus, nam similique? Illum culpa voluptas cum nostrum aperiam. Illo asperiores repellendus repudiandae veniam tenetur maxime aspernatur optio adipisci fuga veritatis necessitatibus officiis sequi ut, ipsum doloremque magni reiciendis dolor enim vero eveniet quia dignissimos! Aut delectus nam quisquam placeat? Soluta, magni voluptates iusto a unde laborum quia laboriosam tempore nulla amet. Praesentium necessitatibus ipsa sed tenetur aliquam, reiciendis quis sapiente suscipit. Minus quis eveniet dolore facilis. Sapiente, dolores!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, aut nobis, nisi itaque quaerat est fugiat quas pariatur officiis vel, excepturi quo ut fugit totam provident? Ut mollitia recusandae in perspiciatis doloribus, nam similique? Illum culpa voluptas cum nostrum aperiam. Illo asperiores repellendus repudiandae veniam tenetur maxime aspernatur optio adipisci fuga veritatis necessitatibus officiis sequi ut, ipsum doloremque magni reiciendis dolor enim vero eveniet quia dignissimos! Aut delectus nam quisquam placeat? Soluta, magni voluptates iusto a unde laborum quia laboriosam tempore nulla amet. Praesentium necessitatibus ipsa sed tenetur aliquam, reiciendis quis sapiente suscipit. Minus quis eveniet dolore facilis. Sapiente, dolores!', 'assets/docs/rps/rps_1754668557_68961e0d90ac2.pdf', 'draft', NULL, NULL, '2025-08-08 08:55:57', '2025-08-08 08:55:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rps_weekly_plans`
--

CREATE TABLE `rps_weekly_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `rps_id` bigint UNSIGNED NOT NULL,
  `week_number` int NOT NULL,
  `topic` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `learning_materials` text COLLATE utf8mb4_unicode_ci,
  `teaching_methods` text COLLATE utf8mb4_unicode_ci,
  `assignments` text COLLATE utf8mb4_unicode_ci,
  `assessment` text COLLATE utf8mb4_unicode_ci,
  `references` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('drPOQRVCY5ci0Z80ytwy0crzGARXrc6MrUn68MgY', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1hjOU00RDNZTnhzbzdQenBvSjFYY0ZuVTFyb1htYzFZUUJlSWtLWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770811208),
('E3iuOh0vVwInsbcg2UhnyvgLq7ayoDuCNYKkMqd5', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGFOMUMzZEhDc2pmZVRXVGRkczNsb1ZDYURyNEpqMXkzZHpKMTJsZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770868508),
('HZgelJj8ebHVI4N3lHgmJdp1hddCPHvaEiOSyWuA', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQkpqbTVpQmZQRDlPY1V3ejlnV0FMamN3ek1yaXh5UFpQUEsyVWNEYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770858076),
('icdsodNAqz0eWHhki4TZ1UnEOjp1NP3KAmKtZYyn', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDFvbFc2eDN1b3lUTXFoRkt0end4eUtCMlBiSUFodk1Md2hrUHU0diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770699532),
('ieX09Tw9E13NnmsrTE6ahdk1KoIiXcf69kKlkHNp', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOElPaFVHb3RsYm9xOTZyMnlRR0xjc0RwaEVpU1k0VGtKaWprcHhaaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1775704207),
('msOJc6qyDpJWt5Be37bS9vir4P6eWDtsTkcMYyrS', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRng4cUJWOFQ2V2cxSmFDM0xDakZJTUxXaUJCMjMyRlJybDBPbzluMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770783950),
('PyRTnraCBy1QeuxdSKVKQBVblodVocY10nYK9jJZ', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidzdtSkFZY3htREd6Mmc5VUVIRTIwS25xQUJUMlA0UDQwcEo2MlRoViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770712955),
('rkF1fTzpGS9ailMniv2BucqT9b625w780DrcfGi0', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkhFdU1XNGNHcUlUREdsU1U2SENicXM5cHlRakpYMWduTFZaY0ZlbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770739206),
('s2DaUxTuHyVHkU0zEBdhLveTboqUHVTLf8HqNejL', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWh6bW00c3d1eDNjT0dUMkFpV2hPMG95OHExZTVwdlJrQUlsOUJuVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770818699),
('U4j7uWI7NC4P2pBrryWuUVVnKEIwaAxE3QzaJh3g', NULL, '192.168.65.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGg5dU9vNDluQUN5TUZjS3F4UWEyUnh0RUtmOU96SnZpN3V1bTlFQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hbHVtbmkvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770829164);

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `description` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `site_settings`
--

INSERT INTO `site_settings` (`id`, `key_name`, `value`, `type`, `description`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_title', 'FTPP', 'text', NULL, 'general', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'site_description', 'Fakultas Teknik Perminyakan dan Pertambangan - UNIPA', 'text', NULL, 'general', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'site_logo', '/images/logo.png', 'file', NULL, 'general', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'favicon', '/images/favicon.ico', 'file', NULL, 'general', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 'contact_email', 'info@fti.ac.id', 'email', NULL, 'contact', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'contact_phone', '+62 21 7918 1234', 'text', NULL, 'contact', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 'contact_fax', '+62 21 7918 1235', 'text', NULL, 'contact', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 'address', 'Jl. Pendidikan No. 123, Jakarta Selatan 12950, Indonesia', 'textarea', NULL, 'contact', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 'facebook_url', 'https://facebook.com/fti.university', 'url', NULL, 'social', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(10, 'instagram_url', 'https://instagram.com/fti_university', 'url', NULL, 'social', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(11, 'youtube_url', 'https://youtube.com/@fti-university', 'url', NULL, 'social', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(12, 'linkedin_url', 'https://linkedin.com/school/fti-university', 'url', NULL, 'social', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(13, 'meta_keywords', 'fakultas, teknologi informasi, universitas, pendidikan, IT, komputer', 'text', NULL, 'seo', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(14, 'google_analytics_id', 'G-XXXXXXXXXX', 'text', NULL, 'seo', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(15, 'theme_color', '#3B82F6', 'color', NULL, 'appearance', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(16, 'items_per_page', '12', 'number', NULL, 'general', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(17, 'enable_news', '1', 'boolean', NULL, 'features', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(18, 'enable_events', '1', 'boolean', NULL, 'features', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(19, 'enable_gallery', '1', 'boolean', NULL, 'features', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(20, 'enable_testimonials', '1', 'boolean', NULL, 'features', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(21, 'testimoni_back', '/storage/assets/img/imgBg1.jpg', 'text', NULL, 'general', NULL, NULL),
(28, 'tujuan', 'Menghasilkan lulusan yang berkompeten di bidang teknik pertambangan dan perminyakan, berkontribusi dalam pengembangan sumber daya alam Papua secara berkelanjutan, dan menjadi pusat unggulan penelitian dan pengabdian masyarakat di Indonesia Timur.', 'textarea', 'Tujuan Fakultas Teknik Pertambangan Perminyakan', 'general', '2025-09-07 15:15:28', '2025-09-07 15:15:28'),
(29, 'milestones', '[\r\n  {\"year\": \"1985\", \"event\": \"Pendirian Fakultas Teknik Pertambangan\"},\r\n  {\"year\": \"1992\", \"event\": \"Pembukaan Program Studi Teknik Perminyakan\"},\r\n  {\"year\": \"2005\", \"event\": \"Pembukaan Program Studi Teknik Geologi\"},\r\n  {\"year\": \"2010\", \"event\": \"Memperoleh Akreditasi A dari BAN-PT\"},\r\n  {\"year\": \"2015\", \"event\": \"Pembukaan Program Magister Teknik Pertambangan\"},\r\n  {\"year\": \"2020\", \"event\": \"Pembukaan Program Doktor Teknik Pertambangan\"},\r\n  {\"year\": \"2023\", \"event\": \"Kerjasama Internasional dengan Universitas di Australia\"}\r\n]', 'json', 'Timeline Milestone Penting Fakultas', 'general', '2025-09-07 15:15:28', '2025-09-07 15:15:28'),
(30, 'milestone_details', '[\r\n  {\r\n    \"year\": \"1985\",\r\n    \"title\": \"Pendirian Fakultas Teknik Pertambangan\",\r\n    \"description\": \"Fakultas Teknik Pertambangan Perminyakan didirikan sebagai bagian dari komitmen Universitas Papua untuk mengembangkan sumber daya alam Papua secara berkelanjutan dan bertanggung jawab.\"\r\n  },\r\n  {\r\n    \"year\": \"1992\", \r\n    \"title\": \"Ekspansi Program Studi\",\r\n    \"description\": \"Pembukaan Program Studi Teknik Perminyakan untuk memenuhi kebutuhan industri energi di Indonesia Timur dan mendukung pengembangan sektor migas di Papua.\"\r\n  },\r\n  {\r\n    \"year\": \"2005\",\r\n    \"title\": \"Diversifikasi Keilmuan\",\r\n    \"description\": \"Program Studi Teknik Geologi dibuka untuk memperkuat basis keilmuan geosains di Papua dan mendukung eksplorasi sumber daya mineral.\"\r\n  },\r\n  {\r\n    \"year\": \"2010\",\r\n    \"title\": \"Pengakuan Kualitas Nasional\",\r\n    \"description\": \"Memperoleh Akreditasi A dari BAN-PT sebagai pengakuan atas kualitas pendidikan tinggi yang diberikan dan standar akademik yang terjaga.\"\r\n  },\r\n  {\r\n    \"year\": \"2015\",\r\n    \"title\": \"Pendidikan Pascasarjana\",\r\n    \"description\": \"Pembukaan Program Magister Teknik Pertambangan untuk menghasilkan ahli tingkat lanjut yang mampu melakukan penelitian dan pengembangan teknologi pertambangan.\"\r\n  },\r\n  {\r\n    \"year\": \"2020\",\r\n    \"title\": \"Pusat Penelitian dan Pengembangan\",\r\n    \"description\": \"Program Doktor dibuka untuk memperkuat riset dan pengembangan ilmu pengetahuan di bidang pertambangan dan perminyakan, serta menciptakan peneliti berkualitas tinggi.\"\r\n  },\r\n  {\r\n    \"year\": \"2023\",\r\n    \"title\": \"Kerjasama Internasional\",\r\n    \"description\": \"Menjalin kerjasama dengan universitas-universitas terkemuka di Australia untuk pertukaran mahasiswa, penelitian bersama, dan pengembangan kurikulum internasional.\"\r\n  }\r\n]', 'json', 'Detail Milestone dan Pencapaian Fakultas', 'general', '2025-09-07 15:15:28', '2025-09-07 15:15:28'),
(31, 'history_images', '[\r\n  {\r\n    \"url\": \"storage/assets/img/history/founding-1985.jpg\",\r\n    \"caption\": \"Foto peresmian Fakultas Teknik Pertambangan tahun 1985\",\r\n    \"year\": \"1985\"\r\n  },\r\n  {\r\n    \"url\": \"storage/assets/img/history/first-graduation-1989.jpg\", \r\n    \"caption\": \"Wisuda pertama lulusan Teknik Pertambangan\",\r\n    \"year\": \"1989\"\r\n  },\r\n  {\r\n    \"url\": \"storage/assets/img/history/petroleum-program-1992.jpg\",\r\n    \"caption\": \"Pembukaan Program Studi Teknik Perminyakan\",\r\n    \"year\": \"1992\"\r\n  },\r\n  {\r\n    \"url\": \"storage/assets/img/history/geology-lab-2005.jpg\",\r\n    \"caption\": \"Laboratorium Teknik Geologi yang baru diresmikan\",\r\n    \"year\": \"2005\"\r\n  },\r\n  {\r\n    \"url\": \"storage/assets/img/history/accreditation-2010.jpg\",\r\n    \"caption\": \"Penyerahan sertifikat akreditasi A dari BAN-PT\",\r\n    \"year\": \"2010\"\r\n  },\r\n  {\r\n    \"url\": \"storage/assets/img/history/master-program-2015.jpg\",\r\n    \"caption\": \"Pembukaan program Magister Teknik Pertambangan\",\r\n    \"year\": \"2015\"\r\n  }\r\n]', 'json', 'Galeri Gambar Sejarah Fakultas', 'general', '2025-09-07 15:15:28', '2025-09-07 15:15:28'),
(32, 'sejarah', 'Fakultas Teknik Pertambangan Perminyakan Universitas Papua didirikan pada tahun 1985 sebagai respons terhadap kebutuhan pengembangan sumber daya alam di Papua. Berawal dari Program Studi Teknik Pertambangan, fakultas ini kemudian berkembang dengan membuka Program Studi Teknik Perminyakan pada tahun 1992 dan Program Studi Teknik Geologi pada tahun 2005.\r\n\r\nPerjalanan fakultas ini tidak lepas dari komitmen untuk menghasilkan lulusan yang kompeten dan siap menghadapi tantangan industri pertambangan dan perminyakan. Pada tahun 2010, fakultas meraih pengakuan nasional dengan memperoleh akreditasi A dari BAN-PT untuk semua program studinya.\r\n\r\nSeiring dengan perkembangan zaman, fakultas terus berinovasi dengan membuka program pascasarjana. Program Magister Teknik Pertambangan dibuka pada tahun 2015, diikuti dengan Program Doktor Teknik Pertambangan pada tahun 2020. \r\n\r\nSaat ini, Fakultas Teknik Pertambangan Perminyakan telah menjadi salah satu fakultas unggulan di Universitas Papua dengan lebih dari 1.500 mahasiswa aktif dan telah menghasilkan ribuan alumni yang tersebar di berbagai industri pertambangan dan perminyakan di Indonesia dan luar negeri.\r\n\r\nFakultas ini juga aktif dalam penelitian dan pengabdian masyarakat, khususnya dalam pengembangan teknologi pertambangan ramah lingkungan dan pemberdayaan masyarakat lokal Papua dalam sektor pertambangan.', 'textarea', 'Sejarah Lengkap Fakultas', 'general', '2025-09-07 15:15:28', '2025-09-07 15:15:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stats`
--

CREATE TABLE `stats` (
  `id` bigint UNSIGNED NOT NULL,
  `total_students` int NOT NULL DEFAULT '0',
  `total_partnerships` int NOT NULL DEFAULT '0',
  `total_alumni` int NOT NULL DEFAULT '0',
  `total_lecturers` int NOT NULL DEFAULT '0',
  `year` year NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stats`
--

INSERT INTO `stats` (`id`, `total_students`, `total_partnerships`, `total_alumni`, `total_lecturers`, `year`, `is_current`, `created_at`, `updated_at`) VALUES
(1, 2547, 85, 12350, 65, '2025', 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 2398, 78, 11245, 62, '2024', 0, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 2156, 71, 10120, 58, '2023', 0, '2025-07-17 09:20:04', '2025-07-17 09:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `program_studi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_id` bigint UNSIGNED DEFAULT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','cuti','lulus','DO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `tahun_masuk` year DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`id`, `nim`, `name`, `email`, `phone`, `gender`, `birth_date`, `birth_place`, `address`, `program_studi`, `prodi_id`, `semester`, `status`, `tahun_masuk`, `ipk`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2023001', 'Ahmad Fauzi', 'ahmad@email.com', '08123456789', 'L', '2000-01-15', 'Jakarta', 'Jl. Merdeka No. 1', 'Teknik Pertambangan', 2, '3', 'aktif', '2023', NULL, 1, '2025-08-12 08:09:11', '2025-08-12 08:09:11'),
(2, '2023002', 'Siti Aminah', 'siti@email.com', '08123456790', 'P', '1999-03-20', 'Surabaya', 'Jl. Pahlawan No. 5', 'Teknik Geologi', 3, '5', 'aktif', '2023', NULL, 1, '2025-08-12 08:09:11', '2025-08-12 08:09:11'),
(3, '2025001', 'Test Student', 'parent@example.com', '081234567890', 'L', '2000-01-01', 'Jakarta', 'Test Address', 'Teknik Geologi', 3, '6', 'aktif', '2022', 3.50, 1, '2025-08-16 08:42:00', '2025-08-16 08:42:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teams`
--

CREATE TABLE `teams` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `photo_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` text COLLATE utf8mb4_unicode_ci,
  `expertise` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `teams`
--

INSERT INTO `teams` (`id`, `name`, `position_id`, `prodi_id`, `email`, `phone`, `bio`, `photo_url`, `education`, `expertise`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 'Prof. Dr. Ir. Bambang Supriyanto, M.Sc.', 1, NULL, 'dekan@fti.ac.id', '+62 21 7918 1240', 'Profesor dengan pengalaman 25 tahun di bidang teknologi informasi. Memiliki fokus penelitian pada artificial intelligence dan machine learning.', 'assets/img/team/team-1.jpg', 'S1: Teknik Elektro ITB (1985), S2: Computer Science Stanford University (1990), S3: Computer Science MIT (1995)', 'Artificial Intelligence, Machine Learning, Data Mining, Computer Vision', 1, 1, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'Dr. Siti Nurhaliza, M.Kom.', 2, NULL, 'wadek1@fti.ac.id', '+62 21 7918 1241', 'Wakil Dekan I bidang Akademik dengan fokus pada pengembangan kurikulum dan quality assurance.', 'assets/img/team/team-2.jpg', 'S1: Teknik Informatika UI (1995), S2: Sistem Informasi UGM (2000), S3: Computer Science USU (2008)', 'Software Engineering, Database Systems, Information Systems', 1, 2, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'Dr. Budi Santoso, M.Kom.', 5, NULL, 'kaprodi.tif@fti.ac.id', '+62 21 7918 1250', 'Ketua Program Studi Teknik Informatika dengan pengalaman 15 tahun dalam pengembangan software dan penelitian AI.', 'assets/img/team/team-3.jpg', 'S1: Teknik Informatika ITS (1998), S2: Computer Science UGM (2003), S3: Computer Science UI (2010)', 'Software Engineering, Web Development, Mobile Programming, AI', 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'Dr. Sari Indrawati, M.SI.', 5, 2, 'kaprodi.sif@fti.ac.id', '+62 21 7918 1251', 'Ketua Program Studi Sistem Informasi dengan spesialisasi dalam business intelligence dan enterprise systems.', 'assets/img/team/team-1.jpg', 'S1: Sistem Informasi Binus (2000), S2: Manajemen Sistem Informasi UI (2005), S3: Information Systems UGM (2012)', 'Business Intelligence, Enterprise Systems, Data Analytics, Project Management', 1, 3, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 'Prof. Dr. Ahmad Dahlan, M.T.', 7, NULL, 'ahmad.dahlan@fti.ac.id', '+62 21 7918 1260', 'Dosen berpengalaman dengan fokus penelitian di bidang Network Security, Cryptography, Cybersecurity', 'assets/img/team/team-2.jpg', 'S1, S2, S3 di bidang terkait', 'Network Security, Cryptography, Cybersecurity', 1, 10, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'Dr. Maya Sari, M.Kom.', 9, NULL, 'maya.sari@fti.ac.id', '+62 21 7918 1261', 'Dosen berpengalaman dengan fokus penelitian di bidang Human-Computer Interaction, UI/UX Design, Mobile Development', 'assets/img/team/team-3.jpg', 'S1, S2, S3 di bidang terkait', 'Human-Computer Interaction, UI/UX Design, Mobile Development', 1, 11, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 'Dr. Rudi Hartono, M.T.', 9, 2, 'rudi.hartono@fti.ac.id', '+62 21 7918 1262', 'Dosen berpengalaman dengan fokus penelitian di bidang Database Management, Big Data, Data Warehousing', 'assets/img/team/team-1.jpg', 'S1, S2, S3 di bidang terkait', 'Database Management, Big Data, Data Warehousing', 1, 12, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 'Dr. Rina Kusuma, M.SI.', 9, 2, 'rina.kusuma@fti.ac.id', '+62 21 7918 1263', 'Dosen berpengalaman dengan fokus penelitian di bidang Business Process Management, ERP Systems, Digital Transformation', 'assets/img/team/team-2.jpg', 'S1, S2, S3 di bidang terkait', 'Business Process Management, ERP Systems, Digital Transformation', 1, 13, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 'Dr. Dosen Test 1', 9, 3, 'example_dosen1@mail.com', NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-09-01 05:06:36', '2025-09-01 05:06:36'),
(10, 'Dr. Dosen Test 2', 9, 3, 'example_dosen2@mail.com', NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-09-01 05:06:36', '2025-09-01 05:06:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `team_positions`
--

CREATE TABLE `team_positions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `team_positions`
--

INSERT INTO `team_positions` (`id`, `name`, `level`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Dekan', 1, 'Pimpinan tertinggi fakultas', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'Wakil Dekan I', 2, 'Wakil Dekan bidang Akademik', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'Wakil Dekan II', 2, 'Wakil Dekan bidang Keuangan dan Umum', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'Wakil Dekan III', 2, 'Wakil Dekan bidang Kemahasiswaan', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 'Ketua Program Studi', 3, 'Pimpinan program studi', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'Sekretaris Program Studi', 4, 'Sekretaris program studi', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 'Profesor', 5, 'Guru Besar', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 'Lektor Kepala', 6, 'Dosen senior', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 'Lektor', 7, 'Dosen madya', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(10, 'Asisten Ahli', 8, 'Dosen muda', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(11, 'Tenaga Kependidikan', 9, 'Staff administrasi', '2025-07-17 09:20:04', '2025-07-17 09:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `prodi_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('alumni','student','industry','parent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'alumni',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `position`, `company`, `content`, `photo_url`, `rating`, `prodi_id`, `type`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Sarah Michelle', 'Software Engineer', 'Google Indonesia', 'Pendidikan di Fakultas TI memberikan foundation yang sangat kuat dalam programming dan software development. Kurikulumnya sangat up-to-date dengan kebutuhan industri.', 'https://randomuser.me/api/portraits/women/10.jpg', 5, NULL, 'alumni', 1, 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(2, 'Ahmad Fauzi', 'Data Scientist', 'Tokopedia', 'Program Sistem Informasi di FTI tidak hanya mengajarkan teknologi, tapi juga business process yang sangat valuable di dunia kerja. Terima kasih untuk semua ilmu yang diberikan.', 'https://randomuser.me/api/portraits/men/10.jpg', 5, 2, 'alumni', 1, 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(3, 'Jessica Tan', 'UI/UX Designer', 'Gojek', 'Dosen-dosen di FTI sangat supportive dan selalu mendorong mahasiswa untuk berkembang. Lab dan fasilitasnya juga lengkap untuk praktikum.', 'https://randomuser.me/api/portraits/women/11.jpg', 5, NULL, 'student', 1, 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(4, 'Budi Santoso', 'IT Manager', 'Bank BCA', 'Lulusan FTI yang bekerja di perusahaan kami selalu menunjukkan performa yang excellent. Mereka memiliki technical skill dan soft skill yang baik.', 'https://randomuser.me/api/portraits/men/11.jpg', 5, NULL, 'industry', 1, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(5, 'Maria Gonzales', 'Network Administrator', 'PT. Telkom Indonesia', 'Program D3 TI sangat praktis dan langsung applicable di dunia kerja. Setelah lulus langsung bisa kerja tanpa perlu training tambahan yang lama.', 'https://randomuser.me/api/portraits/women/12.jpg', 4, 3, 'alumni', 1, 0, '2025-07-17 09:20:05', '2025-07-17 09:20:05'),
(6, 'Dr. Hendro Wicaksono', 'Research Scientist', 'Microsoft Research', 'Program S2 di FTI memberikan kesempatan untuk melakukan riset yang berkualitas tinggi dengan guidance dari supervisor yang expert di bidangnya.', 'https://randomuser.me/api/portraits/men/12.jpg', 5, NULL, 'alumni', 1, 1, '2025-07-17 09:20:05', '2025-07-17 09:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_active`, `profile_photo_path`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@fakultas.ac.id', '2025-07-17 09:20:04', 1, NULL, '$2y$12$ZmNop6vYrmIxys6KMydF/u96TwuoOKNfy8O.6lhRv5L/VWAqQFQTe', NULL, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(2, 'Editor', 'editor@fakultas.ac.id', '2025-07-17 09:20:04', 1, NULL, '$2y$12$GoTCre.8kqDjmhfj5ceWieeH0uaDwBtmA5N57nNuxG71UTAkYMHhC', NULL, '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(3, 'Odell Gulgowski', 'allen.gutmann@example.com', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'stv6PeWMNv', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(4, 'Joelle Spinka', 'demetrius11@example.com', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'yTtyR3GUMg', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(5, 'Dr. Iliana Beahan', 'malinda65@example.net', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'aB0OctFQcK', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(6, 'Mr. Jettie Leffler', 'bria92@example.com', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'ldUIslfM9N', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(7, 'Dr. Jacquelyn Lakin I', 'kcrooks@example.org', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'KRoZ96C4r6', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(8, 'Hector Hudson DDS', 'emmett.franecki@example.net', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'CEIhLlXY3a', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(9, 'Amya Pacocha PhD', 'wallace.ohara@example.com', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'folrSr4G3u', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(10, 'Myrtis Satterfield', 'ibergstrom@example.net', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'W1Qmptdx0u', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(11, 'Marquis Nitzsche', 'lelah39@example.com', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', '8nIcfmh7rF', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(12, 'Ahmad Schneider', 'ali.stroman@example.net', '2025-07-17 09:20:04', 1, NULL, '$2y$12$uAKz7EemT7Hw3felWGl70eVuJ7z8oDjuHbGaF2Tp6ds.b0Pg8nfZ.', 'kQ6cnWyJ7X', '2025-07-17 09:20:04', '2025-07-17 09:20:04'),
(13, 'Super Administrator', 'superadmin@faculty.ac.id', '2025-08-09 10:30:00', 1, NULL, '$2y$12$iFPmWPocKLy/Ym3p4ksXm.avTOA6xCC.cUNunkyMmA/RzKKFW3gGC', NULL, '2025-08-09 10:30:00', '2025-08-09 10:30:00'),
(14, 'Administrator', 'admin@faculty.ac.id', '2025-08-09 10:30:00', 1, NULL, '$2y$12$xo4Q2RLEAH4X/blKBEY.2.OvV22WLPWqppB9r5FAagBwPysfyQTza', NULL, '2025-08-09 10:30:01', '2025-08-09 10:30:01'),
(15, 'Petugas Umum', 'petugas@faculty.ac.id', '2025-08-09 10:30:01', 1, NULL, '$2y$12$oEM6TFN6oxX3axrzDyXBb.EqVFxKGiebytCP4wOOTTycCqN0kJY/O', NULL, '2025-08-09 10:30:01', '2025-08-09 10:30:01'),
(16, 'Orang Tua Demo', 'orangtua@faculty.ac.id', '2025-08-09 10:30:01', 1, NULL, '$2y$12$/N8eetVa9MNonZjGcqpBwu6pdC4DAZNkUFitF0Mmx.4jMbtGXeBCC', NULL, '2025-08-09 10:30:01', '2025-08-09 10:30:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `academic_periods`
--
ALTER TABLE `academic_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_year_semester` (`year`,`semester`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_academic_year` (`academic_year`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contact_infos`
--
ALTER TABLE `contact_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dean_greetings`
--
ALTER TABLE `dean_greetings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_program_studi_documents` (`program_studi_id`),
  ADD KEY `idx_document_type` (`document_type`),
  ADD KEY `idx_active_documents` (`is_active`);

--
-- Indeks untuk tabel `dosen_mata_kuliahs`
--
ALTER TABLE `dosen_mata_kuliahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosen_mk_year_role_unique` (`dosen_id`,`mata_kuliah_id`,`academic_year`,`role`),
  ADD KEY `dosen_mata_kuliahs_mata_kuliah_id_foreign` (`mata_kuliah_id`);

--
-- Indeks untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `evaluations_student_nim_questionnaire_id_unique` (`student_nim`,`questionnaire_id`),
  ADD KEY `eval_lecturer1_idx` (`lecturer_1_id`),
  ADD KEY `eval_lecturer2_idx` (`lecturer_2_id`),
  ADD KEY `eval_submitted_at_idx` (`submitted_at`),
  ADD KEY `eval_questionnaire_idx` (`questionnaire_id`);

--
-- Indeks untuk tabel `evaluation_answers`
--
ALTER TABLE `evaluation_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluation_answers_question_id_foreign` (`question_id`),
  ADD KEY `evaluation_answers_lecturer_id_foreign` (`lecturer_id`),
  ADD KEY `evaluation_answers_evaluation_id_question_id_lecturer_id_index` (`evaluation_id`,`question_id`,`lecturer_id`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facilities_slug_unique` (`slug`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `features_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `gdrive_folders`
--
ALTER TABLE `gdrive_folders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gdrive_folders_gdrive_folder_id_unique` (`gdrive_folder_id`),
  ADD KEY `gdrive_folders_folder_type_index` (`folder_type`),
  ADD KEY `gdrive_folders_academic_period_id_index` (`academic_period_id`),
  ADD KEY `gdrive_folders_gdrive_folder_id_index` (`gdrive_folder_id`);

--
-- Indeks untuk tabel `gpm_dokumen_spmi`
--
ALTER TABLE `gpm_dokumen_spmi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gpm_dokumen_spmi_slug_unique` (`slug`),
  ADD KEY `gpm_dokumen_spmi_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `gpm_dokumen_spmi_category_index` (`category`),
  ADD KEY `gpm_dokumen_spmi_is_published_index` (`is_published`),
  ADD KEY `gpm_dokumen_spmi_document_code_index` (`document_code`),
  ADD KEY `gpm_dokumen_spmi_published_date_index` (`published_date`),
  ADD KEY `gpm_dokumen_spmi_created_at_index` (`created_at`);

--
-- Indeks untuk tabel `gpm_edom_periods`
--
ALTER TABLE `gpm_edom_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gpm_edom_periods_created_by_foreign` (`created_by`),
  ADD KEY `gpm_edom_periods_is_active_index` (`is_active`),
  ADD KEY `gpm_edom_periods_semester_academic_year_index` (`semester`,`academic_year`),
  ADD KEY `gpm_edom_periods_start_date_end_date_index` (`start_date`,`end_date`);

--
-- Indeks untuk tabel `gpm_edom_questions`
--
ALTER TABLE `gpm_edom_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gpm_edom_questions_category_index` (`category`),
  ADD KEY `gpm_edom_questions_is_active_index` (`is_active`),
  ADD KEY `gpm_edom_questions_order_index` (`order`);

--
-- Indeks untuk tabel `gpm_edom_submissions`
--
ALTER TABLE `gpm_edom_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_edom_submission` (`period_id`,`student_id`,`lecturer_id`,`course_code`),
  ADD KEY `gpm_edom_submissions_period_id_index` (`period_id`),
  ADD KEY `gpm_edom_submissions_student_id_index` (`student_id`),
  ADD KEY `gpm_edom_submissions_lecturer_id_index` (`lecturer_id`),
  ADD KEY `gpm_edom_submissions_course_code_index` (`course_code`),
  ADD KEY `gpm_edom_submissions_average_score_index` (`average_score`);

--
-- Indeks untuk tabel `gpm_settings`
--
ALTER TABLE `gpm_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gpm_settings_key_unique` (`key`),
  ADD KEY `gpm_settings_key_index` (`key`),
  ADD KEY `gpm_settings_group_index` (`group`);

--
-- Indeks untuk tabel `gpm_struktur_organisasi`
--
ALTER TABLE `gpm_struktur_organisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gpm_struktur_organisasi_jabatan_index` (`jabatan`),
  ADD KEY `gpm_struktur_organisasi_order_index` (`order`),
  ADD KEY `gpm_struktur_organisasi_is_active_index` (`is_active`);

--
-- Indeks untuk tabel `gpm_surveys`
--
ALTER TABLE `gpm_surveys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gpm_surveys_slug_unique` (`slug`),
  ADD KEY `gpm_surveys_created_by_foreign` (`created_by`),
  ADD KEY `gpm_surveys_target_respondent_index` (`target_respondent`),
  ADD KEY `gpm_surveys_is_active_index` (`is_active`),
  ADD KEY `gpm_surveys_start_date_end_date_index` (`start_date`,`end_date`);

--
-- Indeks untuk tabel `gpm_survey_questions`
--
ALTER TABLE `gpm_survey_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gpm_survey_questions_survey_id_order_index` (`survey_id`,`order`),
  ADD KEY `gpm_survey_questions_type_index` (`type`);

--
-- Indeks untuk tabel `gpm_survey_responses`
--
ALTER TABLE `gpm_survey_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gpm_survey_responses_survey_id_created_at_index` (`survey_id`,`created_at`),
  ADD KEY `gpm_survey_responses_question_id_index` (`question_id`),
  ADD KEY `gpm_survey_responses_user_id_index` (`user_id`),
  ADD KEY `gpm_survey_responses_respondent_identifier_index` (`respondent_identifier`);

--
-- Indeks untuk tabel `hero_sections`
--
ALTER TABLE `hero_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_kuliahs`
--
ALTER TABLE `jadwal_kuliahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_kuliahs_mata_kuliah_id_foreign` (`mata_kuliah_id`),
  ADD KEY `jadwal_kuliahs_dosen_id_foreign` (`dosen_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `khs_access_logs`
--
ALTER TABLE `khs_access_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khs_access_logs_khs_file_id_accessed_at_index` (`khs_file_id`,`accessed_at`),
  ADD KEY `khs_access_logs_parent_id_index` (`parent_id`),
  ADD KEY `khs_access_logs_accessed_at_index` (`accessed_at`);

--
-- Indeks untuk tabel `khs_files`
--
ALTER TABLE `khs_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_period` (`student_id`,`academic_period_id`),
  ADD UNIQUE KEY `khs_files_gdrive_file_id_unique` (`gdrive_file_id`),
  ADD KEY `idx_student_period` (`student_id`,`academic_period_id`),
  ADD KEY `idx_period` (`academic_period_id`),
  ADD KEY `idx_student` (`student_id`),
  ADD KEY `idx_gdrive` (`gdrive_file_id`),
  ADD KEY `idx_status` (`upload_status`),
  ADD KEY `idx_nim` (`student_nim`),
  ADD KEY `idx_uploader` (`uploaded_by`);

--
-- Indeks untuk tabel `kurikulums`
--
ALTER TABLE `kurikulums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kurikulums_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `mata_kuliahs`
--
ALTER TABLE `mata_kuliahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mata_kuliahs_code_unique` (`code`),
  ADD KEY `mata_kuliahs_kurikulum_id_foreign` (`kurikulum_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_category_id_foreign` (`category_id`),
  ADD KEY `news_author_id_foreign` (`author_id`);

--
-- Indeks untuk tabel `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parents_username_unique` (`username`),
  ADD KEY `parents_student_id_foreign` (`student_id`);

--
-- Indeks untuk tabel `parent_khs_access_logs`
--
ALTER TABLE `parent_khs_access_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_access` (`parent_id`,`accessed_at`),
  ADD KEY `idx_khs_access` (`khs_file_id`,`accessed_at`),
  ADD KEY `idx_access_type` (`access_type`),
  ADD KEY `idx_accessed_at` (`accessed_at`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penjaminan_mutus`
--
ALTER TABLE `penjaminan_mutus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjaminan_mutus_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `program_studis`
--
ALTER TABLE `program_studis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_studis_code_unique` (`code`);

--
-- Indeks untuk tabel `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaires_prodi_idx` (`prodi_id`);

--
-- Indeks untuk tabel `questionnaire_categories`
--
ALTER TABLE `questionnaire_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_categories_questionnaire_id_foreign` (`questionnaire_id`);

--
-- Indeks untuk tabel `questionnaire_questions`
--
ALTER TABLE `questionnaire_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_questions_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `questionnaire_scale_options`
--
ALTER TABLE `questionnaire_scale_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_scale_options_questionnaire_id_foreign` (`questionnaire_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `rps`
--
ALTER TABLE `rps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rps_mata_kuliah_id_foreign` (`mata_kuliah_id`),
  ADD KEY `rps_dosen_id_foreign` (`dosen_id`);

--
-- Indeks untuk tabel `rps_weekly_plans`
--
ALTER TABLE `rps_weekly_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rps_weekly_plans_rps_id_foreign` (`rps_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_name_unique` (`key_name`);

--
-- Indeks untuk tabel `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_nim_unique` (`nim`),
  ADD KEY `students_prodi_id_index` (`prodi_id`);

--
-- Indeks untuk tabel `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teams_email_unique` (`email`),
  ADD KEY `teams_position_id_foreign` (`position_id`),
  ADD KEY `teams_prodi_idx` (`prodi_id`),
  ADD KEY `teams_is_active_idx` (`is_active`);

--
-- Indeks untuk tabel `team_positions`
--
ALTER TABLE `team_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD PRIMARY KEY (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indeks untuk tabel `telescope_monitoring`
--
ALTER TABLE `telescope_monitoring`
  ADD PRIMARY KEY (`tag`);

--
-- Indeks untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_prodi_id_foreign` (`prodi_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `academic_periods`
--
ALTER TABLE `academic_periods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `contact_infos`
--
ALTER TABLE `contact_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dean_greetings`
--
ALTER TABLE `dean_greetings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `dosen_mata_kuliahs`
--
ALTER TABLE `dosen_mata_kuliahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `evaluation_answers`
--
ALTER TABLE `evaluation_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `gdrive_folders`
--
ALTER TABLE `gdrive_folders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gpm_dokumen_spmi`
--
ALTER TABLE `gpm_dokumen_spmi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gpm_edom_periods`
--
ALTER TABLE `gpm_edom_periods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gpm_edom_questions`
--
ALTER TABLE `gpm_edom_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `gpm_edom_submissions`
--
ALTER TABLE `gpm_edom_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gpm_settings`
--
ALTER TABLE `gpm_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `gpm_struktur_organisasi`
--
ALTER TABLE `gpm_struktur_organisasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gpm_surveys`
--
ALTER TABLE `gpm_surveys`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `gpm_survey_questions`
--
ALTER TABLE `gpm_survey_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gpm_survey_responses`
--
ALTER TABLE `gpm_survey_responses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hero_sections`
--
ALTER TABLE `hero_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kuliahs`
--
ALTER TABLE `jadwal_kuliahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `khs_access_logs`
--
ALTER TABLE `khs_access_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `khs_files`
--
ALTER TABLE `khs_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kurikulums`
--
ALTER TABLE `kurikulums`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `mata_kuliahs`
--
ALTER TABLE `mata_kuliahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `parents`
--
ALTER TABLE `parents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `parent_khs_access_logs`
--
ALTER TABLE `parent_khs_access_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penjaminan_mutus`
--
ALTER TABLE `penjaminan_mutus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `program_studis`
--
ALTER TABLE `program_studis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `questionnaires`
--
ALTER TABLE `questionnaires`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `questionnaire_categories`
--
ALTER TABLE `questionnaire_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `questionnaire_questions`
--
ALTER TABLE `questionnaire_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `questionnaire_scale_options`
--
ALTER TABLE `questionnaire_scale_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `rps`
--
ALTER TABLE `rps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rps_weekly_plans`
--
ALTER TABLE `rps_weekly_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `stats`
--
ALTER TABLE `stats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `team_positions`
--
ALTER TABLE `team_positions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dosen_mata_kuliahs`
--
ALTER TABLE `dosen_mata_kuliahs`
  ADD CONSTRAINT `dosen_mata_kuliahs_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dosen_mata_kuliahs_mata_kuliah_id_foreign` FOREIGN KEY (`mata_kuliah_id`) REFERENCES `mata_kuliahs` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_lecturer_1_id_foreign` FOREIGN KEY (`lecturer_1_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_lecturer_2_id_foreign` FOREIGN KEY (`lecturer_2_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `evaluation_answers`
--
ALTER TABLE `evaluation_answers`
  ADD CONSTRAINT `evaluation_answers_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluation_answers_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluation_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questionnaire_questions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `features`
--
ALTER TABLE `features`
  ADD CONSTRAINT `features_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `gdrive_folders`
--
ALTER TABLE `gdrive_folders`
  ADD CONSTRAINT `gdrive_folders_academic_period_id_foreign` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `gpm_dokumen_spmi`
--
ALTER TABLE `gpm_dokumen_spmi`
  ADD CONSTRAINT `gpm_dokumen_spmi_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `gpm_edom_periods`
--
ALTER TABLE `gpm_edom_periods`
  ADD CONSTRAINT `gpm_edom_periods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `gpm_edom_submissions`
--
ALTER TABLE `gpm_edom_submissions`
  ADD CONSTRAINT `gpm_edom_submissions_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gpm_edom_submissions_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `gpm_edom_periods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gpm_edom_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `gpm_surveys`
--
ALTER TABLE `gpm_surveys`
  ADD CONSTRAINT `gpm_surveys_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `gpm_survey_questions`
--
ALTER TABLE `gpm_survey_questions`
  ADD CONSTRAINT `gpm_survey_questions_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `gpm_surveys` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `gpm_survey_responses`
--
ALTER TABLE `gpm_survey_responses`
  ADD CONSTRAINT `gpm_survey_responses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `gpm_survey_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gpm_survey_responses_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `gpm_surveys` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gpm_survey_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `jadwal_kuliahs`
--
ALTER TABLE `jadwal_kuliahs`
  ADD CONSTRAINT `jadwal_kuliahs_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_kuliahs_mata_kuliah_id_foreign` FOREIGN KEY (`mata_kuliah_id`) REFERENCES `mata_kuliahs` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `khs_access_logs`
--
ALTER TABLE `khs_access_logs`
  ADD CONSTRAINT `khs_access_logs_khs_file_id_foreign` FOREIGN KEY (`khs_file_id`) REFERENCES `khs_files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `khs_access_logs_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `khs_files`
--
ALTER TABLE `khs_files`
  ADD CONSTRAINT `khs_files_academic_period_id_foreign` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `khs_files_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `khs_files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kurikulums`
--
ALTER TABLE `kurikulums`
  ADD CONSTRAINT `kurikulums_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mata_kuliahs`
--
ALTER TABLE `mata_kuliahs`
  ADD CONSTRAINT `mata_kuliahs_kurikulum_id_foreign` FOREIGN KEY (`kurikulum_id`) REFERENCES `kurikulums` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`);

--
-- Ketidakleluasaan untuk tabel `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `parent_khs_access_logs`
--
ALTER TABLE `parent_khs_access_logs`
  ADD CONSTRAINT `parent_khs_access_logs_khs_file_id_foreign` FOREIGN KEY (`khs_file_id`) REFERENCES `khs_files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parent_khs_access_logs_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjaminan_mutus`
--
ALTER TABLE `penjaminan_mutus`
  ADD CONSTRAINT `penjaminan_mutus_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD CONSTRAINT `questionnaires_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `questionnaire_categories`
--
ALTER TABLE `questionnaire_categories`
  ADD CONSTRAINT `questionnaire_categories_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `questionnaire_questions`
--
ALTER TABLE `questionnaire_questions`
  ADD CONSTRAINT `questionnaire_questions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `questionnaire_categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `questionnaire_scale_options`
--
ALTER TABLE `questionnaire_scale_options`
  ADD CONSTRAINT `questionnaire_scale_options_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rps`
--
ALTER TABLE `rps`
  ADD CONSTRAINT `rps_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rps_mata_kuliah_id_foreign` FOREIGN KEY (`mata_kuliah_id`) REFERENCES `mata_kuliahs` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rps_weekly_plans`
--
ALTER TABLE `rps_weekly_plans`
  ADD CONSTRAINT `rps_weekly_plans_rps_id_foreign` FOREIGN KEY (`rps_id`) REFERENCES `rps` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `team_positions` (`id`),
  ADD CONSTRAINT `teams_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `program_studis` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
