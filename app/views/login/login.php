<?= include_file("header") ?>
    <section class="fullscreen">
        <h1>Connexion</h1>
        <?php if (isset($_GET["error"])) { ?> 
            <?php if ($_GET["error"] === "exists") { ?>
                <span>Un utilisateur avec ce nom existe déjà</span>
            <?php } ?>
        <?php } ?>
        <form action="/login" class="f-col align-center justify-center" method="POST">
            <input type="text" name="login" placeholder="Login" id="">
            <input type="password" name="pass" placeholder="Mot de passe" id="">
            <input type="submit" class="button spaced" value="Se connecter">
        </form>
        <span>Pas de compte ? <a href="<?= router("register") ?>">Incrivez-vous</a></span>
    </section>
<?= include_file("footer") ?>