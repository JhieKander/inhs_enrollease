-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 05:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inhs_enrollease`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `AcademicYear_ID` int(10) NOT NULL,
  `Academic_Year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`AcademicYear_ID`, `Academic_Year`) VALUES
(1, '2025 - 2026');

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `Admin_AccountID` int(10) NOT NULL,
  `Admin_FirstName` varchar(100) NOT NULL,
  `Admin_MiddleName` varchar(100) DEFAULT NULL,
  `Admin_LastName` varchar(100) NOT NULL,
  `Admin_ExtName` varchar(100) DEFAULT NULL,
  `Admin_Email` varchar(100) NOT NULL,
  `Admin_Password` varchar(100) NOT NULL,
  `Admin_TempPassword` varchar(100) DEFAULT NULL,
  `Admin_Gender` enum('Male','Female') NOT NULL,
  `Admin_ContactNumber` varchar(100) NOT NULL,
  `Admin_Status` enum('Active','Inactive') NOT NULL,
  `Admin_ProfileImage` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `Schedule_ID` int(10) NOT NULL,
  `Year_Level` varchar(100) NOT NULL,
  `Section` varchar(100) NOT NULL,
  `Subject` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Subject`)),
  `Break_Time` time NOT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_member`
--

CREATE TABLE `faculty_member` (
  `Faculty_MemberID` int(10) NOT NULL,
  `Faculty_FirstName` varchar(100) NOT NULL,
  `Faculty_MiddleName` varchar(100) DEFAULT NULL,
  `Faculty_LastName` varchar(100) NOT NULL,
  `Faculty_ExtName` varchar(100) DEFAULT NULL,
  `Faculty_Gender` enum('Male','Female') NOT NULL,
  `Faculty_Email` varchar(100) NOT NULL,
  `Faculty_Subject` varchar(100) NOT NULL,
  `Faculty_Status` enum('Active','Inactive') NOT NULL,
  `Faculty_ContactNumber` varchar(100) NOT NULL,
  `Faculty_ProfileImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `Gallery_ID` int(10) NOT NULL,
  `Gallery_Image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`Gallery_ID`, `Gallery_Image`) VALUES
(1, 'inhs1.jpg'),
(2, 'imus-national-high-school.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `News_ID` int(10) NOT NULL,
  `News_Title` varchar(100) NOT NULL,
  `News_Date` date NOT NULL,
  `News_Desc` text NOT NULL,
  `News_Image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`News_ID`, `News_Title`, `News_Date`, `News_Desc`, `News_Image`) VALUES
(1, '𝐉𝐔𝐒𝐓 𝐈𝐍 | ASUS A15 TUF Gaming Laptops!', '2024-11-15', 'We’ve just added 2 sets of ASUS A15 TUF Gaming Laptops to our E-TAWID DUNONG PROGRAM, Imus National High School’s innovative All-in-One Learning Modality designed to address the challenges of class suspensions and maintain the delivery of quality education. 🎉💻\r\n\r\nLayout: Jayca Maxene Rivero', '467321593_875148158107068_8126235204181381674_n.jpg'),
(2, '𝐉𝐔𝐒𝐓 𝐈𝐍 | DJI Avata 2 FPV Drone', '2024-11-16', 'Peeking from the Sky: It’s not a bird, it’s not a plane—it’s the INHS DJI Avata 2 FPV Drone, changing how we view our campus and capturing our school community from a whole new angle.\r\n\r\nLayout: Jayca Maxene Rivero', '467123149_875879301367287_3932321680063932285_n.jpg'),
(3, '𝐀𝐃𝐕𝐈𝐒𝐎𝐑𝐘', '2024-11-17', 'As announced by the Provincial Government of Cavite, face-to-face classes at Imus National High School are suspended tomorrow, November 18, 2024, due to the possibility of heavy rainfall and strong winds, with the province under Signal No. 2. \r\n\r\nThe school will implement modular or asynchronous learning modalities.\r\n\r\nStay safe and watch out for possible heavy rain and strong winds. Keep your pets in a safe place with enough food and water. Get an emergency kit ready, and keep checking local updates for the latest news.', '467336780_876507091304508_163059817590422164_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `powerup_details`
--

CREATE TABLE `powerup_details` (
  `PowerUp_ID` int(10) NOT NULL,
  `StudentID_Number` int(10) DEFAULT NULL,
  `LRN` int(15) DEFAULT NULL,
  `Student_GeneralAverage` int(10) DEFAULT NULL,
  `PowerUp_Enroll` varchar(100) DEFAULT NULL,
  `PowerUp_ExamSched` varchar(100) DEFAULT NULL,
  `PowerUp_ExamStatus` enum('Passed','Failed') DEFAULT NULL,
  `PowerUp_InterviewSched` varchar(100) DEFAULT NULL,
  `PowerUp_InterviewStatus` enum('Passed','Failed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `readingskills_material`
--

CREATE TABLE `readingskills_material` (
  `Material_ID` int(10) NOT NULL,
  `Language_Material` enum('English','Filipino','','') NOT NULL,
  `Title` text NOT NULL,
  `Context` text NOT NULL,
  `Word_Count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `readingskills_material`
--

INSERT INTO `readingskills_material` (`Material_ID`, `Language_Material`, `Title`, `Context`, `Word_Count`) VALUES
(1, 'English', 'Magician Invents Special Effects', 'George M\'elies, a French moviemaker and a former magician happened to invent special effects in movies by accident. He was filming the street scene in Paris when his camera suddenly jammed as a bus was passing by. He stopped, fixed his camera, and was surprised to see a carriage in the place where the bus had been! He discovered that the bus had changed into a carriage! From that day on, Mr. M\'elies invented many amazing techniques using his camera. He became known as \"the magician of movies\".\n\nA common special effect he invented is called Projections. In this effect, a moviemaker projects a picture or a movie on a screen behind the actors. The actors act in front of the screen. Then, the camera films the actors and the picture or the movie at the same. This effect makes it possible for actors to look like they are in imaginary places.\n\nOther special effects Mr. M\'elies created are: animation which makes lifeless models or objects come to life when they are shown on the screen; matte shots enabling the moviemaker to cover or matte out part of a film that he doesn\'t want and optical printer and computer-age special effects.', 217),
(2, 'Filipino', 'Basura: Isang Malaking Problema', 'Inihahanda na ni Kune ang mga basura tulad ng plastic, bote, garapa at mga lumang magasin at dyaryo galing sa kanilang bahay na ipagbibili niya kay Mang Pedring na magbobote. Napatigil siya nang matawag ang kanyang pansin ng isang Editoryal tungkol sa Basura ng Pilipino Star Ngayon, na ipinalabas noong Nobyember 19, 2000. Ito ang ilan sa kanyang nabasa:\r\n\r\nProblema ang basura sa Metro Manila ngayon at lalo pang magiging ga-bundok sa hinaharap kung hindi kikilos ang pamahalaan. Nagbabala ang Greenpeace, isang international campaign group, na lulubha ang problema sa basura sa Metro Manila kung hindi gagawa ng estratehiya ang pamahalaan tungkol dito. Isinusulong ng grupo ang paraan ng recycling at composting kaysa sa tradisyonal na “dump, bury, burn”.\r\n\r\nSa mga nakaraan naming editoryal, madalas naming sabihin na ang composting ay isang magandang paraan para malutas ang problema sa basura. Ang sapat lamang gawin ay katulungin ang Department of Agriculture upang maisulong ito at matiyak na makikinabang ang mga magsasaka.\r\n\r\nMatapos mabasa ang artiko, napaisip si Kune at tiningnang muli ang mga bagay na ipagbibili na sana niya. May ilan sa mga yun na maari pa nilang magamit sa ibang bagay. Dali-dali niyang ibinukod ang mga iyon at ibinalik sa loob ng kanilang bahay.', 204);

-- --------------------------------------------------------

--
-- Table structure for table `readingskills_question`
--

CREATE TABLE `readingskills_question` (
  `Question_ID` int(10) NOT NULL,
  `Material_ID` int(10) NOT NULL,
  `Questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Questions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `readingskills_question`
--

INSERT INTO `readingskills_question` (`Question_ID`, `Material_ID`, `Questions`) VALUES
(2, 1, '[\n    {\n        \"question_number\": 1,\n        \"question_text\": \"Who is the main figure in the story?\",\n        \"choices\": {\"A\": \"Thomas Edison\", \"B\": \"George M\'elies\", \"C\": \"Walt Disney\", \"D\": \"Alfred Hitchcock\"},\n        \"correct_answer\": \"B\"\n    },\n    {\n        \"question_number\": 2,\n        \"question_text\": \"What profession did George M\'elies have before becoming a filmmaker?\",\n        \"choices\": {\"A\": \"A painter\", \"B\": \"A magician\", \"C\": \"A musician\", \"D\": \"A writer\"},\n        \"correct_answer\": \"B\"\n    },\n    {\n        \"question_number\": 3,\n        \"question_text\": \"What accident led to the invention of special effects?\",\n        \"choices\": {\"A\": \"The film reel got damaged\", \"B\": \"The camera jammed while filming a street scene\", \"C\": \"The actors forgot their lines\", \"D\": \"The lighting failed during the shoot\"},\n        \"correct_answer\": \"B\"\n    },\n    {\n        \"question_number\": 4,\n        \"question_text\": \"What surprising event occurred when George M\'elies fixed his camera?\",\n        \"choices\": {\"A\": \"The camera started working again\", \"B\": \"The bus turned into a carriage\", \"C\": \"The actors disappeared\", \"D\": \"The scene changed to a forest\"},\n        \"correct_answer\": \"B\"\n    },\n    {\n        \"question_number\": 5,\n        \"question_text\": \"What is the term for the effect where a picture or movie is projected behind actors?\",\n        \"choices\": {\"A\": \"Animation\", \"B\": \"Matte shots\", \"C\": \"Projections\", \"D\": \"Optical printing\"},\n        \"correct_answer\": \"C\"\n    },\n    {\n        \"question_number\": 6,\n        \"question_text\": \"How do projections help in filmmaking?\",\n        \"choices\": {\"A\": \"They make actors disappear\", \"B\": \"They allow actors to act in front of a screen that shows imaginary places\", \"C\": \"They increase the film’s runtime\", \"D\": \"They reduce production costs\"},\n        \"correct_answer\": \"B\"\n    },\n    {\n        \"question_number\": 7,\n        \"question_text\": \"Which of the following is NOT mentioned as a special effect invented by George M\'elies?\",\n        \"choices\": {\"A\": \"Animation\", \"B\": \"Matte shots\", \"C\": \"3D effects\", \"D\": \"Optical printer\"},\n        \"correct_answer\": \"C\"\n    },\n    {\n        \"question_number\": 8,\n        \"question_text\": \"What does animation do in films?\",\n        \"choices\": {\"A\": \"It adds sound to the movie\", \"B\": \"It makes lifeless models or objects come to life\", \"C\": \"It enhances color quality\", \"D\": \"It creates the illusion of depth\"},\n        \"correct_answer\": \"B\"\n    },\n    {\n        \"question_number\": 9,\n        \"question_text\": \"What is the purpose of matte shots in filmmaking?\",\n        \"choices\": {\"A\": \"To enhance the lighting\", \"B\": \"To create a soundtrack\", \"C\": \"To cover or matte out parts of a film\", \"D\": \"To speed up the film editing process\"},\n        \"correct_answer\": \"C\"\n    },\n    {\n        \"question_number\": 10,\n        \"question_text\": \"How is George M\'elies referred to because of his contributions to film?\",\n        \"choices\": {\"A\": \"The father of cinema\", \"B\": \"The magician of movies\", \"C\": \"The king of animation\", \"D\": \"The master of effects\"},\n        \"correct_answer\": \"B\"\n    }\n]'),
(3, 2, '[\r\n    {\r\n        \"question_number\": 1,\r\n        \"question_text\": \"Ano ang inihahanda ni Kune para ibenta kay Mang Pedring?\",\r\n        \"choices\": {\"A\": \"Luma at sirang gamit\", \"B\": \"Basura tulad ng plastic, bote, at lumang magasin\", \"C\": \"Mga damit na hindi na ginagamit\", \"D\": \"Mga halaman at bulaklak\"},\r\n        \"correct_answer\": \"B\"\r\n    },\r\n    {\r\n        \"question_number\": 2,\r\n        \"question_text\": \"Ano ang tawag sa editoryal na nabasa ni Kune?\",\r\n        \"choices\": {\"A\": \"Basura ng Pilipino Star Ngayon\", \"B\": \"Isang Balita\", \"C\": \"Ang Pahayagan ng Bayan\", \"D\": \"Ang Dapat Malaman\"},\r\n        \"correct_answer\": \"A\"\r\n    },\r\n    {\r\n        \"question_number\": 3,\r\n        \"question_text\": \"Anong petsa inilabas ang editoryal na ito?\",\r\n        \"choices\": {\"A\": \"Nobyembre 19, 2000\", \"B\": \"Disyembre 25, 2000\", \"C\": \"Oktubre 10, 2000\", \"D\": \"Setyembre 30, 2000\"},\r\n        \"correct_answer\": \"A\"\r\n    },\r\n    {\r\n        \"question_number\": 4,\r\n        \"question_text\": \"Ano ang sinasabi ng Greenpeace tungkol sa basura sa Metro Manila?\",\r\n        \"choices\": {\"A\": \"Luluwag ang problema sa basura\", \"B\": \"Magiging ga-bundok ang basura kung walang aksyon\", \"C\": \"Wala silang pakialam sa basura\", \"D\": \"Ang basura ay hindi mahalaga\"},\r\n        \"correct_answer\": \"B\"\r\n    },\r\n    {\r\n        \"question_number\": 5,\r\n        \"question_text\": \"Ano ang isinusulong ng Greenpeace bilang solusyon sa problema sa basura?\",\r\n        \"choices\": {\"A\": \"Dump, bury, burn\", \"B\": \"Pagkakagawa ng mga bagong produkto\", \"C\": \"Recycling at composting\", \"D\": \"Pagbibili ng basura\"},\r\n        \"correct_answer\": \"C\"\r\n    },\r\n    {\r\n        \"question_number\": 6,\r\n        \"question_text\": \"Sino ang dapat katulungan ng Department of Agriculture upang maisulong ang composting?\",\r\n        \"choices\": {\"A\": \"Mga mangingisda\", \"B\": \"Mga magsasaka\", \"C\": \"Mga estudyante\", \"D\": \"Mga negosyante\"},\r\n        \"correct_answer\": \"B\"\r\n    },\r\n    {\r\n        \"question_number\": 7,\r\n        \"question_text\": \"Ano ang naging reaksyon ni Kune matapos mabasa ang artikulo?\",\r\n        \"choices\": {\"A\": \"Nagalit siya sa kanyang mga magulang\", \"B\": \"Napaisip siya at tiningnan muli ang mga bagay na ipagbibili\", \"C\": \"Umiyak siya dahil sa dami ng basura\", \"D\": \"Umuwi siya ng wala sa isip\"},\r\n        \"correct_answer\": \"B\"\r\n    },\r\n    {\r\n        \"question_number\": 8,\r\n        \"question_text\": \"Anong ginawa ni Kune sa ilan sa mga bagay na maari pang magamit?\",\r\n        \"choices\": {\"A\": \"Tinapon niya ang mga ito\", \"B\": \"Ibinalik niya ang mga ito sa loob ng kanilang bahay\", \"C\": \"Ibinigay niya ito sa kanyang kaibigan\", \"D\": \"Ipinagpalit niya ito sa ibang bagay\"},\r\n        \"correct_answer\": \"B\"\r\n    },\r\n    {\r\n        \"question_number\": 9,\r\n        \"question_text\": \"Ano ang pangunahing mensahe ng editoryal tungkol sa basura?\",\r\n        \"choices\": {\"A\": \"Ang basura ay hindi mahalaga\", \"B\": \"Kailangan ng aksyon upang masolusyunan ang problema sa basura\", \"C\": \"Wala nang solusyon sa problema\", \"D\": \"Ang mga tao ay hindi dapat magtapon ng basura\"},\r\n        \"correct_answer\": \"B\"\r\n    },\r\n    {\r\n        \"question_number\": 10,\r\n        \"question_text\": \"Ano ang nagpapakita ng pagbabago ng isip ni Kune?\",\r\n        \"choices\": {\"A\": \"Naging masaya siya sa kanyang ginawa\", \"B\": \"Naisip niya ang halaga ng mga bagay na maaaring magamit muli\", \"C\": \"Nagtataka siya sa kanyang nararamdaman\", \"D\": \"Hindi siya nakatulog sa gabi\"},\r\n        \"correct_answer\": \"B\"\r\n    }\r\n]');

-- --------------------------------------------------------

--
-- Table structure for table `readingskills_result`
--

CREATE TABLE `readingskills_result` (
  `Result_ID` int(10) NOT NULL,
  `StudentID_Number` int(10) NOT NULL,
  `LRN` int(12) NOT NULL,
  `English_Video` varchar(100) DEFAULT NULL,
  `English_ReadingTime` varchar(100) DEFAULT NULL,
  `English_ReadingTimeSpeed` int(10) DEFAULT NULL,
  `English_MisprononounceWords` int(10) DEFAULT NULL,
  `English_MispronounceRating` enum('Sufficient','Instructional','Failed','') DEFAULT NULL,
  `English_ComprehensionScore` int(10) DEFAULT NULL,
  `English_ComprehensionRating` enum('Sufficient','Instructional','Failed','Unprepared') DEFAULT NULL,
  `English_ReadingStatus` enum('Reader','Non-Reader') DEFAULT NULL,
  `Filipino_Video` varchar(100) DEFAULT NULL,
  `Filipino_ReadingTime` varchar(100) DEFAULT NULL,
  `Filipino_ReadingTimeSpeed` int(10) DEFAULT NULL,
  `Filipino_MisprononounceWords` int(10) DEFAULT NULL,
  `Filipino_MispronounceRating` enum('Malaya','Instruksyunal','Kabiguan','') DEFAULT NULL,
  `Filipino_ComprehensionScore` int(10) DEFAULT NULL,
  `Filipino_ComprehensionRating` enum('Malaya','Instruksyunal','Kabiguan','Walang Paghahanda') DEFAULT NULL,
  `Filipino_ReadingStatus` enum('Reader','Non-Reader') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `Section_ID` int(10) NOT NULL,
  `YearLevel_ID` int(10) NOT NULL,
  `Section_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`Section_ID`, `YearLevel_ID`, `Section_Name`) VALUES
(1, 7, 'Adelfa'),
(2, 7, 'Anthurium'),
(3, 7, 'Aster'),
(4, 7, 'Azalea'),
(5, 7, 'Azucena'),
(6, 7, 'Begonia'),
(7, 7, 'Bluebell'),
(8, 7, 'Bougainvillea'),
(9, 7, 'Buttercup'),
(10, 7, 'Cadena De Amor'),
(11, 7, 'Camia'),
(12, 7, 'Carnation'),
(13, 7, 'Cattleya'),
(14, 7, 'Chrysanthemum'),
(15, 7, 'Cosmos'),
(16, 7, 'Crocus'),
(17, 7, 'Daffodil'),
(18, 7, 'Dahlia'),
(19, 7, 'Daisy'),
(20, 7, 'Dama De Noche'),
(21, 7, 'Dandelion'),
(22, 7, 'Daphne'),
(23, 7, 'Euphorbia'),
(24, 7, 'Everlasting'),
(25, 7, 'Freesia'),
(26, 7, 'Fuschia'),
(27, 7, 'Gardenia'),
(28, 7, 'Gerbera'),
(29, 7, 'Gladiola'),
(30, 7, 'Gumamela'),
(31, 7, 'Helenium'),
(32, 7, 'Honesty'),
(33, 7, 'Ilang-Ilang'),
(34, 7, 'Iris'),
(35, 7, 'Ixora'),
(36, 7, 'Jasmine'),
(37, 7, 'Lavander'),
(38, 7, 'Lilac'),
(39, 7, 'Lily'),
(40, 7, 'Lotus'),
(41, 7, 'Lupin'),
(42, 7, 'Magnolia'),
(43, 7, 'Marigold'),
(44, 7, 'Moonflower'),
(45, 7, 'Orchids'),
(46, 7, 'Poinsettia'),
(47, 7, 'Primrose'),
(48, 7, 'Rosal'),
(49, 7, 'Rose'),
(50, 7, 'Sampaguita'),
(51, 7, 'San Francisco'),
(52, 7, 'Santan'),
(53, 7, 'Snapdragon'),
(54, 7, 'Snowdrop'),
(55, 7, 'Snowflower'),
(56, 7, 'Syringa'),
(57, 7, 'Trillium'),
(58, 7, 'Tulips'),
(59, 7, 'Ursinia'),
(60, 7, 'Viola'),
(61, 7, 'Waling-Waling'),
(62, 7, 'Wisteria'),
(63, 7, 'Yellowbell'),
(64, 7, 'Zinnia'),
(65, 7, 'Del Mundo (Power-Up)'),
(66, 7, 'Quisumbing (Power-Up)'),
(67, 8, 'Acceptance'),
(68, 8, 'Attentive'),
(69, 8, 'Charity'),
(70, 8, 'Chastity'),
(71, 8, 'Compassion'),
(72, 8, 'Confidence'),
(73, 8, 'Contentment'),
(74, 8, 'Courage'),
(75, 8, 'Courteous'),
(76, 8, 'Dedication'),
(77, 8, 'Dependable'),
(78, 8, 'Dignity'),
(79, 8, 'Diligence'),
(80, 8, 'Efficiency'),
(81, 8, 'Empathy'),
(82, 8, 'Endurance'),
(83, 8, 'Enthusiasm'),
(84, 8, 'Equality'),
(85, 8, 'Faith'),
(86, 8, 'Fame'),
(87, 8, 'Fortitude'),
(88, 8, 'Friendship'),
(89, 8, 'Goodness'),
(90, 8, 'Grace'),
(91, 8, 'Gratitude'),
(92, 8, 'Honesty'),
(93, 8, 'Honor'),
(94, 8, 'Hope'),
(95, 8, 'Humility'),
(96, 8, 'Independence'),
(97, 8, 'Industrious'),
(98, 8, 'Integrity'),
(99, 8, 'Joy'),
(100, 8, 'Justice'),
(101, 8, 'Kindness'),
(102, 8, 'Liberty'),
(103, 8, 'Logic'),
(104, 8, 'Love'),
(105, 8, 'Loyalty'),
(106, 8, 'Modesty'),
(107, 8, 'Optimism'),
(108, 8, 'Passion'),
(109, 8, 'Patience'),
(110, 8, 'Peace'),
(111, 8, 'Perseverance'),
(112, 8, 'Piety'),
(113, 8, 'Prosperity'),
(114, 8, 'Punctuality'),
(115, 8, 'Purity'),
(116, 8, 'Respect'),
(117, 8, 'Reverence'),
(118, 8, 'Serenity'),
(119, 8, 'Sincerity'),
(120, 8, 'Solitude'),
(121, 8, 'Strength'),
(122, 8, 'Temperance'),
(123, 8, 'Tolerance'),
(124, 8, 'Trustworthy'),
(125, 8, 'Truthfulness'),
(126, 8, 'Unity'),
(127, 8, 'Wisdom'),
(128, 8, 'Zeal'),
(129, 8, 'Service'),
(130, 8, 'Pythagoras (Power-Up)'),
(131, 8, 'Euclid (Power-Up)'),
(132, 9, 'Aluminum'),
(133, 9, 'Antimony'),
(134, 9, 'Argon'),
(135, 9, 'Arsenic'),
(136, 9, 'Astatine'),
(137, 9, 'Barium'),
(138, 9, 'Beryllium'),
(139, 9, 'Bismuth'),
(140, 9, 'Boron'),
(141, 9, 'Bromine'),
(142, 9, 'Cadmium'),
(143, 9, 'Calcium'),
(144, 9, 'Carbon'),
(145, 9, 'Cesium'),
(146, 9, 'Chlorine'),
(147, 9, 'Chromium'),
(148, 9, 'Cobalt'),
(149, 9, 'Copper'),
(150, 9, 'Dysprosium'),
(151, 9, 'Fluorine'),
(152, 9, 'Gold'),
(153, 9, 'Helium'),
(154, 9, 'Holmium'),
(155, 9, 'Hydrogen'),
(156, 9, 'Iodine'),
(157, 9, 'Iron'),
(158, 9, 'Krypton'),
(159, 9, 'Lead'),
(160, 9, 'Lithium'),
(161, 9, 'Magnesium'),
(162, 9, 'Manganese'),
(163, 9, 'Mercury'),
(164, 9, 'Molybdenum'),
(165, 9, 'Neon'),
(166, 9, 'Nickel'),
(167, 9, 'Nitrogen'),
(168, 9, 'Oganesson'),
(169, 9, 'Oxygen'),
(170, 9, 'Phosphorus'),
(171, 9, 'Platinum'),
(172, 9, 'Polonium'),
(173, 9, 'Potassium'),
(174, 9, 'Radium'),
(175, 9, 'Radon'),
(176, 9, 'Ruthenium'),
(177, 9, 'Selenium'),
(178, 9, 'Silicon'),
(179, 9, 'Silver'),
(180, 9, 'Sodium'),
(181, 9, 'Strontium'),
(182, 9, 'Thorium'),
(183, 9, 'Tin'),
(184, 9, 'Titanium'),
(185, 9, 'Tungsten'),
(186, 9, 'Uranium'),
(187, 9, 'Vanadium'),
(188, 9, 'Xenon'),
(189, 9, 'Yttrium'),
(190, 9, 'Zinc'),
(191, 9, 'Zirconium'),
(192, 9, 'Plato (Power-Up)'),
(193, 9, 'Socrates (Power-Up)'),
(194, 10, 'Diamond'),
(195, 10, 'Afghanite'),
(196, 10, 'Agate'),
(197, 10, 'Alexandrite'),
(198, 10, 'Amber'),
(199, 10, 'Amethyst'),
(200, 10, 'Ametrine'),
(201, 10, 'Ammolite'),
(202, 10, 'Andaluzite'),
(203, 10, 'Apatite'),
(204, 10, 'Aquamarine'),
(205, 10, 'Aventurine'),
(206, 10, 'Azurite'),
(207, 10, 'Beryl'),
(208, 10, 'Bloodstone'),
(209, 10, 'Calcite'),
(210, 10, 'Carnelian'),
(211, 10, 'Chalcedony'),
(212, 10, 'Charoite'),
(213, 10, 'Citrine'),
(214, 10, 'Coral'),
(215, 10, 'Diaspore'),
(216, 10, 'Druzy'),
(217, 10, 'Emerald'),
(218, 10, 'Epidote'),
(219, 10, 'Fluorite'),
(220, 10, 'Garnet'),
(221, 10, 'Jade'),
(222, 10, 'Jasper'),
(223, 10, 'Kunzite'),
(224, 10, 'Kyanite'),
(225, 10, 'Lapis Lazuli'),
(226, 10, 'Larimar'),
(227, 10, 'Malachite'),
(228, 10, 'Moonstone'),
(229, 10, 'Morganite'),
(230, 10, 'Mystic Quartz'),
(231, 10, 'Onyx'),
(232, 10, 'Opal'),
(233, 10, 'Pearl'),
(234, 10, 'Peridot'),
(235, 10, 'Pyrite'),
(236, 10, 'Rhyolite'),
(237, 10, 'Ruby'),
(238, 10, 'Sapphire'),
(239, 10, 'Sphene'),
(240, 10, 'Spinel'),
(241, 10, 'Tanzanite'),
(242, 10, 'Tiffany'),
(243, 10, 'Topaz'),
(244, 10, 'Tourmaline'),
(245, 10, 'Turquoise'),
(246, 10, 'Zircon'),
(247, 10, 'Einstein (Power-Up)'),
(248, 10, 'Schrodinger (Power-Up)');

-- --------------------------------------------------------

--
-- Table structure for table `student_addinfo`
--

CREATE TABLE `student_addinfo` (
  `AddInfo_ID` int(10) NOT NULL,
  `StudentID_Number` int(10) NOT NULL,
  `Student_LRN` int(15) DEFAULT NULL,
  `Student_Status` enum('Not Enrolled','Enrolled','Dropped','Kicked') DEFAULT NULL,
  `Student_TempPassword` varchar(100) DEFAULT NULL,
  `Student_Type` varchar(100) DEFAULT NULL,
  `Academic_History` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Academic_History`)),
  `Current_AcademicYear` varchar(100) DEFAULT NULL,
  `Current_YearLevel` varchar(100) DEFAULT NULL,
  `Current_Section` varchar(100) DEFAULT NULL,
  `TLE_Subject` varchar(100) DEFAULT NULL,
  `Emergency_ContactName` varchar(100) DEFAULT NULL,
  `Emergency_ContactNumber` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_profile`
--

CREATE TABLE `student_profile` (
  `StudentID_Number` int(10) NOT NULL,
  `Student_LRN` int(15) DEFAULT NULL,
  `Student_FirstName` varchar(100) DEFAULT NULL,
  `Student_MiddleName` varchar(100) DEFAULT NULL,
  `Student_LastName` varchar(100) DEFAULT NULL,
  `Student_ExtName` varchar(100) DEFAULT NULL,
  `Student_Email` varchar(100) NOT NULL,
  `Student_Password` varchar(100) NOT NULL,
  `Student_Gender` enum('Male','Female') DEFAULT NULL,
  `Student_Birthdate` date DEFAULT NULL,
  `Student_MotherTongue` varchar(100) DEFAULT NULL,
  `Student_BirthPlace` varchar(100) DEFAULT NULL,
  `Student_PSABCNo` varchar(100) DEFAULT NULL,
  `Student_IPCommunity` varchar(100) DEFAULT NULL,
  `Student_WithDisability` varchar(100) DEFAULT NULL,
  `Student_4PsBeneficiary` varchar(100) DEFAULT NULL,
  `Current_Country` varchar(100) DEFAULT NULL,
  `Current_Province` varchar(100) DEFAULT NULL,
  `Current_City` varchar(100) DEFAULT NULL,
  `Current_Barangay` varchar(100) DEFAULT NULL,
  `Current_StreetName` varchar(100) DEFAULT NULL,
  `Current_HouseNumber` varchar(100) DEFAULT NULL,
  `Permanent_Country` varchar(100) DEFAULT NULL,
  `Permanent_Province` varchar(100) DEFAULT NULL,
  `Permanent_City` varchar(100) DEFAULT NULL,
  `Permanent_Barangay` varchar(100) DEFAULT NULL,
  `Permanent_StreetName` varchar(100) DEFAULT NULL,
  `Permanent_HouseNo` varchar(100) DEFAULT NULL,
  `Father_FirstName` varchar(100) DEFAULT NULL,
  `Father_MiddleName` varchar(100) DEFAULT NULL,
  `Father_LastName` varchar(100) DEFAULT NULL,
  `Father_ContactNumber` varchar(100) DEFAULT NULL,
  `Mother_FirstName` varchar(100) DEFAULT NULL,
  `Mother_MiddleName` varchar(100) DEFAULT NULL,
  `Mother_LastName` varchar(100) DEFAULT NULL,
  `Mother_ContactNumber` varchar(100) DEFAULT NULL,
  `Guardian_FirstName` varchar(100) DEFAULT NULL,
  `Guardian_MiddleName` varchar(100) DEFAULT NULL,
  `Guardian_LastName` varchar(100) DEFAULT NULL,
  `Guardian_ContactNumber` varchar(100) DEFAULT NULL,
  `Last_GradeLevel` varchar(100) DEFAULT NULL,
  `Last_SchoolYear` varchar(100) DEFAULT NULL,
  `Last_SchoolName` varchar(100) DEFAULT NULL,
  `Last_SchoolID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_requirements`
--

CREATE TABLE `student_requirements` (
  `Requirements_ID` int(10) NOT NULL,
  `StudentID_Number` int(10) NOT NULL,
  `LRN` int(15) DEFAULT NULL,
  `Application_Form` varchar(100) NOT NULL,
  `SF9_ReportCard` varchar(100) NOT NULL,
  `B_Certificate` varchar(100) NOT NULL,
  `Con_Admission` varchar(100) NOT NULL,
  `PowerUp_Form` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tle_subject`
--

CREATE TABLE `tle_subject` (
  `TLE_ID` int(10) NOT NULL,
  `TLE_SpecialtySubject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tle_subject`
--

INSERT INTO `tle_subject` (`TLE_ID`, `TLE_SpecialtySubject`) VALUES
(1, 'Computer Servicing System (CSS)'),
(2, 'Contact Center Servicing (CCS)'),
(3, 'Cookery'),
(4, 'Electrical Installation and Maintenance (EIM)'),
(5, 'Electronic Products Assembly and Servicing (EPAS)'),
(6, 'Technical Drafting');

-- --------------------------------------------------------

--
-- Table structure for table `yearlevel`
--

CREATE TABLE `yearlevel` (
  `YearLevel_ID` int(10) NOT NULL,
  `Year_Level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yearlevel`
--

INSERT INTO `yearlevel` (`YearLevel_ID`, `Year_Level`) VALUES
(7, 'Grade 7'),
(8, 'Grade 8'),
(9, 'Grade 9'),
(10, 'Grade 10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`AcademicYear_ID`);

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`Admin_AccountID`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`Schedule_ID`);

--
-- Indexes for table `faculty_member`
--
ALTER TABLE `faculty_member`
  ADD PRIMARY KEY (`Faculty_MemberID`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`Gallery_ID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`News_ID`);

--
-- Indexes for table `powerup_details`
--
ALTER TABLE `powerup_details`
  ADD PRIMARY KEY (`PowerUp_ID`),
  ADD KEY `StudentID` (`StudentID_Number`);

--
-- Indexes for table `readingskills_material`
--
ALTER TABLE `readingskills_material`
  ADD PRIMARY KEY (`Material_ID`);

--
-- Indexes for table `readingskills_question`
--
ALTER TABLE `readingskills_question`
  ADD PRIMARY KEY (`Question_ID`),
  ADD KEY `Material_ID` (`Material_ID`);

--
-- Indexes for table `readingskills_result`
--
ALTER TABLE `readingskills_result`
  ADD PRIMARY KEY (`Result_ID`),
  ADD KEY `studLRN` (`LRN`),
  ADD KEY `Student_Number` (`StudentID_Number`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`Section_ID`),
  ADD KEY `YearLevelID` (`YearLevel_ID`);

--
-- Indexes for table `student_addinfo`
--
ALTER TABLE `student_addinfo`
  ADD PRIMARY KEY (`AddInfo_ID`),
  ADD KEY `IDNumber` (`StudentID_Number`);

--
-- Indexes for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD PRIMARY KEY (`StudentID_Number`);

--
-- Indexes for table `student_requirements`
--
ALTER TABLE `student_requirements`
  ADD PRIMARY KEY (`Requirements_ID`),
  ADD KEY `IDNum` (`StudentID_Number`);

--
-- Indexes for table `tle_subject`
--
ALTER TABLE `tle_subject`
  ADD PRIMARY KEY (`TLE_ID`);

--
-- Indexes for table `yearlevel`
--
ALTER TABLE `yearlevel`
  ADD PRIMARY KEY (`YearLevel_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `AcademicYear_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `Admin_AccountID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `Schedule_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty_member`
--
ALTER TABLE `faculty_member`
  MODIFY `Faculty_MemberID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `Gallery_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `News_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `powerup_details`
--
ALTER TABLE `powerup_details`
  MODIFY `PowerUp_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `readingskills_material`
--
ALTER TABLE `readingskills_material`
  MODIFY `Material_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `readingskills_question`
--
ALTER TABLE `readingskills_question`
  MODIFY `Question_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `readingskills_result`
--
ALTER TABLE `readingskills_result`
  MODIFY `Result_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `Section_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `student_addinfo`
--
ALTER TABLE `student_addinfo`
  MODIFY `AddInfo_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_profile`
--
ALTER TABLE `student_profile`
  MODIFY `StudentID_Number` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_requirements`
--
ALTER TABLE `student_requirements`
  MODIFY `Requirements_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tle_subject`
--
ALTER TABLE `tle_subject`
  MODIFY `TLE_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `powerup_details`
--
ALTER TABLE `powerup_details`
  ADD CONSTRAINT `StudentID` FOREIGN KEY (`StudentID_Number`) REFERENCES `student_profile` (`StudentID_Number`);

--
-- Constraints for table `readingskills_question`
--
ALTER TABLE `readingskills_question`
  ADD CONSTRAINT `Material_ID` FOREIGN KEY (`Material_ID`) REFERENCES `readingskills_material` (`Material_ID`);

--
-- Constraints for table `readingskills_result`
--
ALTER TABLE `readingskills_result`
  ADD CONSTRAINT `Student_Number` FOREIGN KEY (`StudentID_Number`) REFERENCES `student_profile` (`StudentID_Number`);

--
-- Constraints for table `student_addinfo`
--
ALTER TABLE `student_addinfo`
  ADD CONSTRAINT `IDNumber` FOREIGN KEY (`StudentID_Number`) REFERENCES `student_profile` (`StudentID_Number`);

--
-- Constraints for table `student_requirements`
--
ALTER TABLE `student_requirements`
  ADD CONSTRAINT `IDNum` FOREIGN KEY (`StudentID_Number`) REFERENCES `student_profile` (`StudentID_Number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
