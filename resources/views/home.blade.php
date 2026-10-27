<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMVN - Bố cục Diễn đàn</title>
    <!-- Tích hợp Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome cho các icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f5f7;
            font-family: Arial, sans-serif;
        }
        
        /* Phần Header */
        .header-bg {
            background-color: #104c82; /* Màu xanh đặc trưng */
        }
        .logo-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .main-nav .nav-link {
            color: #d1e2f3;
            font-size: 0.9rem;
            padding: 10px 15px;
        }
        .main-nav .nav-link:hover {
            color: white;
        }
        .main-nav .nav-link.active {
            background-color: white;
            color: #104c82;
            font-weight: bold;
            border-radius: 2px 2px 0 0;
        }
        
        /* Sub Navigation */
        .sub-nav {
            background-color: white;
            border-bottom: 1px solid #ddd;
            font-size: 0.85rem;
        }
        .sub-nav a {
            color: #104c82;
            text-decoration: none;
            padding: 8px 0;
            display: inline-block;
        }

        /* Thẻ bài viết nổi bật */
        .featured-box {
            background: white;
            border: 1px solid #e2e2e2;
            padding: 15px;
            height: 100%;
        }
        .featured-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Danh sách bài viết */
        .thread-container {
            background: white;
            border: 1px solid #e2e2e2;
            margin-top: 20px;
        }
        .thread-header {
            background-color: #f8f9fa;
            color: #104c82;
            font-size: 1.1rem;
            padding: 12px 15px;
            border-bottom: 1px solid #e2e2e2;
        }
        .thread-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }
        .thread-item:hover {
            background-color: #f8f9fa;
        }
        .thread-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
        }
        .badge-custom {
            font-size: 0.75rem;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: normal;
            border: 1px solid transparent;
            margin-right: 5px;
        }
        .badge-green { background-color: #e5f5e5; color: #28a745; border-color: #c3e6c3; }
        .badge-orange { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        .badge-blue { background-color: #cce5ff; color: #004085; border-color: #b8daff; }
        
        .thread-title {
            color: #104c82;
            text-decoration: none;
            font-size: 0.95rem;
        }
        .thread-title:hover {
            text-decoration: underline;
        }
        .thread-meta {
            font-size: 0.8rem;
            color: #777;
            margin-top: 3px;
        }
        .thread-stats {
            font-size: 0.8rem;
            color: #666;
            text-align: right;
            white-space: nowrap;
        }
        .last-post {
            font-size: 0.8rem;
            text-align: right;
            min-width: 120px;
        }
        .last-post-avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>
</head>
<body>

    <!-- Bắt đầu Header -->
    <header class="header-bg pt-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end">
                <div class="d-flex align-items-end">
                    <a href="#" class="logo-text mb-2 me-4">CỘNG ĐỒNG SINH VIÊN&trade;</a>
                    <ul class="nav main-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-newspaper"></i> Lều báo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-beer-mug-empty"></i> Quán con sò say</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-pen-nib"></i> Trại sáng tác</a>
                        </li>
                    </ul>
                </div>
                <div class="pb-2">
                    <a href="#" class="text-white text-decoration-none" style="font-size: 0.9rem;">
                        <i class="fa-solid fa-lock"></i> Đăng ký
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sub Navigation -->
    <div class="sub-nav mb-3">
        <div class="container">
            <a href="#">Bài viết mới</a>
        </div>
    </div>

    <!-- Nội dung chính -->
    <main class="container mb-5">
        <p class="text-muted mb-3">&copy; XAMVN.COM</p>

        <!-- Phần Slide nổi bật (Tái hiện bằng Grid) -->
        <div class="row g-0 border mb-4">
            <div class="col-md-6 border-end">
                <div class="featured-box d-flex">
                    <img src="https://via.placeholder.com/45" alt="Avatar" class="featured-avatar me-3">
                    <div>
                        <h6 class="mb-1"><a href="#" class="text-danger text-decoration-none">🌸 Lật Bài Ngửa...</a></h6>
                        <div class="text-muted" style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                            https://z.zpi.cx/11/1c09SLf... Trong cái xã hội đầy lừa lọc dối...
                        </div>
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">
                            Trình Ca &middot; Hôm nay, lúc 07:49 &middot; Trả lời: 49
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="featured-box d-flex">
                    <img src="https://via.placeholder.com/45" alt="Avatar" class="featured-avatar me-3">
                    <div>
                        <h6 class="mb-1"><a href="#" class="text-primary text-decoration-none">Địt mây em tập yoga</a></h6>
                        <div class="text-muted" style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                            thằng nào đang địt mấy con này chưa, người nó thế thì địt sướng...
                        </div>
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">
                            nguyenhoangvinhnghiem &middot; Hôm nay, lúc 08:46 &middot; Trả lời: 46
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách bài viết -->
        <div class="thread-container">
            <div class="thread-header">
                Mới ra lò
            </div>
            
            <!-- Item 1 -->
            <div class="thread-item">
                <img src="https://via.placeholder.com/38" class="thread-avatar me-3" alt="User">
                <div class="flex-grow-1">
                    <div>
                        <span class="badge-custom badge-green">Có hình</span>
                        <a href="#" class="thread-title">🥀 la thả hồn trôi điếu thuốc tàn. Lững lờ theo khói phút đi hoang.</a>
                    </div>
                    <div class="thread-meta">
                        Hoanggiap512 &middot; Hôm nay, lúc 17:29 &middot; <a href="#" class="text-muted text-decoration-none">Trò chuyện linh tinh</a>
                    </div>
                </div>
                <div class="thread-stats px-3 border-end">
                    <div class="mb-1">Trả lời: <span class="fw-bold">32</span></div>
                    <div>Lượt xem: <span class="fw-bold">178</span></div>
                </div>
                <div class="last-post ps-3">
                    <div class="mb-1">4 phút trước</div>
                    <div class="text-primary">Hoanggiap512 <img src="https://via.placeholder.com/20" class="last-post-avatar"></div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="thread-item">
                <img src="https://via.placeholder.com/38" class="thread-avatar me-3" alt="User">
                <div class="flex-grow-1">
                    <div>
                        <span class="badge-custom badge-orange">Trực tiếp</span>
                        <a href="#" class="thread-title">Làng trẻ sos đang rất cần sos</a>
                    </div>
                    <div class="thread-meta">
                        Marine Corp Commandant &middot; Hôm nay, lúc 14:26 &middot; <a href="#" class="text-muted text-decoration-none">Trò chuyện linh tinh</a>
                    </div>
                </div>
                <div class="thread-stats px-3 border-end">
                    <div class="mb-1">Trả lời: <span class="fw-bold">8</span></div>
                    <div>Lượt xem: <span class="fw-bold">207</span></div>
                </div>
                <div class="last-post ps-3">
                    <div class="mb-1">5 phút trước</div>
                    <div class="text-primary">Kinh Ngư <img src="https://via.placeholder.com/20" class="last-post-avatar"></div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="thread-item">
                <img src="https://via.placeholder.com/38" class="thread-avatar me-3" alt="User">
                <div class="flex-grow-1">
                    <div>
                        <span class="badge-custom badge-blue">[VnExpress]</span>
                        <a href="#" class="thread-title">Nguyên Phó giám đốc Sở Kế hoạch và Đầu tư TP HCM bị khai trừ Đảng</a>
                    </div>
                    <div class="thread-meta">
                        dungdamchemnhau &middot; 5 phút trước &middot; <a href="#" class="text-muted text-decoration-none">Lều báo nhân dân</a>
                    </div>
                </div>
                <div class="thread-stats px-3 border-end">
                    <div class="mb-1">Trả lời: <span class="fw-bold">0</span></div>
                    <div>Lượt xem: <span class="fw-bold">1</span></div>
                </div>
                <div class="last-post ps-3">
                    <div class="mb-1">5 phút trước</div>
                    <div class="text-primary">dungdamchemnhau <img src="https://via.placeholder.com/20" class="last-post-avatar"></div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="thread-item">
                <img src="https://via.placeholder.com/38" class="thread-avatar me-3" alt="User">
                <div class="flex-grow-1">
                    <div>
                        <a href="#" class="thread-title">🔥 Chính thức tao chán làm bò đỏ rồi, quay về đúng bản chất phản động thôi</a>
                    </div>
                    <div class="thread-meta">
                        bodothanthien &middot; Hôm nay, lúc 10:04 &middot; <a href="#" class="text-muted text-decoration-none">Trò chuyện linh tinh</a>
                    </div>
                </div>
                <div class="thread-stats px-3 border-end">
                    <div class="mb-1">Trả lời: <span class="fw-bold">98</span></div>
                    <div>Lượt xem: <span class="fw-bold">2K</span></div>
                </div>
                <div class="last-post ps-3">
                    <div class="mb-1">5 phút trước</div>
                    <div class="text-primary">vuacuaxam <img src="https://via.placeholder.com/20" class="last-post-avatar"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>