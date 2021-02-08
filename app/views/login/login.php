<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= url('css/app.css') ?>">
    <title>Hohohot</title>
</head>
<body>
    <section class="fullscreen">
        <h1>Connexion</h1>
        <form action="/login" class="f-col align-center justify-center" method="POST">
            <input type="text" name="login" placeholder="Login" id="">
            <input type="password" name="pass" placeholder="Mot de passe" id="">
            <input type="submit" class="button spaced" value="Se connecter">
        </form>
    </section>
</body>
<script src="app.js"></script>
<script src="api_fetch.js"></script>
</html>