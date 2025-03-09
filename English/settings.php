<?php session_start(); error_reporting(E_ALL); 
ini_set('display_errors', 1); if 
(!isset($_SESSION['user_uid'])) {
    header("Location: login.php"); exit;
}
$servername = "localhost"; $username = 
"gold24_user"; $password = "random_password"; 
$dbname = "gold24_db"; $conn = new 
mysqli($servername, $username, $password, 
$dbname); if ($conn->connect_error) {
    die("Connection failed: " . 
    $conn->connect_error);
}
$conn->set_charset("utf8mb4"); $user_uid = 
$_SESSION['user_uid']; $message = ''; 
$message_type = ''; if 
($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = 
    trim($_POST['current_password']); 
    $new_password = trim($_POST['new_password']); 
    $confirm_password = 
    trim($_POST['confirm_password']); if 
    ($new_password !== $confirm_password) {
        $_SESSION['message'] = 'رمزهای عبور جدید 
        با یکدیگر مطابقت ندارند'; 
        $_SESSION['message_type'] = 'error'; 
        header("Location: " . 
        $_SERVER['PHP_SELF']); exit();
    }
    $stmt = $conn->prepare("SELECT password FROM 
    users WHERE user_uid = ?"); 
    $stmt->bind_param("s", $user_uid); 
    $stmt->execute(); $result = 
    $stmt->get_result(); if ($result->num_rows > 
    0) {
        $hashed_password = 
        $result->fetch_assoc()['password']; if 
        (password_verify($current_password, 
        $hashed_password)) {
            $new_hashed_password = 
            password_hash($new_password, 
            PASSWORD_DEFAULT); $update_stmt = 
            $conn->prepare("UPDATE users SET 
            password = ? WHERE user_uid = ?"); 
            $update_stmt->bind_param("ss", 
            $new_hashed_password, $user_uid);
            
            if ($update_stmt->execute()) { 
                $_SESSION['message'] = 'رمز عبور 
                با موفقیت تغییر کرد'; 
                $_SESSION['message_type'] = 
                'success';
            } else {
                $_SESSION['message'] = 'خطا در 
                بروزرسانی رمز عبور'; 
                $_SESSION['message_type'] = 
                'error';
            }
            $update_stmt->close();
        } else {
            $_SESSION['message'] = 'رمز عبور فعلی 
            اشتباه است'; 
            $_SESSION['message_type'] = 'error';
        }
    }
    $stmt->close(); header("Location: " . 
    $_SERVER['PHP_SELF']); exit();
}
if (isset($_SESSION['message'])) { $message = 
    $_SESSION['message']; $message_type = 
    $_SESSION['message_type']; 
    unset($_SESSION['message']); 
    unset($_SESSION['message_type']);
}
$conn->close(); ?> <!DOCTYPE html> <html 
lang="fa" dir="rtl"> <head>
    <meta charset="UTF-8"> <meta name="viewport" 
    content="width=device-width, 
    initial-scale=1.0"> <title>تغییر رمز 
    عبور</title> <style>
        :root {
            --primary-color: #D4AF37; /* طلایی 
            گرم */ --hover-color: #FFA500; /* 
            نارنجی */ --background-color: 
            #2B1B17; /* قهوه‌ای تیره */
            --input-bg: #2B1B17; /* پس‌زمینه 
            فیلدهای ورودی */ --border-color: 
            #D4AF37; /* طلایی گرم */
            --text-color: #D4AF37; /* متن طلایی 
            */
        }
.notification { padding: 15px; margin: 20px 0; 
        border: 1px solid; border-radius: 4px; 
        font-family: 'Segoe UI', Tahoma, Geneva, 
        Verdana, sans-serif;
    }
    .notification.success { color: #155724; 
        background-color: #d4edda; border-color: 
        #c3e6cb;
    }
    .notification.error { color: #721c24; 
        background-color: #f8d7da; border-color: 
        #f5c6cb;
    }
    .profile-container { max-width: 500px; 
        margin: 50px auto; padding: 30px; 
        background-color: 
        var(--background-color); border-radius: 
        8px; box-shadow: 0 2px 15px rgba(0, 0, 0, 
        0.1);
    }
    .form-group { margin-bottom: 20px;
    }
    .form-group label { display: block; 
        margin-bottom: 8px; color: 
        var(--text-color); font-weight: 600;
    }
    .form-group input { width: 100%; padding: 
        10px; border: 1px solid 
        var(--border-color); border-radius: 4px; 
        background-color: var(--input-bg); color: 
        var(--text-color); font-size: 16px;
    }
    .button-container { display: flex; gap: 15px; 
        margin-top: 25px;
    }
    .btn { padding: 12px 25px; border: none; 
        border-radius: 4px; cursor: pointer; 
        font-size: 16px; transition: opacity 
        0.3s;
    }
    .save-btn { background-color: 
        var(--primary-color); color: black;
    }
    .back-btn { background-color: 
        var(--hover-color); color: black;
    }
    .btn:hover { opacity: 0.85;
    }
</style> </head> <body> <div 
    class="profile-container">
        <h2>تغییر رمز عبور</h2> <?php if 
(!empty($message)): ?>
        <div class="notification <?php echo 
        $message_type; ?>">
            <?php echo $message; ?> </div> <?php 
    endif; ?> <form method="POST" action="">
        <div class="form-group"> <label 
            for="current-password">رمز عبور 
            فعلی:</label> <input type="password" 
            id="current-password" 
            name="current_password" required>
        </div> <div class="form-group"> <label 
            for="new-password">رمز عبور 
            جدید:</label> <input type="password" 
            id="new-password" name="new_password" 
            required>
        </div> <div class="form-group"> <label 
            for="confirm-password">تکرار رمز عبور 
            جدید:</label> <input type="password" 
            id="confirm-password" 
            name="confirm_password" required>
        </div> <div class="button-container"> 
            <button type="submit" class="btn 
            save-btn">ذخیره تغییرات</button> <a 
            href="/English/index.php" class="btn 
            back-btn">بازگشت به خانه</a>
        </div> </form> </div> </body>
</html>
