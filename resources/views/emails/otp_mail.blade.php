<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Verification Code</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #0f172a;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1e293b;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.3);
            border: 1px solid #334155;
        }
        .header {
            padding: 30px;
            text-align: center;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 24px;
            color: #94a3b8;
            margin: 0 0 24px 0;
        }
        .otp-box {
            display: inline-block;
            background-color: #0f172a;
            color: #38bdf8;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 6px;
            padding: 16px 32px;
            border-radius: 12px;
            margin: 10px 0 24px 0;
            border: 1px solid #0284c7;
            font-family: 'Courier New', Courier, monospace;
        }
        .footer {
            padding: 20px 30px;
            background-color: #0f172a;
            text-align: center;
            border-top: 1px solid #334155;
        }
        .footer p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }
        .warning {
            font-size: 13px !important;
            color: #ef4444 !important;
            margin-top: 16px !important;
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="container" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            <h1>DICE MADLY</h1>
                        </td>
                    </tr>
                    <!-- Body Content -->
                    <tr>
                        <td class="content">
                            <p>Hello,</p>
                            <p>You requested a One-Time Password (OTP) to log in to your account. Use the code below to complete the verification process:</p>
                            
                            <div class="otp-box">{{ $code }}</div>
                            
                            <p>This verification code is valid for <strong>10 minutes</strong>. If you did not request this code, please ignore this email or secure your account.</p>
                            
                            <p class="warning">For security reasons, never share this OTP with anyone.</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p>&copy; {{ date('Y') }} Dice Madly. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
