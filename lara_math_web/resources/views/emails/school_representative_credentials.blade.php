<!DOCTYPE html>
<html>
<head>
    <title>School Representative Credentials</title>
</head>
<body>
    <h1>Welcome to our System</h1>
    <p>Dear {{ $repName }},</p>
    <p>You have been registered as the representative for the school: {{ $schoolName }}.</p>
    <p>Your login credentials are as follows:</p>
    <ul>
        <li>Email: {{ $repEmail }}</li>
        <li>Password: {{ $password }}</li>
    </ul>
    <p>Please save this email as these will be your permanent login credentials.</p>
    <p>Thank you!</p>
</body>
</html>
