CREATE DATABASE IF NOT EXISTS `web_coba` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_coba`;

CREATE TABLE IF NOT EXISTS `branches` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255),
    `phone` VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `branches` (`name`, `address`, `phone`) VALUES
('CN Hoàng Hoa Thám - Vũng Tàu', 'Số 1 Hoàng Hoa Thám, P.3, TP. Vũng Tàu', '0254 355 3567'),
('CN 12/1 Hoàng Hoa Thám - Vũng Tàu', '12/1 Hoàng Hoa Thám, P.2, TP. Vũng Tàu', '0254 352 6166'),
('CN Phú Mỹ Hưng - Q.7, TP.HCM', '216 Phạm Thái Bường, Phú Mỹ Hưng, Q.7, TP.HCM', '028 36201281'),
('CN Trần Cao Vân - Q.3, TP.HCM', '40B Trần Cao Vân, P. Võ Thị Sáu, Q.3, TP.HCM', '028 3823 7356');

CREATE TABLE IF NOT EXISTS `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fullname` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `branch` VARCHAR(255) NOT NULL,
    `booking_date` DATE NOT NULL,
    `booking_time` TIME NOT NULL,
    `guests` INT NOT NULL DEFAULT 1,
    `note` TEXT NULL,
    `status` ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `subscribers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `news` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `summary` TEXT NOT NULL,
    `content` LONGTEXT NULL,
    `image` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `news` (`title`, `summary`, `content`, `image`, `created_at`) VALUES
('Đi ăn Tết ở đâu? Gợi ý nhà hàng ẩm thực miền Nam cho ngày sum họp', 'Tới đây, người vội chuẩn bị mâm cơm gia đình, nhiều người cũng chọn đi ăn Tết tại nhà hàng để tiện hướng không khí thư thả, không phải nấu nướng mà vẫn giữ trọn hương vị truyền thống. Câu hỏi quen thuộc mỗi dịp xuân về lại là "Đi ăn Tết ở đâu để vừa ngon, vừa ấm cúng?"', 'Nội dung chi tiết bài viết Đi ăn Tết ở đâu...', 'public/img/HomeBackground_01.jpg', NOW() - INTERVAL 8 HOUR),

('Nhà hàng phù hợp tổ chức liên hoan cuối năm tại TP.HCM - Không gian ấm cúng, món ngon dễ ăn', 'Cuối năm là dịp các công ty, nhóm bạn và gia đình tìm kiếm nhà hàng phù hợp tổ chức liên hoan cuối năm tại TP.HCM để cùng nhau tổng kết một năm làm việc vất vả cần nghỉ ngơi. Tuy nhiên, giữa vô vàn lựa chọn, việc tìm được một nhà hàng vừa đáp ứng không gian thoải mái, vừa có món ăn dễ ăn, lại phục vụ chuyên nghiệp không phải dễ dàng.', 'Nội dung chi tiết bài viết Liên hoan cuối năm...', 'public/img/HomeBackground_02.jpg', NOW() - INTERVAL 7 HOUR),

('Nhà hàng tổ chức tất niên công ty tại Vũng Tàu - Không gian ấm cúng, món ngon dễ ăn', 'Cuối năm là thời điểm các công ty, doanh nghiệp tìm kiếm nhà hàng tổ chức tất niên tại Vũng Tàu để cùng nhau nhìn lại chặng đường đã qua và gắn kết tinh thần tập thể. Một không gian rộng rãi, món ăn ngon - dễ ăn, phục vụ chuyên nghiệp và mức chi phí hợp lý chính là những tiêu chí được quan tâm hàng đầu.', 'Nội dung chi tiết bài viết Tất niên Vũng Tàu...', 'public/img/HomeBackground_03.jpg', NOW() - INTERVAL 6 HOUR),

('Quán ăn gia đình tại Vũng Tàu - Cô Ba lựa chọn lý tưởng cho mọi lứa tuổi', 'Vũng Tàu không chỉ là điểm đến du lịch biển quen thuộc mà còn là nơi lý tưởng để tổ chức những bữa ăn gia đình, họp mặt bạn bè, liên hoan hay sinh nhật. Trong số các quán ăn gia đình tại Vũng Tàu, Cô Ba Vũng Tàu được nhiều thực khách lựa chọn nhờ không gian ấm cúng vị truyền thống, không gian thoải mái và thực đơn phù hợp cho mọi lứa tuổi.', 'Nội dung chi tiết bài viết Quán ăn gia đình...', 'public/img/2023_08_28_21_35_44_30.jpg', NOW() - INTERVAL 5 HOUR),

('Du lịch Vũng Tàu lễ Tết nên ăn ở đâu cho tiện & ngon? Gợi ý quán được du khách tin chọn', 'Vũng Tàu là điểm đến quen thuộc mỗi dịp lễ, Tết, cuối tuần nhờ khoảng cách gần TP.HCM và không khí biển trong lành. Tuy nhiên, vào mùa cao điểm, việc tìm được quán ăn vừa ngon, vừa tiện, không mất nhiều thời gian chờ đợi luôn là điều khiến nhiều du khách băn khoăn.', 'Nội dung chi tiết bài viết Du lịch Vũng Tàu lễ Tết...', 'public/img/HomeBackground_01.jpg', NOW() - INTERVAL 4 HOUR),

('Quán ăn miền Nam gần trung tâm TP.HCM - Dễ tìm, dễ đi, chuẩn vị truyền thống', 'TP.HCM là điểm đến sôi động với du khách trong và ngoài nước. Sau khi tham quan các địa điểm nổi tiếng như Quận 1, Quận 3, Quận Phú Nhuận, nhu cầu tìm quán ăn miền Nam gần trung tâm TP.HCM để thưởng thức hương vị truyền thống luôn được nhiều người quan tâm.', 'Nội dung chi tiết bài viết Quán ăn miền Nam gần trung tâm...', 'public/img/HomeBackground_02.jpg', NOW() - INTERVAL 3 HOUR),

('Quán ăn miền Nam tại TP.HCM được du khách yêu thích - Trải nghiệm trọn vẹn hương vị phương Nam', 'TP.HCM không chỉ là trung tâm kinh tế - du lịch sôi động mà còn là nơi hội tụ tinh hoa ẩm thực miền Nam. Với du khách trong và ngoài nước, việc tìm được quán ăn miền Nam tại TP.HCM vừa ngon, vừa chuẩn vị, vừa mang đậm bản sắc văn hóa luôn là một trải nghiệm đáng nhớ.', 'Nội dung chi tiết bài viết Quán ăn miền Nam tại TP.HCM...', 'public/img/HomeBackground_03.jpg', NOW() - INTERVAL 2 HOUR),

('Ở TP.HCM nên tổ chức họp mặt ở quán ăn miền Nam nào? Gợi ý không gian & món ngon dễ chọn', 'TP.HCM là nơi lý tưởng để tổ chức các buổi họp mặt gia đình, bạn bè đồng nghiệp hay tiệc hoan ca cùng gia đình. Giữa rất nhiều phong cách ẩm thực, quán ăn miền Nam vẫn luôn được ưu tiên nhờ hương vị quen thuộc, ấm cúng và không gian gần gũi.', 'Nội dung chi tiết bài viết Tổ chức họp mặt...', 'public/img/2023_08_28_21_35_44_30.jpg', NOW() - INTERVAL 1 HOUR);
