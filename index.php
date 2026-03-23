<?php
// Определение мобильного устройства
function isMobile() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $mobileAgents = [
        'Android', 'webOS', 'iPhone', 'iPad', 'iPod', 'BlackBerry',
        'Windows Phone', 'Opera Mini', 'IEMobile', 'Mobile'
    ];
    
    foreach ($mobileAgents as $agent) {
        if (stripos($userAgent, $agent) !== false) {
            return true;
        }
    }
    return false;
}

$pageTitle = "тест игры";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden; 
        }
        
        body {
            background: linear-gradient(90deg,rgba(0, 183, 255, 1) 0%, rgba(255, 255, 255, 1) 50%, rgba(4, 0, 255, 1) 100%);;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .game-wrapper {
            background: #000;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            position: relative;
        }
        
        .game-frame {
            display: block;
            border: none;
            background: #000;
        }
        
        .mobile-block {
            max-width: 500px;
            text-align: center;
            padding: 40px;
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        
        .mobile-block h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .mobile-block p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .download-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .download-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .download-btn.android {
            background: #3DDC84;
        }
        
        .download-btn.ios {
            background: #000;
        }
        
        @media (max-width: 768px) {
            .mobile-block {
                margin: 20px;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <?php if (isMobile()): ?>
        <div class="mobile-block">
            <h2>Игра доступна только на компьютере</h2>
            <p>К сожалению, данная игра оптимизирована для игры на компьютере с клавиатурой и мышью</p>
        </div>
    <?php else: ?>
        <div class="game-wrapper" id="gameWrapper">
            <iframe 
                src="game.html" 
                class="game-frame" 
                id="gameFrame"
                frameborder="0"
                allow="autoplay; fullscreen"
                allowfullscreen>
            </iframe>
        </div>
    <?php endif; ?>

    <script>
    (function() {
        'use strict';
        
        const ORIGINAL_WIDTH = 1925;
        const ORIGINAL_HEIGHT = 1080;
        const ASPECT_RATIO = ORIGINAL_WIDTH / ORIGINAL_HEIGHT;
        
        const gameWrapper = document.getElementById('gameWrapper');
        const gameFrame = document.getElementById('gameFrame');
        
        function calculateGameSize() {
            if (!gameWrapper || !gameFrame) return;
            
            // Получаем размеры окна
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            let gameWidth, gameHeight;
            
            // Рассчитываем размеры, сохраняя пропорции
            if (windowWidth / windowHeight > ASPECT_RATIO) {
                // Окно шире, чем нужно - ограничиваем по высоте
                gameHeight = windowHeight;
                gameWidth = gameHeight * ASPECT_RATIO;
            } else {
                // Окно уже, чем нужно - ограничиваем по ширине
                gameWidth = windowWidth;
                gameHeight = gameWidth / ASPECT_RATIO;
            }
            
            // Округляем до целых чисел
            gameWidth = Math.round(gameWidth);
            gameHeight = Math.round(gameHeight);
            
            // Применяем размеры
            gameWrapper.style.width = gameWidth + 'px';
            gameWrapper.style.height = gameHeight + 'px';
            gameFrame.style.width = gameWidth + 'px';
            gameFrame.style.height = gameHeight + 'px';
        }
        
        // Вызываем при загрузке
        window.addEventListener('load', calculateGameSize);
        
        // Вызываем при изменении размера окна
        window.addEventListener('resize', calculateGameSize);
        
        // Вызываем при повороте экрана на мобильных
        window.addEventListener('orientationchange', calculateGameSize);
        
    })();
    </script>
</body>
</html>
