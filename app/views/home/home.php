<?= include_file("header") ?>
    <?php use Monkey\Services\Auth; ?>

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
        <section class="card">
            <h1>Résumé des 100 dernières mesures</h1>
            <canvas id="tempChart"></canvas>
        </section>
    </section>
    <section class="api-info">
        Présentation oui
    </section>
    <input type="hidden" id="user_token" value="<?= Auth::token() ?>">
    <script src="<?= url('js/chart.js') ?>"></script>
    <script src="<?= url('js/apichart.js') ?>"></script>
    <script src="<?= url('js/app.js') ?>"></script>
<?= include_file("footer") ?>