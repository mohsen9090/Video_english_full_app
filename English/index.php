<?php session_start(); ini_set('display_errors', 
0); error_reporting(0); require_once 
'vendor/autoload.php'; $dotenv = 
Dotenv\Dotenv::createImmutable(__DIR__); 
$dotenv->load(); if 
(!isset($_SESSION['user_id'])) {
    header("Location:login.php"); exit();
}
try { $conn = new mysqli($_ENV['DB_HOST'], 
    $_ENV['DB_USER'], $_ENV['DB_PASS'], 
    $_ENV['DB_NAME']); if ($conn->connect_error) 
    {
        throw new Exception("خطا در اتصال به 
        دیتابیس");
    }
    $conn->set_charset("utf8mb4"); $user_id = 
    $_SESSION['user_uid'] ?? 'all'; $username = 
    $_SESSION['user_name'] ?? null; $lessons = 
    range(1, 12); $locked_lessons = array_fill(1, 
    12, true); if (!empty($user_id) && $user_id 
    != 'all') {
        $stmt = $conn->prepare("SELECT 
        lesson_id,is_locked FROM lesson_locks 
        WHERE user_id=?"); $stmt->bind_param("s", 
        $user_id); $stmt->execute(); $result = 
        $stmt->get_result(); while ($row = 
        $result->fetch_assoc()) {
            $lesson_id = $row['lesson_id']; if 
            (isset($locked_lessons[$lesson_id])) 
            {
                $locked_lessons[$lesson_id] = 
                $row['is_locked'] == 1;
            }
        }
    }
    foreach ($lessons as $lesson) { if ($lesson 
        <= 5) {
            $locked_lessons[$lesson] = false;
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage()); die("خطا در 
    اتصال به دیتابیس");
}
// ویدیوهای دوره
$course_video_1 = 
'https://gold24.io/English/c3e4c3145f8a1374bb5511328d8dd7d9.MP4'; 
$course_video_2 = 
'https://gold24.io/English/99d975b681b3580821ffe35b3c84c34c.MP4'; 
$course_video_3 = 
'https://gold24.io/English/e7942b24f73989fd6e94ed66f13a5245.MP4'; 
$course_video_4 = 
'https://gold24.io/English/b78f5bdc712232920a030900a6fc65e2.MP4'; 
$course_video_5 = 
'https://gold24.io/English/cb509dd51fb54ae76a5eba0c22eceab4.MP4'; 
$course_video_6 = 
'https://gold24.io/English/386d485b6d91d435dad096967bd50b50.MP4'; 
$course_video_7 = 
'https://gold24.io/English/49e718c4cd215b584bed8e012006924c.MP4'; 
$course_video_8 = 
'https://gold24.io/English/5b7e503f907c2a099dfda791f3267182.MP4'; 
$course_video_9 = 
'https://gold24.io/English/4fdeb4bdf50a5e94a8e97a01b4ec172a.MP4'; 
$course_video_10 = 
'https://gold24.io/English/21176fb17cb0029baf3930187eed0b4b.MP4'; 
$course_video_11 = 
'https://gold24.io/English/8e9bf54acbf767eb63e736d1dd91681f.MP4'; 
$course_video_12 = 
'https://gold24.io/English/1e15e59f08db4a9e97e9a0a45f7830f1.MP4'; 
?> <!DOCTYPE html> <html lang="fa" dir="rtl"> 
<head>
    <meta charset="UTF-8"> <meta name="viewport" 
    content="width=device-width, 
    initial-scale=1.0"> <title>آموزش زبان انگلیسی 
    | English.Online24</title>
    <meta name="description" content="یادگیری 
    زبان انگلیسی با جدیدترین روش‌ها! دسترسی به 
    دوره‌های مکالمه، گرامر و آزمون‌های بین‌المللی + 
    پشتیبانی ۲۴/۷"> <meta name="keywords" 
    content="آموزش زبان انگلیسی, دوره‌های زبان, 
    خرید دوره, کریپتو, فروشگاه آنلاین"> <link 
    rel="canonical" 
    href="https://www.english.online24"> <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet"> <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> 
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> 
    <link 
    href="https://unpkg.com/aos@2.3.1/dist/aos.css" 
    rel="stylesheet"> <link rel="stylesheet" 
    href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/> 
    <style>
        @font-face { font-family: 'IRANSans'; 
            src: url('fonts/IRANSansWeb.woff2') 
            format('woff2');
        }
        body { background: #1C1C1C; /* پس‌زمینه 
            سیاه */ font-family: 'IRANSans', 
            sans-serif; color: #FFF; margin: 0; 
            padding: 20px;
        }
        .header { background: linear-gradient(to 
            right, #8B0000, #A52A2A); /* هدر 
            گرادینت قرمز تیره */ padding: 15px; 
            border-radius: 12px; text-align: 
            center; color: white;
        }
        .container { display: flex; gap: 20px; 
            padding: 20px;
        }
        .dashboard { width: 250px; background: 
            #2B1B17; /* رنگ تیره برای پنل کاربری 
            */ padding: 20px; border-radius: 
            12px; height: fit-content; position: 
            relative; overflow: hidden;
        }
        .dashboard h3 { color: #FFD700; margin: 0 
            0 15px 0;
        }
        .user-info { margin-bottom: 20px; 
            padding: 10px; background: 
            rgba(139,0,0,0.1); border-radius: 
            8px; animation: fadeIn 1s;
        }
        .dashboard-buttons { display: flex; 
            flex-direction: column; gap: 10px;
        }
        .dashboard-button { background: #C27C00; 
            /* رنگ طلایی گرم‌تر */ color: #FFF; 
            padding: 10px; border-radius: 8px; 
            text-decoration: none; text-align: 
            center; transition: 0.3s; animation: 
            fadeInUp 1s;
        }
        .dashboard-button:hover { background: 
            #FFB81C; /* رنگ طلایی روشن‌تر هنگام 
            هاور */
        }
        .course-container { flex: 1; position: 
            relative; overflow: hidden;
        }
        .course-grid { display: grid; 
            grid-template-columns: 
            repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; animation: fadeIn 1s;
        }
        .course-card { background: #2B1B17; /* 
            پس‌زمینه تیره برای کارت دوره */ 
            border: 2px solid #FFD700; /* حاشیه 
            طلایی */ border-radius: 12px; 
            padding: 20px; text-align: center; 
            position: relative; overflow: hidden; 
            transition: transform 0.3s; 
            box-shadow: 2px 2px 10px rgba(255, 
            255, 255, 0.1);
        }
        .course-card:hover { transform: 
            translateY(-5px);
        }
        .course-card h2 { font-size: 24px; 
            text-transform: uppercase; color: 
            #FFD700;
        }
        .course-card .course-description { 
            font-size: 14px; color: #ccc; 
            margin-top: 10px;
        }
        .progress-bar { width: 100%; height: 
            10px; background-color: #8B0000; /* 
            رنگ زمینه */ border-radius: 5px; 
            margin-top: 10px; position: relative; 
            overflow: hidden;
        }
        .progress-bar .progress { height: 100%; 
            background-color: #FFD700; /* رنگ 
            طلایی */ border-radius: 5px; width: 
            0%; transition: width 0.5s 
            ease-in-out;
        }
        .course-card .reviews { margin-top: 20px;
        }
                .course-card .reviews .rating { 
            color: #FFD700; font-size: 18px;
        }
        .course-card .reviews .review-text { 
            font-size: 14px; color: #ccc; 
            margin-top: 5px;
        }
        .course-card .media-container { 
            margin-top: 20px;
        }
        .course-card .media-container video { 
            width: 100%; border-radius: 8px;
        }
        .course-card .media-container img { 
            width: 100%; border-radius: 8px;
        }
        .course-card .share-button { display: 
            inline-block; background-color: 
            #8B0000;
            color: #FFF; padding: 5px 10px; 
            border-radius: 5px; text-decoration: 
            none; margin-top: 10px; transition: 
            background-color 0.3s;
        }
        .course-card .share-button:hover { 
            background-color: #A52A2A;
        }
        .vip-course { background-color: #FFD700; 
            color: #2B1B17; padding: 5px 10px; 
            border-radius: 5px; font-size: 12px; 
            margin-left: 10px;
        }
        .private-course { background-color: 
            #8B0000;
            color: #FFF; padding: 5px 10px; 
            border-radius: 5px; font-size: 12px; 
            margin-right: 10px;
        }
        .button { background: #C27C00; /* رنگ 
            طلایی گرم */ color: #333; padding: 
            10px 20px; border-radius: 8px; 
            text-decoration: none; display: 
            inline-block; margin: 10px; 
            transition: 0.3s;
        }
        .button:hover { background: #FFB81C; /* 
            رنگ طلایی روشن‌تر هنگام هاور */ 
            transform: translateY(-2px);
        }
        @media (max-width: 768px) { .container { 
                flex-direction: column;
            }
            .dashboard { width: auto;
            }
        }
    </style> </head> <body> <div class="header 
    wow fadeInDown" data-wow-duration="1s">
        <h1>English.Online24 | پلتفرم تخصصی آموزش 
        زبان انگلیسی</h1> <h2 
        class="typed-text"></h2>
    </div> <div class="container"> <div 
        class="dashboard wow fadeInLeft" 
        data-wow-duration="1s" 
        data-wow-delay="0.5s">
            <h3>پنل کاربری</h3> <?php 
            if(!empty($user_id) && $user_id != 
            'all'): ?> <div class="user-info">
                <p><strong>نام 
                کاربری:</strong><?=htmlspecialchars($username??"")?></p> 
                <p><strong>کد 
                کاربری:</strong><?=htmlspecialchars($user_id??"")?></p>
            </div> <?php endif; ?> <div 
            class="dashboard-buttons">
                <a href="profile.php" 
                class="dashboard-button">پروفایل</a> 
                <a href="settings.php" 
                class="dashboard-button">تنظیمات</a> 
                <a href="logout.php" 
                class="dashboard-button">خروج</a>
            </div> </div> <div 
        class="course-container">
            <div class="course-grid"> <?php 
                foreach($lessons as $lesson): ?> 
                <div class="course-card wow 
                fadeInUp" data-wow-duration="1s" 
                data-wow-delay="<?=$loop->index*0.2?>s">
                    <h2> <?php 
                        if($lesson>=6&&$lesson<=12):?><span 
                        class="private-course">ویژه/خصوصی</span><?php 
                        endif;?> درس <?=$lesson?> 
                        <?php 
                        if($lesson>=6&&$lesson<=12):?><span 
                        class="vip-course">VIP</span><?php 
                        endif;?> 
                        <?=$locked_lessons[$lesson]?' 
                        🔒 ':''?>
                    </h2> <p 
                    class="course-description">توضیحات 
                    مختصر درباره محتوای این 
                    درس</p> <div 
                    class="progress-bar">
                        <div 
                        class="progress"></div>
                    </div> <div class="reviews"> 
                        <div class="rating">
                            <i class="fas 
                            fa-star"></i><i 
                            class="fas 
                            fa-star"></i><i 
                            class="fas 
                            fa-star"></i><i 
                            class="fas 
                            fa-star"></i><i 
                            class="fas 
                            fa-star"></i>
                        </div> <p 
                        class="review-text">نظر 
                        کاربران در مورد این 
                        درس</p>
                    </div> <div 
                    class="media-container">
                        <?php if($lesson == 1): 
                        ?> <video controls>
                            <source 
                            src="<?=$course_video_1?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 2): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_2?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 3): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_3?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 4): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_4?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 5): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_5?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 6): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_6?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 7): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_7?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 8): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_8?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 9): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_9?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 10): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_10?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 11): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_11?>" 
                            type="video/mp4">
                        </video> <?php 
                        elseif($lesson == 12): ?> 
                        <video controls>
                            <source 
                            src="<?=$course_video_12?>" 
                            type="video/mp4">
                        </video> <?php else: ?> 
                        <img 
                        src="path/to/your/placeholder/image.jpg" 
                        alt="Course image"> <?php 
                        endif; ?>
                    </div> <a href="#" 
                    class="share-button"><i 
                    class="fas 
                    fa-share-alt"></i>اشتراک‌گذاری</a> 
                    <?php 
                    if($locked_lessons[$lesson]): 
                    ?>
                        <?php 
                        if($lesson>=6&&$lesson<=12): 
                        ?>
                            <a 
                            href="purchase.php?lesson=<?=$lesson?>" 
                            class="button">خرید 
                            دوره</a>
                        <?php endif; ?> <?php 
                    else: ?>
                        <a 
                        href="lesson<?=$lesson?>.html" 
                        class="button">شروع 
                        یادگیری</a>
                    <?php endif; ?> </div> <?php 
                endforeach; ?>
            </div> </div> </div> <footer 
    style="text-align:center;margin-top:20px;">
        <div class="contact" style="margin:20px 
        0;font-size:1.1em;">پشتیبانی تلگرام:<a 
        href="https://t.me/rosegold181" 
        style="color:#0088cc;text-decoration:none">@rosegold181</a></div> 
        <p>©<?=date('Y')?> English.Online24</p>
    </footer> <script> new WOW().init(); var 
        typed = new Typed('.typed-text', {
            strings: ["یادگیری تضمینی با متد 
            نوین"], typeSpeed: 100, loop: true, 
            backSpeed: 50
        });
    </script> <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body> </html>
