<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        // Tránh chạy 2 lần làm dữ liệu bị nhân đôi
        if (DB::table('posts')->exists()) {
            $this->command->warn('Bảng posts đã có dữ liệu, bỏ qua. Chạy "php artisan migrate:fresh" rồi seed lại nếu muốn làm mới.');
            return;
        }

        // ---------- 1. NGƯỜI DÙNG (mật khẩu chung: password123) ----------
        $userData = [
            ['Quản trị viên',     'admin@test.com', 'admin'],
            ['Nguyễn Minh Huy',   'huy@test.com',   'user'],
            ['Trần Thu Hà',       'ha@test.com',    'user'],
            ['Lê Quốc Bảo',       'bao@test.com',   'user'],
            ['Phạm Ngọc Anh',     'anh@test.com',   'user'],
            ['Vũ Đức Thắng',      'thang@test.com', 'user'],
            ['Đỗ Khánh Linh',     'linh@test.com',  'user'],
            ['Hoàng Gia Khang',   'khang@test.com', 'user'],
        ];

        $users = [];
        foreach ($userData as [$name, $email, $role]) {
            $users[] = User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password123', 'role' => $role]
            );
        }
        $userIds = collect($users)->pluck('id')->all();

        // ---------- 2. CHUYÊN MỤC ----------
        $categoryData = [
            ['Học tập',             'Chia sẻ tài liệu, phương pháp học và kinh nghiệm thi cử.'],
            ['Đời sống sinh viên',  'Ký túc xá, nhà trọ, chi tiêu và những chuyện thường ngày.'],
            ['Công nghệ',           'Lập trình, thiết bị, phần mềm và xu hướng công nghệ.'],
            ['Việc làm & Thực tập', 'CV, phỏng vấn, thực tập và định hướng nghề nghiệp.'],
            ['Giải trí',            'Phim, nhạc, game, sách và các hoạt động thư giãn.'],
        ];

        $categoryIds = [];
        foreach ($categoryData as [$name, $desc]) {
            $categoryIds[] = Category::create(['name' => $name, 'description' => $desc])->id;
        }

        // ---------- 3. BÀI VIẾT: [chỉ số chuyên mục, tiêu đề, nội dung] ----------
        $posts = [
            // ===== Học tập (0) =====
            [0, "Cách ôn thi cuối kỳ hiệu quả trong 2 tuần",
                "Mình thường chia 2 tuần ôn thi thành 3 giai đoạn: tuần đầu hệ thống lại lý thuyết, 4 ngày tiếp theo làm đề cũ, các ngày cuối chỉ xem lại phần hay sai. Quan trọng nhất là làm đề thật với đúng thời gian thi, vì nhiều bạn hiểu bài nhưng quản lý giờ kém nên mất điểm oan.\n\nAi có cách ôn khác thì chia sẻ thêm nhé."],
            [0, "Xin tài liệu môn Giải tích 1 (có đáp án)",
                "Mình đang cần đề thi các năm trước và bài tập chương giới hạn, đạo hàm, tích phân của môn Giải tích 1. Bạn nào có file PDF hoặc ảnh chụp lời giải chi tiết thì cho mình xin với, cảm ơn nhiều. Mình sẽ chia sẻ lại bộ ghi chú công thức mình tự tổng hợp."],
            [0, "Phương pháp Pomodoro có thật sự hiệu quả?",
                "Mình thử Pomodoro 25 phút học và 5 phút nghỉ trong một tháng. Kết quả là học các môn cần ghi nhớ thì rất ổn, nhưng khi làm bài tập lớn cần tập trung sâu thì 25 phút lại quá ngắn và hay bị ngắt mạch. Các bạn thấy sao, có ai điều chỉnh thành 50/10 không?"],
            [0, "Review môn Cơ sở dữ liệu: học gì, thi gì?",
                "Môn này gồm 3 phần chính: mô hình thực thể liên kết, chuẩn hóa dữ liệu và SQL. Đề thi thường cho một bài toán thực tế, yêu cầu vẽ ERD rồi viết khoảng 5 câu truy vấn có JOIN và GROUP BY. Nên luyện viết tay truy vấn vì thi không được chạy thử.\n\nGợi ý: làm thật nhiều bài tập JOIN nhiều bảng."],
            [0, "Nên học IELTS hay TOEIC khi còn là sinh viên năm 2?",
                "Mình đang phân vân giữa hai chứng chỉ. TOEIC thường được các công ty và trường dùng làm điều kiện chuẩn đầu ra, còn IELTS có giá trị rộng hơn khi xin học bổng hoặc du học. Nếu chưa có kế hoạch ra nước ngoài thì mình nghiêng về TOEIC trước, bạn nào đã thi cả hai cho mình xin ý kiến."],
            [0, "Cách ghi chép bài giảng bằng Notion",
                "Mình dùng một database cho mỗi học kỳ, mỗi môn là một trang con, trong đó có các mục: bài giảng, bài tập, deadline và câu hỏi cần hỏi thầy. Cách này giúp mình tìm lại nội dung rất nhanh và không bị rải rác nhiều nơi. Nếu cần mình chia sẻ template để các bạn copy về dùng."],
            [0, "Tìm bạn lập nhóm học Lập trình hướng đối tượng",
                "Mình đang học môn OOP bằng Java và muốn lập nhóm 3-4 người, mỗi tuần gặp 2 buổi để làm bài tập và review code của nhau. Nhóm mình ưu tiên bạn nghiêm túc, đúng giờ và sẵn sàng giải thích bài cho người khác. Ai quan tâm thì bình luận bên dưới, mình sẽ tạo nhóm chat."],
            [0, "Kinh nghiệm xin học bổng toàn phần",
                "Mình từng được học bổng của một trường ở nước ngoài nên muốn chia sẻ vài điều. Hồ sơ cần nhất quán: bài luận, thư giới thiệu và hoạt động ngoại khóa phải kể cùng một câu chuyện về bạn. Hãy bắt đầu chuẩn bị từ 1 năm trước hạn nộp, đừng chờ sát ngày mới làm.\n\nAi cần review bài luận thì nhắn mình."],
            [0, "Làm đồ án tốt nghiệp: bắt đầu từ đâu?",
                "Sắp lên năm cuối nên mình khá lo về đồ án. Mình định chọn đề tài trước học kỳ, tìm giảng viên hướng dẫn sớm rồi chia nhỏ công việc theo tuần. Các anh chị đã bảo vệ xong có thể cho mình lời khuyên về việc chọn đề tài vừa sức mà vẫn có điểm nhấn không?"],
            [0, "Chia sẻ mẹo viết báo cáo thực hành gọn và đẹp",
                "Một báo cáo tốt không cần dài. Mình luôn đặt mục tiêu ở đầu bài, trình bày kết quả bằng bảng và hình rồi mới giải thích, cuối cùng là phần nhận xét ngắn gọn. Dùng cùng một font, cùng kiểu đánh số hình và bảng cũng khiến báo cáo trông chuyên nghiệp hơn rất nhiều."],

            // ===== Đời sống sinh viên (1) =====
            [1, "Review ký túc xá khu B: có đáng ở không?",
                "Mình ở khu B được một học kỳ. Ưu điểm là giá rẻ, gần giảng đường, có wifi và khu tự học mở đến 22h. Nhược điểm là phòng 8 người hơi chật, giờ cao điểm thì nhà vệ sinh phải xếp hàng. Nếu bạn ưu tiên tiết kiệm và gần trường thì mình thấy vẫn đáng ở."],
            [1, "Chi tiêu 3 triệu/tháng cho sinh viên có khả thi?",
                "Mình thử quản lý chi tiêu 3 triệu mỗi tháng: ăn uống khoảng 1,8 triệu, đi lại 400 nghìn, học liệu và in ấn 300 nghìn, còn lại là các khoản phát sinh. Mình ghi chép từng khoản vào bảng tính nên biết mình tiêu quá ở đâu. Với sinh viên ở trọ tự nấu ăn thì hoàn toàn khả thi."],
            [1, "Tìm trọ gần trường, giá dưới 2 triệu",
                "Mình sắp nhập học và cần tìm phòng trọ cách trường tối đa 3 km, giá dưới 2 triệu một tháng, ưu tiên khu an ninh tốt, có chỗ để xe. Bạn nào đang ở hoặc biết chỗ còn phòng thì giới thiệu giúp mình, cảm ơn nhiều. Có thể ở ghép cũng được."],
            [1, "Quán cà phê yên tĩnh để học bài quanh trường",
                "Mình đang tìm quán có ổ cắm, wifi ổn, không quá ồn và giá nước dưới 40 nghìn để ngồi học vài tiếng. Bạn nào có địa điểm ruột thì chia sẻ giúp, mình sẽ tổng hợp lại thành danh sách cho mọi người cùng tham khảo."],
            [1, "Cách cân bằng giữa học và đi làm thêm",
                "Mình đi làm thêm 3 buổi mỗi tuần từ năm hai. Bí quyết của mình là xếp ca làm theo lịch học, không nhận ca sát ngày thi và luôn dành ít nhất một ngày nghỉ hoàn toàn. Nếu thấy điểm số giảm thì nên giảm giờ làm ngay, đừng cố chịu đựng."],
            [1, "Mất ví ở căng tin, ai nhặt được giúp mình với",
                "Chiều hôm qua mình để quên ví màu nâu ở căng tin khu A, bên trong có thẻ sinh viên, CCCD và một ít tiền mặt. Mình không cần tiền, chỉ mong lấy lại giấy tờ. Bạn nào nhặt được xin liên hệ mình qua bình luận bên dưới, mình xin cảm ơn và có quà nhỏ."],
            [1, "Rủ nhau đá bóng giao hữu chiều thứ 7",
                "Nhóm mình thiếu vài người cho trận giao hữu 7 người chiều thứ 7 lúc 16h ở sân trường. Không yêu cầu giỏi, chủ yếu là vận động và làm quen bạn mới. Chia tiền sân đều, bạn nào tham gia thì bình luận để mình chốt danh sách."],
            [1, "Làm sao để bớt áp lực khi trượt môn?",
                "Học kỳ này mình trượt một môn và thấy rất nản. Sau khi nói chuyện với bạn bè và thầy cố vấn, mình nhận ra trượt một môn không quyết định tương lai, quan trọng là rút ra nguyên nhân và có kế hoạch học lại. Nếu bạn nào cũng đang như mình thì đừng ngại tìm người chia sẻ."],
            [1, "Kinh nghiệm đi xe buýt tới trường tiết kiệm",
                "Mua vé tháng sinh viên chỉ tốn một khoản nhỏ so với đi xe máy mỗi ngày, chưa kể tiền xăng và gửi xe. Mình dùng ứng dụng chỉ đường để biết giờ xe tới nên không phải chờ lâu. Tranh thủ thời gian trên xe để đọc tài liệu cũng rất tiện."],
            [1, "Có nên tham gia câu lạc bộ ngay năm nhất?",
                "Theo mình là nên, nhưng chỉ chọn một đến hai câu lạc bộ đúng sở thích. Tham gia sớm giúp bạn có nhóm bạn, học kỹ năng mềm và có thêm hoạt động để ghi vào CV. Đừng tham gia quá nhiều kẻo ảnh hưởng đến việc học."],

            // ===== Công nghệ (2) =====
            [2, "Laptop nào phù hợp cho sinh viên IT dưới 20 triệu?",
                "Mình cần laptop để lập trình, chạy máy ảo và đôi khi chơi game nhẹ. Cấu hình mình nhắm tới là RAM tối thiểu 16GB, SSD 512GB và chip thế hệ mới, ưu tiên pin trâu vì hay mang đi học. Các bạn đang dùng máy nào ổn thì gợi ý giúp mình với."],
            [2, "Lộ trình tự học Laravel cho người mới",
                "Mình đề xuất học theo thứ tự: PHP cơ bản, routing và controller, Blade, Eloquent ORM, validation, authentication rồi cuối cùng là policy. Sau mỗi phần nên làm một dự án nhỏ như blog hoặc diễn đàn để nhớ lâu. Tài liệu chính thức của Laravel viết rất dễ đọc, nên bắt đầu từ đó."],
            [2, "Git cơ bản: những lệnh sinh viên nên biết",
                "Chỉ cần nắm chắc git status, add, commit, push, pull, branch và checkout là đủ làm việc nhóm ở mức đồ án. Hãy tạo nhánh riêng cho mỗi tính năng và commit thường xuyên với thông điệp rõ ràng. Khi có xung đột, đừng hoảng, đọc kỹ phần được đánh dấu rồi chọn đúng nội dung cần giữ."],
            [2, "ChatGPT có làm sinh viên lười suy nghĩ không?",
                "Mình thấy công cụ AI rất hữu ích để giải thích khái niệm và gợi ý hướng làm, nhưng nếu chép nguyên câu trả lời mà không hiểu thì sẽ mất khả năng tự giải quyết vấn đề. Cách mình dùng là tự làm trước, sau đó nhờ AI góp ý và so sánh. Các bạn nghĩ sao?"],
            [2, "Hỏi cách fix lỗi 'Class not found' trong Laravel",
                "Mình tạo controller xong gọi trong route thì báo Target class does not exist. Mình đã kiểm tra tên file đúng chữ hoa chữ thường. Bạn nào gặp rồi cho mình hỏi nguyên nhân thường là gì? Mình nghi do thiếu namespace hoặc chưa use ở đầu file route."],
            [2, "So sánh MySQL và PostgreSQL cho đồ án nhỏ",
                "Với đồ án quy mô nhỏ, MySQL dễ cài, nhiều tài liệu và hầu hết hosting đều hỗ trợ. PostgreSQL mạnh hơn ở kiểu dữ liệu, truy vấn phức tạp và chuẩn SQL. Nếu chỉ làm CRUD thông thường thì cái nào cũng đủ, mình chọn cái mà nhóm đã quen."],
            [2, "Nên học Python hay JavaScript trước?",
                "Nếu muốn làm web thì JavaScript gần như bắt buộc, còn Python thân thiện hơn cho người mới và mạnh về dữ liệu, tự động hóa. Mình khuyên bạn chọn theo mục tiêu: muốn làm giao diện thì JavaScript, muốn xử lý dữ liệu hay AI thì Python. Ngôn ngữ nào thì tư duy lập trình vẫn là nền tảng."],
            [2, "Cách bảo mật tài khoản cá nhân đơn giản",
                "Bật xác thực hai lớp cho email và mạng xã hội, dùng trình quản lý mật khẩu thay vì đặt mật khẩu giống nhau ở nhiều nơi, và cẩn thận với các đường dẫn lạ trong tin nhắn. Chỉ ba việc này đã chặn được phần lớn các vụ mất tài khoản mà mình từng gặp."],
            [2, "Chia sẻ bộ phím tắt VS Code giúp code nhanh hơn",
                "Mình hay dùng Ctrl+P để mở file nhanh, Ctrl+Shift+P mở bảng lệnh, Alt+Up/Down để di chuyển dòng, Ctrl+D để chọn các từ giống nhau và Ctrl+/ để comment. Chỉ cần nhớ khoảng 10 phím tắt là tốc độ làm việc tăng đáng kể."],
            [2, "Tự dựng server ảo trên máy cá nhân với Docker",
                "Docker giúp bạn chạy cùng một môi trường ở mọi máy mà không lo lệch phiên bản. Với đồ án web, bạn chỉ cần một file docker-compose gồm PHP, MySQL và Nginx là cả nhóm có thể chạy giống hệt nhau. Mới học thì nên bắt đầu từ một container đơn giản rồi mở rộng dần."],

            // ===== Việc làm & Thực tập (3) =====
            [3, "Viết CV cho sinh viên chưa có kinh nghiệm",
                "Khi chưa có kinh nghiệm đi làm, hãy tập trung vào dự án cá nhân, đồ án môn học, hoạt động câu lạc bộ và các kỹ năng liên quan. CV nên gói gọn trong một trang, mô tả kết quả bằng con số nếu có và tránh liệt kê chung chung. Gửi kèm đường dẫn GitHub hoặc portfolio sẽ gây ấn tượng hơn."],
            [3, "Kinh nghiệm phỏng vấn thực tập vị trí Backend",
                "Buổi phỏng vấn của mình gồm câu hỏi về cơ sở dữ liệu, REST API, một bài code nhỏ và câu chuyện về dự án đã làm. Nhà tuyển dụng quan tâm cách bạn suy nghĩ hơn là đáp án hoàn hảo, nên hãy nói to quá trình giải quyết. Nếu không biết thì nói thật rồi trình bày hướng bạn sẽ tìm hiểu."],
            [3, "Thực tập không lương có nên nhận?",
                "Nếu công ty cho bạn học được thật sự, có người hướng dẫn và dự án rõ ràng thì thực tập không lương vẫn đáng cân nhắc. Ngược lại, nếu bạn chỉ làm việc vặt thì nên từ chối. Hãy hỏi trước về nội dung công việc, người mentor và khả năng được nhận chính thức."],
            [3, "Danh sách công ty tuyển thực tập hè",
                "Mình đang tổng hợp các công ty công nghệ có chương trình thực tập hè cho sinh viên năm 3 và năm 4, kèm thời hạn nộp hồ sơ. Bạn nào biết thêm thông tin thì bổ sung ở bình luận, mình sẽ cập nhật danh sách theo từng tuần để mọi người cùng theo dõi."],
            [3, "Làm freelance khi còn đi học: bắt đầu thế nào?",
                "Mình bắt đầu bằng những dự án nhỏ như làm landing page hay sửa lỗi website cho người quen. Quan trọng là thống nhất phạm vi công việc và thời hạn bằng văn bản ngay từ đầu để tránh phát sinh. Khi đã có vài sản phẩm thì bạn dễ nhận dự án lớn hơn."],
            [3, "Cách xây dựng portfolio cho sinh viên IT",
                "Portfolio nên có 3 đến 5 dự án tốt nhất, mỗi dự án gồm ảnh demo, công nghệ sử dụng, vai trò của bạn và đường dẫn mã nguồn. Viết README thật rõ ràng cũng là điểm cộng lớn. Chất lượng quan trọng hơn số lượng, một dự án hoàn chỉnh tốt hơn mười dự án dang dở."],
            [3, "LinkedIn có thật sự cần thiết cho sinh viên?",
                "Mình thấy khá hữu ích: nhiều nhà tuyển dụng tìm ứng viên qua đây và bạn có thể theo dõi các anh chị trong ngành. Chỉ cần ảnh rõ ràng, phần giới thiệu ngắn gọn, liệt kê dự án và kỹ năng là đã đủ. Không cần cập nhật hằng ngày, thỉnh thoảng chia sẻ thứ mình học được là tốt."],
            [3, "Mức lương thực tập sinh phổ biến hiện nay",
                "Theo những gì mình khảo sát trong nhóm bạn, thực tập sinh công nghệ thường nhận từ 3 đến 7 triệu mỗi tháng, tùy công ty và vị trí. Một số nơi hỗ trợ thêm tiền ăn trưa hoặc thưởng dự án. Bạn nào có số liệu khác thì chia sẻ để mọi người có cái nhìn đầy đủ hơn."],
            [3, "Soft skill nào nhà tuyển dụng quan tâm nhất?",
                "Qua các buổi chia sẻ mình tham dự, những kỹ năng được nhắc nhiều nhất là giao tiếp, làm việc nhóm, quản lý thời gian và tinh thần học hỏi. Kỹ thuật có thể đào tạo thêm, còn thái độ thì khó thay đổi hơn. Hãy luyện tập qua các dự án nhóm và hoạt động câu lạc bộ."],
            [3, "Có nên đi làm thêm part-time ngay từ năm hai?",
                "Nếu công việc liên quan đến ngành học thì rất nên, vì bạn vừa có kinh nghiệm vừa có thu nhập. Còn làm những việc không liên quan thì chỉ nên coi là cách kiếm thêm chi tiêu. Điều quan trọng là bạn vẫn giữ được điểm số và sức khỏe, đừng đánh đổi quá nhiều."],

            // ===== Giải trí (4) =====
            [4, "Gợi ý phim hay để xem cuối tuần",
                "Cuối tuần này mình muốn xem một bộ phim nhẹ nhàng để thư giãn sau tuần thi. Mình thích thể loại tâm lý, hài nhẹ hoặc phim hoạt hình. Các bạn có gợi ý nào không? Mình sẽ tổng hợp những phim được nhắc nhiều nhất rồi cập nhật lại ở bài này."],
            [4, "Anime nào đáng xem mùa này?",
                "Mùa này có khá nhiều bộ mới, mình đã xem thử vài tập đầu và thấy có bộ cốt truyện chắc, có bộ thiên về hình ảnh. Bạn nào đang theo dõi thì cho mình biết bộ nào đáng để dành thời gian, mình ưu tiên thể loại học đường và phiêu lưu."],
            [4, "Playlist nhạc để học bài tập trung",
                "Mình thấy nhạc không lời, lo-fi hoặc nhạc cổ điển nhẹ giúp mình tập trung nhất vì không bị phân tâm bởi lời hát. Bạn nào có playlist yêu thích thì chia sẻ nhé, mình đang chán danh sách hiện tại rồi."],
            [4, "Game mobile nhẹ cho máy yếu",
                "Điện thoại của mình cấu hình thấp, chơi các game đồ họa nặng thì rất giật. Mình đang tìm game dung lượng nhỏ, chơi được lúc rảnh như giải đố, chiến thuật nhẹ hoặc chơi offline. Bạn nào có gợi ý thì giúp mình với."],
            [4, "Review sách: Đắc nhân tâm có còn phù hợp?",
                "Mình đọc cuốn này năm ngoái và thấy nhiều nguyên tắc về giao tiếp vẫn đúng đến bây giờ như lắng nghe, tôn trọng và khen ngợi chân thành. Tuy vậy một số ví dụ hơi cũ, nên đọc với tâm thế chọn lọc. Với sinh viên bắt đầu đi làm thì đây vẫn là cuốn dễ đọc và có ích."],
            [4, "Cùng bàn luận về trận bán kết hôm qua",
                "Trận đấu tối qua thật sự kịch tính, hai đội đều chơi hết mình đến những phút cuối. Mình thấy quyết định thay người ở hiệp hai là bước ngoặt. Các bạn thấy sao? Cùng bàn luận nhưng nhớ giữ văn minh nhé."],
            [4, "Địa điểm đi chơi cuối tuần cho sinh viên",
                "Mình đang cần ý tưởng đi chơi cho nhóm bạn với ngân sách khoảng 150 nghìn mỗi người: công viên, bảo tàng, phố sách hoặc một quán nhỏ có không gian đẹp. Bạn nào có địa điểm vừa rẻ vừa vui thì giới thiệu nhé, mình sẽ đi thử rồi viết review."],
            [4, "Kênh YouTube học tiếng Anh thú vị",
                "Mình học tiếng Anh qua các kênh kể chuyện, podcast và hướng dẫn nấu ăn có phụ đề. Học qua nội dung mình thích giúp mình không thấy chán và nhớ từ lâu hơn. Nếu bạn có kênh yêu thích thì chia sẻ ở bình luận, mình sẽ gom lại thành danh sách."],
            [4, "Chia sẻ bộ sưu tập ảnh phong cảnh tự chụp",
                "Mình mới tập chụp ảnh bằng điện thoại, chủ yếu là cảnh hoàng hôn và đường phố buổi sáng. Mình học được rằng ánh sáng và bố cục quan trọng hơn thiết bị. Bạn nào có kinh nghiệm chỉnh màu hay chụp đêm thì góp ý giúp mình nhé."],
            [4, "Board game cho nhóm bạn 4-6 người",
                "Nhóm mình hay tụ tập cuối tuần và muốn thử board game. Mình quan tâm các trò dễ học, mỗi ván khoảng 30 đến 45 phút và có tính tương tác cao. Bạn nào chơi rồi thì gợi ý vài tựa game hợp với người mới nhé."],
        ];

        // ---------- 4. BÌNH LUẬN THEO CHUYÊN MỤC ----------
        $commentPool = [
            0 => [
                'Cảm ơn bạn, bài viết rất hữu ích!',
                'Mình cũng đang gặp vấn đề này, đã lưu lại để áp dụng.',
                'Bạn có thể chia sẻ thêm tài liệu được không?',
                'Mình thử cách này rồi, kết quả khá tốt đấy.',
                'Theo mình nên kết hợp thêm làm đề cũ nữa sẽ hiệu quả hơn.',
                'Cho mình xin link tham khảo với nhé.',
            ],
            1 => [
                'Mình cũng từng như vậy, bạn cố lên nhé!',
                'Cảm ơn bạn đã chia sẻ, rất thực tế.',
                'Cho mình xin thêm thông tin chi tiết với.',
                'Khu mình ở cũng tương tự, đồng cảm quá.',
                'Mình đăng ký tham gia nhé, nhắn mình qua đây.',
                'Cái này mình áp dụng được ngay, thanks bạn.',
            ],
            2 => [
                'Bài viết rõ ràng, dễ hiểu, cảm ơn bạn.',
                'Mình bổ sung thêm: nên đọc tài liệu chính thức trước.',
                'Bạn thử xóa cache rồi chạy lại xem sao.',
                'Mình cũng dùng cách này và thấy ổn.',
                'Có thể làm rõ hơn phần cấu hình không bạn?',
                'Hay quá, mình sẽ thử trên dự án của mình.',
            ],
            3 => [
                'Cảm ơn bạn, mình đang cần đúng thông tin này.',
                'Mình từng phỏng vấn ở đó, bạn chuẩn bị kỹ phần cơ bản nhé.',
                'Bài viết hữu ích cho người mới như mình.',
                'Có ai biết hạn nộp hồ sơ cụ thể không ạ?',
                'Theo kinh nghiệm của mình thì dự án cá nhân rất quan trọng.',
                'Chúc bạn sớm tìm được chỗ thực tập ưng ý!',
            ],
            4 => [
                'Mình cũng thích cái này, cảm ơn bạn gợi ý.',
                'Đồng ý với bạn, mình cũng thấy vậy.',
                'Bạn có thể gợi ý thêm vài cái nữa không?',
                'Mình sẽ thử cuối tuần này xem sao.',
                'Hay quá, đúng gu của mình luôn!',
                'Chia sẻ thú vị, theo dõi bạn để xem thêm nhé.',
            ],
        ];

        // ---------- 5. GHI DỮ LIỆU ----------
        $totalComments = 0;

        foreach ($posts as $i => [$catIdx, $title, $content]) {
            $postTime = now()->subDays(rand(0, 30))->subMinutes(rand(0, 1400));
            if ($postTime->isFuture()) {
                $postTime = now()->subMinutes(5);
            }

            $postId = DB::table('posts')->insertGetId([
                'user_id'     => $userIds[array_rand($userIds)],
                'category_id' => $categoryIds[$catIdx],
                'title'       => $title,
                'content'     => $content,
                'created_at'  => $postTime->toDateTimeString(),
                'updated_at'  => $postTime->toDateTimeString(),
            ]);

            // Cứ 7 bài lại có 1 bài "nóng" với nhiều bình luận
            $commentCount = ($i % 7 === 0) ? rand(8, 12) : rand(0, 6);
            $rows = [];

            for ($c = 0; $c < $commentCount; $c++) {
                $commentTime = $postTime->copy()->addMinutes(rand(5, 4000));
                if ($commentTime->isFuture()) {
                    $commentTime = now();
                }

                // ~15% bình luận có chỉnh sửa
                $updatedTime = $commentTime;
                if (rand(1, 100) <= 15) {
                    $updatedTime = $commentTime->copy()->addMinutes(rand(1, 300));
                    if ($updatedTime->isFuture()) {
                        $updatedTime = now();
                    }
                }

                $pool = $commentPool[$catIdx];

                $rows[] = [
                    'post_id'    => $postId,
                    'user_id'    => $userIds[array_rand($userIds)],
                    'content'    => $pool[array_rand($pool)],
                    'created_at' => $commentTime->toDateTimeString(),
                    'updated_at' => $updatedTime->toDateTimeString(),
                ];
            }

            if ($rows) {
                DB::table('comments')->insert($rows);
                $totalComments += count($rows);
            }
        }

        $this->command->info('Đã tạo: ' . count($users) . ' người dùng, ' . count($categoryData) . ' chuyên mục, ' . count($posts) . " bài viết, {$totalComments} bình luận.");
        $this->command->info('Đăng nhập admin: admin@test.com / password123 (các tài khoản khác cùng mật khẩu).');
    }
}