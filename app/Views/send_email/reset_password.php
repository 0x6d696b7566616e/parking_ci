<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {
            color: #555;
            text-align: center;
            margin-top: 30px;
        }

        a {
            background-color: #00a8ff;
            color: white !important;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin: auto;
            width: fit-content;
            display: block;
        }

        a:hover {
            background-color: #007eff;
        }

        p {
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Reset Password</h1>
    <p><strong>You can ignore this message, if you not request to reset password.</strong></p>
    <p>Please, click this link to reset your password</p>
    <a href="<?= base_url('reset-password/'.$token) ?>">Reset Password</a>
</body>
</html>