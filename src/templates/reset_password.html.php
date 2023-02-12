<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .error {
            color: #c00;
        }

        .success {
            color: #090
        }
    </style>
</head>
<body>
<?php if (isset($message)): ?>
    <p class="success"><?= $message ?></p>
<?php endif ?>
<?php foreach ($errors ?? [] as $error) : ?>
    <p class="error"><?= $error ?></p>
<?php endforeach ?>
<form method="post">
    <ul>
        <li>
            <label for="email_address">Adres Email</label>
            <input type="email" name="email" id="email_address" value="<?= $form['email'] ?? "" ?>">
        </li>
        <li>
            <button type="submit">Zresetuj hasło</button>
        </li>
    </ul>
</form>
</body>
</html>