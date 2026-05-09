@<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صيانة الموقع</title>
    <meta name="description" content="صفحة صيانة الموقع. الموقع تحت الصيانة حالياً ولا يمكن التسجيل أو الاستخدام.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
        }
        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 2rem 3rem;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        p {
            font-size: 1.2rem;
            line-height: 1.5;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); opacity: 0.9; }
        }
        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #25D366;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }
        .whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }
        .whatsapp-text {
            margin-top: 1rem;
            font-size: 1rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="glass">
        <div class="icon">⚙️</div>
        <h1>الموقع تحت الصيانة</h1>
        <p>نحن نقوم بأعمال صيانة حيوية لتحسين تجربة الاستخدام. يرجى العودة لاحقاً.</p>
        <div class="whatsapp-text">للتواصل واتساب</div>
        <a href="https://wa.me/201070191977" class="whatsapp-btn">
            <span>01070191977</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12.012 2c-5.508 0-9.987 4.479-9.987 9.987 0 1.763.462 3.421 1.262 4.853l-1.287 4.712 4.818-1.263c1.4.758 2.991 1.186 4.694 1.186 5.508 0 9.987-4.479 9.987-9.987 0-5.508-4.479-9.987-9.987-9.987zm.012 17.535c-1.547 0-2.991-.413-4.24-1.127l-.304-.171-2.553.67.681-2.489-.187-.297c-.779-1.241-1.211-2.709-1.211-4.28 0-4.414 3.59-8.004 8.004-8.004s8.004 3.59 8.004 8.004-3.59 8.004-8.004 8.004zm4.417-6.012c-.242-.121-1.434-.708-1.657-.79-.223-.081-.385-.121-.547.121-.162.242-.627.79-.769.951-.142.162-.283.182-.525.061-.242-.121-1.019-.375-1.942-1.196-.718-.641-1.202-1.433-1.343-1.675-.142-.242-.015-.373.106-.493.109-.108.242-.283.364-.425.121-.142.162-.242.242-.404.081-.162.041-.304-.02-.425-.061-.121-.547-1.317-.749-1.802-.197-.474-.399-.41-.547-.418l-.466-.008c-.162 0-.425.061-.647.304-.223.242-.85.83-.85 2.025s.87 2.348.992 2.51c.121.162 1.712 2.614 4.147 3.663.579.25 1.031.399 1.383.511.581.185 1.11.158 1.528.096.466-.07 1.434-.587 1.637-1.154.202-.567.202-1.053.142-1.154-.061-.101-.223-.162-.465-.283z"/></svg>
        </a>
    </div>
</body>
</html>
@end
