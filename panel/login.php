<?php
session_start();

// Eğer kullanıcı zaten giriş yapmışsa, panelin ana sayfasına yönlendir.
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // DÜZELTME: Yönlendirme adresi panelin ana sayfası olarak güncellendi.
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tek ve sabit kullanıcı bilgileri (Gelecekte veritabanından çekilmeli)
    $username = 'admin';
    $password = 'password'; 

    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] === $username && $_POST['password'] === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        // DÜZELTME: Yönlendirme adresi panelin ana sayfası olarak güncellendi.
        header('Location: index.php');
        exit;
    } else {
        $error = 'Geçersiz kullanıcı adı veya şifre!';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli - Giriş</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        // Horizon Temasından esinlenilen Tailwind CSS yapılandırması
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        'brand-navy': '#1B2559',
                        'brand-blue': '#2B3674',
                        'brand-light-blue': '#F4F7FE',
                        'brand-purple': '#4318FF',
                        'brand-gray': '#A3AED0',
                        'brand-secondary-gray': '#707EAE',
                        'brand-danger': '#EF4444',
                        'brand-success': '#01B574',
                        'brand-paper': '#FFFFFF',
                    },
                    boxShadow: {
                        'custom': '0px 18px 40px 0px #7090B01F',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F4F7FE; /* brand-light-blue */
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="#" class="text-4xl font-bold text-brand-purple mb-10">Horizon</a>
            <p class="text-brand-secondary-gray mt-2">Yönetim paneline erişmek için giriş yapın.</p>
        </div>

        <div class="bg-brand-paper rounded-2xl shadow-custom p-8">
            <form method="post" action="login.php" class="space-y-6">
                
                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-brand-danger px-4 py-3 rounded-xl relative text-sm" role="alert">
                        <p><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>

                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-2" for="username">
                        Kullanıcı Adı
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-user text-brand-gray"></i>
                        </span>
                        <input class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition" id="username" name="username" type="text" placeholder="admin" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-2" for="password">
                        Şifre
                    </label>
                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-lock text-brand-gray"></i>
                        </span>
                        <input class="block w-full bg-brand-light-blue border-gray-200 rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition" id="password" name="password" type="password" placeholder="••••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                     <a href="#" class="text-sm font-medium text-brand-purple hover:underline">Şifremi Unuttum</a>
                </div>

                <div>
                    <button class="w-full flex justify-center items-center gap-2 bg-brand-purple hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-xl focus:outline-none focus:shadow-outline transition-all duration-200" type="submit">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Güvenli Giriş</span>
                    </button>
                </div>
            </form>
        </div>
        <p class="text-center text-brand-gray text-sm mt-8">
            &copy; <?php echo date("Y"); ?> CmsTuran. Tüm hakları saklıdır.
        </p>
    </div>
</body>
</html>
