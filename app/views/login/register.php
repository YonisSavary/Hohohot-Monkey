<?= include_file("header") ?>
    <section class="fullscreen">
        <h1>Inscription</h1>
        <form action="/register" class="f-col align-center justify-center" method="POST">
            <input type="text" name="login" placeholder="Login" id="">
            <input type="password" name="pass" placeholder="Mot de passe" id="">
            <input type="submit" class="button spaced" value="S'inscrire">
        </form>
    </section>
<?= include_file("footer") ?>