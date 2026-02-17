<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كود التحقق</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .code {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            background-color: #f0f0f0;
            padding: 20px 30px;
            border-radius: 8px;
            letter-spacing: 8px;
            display: inline-block;
            margin: 20px 0;
        }

        .message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin: 20px 0;
        }

        .footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>كود تفعيل الحساب</h1>
        </div>
        <div class="content">
            <p class="message">مرحباً،</p>
            <p class="message">تم طلب كود تفعيل الحساب. استخدم الكود التالي لتفعيل حسابك:</p>

            <div class="code">{{ $code }}</div>

            <div class="warning">
                ⏰ هذا الكود صالح لمدة <strong>10 دقائق</strong> فقط
            </div>

            <p class="message" style="margin-top: 30px;">
                إذا لم تطلب هذا الكود، يرجى تجاهل هذه الرسالة.
            </p>
        </div>
        <div class="footer">
            <p>{{ config('app.name') }}</p>
            <p>هذه رسالة تلقائية، يرجى عدم الرد عليها</p>
        </div>
    </div>
</body>

</html>