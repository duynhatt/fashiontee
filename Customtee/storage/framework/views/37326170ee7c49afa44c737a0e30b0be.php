<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu FashionTee</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; color: #333333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f6f8; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 560px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;" cellspacing="0" cellpadding="0" border="0">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;">
                                FASHION<span style="color: #10b981;">TEE</span>
                            </h1>
                            <p style="margin: 6px 0 0 0; color: #94a3b8; font-size: 13px; letter-spacing: 0.5px;">
                                Thương hiệu Thời trang & Thiết kế
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 35px 40px 30px 40px;">
                            <h2 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 700; color: #0f172a;">
                                Xin chào <?php echo e($name ?? 'bạn'); ?>,
                            </h2>
                            <p style="margin: 0 0 16px 0; font-size: 15px; line-height: 1.6; color: #475569;">
                                Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản <strong>FashionTee</strong> của bạn. Vui lòng sử dụng mã xác nhận gồm 6 chữ số dưới đây:
                            </p>

                            <!-- OTP Box -->
                            <div style="background-color: #f8fafc; border: 2px dashed #0284c7; border-radius: 10px; padding: 20px; text-align: center; margin: 25px 0;">
                                <div style="font-size: 13px; font-weight: 600; color: #0284c7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">
                                    Mã đặt lại mật khẩu
                                </div>
                                <div style="font-family: 'Courier New', Courier, monospace; font-size: 36px; font-weight: 800; letter-spacing: 10px; color: #0f172a;">
                                    <?php echo e($code); ?>

                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 8px;">
                                    ⏱ Mã có hiệu lực trong vòng <strong><?php echo e($expire ?? 10); ?> phút</strong>
                                </div>
                            </div>

                            <!-- Security Notes -->
                            <p style="margin: 0 0 12px 0; font-size: 14px; line-height: 1.6; color: #64748b;">
                                🔒 <strong>Lưu ý bảo mật:</strong> Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này. Mật khẩu của bạn vẫn được giữ nguyên an toàn.
                            </p>

                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 25px 0 20px 0;">

                            <p style="margin: 0; font-size: 14px; color: #334155; line-height: 1.5;">
                                Trân trọng,<br>
                                <strong style="color: #0f172a;">Đội ngũ FashionTee</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #94a3b8; line-height: 1.5;">
                                Email này được gửi tự động từ hệ thống FashionTee.<br>
                                © <?php echo e(date('Y')); ?> FashionTee. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH D:\e7\laragon\www\DATN\DATN-CustomTee\Customtee\resources\views/emails/reset-password.blade.php ENDPATH**/ ?>