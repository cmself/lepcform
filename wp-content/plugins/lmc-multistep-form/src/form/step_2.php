
<?php
/*
 * Récuperer toutes les fonctions enregistrées en BO
 */
$fonctions_entreprise = [];
$lmc_multistep_fe = get_posts( array(
    'post_type'      => 'lmc_multistep_fe',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby' => 'title',
    'order'   => 'ASC'
) );
foreach ( $lmc_multistep_fe as $fonction_entreprise ) {
    $fonctions_entreprise[] = esc_html( $fonction_entreprise->post_title );
}
?>

<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=1" class="block! w-full!">
    <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>
<div class="relative! w-full!">
    <h3>Étape 2 : Interlocuteurs</h3>
    <h4>Informations du contact principal</h4>
</div>

<?php if (isset($errors['step2']['name'])): ?>
    <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
        <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step2']['name'] ?></p>
        <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step2']['texte'] ?></p>
    </div>
<?php else: ?>

    <?php if(isset($_POST['step']) && $_POST['step'] == 2): ?>

        <h5>Veuillez patienter ...</h5>
        <div class="w-full! text-center!"><img src="<?= plugins_url('lmc-multistep-form/assets/img/loader.gif') ?>" alt="loader" class="loader inline-block!"></div>

    <?php endif; ?>

<?php endif; ?>

    <div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="step2_prenom_0"><span>Prénom * :</span> <input type="text" id="step2_prenom_0" name="step2_prenom_0" placeholder="Prénom" value="<?php echo (isset($value_form[0]->step2_prenom_0) && !empty($value_form[0]->step2_prenom_0)) ? $value_form[0]->step2_prenom_0 : ''; ?>" required></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="step2_nom_0"><span>Nom * :</span> <input type="text" id="step2_nom_0" name="step2_nom_0" placeholder="Nom" value="<?php echo (isset($value_form[0]->step2_nom_0) && !empty($value_form[0]->step2_nom_0)) ? $value_form[0]->step2_nom_0 : ''; ?>" required></label>
            </p>
        </div>
    </div>

    <p>
        <label for="step2_fonction_0"><span>Fonction dans l’organisation * :</span>
            <input type="text" id="step2_fonction_0" name="step2_fonction_0" placeholder="Tapez une fonction..." value="<?php echo (isset($value_form[0]->step2_fonction_0) && !empty($value_form[0]->step2_fonction_0)) ? $value_form[0]->step2_fonction_0 : ''; ?>" required/>
            <div id="suggestions0" class="suggestions"></div>
        </label>
    </p>

    <p>
        <label for="step2_email_0"><span>Email * :</span> <input type="email" id="step2_email_0" name="step2_email_0" placeholder="Email" value="<?php echo (isset($value_form[0]->step2_email_0) && !empty($value_form[0]->step2_email_0)) ? $value_form[0]->step2_email_0 : ''; ?>" required></label>
    </p>

    <p>
        <label for="step2_role_0"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
            <input type="text" id="step2_role_0_disabled" name="step2_role_0_disabled" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][0]); ?>" disabled required>
            <input type="hidden" name="step2_role_0" id="step2_role_0" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][0]); ?>" required>
        </label>
    </p>

    <p>
        <label for="step2_signataire_0" class="checkbox">
            <input type="checkbox" class="step2_signataire" id="step2_signataire_0"
                                                  name="step2_signataire_0" value="1" <?php echo ($value_form[0]->step2_signataire_0 == 1) ? 'checked' : ''; ?> /><span>Contact signataire</span> <i
                    class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
    </p>

    <div class="useradd">

        <?php if(isset($value_form[0]->step2_email_1) && !empty($value_form[0]->step2_email_1)){ ?>

        <div class="user" id="N_1">

            <div class="relative! w-full! min-h-[50px]!">
                <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_1')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
            </div>

            <div class="relative! w-full!">
                <h4> 2ème contact </h4>
            </div>


            <div class="coltwo">
                <div class="w-full!">
                    <p>
                        <label for="step2_prenom_1"><span>Prénom * :</span> <input type="text" id="step2_prenom_1" name="step2_prenom_1" placeholder="Prénom" value="<?php echo (isset($value_form[0]->step2_prenom_1) && !empty($value_form[0]->step2_prenom_1)) ? $value_form[0]->step2_prenom_1 : ''; ?>" required></label>
                    </p>
                </div>
                <div class="w-full!">
                    <p>
                        <label for="step2_nom_1"><span>Nom * :</span> <input type="text" id="step2_nom_1" name="step2_nom_1" placeholder="Nom" value="<?php echo (isset($value_form[0]->step2_nom_1) && !empty($value_form[0]->step2_nom_1)) ? $value_form[0]->step2_nom_1 : ''; ?>" required></label>
                    </p>
                </div>
            </div>

            <p>
                <label for="step2_fonction_1"><span>Fonction dans l’organisation * :</span>
                    <input type="text" id="step2_fonction_1" name="step2_fonction_1" placeholder="Tapez une fonction..." value="<?php echo (isset($value_form[0]->step2_fonction_1) && !empty($value_form[0]->step2_fonction_1)) ? $value_form[0]->step2_fonction_1 : ''; ?>" required/>
                    <div id="suggestions1" class="suggestions"></div>
                </label>
            </p>

            <p>
                <label for="step2_email_1"><span>Email * :</span> <input type="email" id="step2_email_1" name="step2_email_1" placeholder="Email" value="<?php echo (isset($value_form[0]->step2_email_1) && !empty($value_form[0]->step2_email_1)) ? $value_form[0]->step2_email_1 : ''; ?>" required></label>
            </p>

            <p>
                <label for="step2_role_1"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
                    <input type="text" id="step2_role_1_disabled" name="step2_role_1_disabled" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" disabled required>
                    <input type="hidden" name="step2_role_1" id="step2_role_1" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" required>
                </label>
            </p>

            <p>
                <label for="step2_signataire_1" class="checkbox"><input type="checkbox" class="step2_signataire" id="step2_signataire_1"
                                                                        name="step2_signataire_1" value="1" <?php echo ($value_form[0]->step2_signataire_1 == 1) ? 'checked' : ''; ?> /><span>Contact signataire</span> <i
                            class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
            </p>

            <input type="hidden" id="step2_useradd_1" name="step2_useradd_1">


        </div>

        <?php } ?>

        <?php if(isset($value_form[0]->step2_email_2) && !empty($value_form[0]->step2_email_2)){ ?>

            <div class="user" id="N_2">


                <div class="relative! w-full! min-h-[50px]!">
                    <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_2')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
                </div>

                <div class="relative! w-full!">
                    <h4> 3ème contact </h4>
                </div>


                <div class="coltwo">
                    <div class="w-full!">
                        <p>
                            <label for="step2_prenom_2"><span>Prénom * :</span> <input type="text" id="step2_prenom_2" name="step2_prenom_2" placeholder="Prénom" value="<?php echo (isset($value_form[0]->step2_prenom_2) && !empty($value_form[0]->step2_prenom_2)) ? $value_form[0]->step2_prenom_2 : ''; ?>" required></label>
                        </p>
                    </div>
                    <div class="w-full!">
                        <p>
                            <label for="step2_nom_2"><span>Nom * :</span> <input type="text" id="step2_nom_2" name="step2_nom_2" placeholder="Nom" value="<?php echo (isset($value_form[0]->step2_nom_2) && !empty($value_form[0]->step2_nom_2)) ? $value_form[0]->step2_nom_2 : ''; ?>" required></label>
                        </p>
                    </div>
                </div>

                <p>
                    <label for="step2_fonction_2"><span>Fonction dans l’organisation * :</span>
                        <input type="text" id="step2_fonction_2" name="step2_fonction_2" placeholder="Tapez une fonction..." value="<?php echo (isset($value_form[0]->step2_fonction_2) && !empty($value_form[0]->step2_fonction_2)) ? $value_form[0]->step2_fonction_2 : ''; ?>" required/>
                        <div id="suggestions2" class="suggestions"></div>
                    </label>
                </p>

                <p>
                    <label for="step2_email_2"><span>Email * :</span> <input type="email" id="step2_email_2" name="step2_email_2" placeholder="Email" value="<?php echo (isset($value_form[0]->step2_email_2) && !empty($value_form[0]->step2_email_2)) ? $value_form[0]->step2_email_2 : ''; ?>" required></label>
                </p>

                <p>
                    <label for="step2_role_2"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
                        <input type="text" id="step2_role_2_disabled" name="step2_role_2_disabled" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" disabled required>
                        <input type="hidden" name="step2_role_2" id="step2_role_2" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" required>
                    </label>
                </p>

                <p>
                    <label for="step2_signataire_2" class="checkbox"><input type="checkbox" class="step2_signataire" id="step2_signataire_2"
                                                                            name="step2_signataire_2" value="1" <?php echo ($value_form[0]->step2_signataire_2 == 1) ? 'checked' : ''; ?> /><span>Contact signataire</span> <i
                                class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
                </p>

                <input type="hidden" id="step2_useradd_2" name="step2_useradd_2">


            </div>

        <?php } ?>


        <?php if(isset($value_form[0]->step2_email_3) && !empty($value_form[0]->step2_email_3)){ ?>

            <div class="user" id="N_3">


                <div class="relative! w-full! min-h-[50px]!">
                    <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_3')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
                </div>

                <div class="relative! w-full!">
                    <h4> 4ème contact </h4>
                </div>


                <div class="coltwo">
                    <div class="w-full!">
                        <p>
                            <label for="step2_prenom_3"><span>Prénom * :</span> <input type="text" id="step2_prenom_3" name="step2_prenom_3" placeholder="Prénom" value="<?php echo (isset($value_form[0]->step2_prenom_3) && !empty($value_form[0]->step2_prenom_3)) ? $value_form[0]->step2_prenom_3 : ''; ?>" required></label>
                        </p>
                    </div>
                    <div class="w-full!">
                        <p>
                            <label for="step2_nom_3"><span>Nom * :</span> <input type="text" id="step2_nom_3" name="step2_nom_3" placeholder="Nom" value="<?php echo (isset($value_form[0]->step2_nom_3) && !empty($value_form[0]->step2_nom_3)) ? $value_form[0]->step2_nom_3 : ''; ?>" required></label>
                        </p>
                    </div>
                </div>

                <p>
                    <label for="step2_fonction_3"><span>Fonction dans l’organisation * :</span>
                        <input type="text" id="step2_fonction_3" name="step2_fonction_3" placeholder="Tapez une fonction..." value="<?php echo (isset($value_form[0]->step2_fonction_3) && !empty($value_form[0]->step2_fonction_3)) ? $value_form[0]->step2_fonction_3 : ''; ?>" required/>
                        <div id="suggestions3" class="suggestions"></div>
                    </label>
                </p>

                <p>
                    <label for="step2_email_3"><span>Email * :</span> <input type="email" id="step2_email_3" name="step2_email_3" placeholder="Email" value="<?php echo (isset($value_form[0]->step2_email_3) && !empty($value_form[0]->step2_email_3)) ? $value_form[0]->step2_email_3 : ''; ?>" required></label>
                </p>

                <p>
                    <label for="step2_role_3"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
                        <input type="text" id="step2_role_3_disabled" name="step2_role_3_disabled" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" disabled required>
                        <input type="hidden" name="step2_role_3" id="step2_role_3" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" required>
                    </label>
                </p>

                <p>
                    <label for="step2_signataire_3" class="checkbox"><input type="checkbox" class="step2_signataire" id="step2_signataire_3"
                                                                            name="step2_signataire_3" value="1" <?php echo ($value_form[0]->step2_signataire_3 == 1) ? 'checked' : ''; ?> /><span>Contact signataire</span> <i
                                class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
                </p>

                <input type="hidden" id="step2_useradd_3" name="step2_useradd_3">


            </div>

        <?php } ?>

    </div>

    <input type="hidden" id="step2_formStartTime" name="step2_formStartTime">
    <script>document.getElementById('step2_formStartTime').value = Date.now();</script>
    <input type="text" name="step2_honeypot" id="step2_honeypot" style="display:none;">
    <input type="hidden" id="step2_csrf_token" name="step2_csrf_token" value="<?php echo $_SESSION['lmc_data'][$id_session]['csrf_token']; ?>">
    <input type="hidden" name="step" value="2">
    <p class="block! w-full! text-center! text-[var(--color-blanc)]! text-[20px]! font-light! py-[20px]! opacity-50!">* champs
        nécessaires pour valider l’étape</p>
    <div class="flex! flex-col md:flex-row gap-[10px] justify-center items-center w-full! text-center!">
        <button type="button" id="addBtn"><i class="fa-solid fa-user-plus mr-[20px]"></i> Ajouter un contact</button>
        <button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
    </div>


<style>
    .tippy-box[data-theme~='lmc'] {
        background-color: var(--color-purple);
        color: var(--color-blanc);
        padding: 10px;
    }
    .tippy-box[data-theme~='lmc'][data-placement^='top'] > .tippy-arrow::before {
        border-top-color: var(--color-purple);
    }
    .tippy-box[data-theme~='lmc'][data-placement^='bottom'] > .tippy-arrow::before {
        border-bottom-color: var(--color-purple);
    }
    .tippy-box[data-theme~='lmc'][data-placement^='left'] > .tippy-arrow::before {
        border-left-color: var(--color-purple);
    }
    .tippy-box[data-theme~='lmc'][data-placement^='right'] > .tippy-arrow::before {
        border-right-color: var(--color-purple);
    }
</style>

<script>


    const container = document.querySelector('.useradd');
    const addBtn = document.getElementById('addBtn');
    const maxContacts = 3;    

    addBtn.addEventListener('click', () => {
        const currentContacts = container.querySelectorAll('.user').length;

        if (currentContacts < maxContacts) {
            const newDiv = document.createElement('div');
            newDiv.classList.add('user');
            newDiv.id = 'N_' + (currentContacts+1);
            newDiv.innerHTML = `

            <div class="relative! w-full! min-h-[50px]!">
                <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_` + (currentContacts+1) + `')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
            </div>

            <div class="relative! w-full!">
               <h4>` + (currentContacts+2) + `ème contact </h4>
            </div>


<div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="step2_prenom_` + (currentContacts+1) + `"><span>Prénom * :</span> <input type="text" id="step2_prenom_` + (currentContacts+1) + `" name="step2_prenom_` + (currentContacts+1) + `"
                                                                   placeholder="Prénom" required></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="step2_nom-` + (currentContacts+1) + `"><span>Nom * :</span> <input type="text" id="step2_nom_` + (currentContacts+1) + `" name="step2_nom_` + (currentContacts+1) + `" placeholder="Nom" required></label>
            </p>
        </div>
    </div>


    <p>
    <label for="step2_fonction_` + (currentContacts+1) + `"><span>Fonction dans l’organisation * :</span>
                        <input type="text" id="step2_fonction_` + (currentContacts+1) + `" name="step2_fonction_` + (currentContacts+1) + `" placeholder="Tapez une fonction..." required/>
                        <div id="suggestions` + (currentContacts+1) + `" class="suggestions"></div>
                    </label>
                </p>

    <p>
        <label for="step2_email_` + (currentContacts+1) + `"><span>Email * :</span> <input type="email" id="step2_email_` + (currentContacts+1) + `" name="step2_email_` + (currentContacts+1) + `" placeholder="Email"
                                                         required></label>
    </p>

    <p>
                    <label for="step2_role_` + (currentContacts+1) + `"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
                        <input type="text" id="step2_role_` + (currentContacts+1) + `_disabled" name="step2_role_` + (currentContacts+1) + `_disabled" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" disabled required>
                        <input type="hidden" name="step2_role_` + (currentContacts+1) + `" id="step2_role_` + (currentContacts+1) + `" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" required>
                    </label>
                </p>



    <p>
        <label for="step2_signataire_` + (currentContacts+1) + `" class="checkbox"><input type="checkbox" class="step2_signataire" id="step2_signataire_` + (currentContacts+1) + `"
                                                  name="step2_signataire_` + (currentContacts+1) + `" value="1"/><span>Contact signataire</span> <i
                    class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
    </p>

    <input type="hidden" id="step2_useradd_` + (currentContacts+1) + `" name="step2_useradd_` + (currentContacts+1) + `">`;
            container.appendChild(newDiv);
            if (currentContacts == 2){
                addBtn.style.display = 'none';
            }

            tippy('[data-tippy-content]', {
                theme: 'lmc',
            });

            const checkboxes = document.querySelectorAll('.step2_signataire');
            if(checkboxes) {
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            checkboxes.forEach(box => {
                                if (box !== checkbox) box.checked = false;
                            });
                        }
                    });

                });
            }

            // Récupération des fonctions_entreprise 1
            const input1 = document.getElementById("step2_fonction_1");
            const suggestionsDiv1 = document.getElementById("suggestions1");
            input1.addEventListener("input", () => {
                const query = input1.value.toLowerCase();
                suggestionsDiv1.innerHTML = "";
                if (query.length === 0) return;
                const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
                filtered.forEach(name => {
                    const div = document.createElement("div");
                    div.textContent = name;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input1.value = name;
                        suggestionsDiv1.innerHTML = "";
                    });
                    suggestionsDiv1.appendChild(div);
                });
            });
            document.addEventListener("click", (e) => {
                if (!input1.contains(e.target)) {
                    suggestionsDiv1.innerHTML = "";
                }
            });

            // Récupération des fonctions_entreprise 2
            const input2 = document.getElementById("step2_fonction_2");
            const suggestionsDiv2 = document.getElementById("suggestions2");
            input2.addEventListener("input", () => {
                const query = input2.value.toLowerCase();
                suggestionsDiv2.innerHTML = "";
                if (query.length === 0) return;
                const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
                filtered.forEach(name => {
                    const div = document.createElement("div");
                    div.textContent = name;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input2.value = name;
                        suggestionsDiv2.innerHTML = "";
                    });
                    suggestionsDiv2.appendChild(div);
                });
            });
            document.addEventListener("click", (e) => {
                if (!input2.contains(e.target)) {
                    suggestionsDiv2.innerHTML = "";
                }
            });

            // Récupération des fonctions_entreprise 3
            const input3 = document.getElementById("step2_fonction_3");
            const suggestionsDiv3 = document.getElementById("suggestions3");
            input3.addEventListener("input", () => {
                const query = input3.value.toLowerCase();
                suggestionsDiv3.innerHTML = "";
                if (query.length === 0) return;
                const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
                filtered.forEach(name => {
                    const div = document.createElement("div");
                    div.textContent = name;
                    div.classList.add("suggestion-item");
                    div.addEventListener("click", () => {
                        input3.value = name;
                        suggestionsDiv3.innerHTML = "";
                    });
                    suggestionsDiv3.appendChild(div);
                });
            });
            document.addEventListener("click", (e) => {
                if (!input3.contains(e.target)) {
                    suggestionsDiv3.innerHTML = "";
                }
            });

        } else {
            addBtn.style.display = 'none';
        }
    });

    function suppUser(id) {
        const element = document.getElementById(id);
        if (element) {
            element.remove();
            reorderContacts();
            addBtn.style.display = 'inline-block';


        } else {
            alert('Élément introuvable : ' + id);
        }
    }

    function reorderContacts() {
        const containerUser = document.querySelector('.useradd');
        const users = container.querySelectorAll('.user');
        const currentUsers = users.length;
        users.forEach((user, index) => {
            user.remove();
        });

        for (let i = 0; i < currentUsers; i++) {

            const newUser = document.createElement('div');
            newUser.classList.add('user');
            newUser.id = 'N_' + (i + 1);
            newUser.innerHTML = `
            <div class="relative! w-full! min-h-[50px]!">
                <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_` + (i+1) + `')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
            </div>

            <div class="relative! w-full!">
               <h4>` + (i+2) + `ème contact </h4>
            </div>



            <div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="step2_prenom_` + (i + 1) + `"><span>Prénom * :</span> <input type="text" id="step2_prenom_` + (i + 1) + `" name="step2_prenom_` + (i + 1) + `"
                                                                   placeholder="Prénom" required></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="step2_nom-` + (i + 1) + `"><span>Nom * :</span> <input type="text" id="step2_nom_` + (i + 1) + `" name="step2_nom_` + (i + 1) + `" placeholder="Nom" required></label>
            </p>
        </div>
    </div>

    <p><label for="step2_fonction_` + (i + 1) + `"><span>Fonction dans l’organisation * :</span>
                        <input type="text" id="step2_fonction_` + (i + 1) + `" name="step2_fonction_` + ( i+1 ) + `" placeholder="Tapez une fonction..." required/>
                        <div id="suggestions` + ( i + 1) + `" class="suggestions"></div>
                    </label>
                </p>

    <p>
        <label for="step2_email_` + (i + 1) + `"><span>Email * :</span> <input type="email" id="step2_email_` + (i + 1) + `" name="step2_email_` + (i + 1) + `" placeholder="Email"
                                                         required></label>
    </p>

    <p>
                    <label for="step2_role_` + (i+1) + `"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
                        <input type="text" id="step2_role_` + (i+1) + `_disabled" name="step2_role_` + (i+1) + `_disabled" placeholder="Nom" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" disabled required>
                        <input type="hidden" name="step2_role_` + (i+1) + `" id="step2_role_` + (i+1) + `" value="<?= htmlspecialchars($_SESSION['lmc_data'][$id_session]['ohme_data']['Contact']['role_dans_lentreprise_pour_la_charte_de_la_charte_de_la_diversite']['options'][1]); ?>" required>
                    </label>
                </p>

    <p>
        <label for="step2_signataire_` + (i+1) + `" class="checkbox"><input type="checkbox" class="step2_signataire" id="step2_signataire_` + (i+1) + `"
                                                  name="step2_signataire_` + (i+1) + `" value="1"/><span>Contact signataire</span> <i
                    class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
    </p>
    <input type="hidden" id="step2_useradd_` + (i + 1) + `" name="step2_useradd_` + (i + 1) + `">`;
            containerUser.appendChild(newUser);

        }

        tippy('[data-tippy-content]', {
            theme: 'lmc',
        });

        const checkboxes = document.querySelectorAll('.step2_signataire');
        if(checkboxes) {
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        checkboxes.forEach(box => {
                            if (box !== checkbox) box.checked = false;
                        });
                    }
                });

            });
        }

        // Récupération des fonctions_entreprise 1
        const input1 = document.getElementById("step2_fonction_1");
        const suggestionsDiv1 = document.getElementById("suggestions1");
        input1.addEventListener("input", () => {
            const query = input1.value.toLowerCase();
            suggestionsDiv1.innerHTML = "";
            if (query.length === 0) return;
            const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
            filtered.forEach(name => {
                const div = document.createElement("div");
                div.textContent = name;
                div.classList.add("suggestion-item");
                div.addEventListener("click", () => {
                    input1.value = name;
                    suggestionsDiv1.innerHTML = "";
                });
                suggestionsDiv1.appendChild(div);
            });
        });
        document.addEventListener("click", (e) => {
            if (!input1.contains(e.target)) {
                suggestionsDiv1.innerHTML = "";
            }
        });

        // Récupération des fonctions_entreprise 2
        const input2 = document.getElementById("step2_fonction_2");
        const suggestionsDiv2 = document.getElementById("suggestions2");
        input2.addEventListener("input", () => {
            const query = input2.value.toLowerCase();
            suggestionsDiv2.innerHTML = "";
            if (query.length === 0) return;
            const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
            filtered.forEach(name => {
                const div = document.createElement("div");
                div.textContent = name;
                div.classList.add("suggestion-item");
                div.addEventListener("click", () => {
                    input2.value = name;
                    suggestionsDiv2.innerHTML = "";
                });
                suggestionsDiv2.appendChild(div);
            });
        });
        document.addEventListener("click", (e) => {
            if (!input2.contains(e.target)) {
                suggestionsDiv2.innerHTML = "";
            }
        });

        // Récupération des fonctions_entreprise 3
        const input3 = document.getElementById("step2_fonction_3");
        const suggestionsDiv3 = document.getElementById("suggestions3");
        input3.addEventListener("input", () => {
            const query = input3.value.toLowerCase();
            suggestionsDiv3.innerHTML = "";
            if (query.length === 0) return;
            const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
            filtered.forEach(name => {
                const div = document.createElement("div");
                div.textContent = name;
                div.classList.add("suggestion-item");
                div.addEventListener("click", () => {
                    input3.value = name;
                    suggestionsDiv3.innerHTML = "";
                });
                suggestionsDiv3.appendChild(div);
            });
        });
        document.addEventListener("click", (e) => {
            if (!input3.contains(e.target)) {
                suggestionsDiv3.innerHTML = "";
            }
        });

    }



    tippy('[data-tippy-content]', {
        theme: 'lmc',
    });

    const checkboxes = document.querySelectorAll('.step2_signataire');
    if(checkboxes) {
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    checkboxes.forEach(box => {
                        if (box !== checkbox) box.checked = false;
                    });
                }
            });
        });
    }




    // Tableau des fonctions
    const fonctions_entreprise = [
        <?php
        foreach ( $fonctions_entreprise as $fonction ) {
            echo '"' . $fonction . '", ';
        }
        ?>
    ];

    // Récupération des fonctions_entreprise 0
    const input0 = document.getElementById("step2_fonction_0");
    const suggestionsDiv0 = document.getElementById("suggestions0");
    input0.addEventListener("input", () => {
        const query = input0.value.toLowerCase();
        suggestionsDiv0.innerHTML = "";
        if (query.length === 0) return;
        const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
        filtered.forEach(name => {
            const div = document.createElement("div");
            div.textContent = name;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input0.value = name;
                suggestionsDiv0.innerHTML = "";
            });
            suggestionsDiv0.appendChild(div);
        });
    });
    document.addEventListener("click", (e) => {
        if (!input0.contains(e.target)) {
            suggestionsDiv0.innerHTML = "";
        }
    });

    // Récupération des fonctions_entreprise 1
    const input1 = document.getElementById("step2_fonction_1");
    const suggestionsDiv1 = document.getElementById("suggestions1");
    input1.addEventListener("input", () => {
        const query = input1.value.toLowerCase();
        suggestionsDiv1.innerHTML = "";
        if (query.length === 0) return;
        const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
        filtered.forEach(name => {
            const div = document.createElement("div");
            div.textContent = name;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input1.value = name;
                suggestionsDiv1.innerHTML = "";
            });
            suggestionsDiv1.appendChild(div);
        });
    });
    document.addEventListener("click", (e) => {
        if (!input1.contains(e.target)) {
            suggestionsDiv1.innerHTML = "";
        }
    });

    // Récupération des fonctions_entreprise 2
    const input2 = document.getElementById("step2_fonction_2");
    const suggestionsDiv2 = document.getElementById("suggestions2");
    input2.addEventListener("input", () => {
        const query = input2.value.toLowerCase();
        suggestionsDiv2.innerHTML = "";
        if (query.length === 0) return;
        const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
        filtered.forEach(name => {
            const div = document.createElement("div");
            div.textContent = name;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input2.value = name;
                suggestionsDiv2.innerHTML = "";
            });
            suggestionsDiv2.appendChild(div);
        });
    });
    document.addEventListener("click", (e) => {
        if (!input2.contains(e.target)) {
            suggestionsDiv2.innerHTML = "";
        }
    });

    // Récupération des fonctions_entreprise 3
    const input3 = document.getElementById("step2_fonction_3");
    const suggestionsDiv3 = document.getElementById("suggestions3");
    input3.addEventListener("input", () => {
        const query = input3.value.toLowerCase();
        suggestionsDiv3.innerHTML = "";
        if (query.length === 0) return;
        const filtered = fonctions_entreprise.filter(name => name.toLowerCase().includes(query)).slice(0, 5);
        filtered.forEach(name => {
            const div = document.createElement("div");
            div.textContent = name;
            div.classList.add("suggestion-item");
            div.addEventListener("click", () => {
                input3.value = name;
                suggestionsDiv3.innerHTML = "";
            });
            suggestionsDiv3.appendChild(div);
        });
    });
    document.addEventListener("click", (e) => {
        if (!input3.contains(e.target)) {
            suggestionsDiv3.innerHTML = "";
        }
    });


</script>