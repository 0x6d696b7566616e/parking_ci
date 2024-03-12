<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
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
    <h1>Email Verification</h1>
    <p>Please, click this link to verify your email address</p>
    <a href="<?= base_url('verify-email/'.$token) ?>">Verify Email</a>
</body>
</html>