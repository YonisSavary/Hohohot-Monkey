<?php

use Monkey\Services\Auth;
?>
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
    <header>
        <h1>Bienvenue sur Hohohot !</h1>
        <section class="f-filler"></section>
        <ul>
            <li>
                <a href="/config">
                    <?= Auth::get_user()->login ?>
                </a>
            </li>
            <li><a href="/logout">Déconnexion</a></li>
            
        </ul>
    </header>
    <section class="main-controller">
        <section id="temp-slot"></section>
    </section>
    <section class="api-info">
        Présentation oui
    </section>
    <input type="hidden" id="user_token" value="<?= Auth::token() ?>">
</body>
<script src="<?= url('js/app.js') ?>"></script>
<script src="<?= url('js/api_fetch.js') ?>"></script>
</html>