<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our System</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">

    <div style="max-width: 600px; background: #ffffff; margin: auto; border-radius: 8px; padding: 20px; border: 1px solid #ddd;">

        <h2 style="color: #333;">Welcome, {{ $name }}!</h2>

        <p style="color: #555; font-size: 14px;">
            We’re excited to let you know that your account has been successfully created.
        </p>

        <div style="background: #f4f4f4; padding: 15px; border-radius: 5px; margin: 15px 0;">
            <p style="margin: 0; font-size: 14px;">
                <strong>Email:</strong> {{ $email }}<br>
                <strong>Password:</strong> {{ $password }}
            </p>
        </div>

        <p style="color: #555; font-size: 14px;">
            You can log in to your account anytime using the credentials above.
            For security, we recommend changing your password after your first login.
        </p>

        <p style="color: #777; font-size: 12px;">
            If you have any questions or need help, feel free to contact our support team.
        </p>

        <p style="color: #333; font-size: 14px; margin-top: 20px;">
            Best regards,<br>
            <strong>Taskify</strong>
        </p>
    </div>

</body>
</html>

