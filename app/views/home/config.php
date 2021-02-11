<?= include_file("header") ?>
    <?php use Monkey\Services\Auth; ?>
    <section class="wrap-body">

        <article class="f-col align-center">
            <h1>Configuration de l'API</h1>

            <table class="spaced">
                <tr>
                    <td><label for="api_url_input" class="spaced">api_url</label></td>
                    <td><input type="text" id="api_url_input"></td>
                </tr>
                <tr>
                    <td><label for="devices_key_input" class="spaced">devices_key</label></td>
                    <td><input type="text" id="devices_key_input"></td>
                </tr>
                <tr>
                    <td><label for="devices_name_input" class="spaced">devices_name</label></td>
                    <td><input type="text" id="devices_name_input"></td>
                </tr>
                <tr>
                    <td><label for="devices_value_input" class="spaced">devices_value</label></td>
                    <td><input type="text" id="devices_value_input"></td>
                </tr>
            </table>
            <button class="button spaced" id="save_button">Sauvegarder</button>


            <details>
            <summary>Comment Configurer ?</summary>
                <p>
                    L'application a été créée pour être le plus simple 
                    et générique possible
                    <ul>
                        <li>api_url : correspond à l'url entière à laquelle nous pouvons récupérer les données capteurs</li>
                        <li>devices_key : correspond au nom du tableau contenant les capteurs dans les données reçues</li>
                        <li>devices_name : correspond a la clé dans laquelle les nom des capteurs sont stockés</li>
                        <li>devices_value : correspond a la clé dans laquelle les températures des capteurs sont stockés</li>
                    </ul>
                    Example : 
                </p>
<pre>
{
    "HotHotHot":"Api v1.0",
    "capteurs":[
        {"type":"Thermique","Nom":"interieur","Valeur":"20.7","Timestamp":1612777580},
        {"type":"Thermique","Nom":"exterieur","Valeur":"19.9","Timestamp":1612777580}
    ]
}
</pre>
            <p>
                ici nous aurons :
                <ul>
                        <li>api_url = &lt;URL_DE_L'API&gt;</li>
                        <li>devices_key = capteurs</li>
                        <li>devices_name = Nom</li>
                        <li>devices_value = Valeur</li>
                </ul>
            </p>
            </details>

            <a href="/home" class="spaced">Retour à l'accueil</a>
        </article>

        <article class="f-col align-center">
            <h1>Changer de mot de passe</h1>
            <section class="spaced f-col">
                <span>Un mot de passe doit avoir 8 caractères minimum</span>
                <span id="p_input_message"></span>
                <input type="password" placeholder="nouveau mot de passe" name="" id="p_input_1">
                <input type="password" placeholder="confirmer mot de passe" name="" id="p_input_2">
            </section>
            <button id="p_input_confirm" class="button">Confirmer</button>
        </article>

        
        <article class="f-col align-center">
            <h1>Supprimer Mon Compte</h1>
            <p>
                Supprimer Son compte :
                <ul>
                    <li>Est définitif</li>
                    <li>Est irréversible</li>
                    <li>Comprend la suppréssion de votre configuration</li>
                </ul>
            </p>
            <button id="delete_confirm" class="button red">Supprimer mon compte</button>
        </article>


        <input type="hidden" id="user_token" value="<?= Auth::token() ?>">
        <script src="<?= url('js/config.js') ?>"></script>
    </section>
<?= include_file("footer") ?>