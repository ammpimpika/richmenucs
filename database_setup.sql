-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2025 at 10:22 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbotcomsci`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$WQVfBP/MOOLA7iPPwPQBLOPRks0i69Y./tnwQ1bCvoAUNQQemOLCe', '2025-06-19 08:33:54'),
(2, 'admin1', '$2y$10$YFWvVqNTz.cIu5Bo1SKe9uTqE6GmUKXXkznbn6Em9nrhW.vOE1ySK', '2025-08-12 11:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `nickname`, `first_name`, `last_name`, `job_title`, `company`, `image`, `image_url`) VALUES
(2, 'พี่แพม', 'พิมพ์ณัฏชยา', 'ขจรพันธ์', 'senior programmer', 'เมโทรซิลเต็ทส์ คอร์ปอเรชั่น จำกัด (มหาชน)', 'alumni_6877518e762b4.jpg', 'https://drive.google.com/uc?export=view&id=1IyWZQtlLfiGFTawaygsW5NiHRLJn_dlu'),
(3, 'พี่ที', 'ปรีชา', 'เวียงภักดิ์', 'เจ้าหน้าที่อาวุโสสายงานเทคโนโลยี', 'ธนาคารกรุงไทย จำกัด(มหาชน)', 'alumni_687751a1e6404.jpg', 'https://drive.google.com/uc?export=view&id=1T7xA-aSDcVmzZD-EvO8J9d1xDsZ-xIbj'),
(4, 'พี่แต๊ก', 'พงศกร', 'สาแก้ว', 'web deverloper', 'ทรูคอร์ปอเรชั่น จำกัด', 'alumni_687751afb8371.jpg', 'https://drive.google.com/uc?export=view&id=1nTUbENEzMuea4JdZa6mJTeSWRlpFjDh4'),
(5, 'พี่ก้อ', 'ธนากร', 'ปุรารัมย์', 'นักวิเคราห์ระบบ', 'ธนาคารแห่งประเทศไทย', 'alumni_687751b7550c1.jpg', 'https://drive.google.com/uc?export=view&id=1TYJmlGwX9VC4e6KEe1B5Ns5WNpxolp-i'),
(6, 'พี่บอล', 'บัณทิต', 'ฉาไธสง', 'junior programmer', 'บิชโพเทนเชียล จำกัด', 'alumni_687751c14ce92.jpg', 'https://drive.google.com/uc?export=view&id=1RNtGOGoBZkXu66hLYrsovlJN_Y2sQE6x'),
(7, 'พี่บาส', 'ชัยวัฒน์', 'รื่นรมย์', 'programmer', 'บิชโพเทนเชียล จำกัด', 'alumni_687751cba075c.jpg', 'https://drive.google.com/uc?export=view&id=1ComgnGWVC7w50PTMY0sa1TIUijCdZYrz'),
(8, 'พี่ปอนด์', 'วิภาวนา', 'ดอกไม้', 'mobile deverloper', 'มิตรซอฟต์ จำกัด', 'alumni_687751d6db7e3.jpg', 'https://drive.google.com/uc?export=view&id=1Ki3bzan1UOB_jn6ZVHb4FeffCJeeDPv8'),
(9, 'พี่แจ็ค', 'ณัฐพงษ์', 'ประกังเว', 'software tester', 'ออนไลน์ แอสเซ็ท จำกัด', 'alumni_687751e268c8f.jpg', 'https://drive.google.com/uc?export=view&id=1d_yZ0iiTGLCqi30BMs8Wmvpj5jyQncNa'),
(10, 'พี่กัน', 'สุธิดา', 'นารินทร์', 'application support', 'ไอเจนโก้ จำกัด', 'alumni_687751f03d7d8.jpg', 'https://drive.google.com/uc?export=view&id=1hMziHANpBu_IOIKKkUJiRghQVRHK0nlR');

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` int(11) NOT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `starting_salary` varchar(50) DEFAULT NULL,
  `highlight` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`id`, `job_title`, `starting_salary`, `highlight`) VALUES
(1, 'เจ้าหน้าที่ IT Support', '12000', 'ดูแลและซ่อมแซมเครื่องคอมพิวเตอร์และระบบภายในสโตร์ จัดทำรายงานจากระบบคอมพิวเตอร์ สนับสนุนระบบ IT'),
(2, 'Junior IT Support', '15000', 'ตรวจเช็คเครื่องและอุปกรณ์ IT, ให้คำแนะนำการใช้โปรแกรม เช่น B Plus, แก้ไขปัญหาหน้างาน'),
(3, 'Software Developer ', '15000', 'เขียนโปรแกรม พัฒนาแอปพลิเคชัน ดูแลระบบซอฟต์แวร์ แก้ไขบั๊กและปรับปรุงโค้ด'),
(4, 'System Analyst', '18000', 'วิเคราะห์ความต้องการของระบบ วางแผนออกแบบระบบ และประสานงานกับทีมพัฒนา'),
(5, 'Database Administrator (DBA)', '20000', 'ดูแลระบบฐานข้อมูล ตรวจสอบความปลอดภัย และสำรองข้อมูล'),
(6, 'Network Engineer', '15000', 'ติดตั้งและดูแลระบบเครือข่าย รวมถึงแก้ไขปัญหาเกี่ยวกับการเชื่อมต่อ'),
(7, 'Web Developer', '15000', 'พัฒนาเว็บไซต์ ออกแบบหน้าตาเว็บ และดูแลระบบหลังบ้าน'),
(8, 'Data Scientist / Data Analyst', '20000', 'วิเคราะห์ข้อมูลเพื่อสนับสนุนการตัดสินใจ ใช้เครื่องมือและเทคนิคทางสถิติ'),
(9, 'UX/UI Designer', '18000', 'ออกแบบหน้าจอและประสบการณ์ผู้ใช้งานให้ใช้งานง่ายและน่าสนใจ'),
(10, 'Cybersecurity Analyst', '20000', 'ป้องกัน ตรวจจับ และตอบสนองต่อภัยคุกคามด้านความปลอดภัยไซเบอร์'),
(11, 'DevOps Engineer', '25000', 'เชื่อมการทำงานระหว่างทีมพัฒนาและทีมเซิร์ฟเวอร์ ทำให้ระบบพัฒนาและนำส่งอัตโนมัติ'),
(12, 'Game Developer', '15000', 'พัฒนาเกม เขียนโค้ดเกม และทดสอบระบบการทำงานของเกม'),
(13, 'Mobile App Developer', '18000', 'พัฒนาแอปพลิเคชันสำหรับ iOS หรือ Android ด้วยภาษาเช่น Swift หรือ Kotlin'),
(14, 'AI/ML Engineer', '25000', 'พัฒนาโมเดลปัญญาประดิษฐ์ วิเคราะห์ข้อมูล และสร้างระบบเรียนรู้จากข้อมูล'),
(15, 'IT Auditor', '20000', 'ตรวจสอบระบบ IT และความปลอดภัยของข้อมูลให้เป็นไปตามมาตรฐาน'),
(16, 'Technical Writer', '15000', 'เขียนคู่มือการใช้งานซอฟต์แวร์ เอกสารเชิงเทคนิค หรือบทความไอที'),
(17, 'Cloud Engineer', '25000', 'ออกแบบ ติดตั้ง และดูแลระบบ Cloud เช่น AWS, Azure, Google Cloud'),
(18, 'QA Engineer (Software Tester)', '15000', 'ทดสอบระบบซอฟต์แวร์ หาและรายงานข้อผิดพลาด (Bug) เพื่อให้ระบบมีคุณภาพ'),
(19, 'IT Project Manager', '25000', 'วางแผนและควบคุมโครงการด้านไอที ประสานงานกับทีมต่าง ๆ เพื่อให้โครงการสำเร็จ'),
(20, 'Robotics Programmer', '20000', 'เขียนโปรแกรมควบคุมหุ่นยนต์หรือระบบอัตโนมัติในอุตสาหกรรม'),
(21, 'BI Analyst (Business Intelligence)', '20000 บาท', 'วิเคราะห์ข้อมูลธุรกิจ สร้างรายงานเชิงลึกเพื่อช่วยการตัดสินใจขององค์กร'),
(22, 'SEO Specialist', '15000', 'ปรับแต่งเว็บไซต์ให้ติดอันดับการค้นหาใน Google และเครื่องมือค้นหาอื่น ๆ'),
(23, 'IT Trainer', '15000', 'สอนและอบรมด้านเทคโนโลยีสารสนเทศแก่พนักงานหรือบุคคลทั่วไป'),
(24, 'Blockchain Developer', '25000บาท', 'พัฒนา smart contracts, รวมระบบบล็อกเชนกับแอปพลิเคชัน และดูแลความปลอดภัยเชิงลึก'),
(25, 'Cloud Security Engineer', '28000', 'ออกแบบและติดตั้งมาตรการความปลอดภัยบน Cloud ตรวจสอบช่องโหว่ และป้องกันการโจมตี'),
(26, 'Site Reliability Engineer (SRE)', '30000', 'ดูแลและปรับปรุงความน่าเชื่อถือ ประสิทธิภาพ และการบำรุงรักษาระบบขนาดใหญ่ให้พร้อมใช้งานเสมอ'),
(27, 'Embedded Systems Engineer', '20000', 'เขียน Embedded C/C++ สำหรับฮาร์ดแวร์ไมโครคอนโทรลเลอร์ เช่น IoT หรือระบบอัตโนมัติ'),
(28, 'Systems Architect', '30000', 'ออกแบบสถาปัตยกรรมระบบไอทีทั้งระบบ เช่น การแบ่งโมดูล การเลือกเทคโนโลยี และวางแนวทางการใช้'),
(29, 'Data Engineer', '25000', 'สร้างและดูแล Data Pipeline, ETL, จัดการ Big Data และฐานข้อมูลขนาดใหญ่'),
(30, 'Computer Vision Engineer', '25000', 'พัฒนาระบบประมวลผลภาพ วิเคราะห์ภาพด้วย AI เช่น การจดจำใบหน้า หรือการตรวจสอบวัตถุ'),
(31, 'AR/VR Developer', '20000', 'พัฒนาแอปพลิเคชัน AR/VR ใช้ Unity หรือ Unreal Engine สร้างประสบการณ์เสมือนจริง'),
(32, 'IT Compliance Specialist', '20000', 'ตรวจสอบให้ระบบไอทีเป็นไปตามมาตรฐาน (PDPA, ISO, GDPR) และดูแลนโยบายด้านข้อมูล'),
(33, 'VR Game Designer', '18000', 'ออกแบบประสบการณ์เกมในโลก VR ทำให้ผู้เล่นอินและมีปฏิสัมพันธ์กับโลกเสมือน');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `facebook_page` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `phone_number`, `facebook_page`, `website`) VALUES
(1, '044-611221-6611', 'https://www.facebook.com/comsci.bru', 'https://cs.bru.ac.th');

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_plan`
--

CREATE TABLE `curriculum_plan` (
  `id` int(11) NOT NULL,
  `year_level` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curriculum_plan`
--

INSERT INTO `curriculum_plan` (`id`, `year_level`, `semester`, `image_url`) VALUES
(1, 1, 1, 'uploads/curriculum_6853c214504119.73991168.png'),
(2, 1, 2, 'uploads/curriculum_6853c2beebf9a4.49155720.png'),
(3, 2, 1, 'uploads/curriculum_6853c2df2dfe43.42105693.png'),
(4, 2, 2, 'uploads/curriculum_6853c2eb6b1a48.28482230.png'),
(5, 3, 1, 'uploads/curriculum_6853c2f8ebbbb2.25314852.png'),
(6, 3, 2, 'uploads/curriculum_6853c3020106b7.07841444.png'),
(7, 4, 1, 'uploads/curriculum_6853c317f07eb4.31164398.png'),
(8, 4, 2, 'uploads/curriculum_6853c322cc4b07.53435665.png');

-- --------------------------------------------------------

--
-- Table structure for table `department_activities`
--

CREATE TABLE `department_activities` (
  `id` int(11) NOT NULL,
  `activity_name` varchar(100) DEFAULT NULL,
  `activity_image_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_activities`
--

INSERT INTO `department_activities` (`id`, `activity_name`, `activity_image_url`, `image_url`) VALUES
(1, 'ภาพกิจกรรมรับน้อง 2568 สาขาวิชาวิทยาการคอมพิวเตอร์ ', 'uploads/activity_6853c77d188528.97898892.jpg', 'https://drive.google.com/file/d/14CLW2ZrGUdEGyKwURDw9o9qT6mSX51LC/view?usp=share_link'),
(2, 'โครงการเตรียมความพร้อมก่อนศึกษา ประจำปีการศึกษา 2568 ', 'uploads/activity_6853c7b8502bf3.81681659.jpg', 'https://drive.google.com/file/d/1qTVJfLMLEHHxrrasVYRsS06Lpyv-9fd6/view?usp=share_link'),
(3, 'อบรมการใช้เทคโนโลยีสารสนเทศสำหรับนักศึกษาปี 1 ', 'uploads/activity_6864f3123da992.64774217.jpg', 'https://drive.google.com/file/d/17R9WAETMGPGllqjvns6v7wW8e9mDM_fl/view?usp=share_link'),
(4, 'นักศึกษาและอาจารย์สาขาร่วมตักบาตรรับปีใหม่', 'uploads/activity_6864f3882a4cd5.85321542.jpg', 'https://drive.google.com/file/d/19FhqblweaWiMSam_TbIytooZnUGouCR_/view?usp=share_link'),
(5, 'งาน Open House 2024', 'uploads/activity_6864f48dd25252.10960421.jpg', 'https://drive.google.com/file/d/1QeXvmGxHcqAc0RMkhZQ8i1911aA3QbDH/view?usp=share_link'),
(6, 'การแข่งขัน เนื่องในสัปดาห์วิทยาศาสตร์', 'uploads/activity_6864fc7127c596.57476568.jpg', 'https://drive.google.com/file/d/1LDFIcyz3Ys12bv8-IR37Q3nD2jb46YzS/view?usp=share_link'),
(7, 'กิจกรรมการประกวด Mr. & Miss SCI “Celestial Quest Of SCI”', 'uploads/activity_689b36751506d4.61267205.jpg', 'https://drive.google.com/file/d/1fK83hrgXcN9KUyzhtXFPGmN0GJoVmtvQ/view?usp=share_link');

-- --------------------------------------------------------

--
-- Table structure for table `department_info`
--

CREATE TABLE `department_info` (
  `id` int(11) NOT NULL,
  `degree_name` varchar(255) DEFAULT NULL,
  `learning_support` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_info`
--

INSERT INTO `department_info` (`id`, `degree_name`, `learning_support`) VALUES
(1, 'วิทยาศาสตรบัณฑิต (วิทยาการคอมพิวเตอร์)', 'ห้องเรียนคอมพิวเตอร์ ที่มีเครื่องคอมพิวเตอร์ประสิทธิภาพสูง พร้อมซอฟต์แวร์เฉพาะด้าน เช่น Python, Java, Visual Studio, Unity, SQL Server '),
(2, 'Bachelor of Science (Computer Science)', 'เครือข่ายอินเทอร์เน็ตและ Wi-Fi ครอบคลุมพื้นที่เรียน'),
(3, 'ตัวย่อที่ใช้คือ วท.บ. (วิทยาการคอมพิวเตอร์) หรือ B.Sc. (Computer Science)', 'อาจารย์ที่ปรึกษา (Advisor) ให้คำปรึกษาเรื่องการเรียน การวางแผนหลักสูตร และการทำโครงงาน');

-- --------------------------------------------------------

--
-- Table structure for table `dress_codes`
--

CREATE TABLE `dress_codes` (
  `id` int(11) NOT NULL,
  `occasion` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dress_codes`
--

INSERT INTO `dress_codes` (`id`, `occasion`, `description`, `image_url`) VALUES
(1, 'กิจกรรมรับน้อง', 'ควรสวมใส่เสื้อผ้าที่เหมาะแก้การทำกิจกรรม', 'uploads/dress_6853c8af8aa4a5.55259458.png'),
(2, 'วันจัดงานกิจกรรม', 'ควรเป็นชุดที่สุภาพแต่ก็ยังสะดวกต่อการทำกิจกรรมในมหาลัย', 'uploads/dress_6853ec0b727856.81545249.png'),
(3, 'การแต่งกายก่อนพิธีรับตรา', 'ชุดนักศึกษา ไม่มีตุ้งติ้ง ไม่มีเข็มขัดกางเกงและกระโปรงควรเป็นสีเทา รองเท้าเป็นรองเท้าผ้าใบสีขาว', 'uploads/dress_6863af7f1bf6f0.33877571.png');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `full_name`, `image_url`) VALUES
(2, 'นายวราวุธ จอสูงเนิน', 'uploads/teacher_6853e0ef758900.62476749.png'),
(3, 'นายสกรณ์ บุษบง', 'uploads/teacher_6853e11442f119.77766379.png'),
(4, 'นายวิชชา ภัทรนิธิคุณากร', 'uploads/teacher_6853e1327eeb78.71951687.jpg'),
(5, 'นายสมพร กระออมแก้ว', 'uploads/teacher_6853e14b5f88f8.57470205.jpg'),
(6, 'ดร.ชาติวุฒิ ธนาจิรันธร', 'uploads/teacher_6853e1666a5975.07472496.png'),
(7, 'ดร.ณปภัช วรรณตรง', 'uploads/teacher_6853e177105d91.92464026.jpg'),
(8, 'ดร.ณัฐพล แสนคำ', 'uploads/teacher_6853e18982dbf2.66135482.jpg'),
(9, 'ดร.ทิพวัลย์ แสนคำ', 'uploads/teacher_6853e1953dfc86.54522424.jpg'),
(10, 'ผศ.ดร.สมศักดิ์ จีวัฒนา', 'uploads/teacher_6853e1a3d193e5.70855450.jpg'),
(11, 'นายชลัท รังสิมาเทวัญ', 'uploads/teacher_6853e1af3ffdf1.55777837.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tuition_fee`
--

CREATE TABLE `tuition_fee` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `other_expenses` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tuition_fee`
--

INSERT INTO `tuition_fee` (`id`, `description`, `other_expenses`) VALUES
(1, 'ค่าแรกเข้าปี 1 เทอมปี 1 อยู่ที่ 10,900  รวมค่าบำรุงการศึกษาและค่ารายงานตัว', 'ค่าบำรุงการศึกษา ปี 1 เป็น 2,900 บาท'),
(2, 'ปี 1 เทอมปี 2 ค่าบำรุงการศึกษา 8,000 บาท', '-'),
(3, 'ปี 2 เทอมปี 1 ค่าบำรุงการศึกษา 8,000 บาท', '-'),
(4, 'ปี 2 เทอมปี 2 ค่าบำรุงการศึกษา 8,000 บาท', '-'),
(5, 'ปี 3 เทอมปี 1 ค่าบำรุงการศึกษา 8,000 บาท', '-'),
(6, 'ปี 3 เทอมปี 2 ค่าบำรุงการศึกษา 8,000 บาท', '-'),
(7, 'ปี 4 เทอมปี 1 ค่าบำรุงการศึกษา 5,900บาท', '-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curriculum_plan`
--
ALTER TABLE `curriculum_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_activities`
--
ALTER TABLE `department_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_info`
--
ALTER TABLE `department_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dress_codes`
--
ALTER TABLE `dress_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tuition_fee`
--
ALTER TABLE `tuition_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `curriculum_plan`
--
ALTER TABLE `curriculum_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department_activities`
--
ALTER TABLE `department_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `department_info`
--
ALTER TABLE `department_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dress_codes`
--
ALTER TABLE `dress_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tuition_fee`
--
ALTER TABLE `tuition_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
