<!DOCTYPE html>
<html>
<head>
    <title>Welcome Aboard!</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Hello {{ $name }},</h2>

    <p>Welcome to the Safe Nest Insurance Underwriter Team! 🎉</p>

    <p>We're thrilled to have you on board as an Underwriter.</p>

    <p><strong>Your login credentials:</strong></p>
    <ul>
        <li><strong>Email:</strong> (the one you signed up with)</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>Be sure to log in and change your password right away for security reasons.</p>

    <p>If you have any questions or need help, feel free to reach out.</p>

    <p>Cheers,<br>The Admin Team</p>
</body>
</html>
