<?php
require_once __DIR__ . '/config.php';

try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `web_coba` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `web_coba`;");

    $pdo->exec("CREATE TABLE IF NOT EXISTS `news` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `summary` TEXT NOT NULL,
        `content` LONGTEXT NULL,
        `image` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $pdo->exec("TRUNCATE TABLE `news`;");

    $articles = [
        [
            'title'   => 'Đi ăn Tết ở đâu? Gợi ý nhà hàng ẩm thực miền Nam cho ngày sum họp',
            'summary' => 'Tới đây, người vội chuẩn bị mâm cơm gia đình, nhiều người cũng chọn đi ăn Tết tại nhà hàng để tiện hướng không khí thư thả, không phải nấu nướng mà vẫn giữ trọn hương vị truyền thống. Câu hỏi quen thuộc mỗi dịp xuân về lại là "Đi ăn Tết ở đâu để vừa ngon, vừa ấm cúng?"',
            'content' => '
<p class="lead fw-semibold">Xuân về là thời điểm mọi người gác lại bộn bề công việc để cùng nhau tận hưởng những giây phút ấm áp bên gia đình. Đi ăn Tết tại nhà hàng miền Nam ngày càng trở thành lựa chọn phổ biến giúp tiết kiệm thời gian chuẩn bị mà vẫn đảm bảo bữa ăn thơm ngon, ý nghĩa.</p>

<h3 id="sec1">Lý do nên chọn nhà hàng ẩm thực miền Nam cho dịp Tết</h3>
<p>Ẩm thực miền Nam nổi tiếng với sự phong phú, hương vị hài hòa giữa vị ngọt nhẹ, chua thanh và mặn đượm. Những món ăn như bánh khọt Vũng Tàu, bánh xèo, lẩu cá hay gỏi cuốn luôn mang lại cảm giác quen thuộc, gần gũi cho mọi lứa tuổi trong gia đình.</p>

<h3 id="sec2">Cô Ba Vũng Tàu - Điểm đến lý tưởng ngày Tết</h3>
<p>Với không gian mang đậm nét văn hóa truyền thống kết hợp nét hiện đại tinh tế, Cô Ba Vũng Tàu là địa điểm hoàn hảo để thưởng thức món bánh khọt giòn rụm trọn vị cùng thực đơn đa dạng phong phú.</p>
<ul>
    <li>Bánh khọt tôm tươi giòn tan thơm lừng.</li>
    <li>Không gian thoáng đãng, ấm cúng phù hợp chụp ảnh kỷ niệm đầu năm.</li>
    <li>Phục vụ chu đáo, thân thiện xuyên suốt kỳ nghỉ lễ.</li>
</ul>
',
            'image'   => 'public/img/HomeBackground_01.jpg'
        ],
        [
            'title'   => 'Nhà hàng phù hợp tổ chức liên hoan cuối năm tại TP.HCM - Không gian ấm cúng, món ngon dễ ăn',
            'summary' => 'Cuối năm là dịp các công ty, nhóm bạn và gia đình tìm kiếm nhà hàng phù hợp tổ chức liên hoan cuối năm tại TP.HCM để cùng nhau tổng kết một năm làm việc vất vả cần nghỉ ngơi. Tuy nhiên, giữa vô vàn lựa chọn, việc tìm được một nhà hàng vừa đáp ứng không gian thoải mái, vừa có món ăn dễ ăn, lại phục vụ chuyên nghiệp không phải dễ dàng.',
            'content' => '
<p class="lead-text fw-semibold">Cuối năm là dịp các công ty, nhóm bạn và gia đình tìm kiếm nhà hàng phù hợp tổ chức liên hoan cuối năm tại TP.HCM để cùng nhau tổng kết một năm làm việc vất vả cần nghỉ ngơi. Tuy nhiên, giữa vô vàn lựa chọn, việc tìm được một nhà hàng vừa đáp ứng không gian thoải mái, vừa có món ăn dễ ăn, lại phục vụ chuyên nghiệp không phải dễ dàng.</p>

<h3 id="sec1">Tiêu chí chọn nhà hàng tổ chức liên hoan cuối năm tại TP.HCM</h3>
<p>Để buổi liên hoan cuối năm diễn ra suôn sẻ và đáng nhớ, nhà hàng được chọn nên đáp ứng các tiêu chí sau:</p>
<ul>
    <li><strong>Không gian rộng rãi, thoáng mát, ấm cúng:</strong> Phù hợp cho số lượng khách từ nhóm nhỏ đến đoàn đông người.</li>
    <li><strong>Thực đơn phong phú, dễ ăn, hợp vị:</strong> Đặc biệt là các món ăn truyền thống miền Nam phù hợp với nhiều lứa tuổi.</li>
    <li><strong>Vị trí thuận tiện, dễ di chuyển:</strong> Các khu vực trung tâm như Quận 3, Quận 7 giúp khách tham gia di chuyển dễ dàng.</li>
    <li><strong>Phục vụ chuyên nghiệp, chu đáo:</strong> Đội ngũ nhân viên nhanh nhẹn, nhiệt tình.</li>
    <li><strong>Mức chi phí hợp lý, có ưu đãi:</strong> Giúp tiết kiệm ngân sách cho doanh nghiệp và gia đình.</li>
</ul>

<div class="text-center my-4">
    <img src="public/img/HomeBackground_02.jpg" alt="Liên hoan cuối năm tại Cô Ba Vũng Tàu" class="img-fluid rounded shadow" style="max-height: 420px; width: 100%; object-fit: cover;">
</div>

<h3 id="sec2">Cô Ba Vũng Tàu – Nhà hàng lý tưởng cho tiệc liên hoan cuối năm</h3>
<p>Nhắc đến thương hiệu ẩm thực miền Nam uy tín tại TP.HCM, Cô Ba Vũng Tàu luôn là cái tên được nhiều thực khách tin tưởng lựa chọn nhờ sự kết hợp hài hòa giữa không gian và ẩm thực phong phú.</p>
<p><strong>Không gian ấm cúng, thiết kế ấn tượng:</strong></p>
<p>Các chi nhánh của Cô Ba Vũng Tàu tại TP.HCM (Phú Mỹ Hưng Q.7 & Trần Cao Vân Q.3) sở hữu không gian rộng rãi, mang nét ấm cúng nhưng vẫn hiện đại, rất hợp cho các buổi tiệc tất niên, họp mặt gia đình hay tiệc công ty.</p>

<h3 id="sec3">Thực đơn ẩm thực miền Nam – Dễ ăn và trọn vị</h3>
<p>Một trong những ưu điểm lớn nhất khi tổ chức tiệc tại Cô Ba Vũng Tàu chính là thực đơn đa dạng, kết hợp hài hòa giữa bánh khọt truyền thống, lẩu cá, gỏi cá sặc và các món ăn miền Nam trọn vị:</p>
<ul>
    <li><strong>Bánh khọt Cô Ba Vũng Tàu:</strong> Nhân tôm tươi, vỏ giòn rụm, ăn kèm rau sống và nước mắm chua ngọt chuẩn vị.</li>
    <li><strong>Bánh xèo miền Tây:</strong> Vàng ươm, thơm nức tiếng.</li>
    <li><strong>Các món cuốn & gỏi thanh nhẹ:</strong> Dễ ăn, chống ngấy cho bữa tiệc.</li>
    <li><strong>Lẩu miền Nam thơm ngon đậm đà:</strong> Ấm áp cho bữa tiệc cuối năm sum vầy.</li>
</ul>

<div class="text-center my-4">
    <img src="public/img/HomeBackground_03.jpg" alt="Món ăn ngon miền Nam" class="img-fluid rounded shadow" style="max-height: 400px; width: 100%; object-fit: cover;">
</div>

<h3 id="sec4">Đặt bàn hàng số tổ chức liên hoan cuối năm tại TP.HCM</h3>
<p>Để đảm bảo chọn được vị trí đẹp và phục vụ chu đáo nhất cho buổi tiệc của bạn, hãy liên hệ đặt bàn trước với Cô Ba Vũng Tàu:</p>
<ul>
    <li>CN1: 216 Phạm Thái Bường, Phú Mỹ Hưng, Q.7, TP.HCM - Hotline: 028 3620 1281</li>
    <li>CN2: 40B Trần Cao Vân, P. Võ Thị Sáu, Q.3, TP.HCM - Hotline: 028 3823 7356</li>
</ul>
<p class="fst-italic text-muted">Cô Ba Vũng Tàu hân hạnh được đồng hành cùng quý khách tạo nên những khoảnh khắc ấm áp, ý nghĩa bên người thân và đồng nghiệp!</p>
',
            'image'   => 'public/img/HomeBackground_02.jpg'
        ],
        [
            'title'   => 'Nhà hàng tổ chức tất niên công ty tại Vũng Tàu - Không gian ấm cúng, món ngon dễ ăn',
            'summary' => 'Cuối năm là thời điểm các công ty, doanh nghiệp tìm kiếm nhà hàng tổ chức tất niên tại Vũng Tàu để cùng nhau nhìn lại chặng đường đã qua và gắn kết tinh thần tập thể. Một không gian rộng rãi, món ăn ngon - dễ ăn, phục vụ chuyên nghiệp và mức chi phí hợp lý chính là những tiêu chí được quan tâm hàng đầu.',
            'content' => '
<p class="lead fw-semibold">Vũng Tàu là địa điểm tuyệt vời cho các buổi liên hoan tất niên công ty kết hợp du lịch ngắn ngày. Cô Ba Vũng Tàu tại chi nhánh Hoàng Hoa Thám tự hào mang đến không gian tiệc ấm cúng, phục vụ tận tình cùng thực đơn miền biển vô cùng đặc sắc.</p>
<h3 id="sec1">Không gian đặt tiệc ấn tượng tại Vũng Tàu</h3>
<p>Với lối kiến trúc mộc mạc đậm chất Việt Nam, nhà hàng cung cấp các khoảng không rộng rãi cho các đoàn tiệc từ vài chục đến hàng trăm khách.</p>
<h3 id="sec2">Thực đơn đặc sản biển & bánh khọt trọn vị</h3>
<p>Những chiếc bánh khọt giòn rụm với tôm tươi ngon kết hợp cùng các món ăn đặc trưng vùng biển mang đến trải nghiệm ẩm thực không thể quên.</p>
',
            'image'   => 'public/img/HomeBackground_03.jpg'
        ],
        [
            'title'   => 'Quán ăn gia đình tại Vũng Tàu - Cô Ba lựa chọn lý tưởng cho mọi lứa tuổi',
            'summary' => 'Vũng Tàu không chỉ là điểm đến du lịch biển quen thuộc mà còn là nơi lý tưởng để tổ chức những bữa ăn gia đình, họp mặt bạn bè, liên hoan hay sinh nhật. Trong số các quán ăn gia đình tại Vũng Tàu, Cô Ba Vũng Tàu được nhiều thực khách lựa chọn nhờ không gian ấm cúng vị truyền thống, không gian thoải mái và thực đơn phù hợp cho mọi lứa tuổi.',
            'content' => '
<p class="lead fw-semibold">Tìm kiếm quán ăn gia đình đáp ứng tiêu chí đồ ăn ngon, không gian sạch sẽ, lịch sự cho ông bà, cha mẹ và trẻ nhỏ luôn là ưu tiên hàng đầu của du khách khi tới Vũng Tàu.</p>
<h3 id="sec1">Thực đơn phong phú chiều lòng mọi lứa tuổi</h3>
<p>Từ món bánh khọt đặc sản giòn thơm dễ ăn cho các bé, đến lẩu cá thanh ngọt cho người lớn tuổi, Cô Ba Vũng Tàu chăm chút từng dĩa thức ăn trọn vẹn hương vị Việt.</p>
',
            'image'   => 'public/img/2023_08_28_21_35_44_30.jpg'
        ],
        [
            'title'   => 'Du lịch Vũng Tàu lễ Tết nên ăn ở đâu cho tiện & ngon? Gợi ý quán được du khách tin chọn',
            'summary' => 'Vũng Tàu là điểm đến quen thuộc mỗi dịp lễ, Tết, cuối tuần nhờ khoảng cách gần TP.HCM và không khí biển trong lành. Tuy nhiên, vào mùa cao điểm, việc tìm được quán ăn vừa ngon, vừa tiện, không mất nhiều thời gian chờ đợi luôn là điều khiến nhiều du khách băn khoăn.',
            'content' => '
<p class="lead fw-semibold">Những mẹo nhỏ giúp bạn và gia đình thưởng thức trọn vẹn hương vị bánh khọt Cô Ba Vũng Tàu nổi tiếng mà không lo chen chúc ngày lễ Tết.</p>
<h3 id="sec1">Đặt bàn trước trực tuyến hoặc hotline</h3>
<p>Chỉ cần đặt bàn trước vài thao tác trên website hoặc hotline, bàn ăn của gia đình bạn sẽ được chuẩn bị sẵn sàng ngay khi tới nơi.</p>
',
            'image'   => 'public/img/HomeBackground_01.jpg'
        ],
        [
            'title'   => 'Quán ăn miền Nam gần trung tâm TP.HCM - Dễ tìm, dễ đi, chuẩn vị truyền thống',
            'summary' => 'TP.HCM là điểm đến sôi động với du khách trong và ngoài nước. Sau khi tham quan các địa điểm nổi tiếng như Quận 1, Quận 3, Quận Phú Nhuận, nhu cầu tìm quán ăn miền Nam gần trung tâm TP.HCM để thưởng thức hương vị truyền thống luôn được nhiều người quan tâm.',
            'content' => '
<p class="lead fw-semibold">Tọa lạc tại vị trí đắc địa Quận 3 và Quận 7, Cô Ba Vũng Tàu mang không gian miền Nam xưa giữa lòng Sài Gòn tấp nập.</p>
<h3 id="sec1">Gần các điểm tham quan trung tâm</h3>
<p>Chỉ mất 5-10 phút di chuyển từ trung tâm TP.HCM, thực khách đã có thể thưởng thức bánh khọt, bánh xèo chuẩn vị Vũng Tàu.</p>
',
            'image'   => 'public/img/HomeBackground_02.jpg'
        ],
        [
            'title'   => 'Quán ăn miền Nam tại TP.HCM được du khách yêu thích - Trải nghiệm trọn vẹn hương vị phương Nam',
            'summary' => 'TP.HCM không chỉ là trung tâm kinh tế - du lịch sôi động mà còn là nơi hội tụ tinh hoa ẩm thực miền Nam. Với du khách trong và ngoài nước, việc tìm được quán ăn miền Nam tại TP.HCM vừa ngon, vừa chuẩn vị, vừa mang đậm bản sắc văn hóa luôn là một trải nghiệm đáng nhớ.',
            'content' => '
<p class="lead fw-semibold">Trải nghiệm nét văn hóa ẩm thực đặc sắc của miền Tây & miền Đông Nam Bộ ngay tại chuỗi nhà hàng Cô Ba Vũng Tàu.</p>
',
            'image'   => 'public/img/HomeBackground_03.jpg'
        ],
        [
            'title'   => 'Ở TP.HCM nên tổ chức họp mặt ở quán ăn miền Nam nào? Gợi ý không gian & món ngon dễ chọn',
            'summary' => 'TP.HCM là nơi lý tưởng để tổ chức các buổi họp mặt gia đình, bạn bè đồng nghiệp hay tiệc hoan ca cùng gia đình. Giữa rất nhiều phong cách ẩm thực, quán ăn miền Nam vẫn luôn được ưu tiên nhờ hương vị quen thuộc, ấm cúng và không gian gần gũi.',
            'content' => '
<p class="lead fw-semibold">Gợi ý địa điểm họp mặt lý tưởng mang phong cách miền Nam ấm áp, đậm đà tình thân.</p>
',
            'image'   => 'public/img/2023_08_28_21_35_44_30.jpg'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO `news` (`title`, `summary`, `content`, `image`, `created_at`) VALUES (:title, :summary, :content, :image, NOW() - INTERVAL :idx HOUR)");

    foreach ($articles as $idx => $art) {
        $stmt->execute([
            ':title'   => $art['title'],
            ':summary' => $art['summary'],
            ':content' => $art['content'],
            ':image'   => $art['image'],
            ':idx'     => count($articles) - $idx
        ]);
    }

    echo "SUCCESS: Re-seeded " . count($articles) . " news articles into `web_coba.news` table!\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
