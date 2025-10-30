<div class="relative! w-full!">
    <h3>Étape 1 : Organisation signataire</h3>
</div>

<div class="w-full! my-[20px]! hidden" id="step_loader">
    <h5>Veuillez patienter</h5>
    <div class="w-full! text-center!">
        <div class="text-center">
            <div role="status">
                <svg aria-hidden="true" class="inline w-8 h-8 text-[var(--color-blanc)] animate-spin  fill-[var(--color-rose)]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
    </div>
</div>

<div class="w-full!" id="step_content">

    <?php if (isset($errors['step1']['name'])): ?>
        <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
            <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step1']['name'] ?></p>
            <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step1']['texte'] ?></p>
        </div>
    <?php endif; ?>

    <p><label for="step1_nom"><span>Nom de l’organisation * :</span> <input type="text" placeholder="NOM" id="step1_nom" name="step1_nom" value="<?php echo (isset($value_form[0]->step1_nom) && !empty($value_form[0]->step1_nom)) ? $value_form[0]->step1_nom : ''; ?>" required></label></p>
    <p><label for="step1_siret"><span>Numéro de SIRET * :</span>
            <?php if (isset($value_form[0]->resign) && !empty($value_form[0]->resign)) { ?>
                <input type="text" id="step1_siret_disabled" pattern="\d{14}" maxlength="14" title="Veuillez entrer exactement 14 chiffres" name="step1_siret_disabled" placeholder="SIRET" value="<?php echo (isset($value_form[0]->step1_siret) && !empty($value_form[0]->step1_siret)) ? $value_form[0]->step1_siret : ''; ?>" readonly>
                <input type="hidden" name="step1_siret" id="step1_siret" value="<?php echo (isset($value_form[0]->step1_siret) && !empty($value_form[0]->step1_siret)) ? $value_form[0]->step1_siret : ''; ?>">
            <?php } else { ?>
                <input type="text" id="step1_siret" pattern="\d{14}" maxlength="14" title="Veuillez entrer exactement 14 chiffres" name="step1_siret" placeholder="SIRET" value="<?php echo (isset($value_form[0]->step1_siret) && !empty($value_form[0]->step1_siret)) ? $value_form[0]->step1_siret : ''; ?>" required>
            <?php } ?>

        </label></p>
    <p><label for="step1_logo"><span>Ajouter un logo :</span> <input type="hidden" name="step1_logoH" id="step1_logoH" value="<?php echo (isset($value_form[0]->step1_logo) && !empty($value_form[0]->step1_logo)) ? $value_form[0]->step1_logo : ''; ?>"> <input
                    type="file" accept=".jpg, .jpeg" id="step1_logo" name="step1_logo"
                    placeholder="Logo"> <?php if ($value_form[0]->step1_logo) { ?>
                <div class="mb-[20px]!"> <img class="h-[60px]! w-auto!" src="<?= plugin_dir_url('') . 'lmc-multistep-form/src/actions/uploads/' . $value_form[0]->step1_logo ?>">
                </div> <?php } ?></label></p>
    <p><label for="step1_ca"><span>Le chiffre d’affaires * :</span>
            <select name="step1_ca" id="step1_ca" required>
                <?php
                if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['chiffre_daffaires']['options']):
                    ?>
                    <option value="" disabled selected hidden>Choisir une réponse</option>
                    <?php
                    foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['chiffre_daffaires']['options'] as $option):
                        ?>
                        <option value="<?= htmlspecialchars($option); ?>"
                            <?php  echo ($value_form[0]->step1_ca == $option) ? 'selected' : '';?>><?= htmlspecialchars($option); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>
    <p><label for="step1_frais"><span>Montant des frais pour la Charte de la diversité * :</span>
            <select name="step1_frais" id="step1_frais" required>
                <?php
                if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['montant_des_frais_pour_la_charte_de_la_diversite']['options']):
                    ?>
                    <option value="" disabled selected hidden>Choisir une réponse</option>
                    <?php
                    foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['montant_des_frais_pour_la_charte_de_la_diversite']['options'] as $option):
                        ?>
                        <option value="<?= htmlspecialchars($option); ?>"
                            <?php  echo ($value_form[0]->step1_frais == $option) ? 'selected' : ''; ?>><?= htmlspecialchars($option); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>
    <p>
        <label>
            <span>Adhérent Les entreprises pour la Cité :</span>
            <div class="wrapper">
                <fieldset>
                    <input type="radio" name="step1_adherent" id="option-1"
                           value="1" <?php
                    echo ($value_form[0]->step1_adherent == 1) ? 'checked' : '';
                    ?>>
                    <input type="radio" name="step1_adherent" id="option-2"
                           value="0" <?php
                    echo ($value_form[0]->step1_adherent == 0) ? 'checked' : '';
                    ?>>
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>Oui</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Non</span>
                    </label>
                </fieldset>
            </div>
        </label>
    </p>

    <div class="w-full my-[20px]">
    <div id="autocomplete" class="autocomplete-container relative"></div>
    </div>


    <p><label for="step1_adresse"><span>Adresse postale * :</span> <input type="text" id="step1_adresse"
                                                                          name="step1_adresse" placeholder="Adresse"
                                                                          value="<?php
                                                                          echo (isset($value_form[0]->step1_adresse) && !empty($value_form[0]->step1_adresse)) ? $value_form[0]->step1_adresse : '';
                                                                          ?>"
                                                                          required readonly></label></p>

    <div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="step1_ville"><span>Ville * :</span> <input type="text" id="step1_ville" name="step1_ville"
                                                                       placeholder="ville"
                                                                       value="<?php
                                                                       echo (isset($value_form[0]->step1_ville) && !empty($value_form[0]->step1_ville)) ? $value_form[0]->step1_ville : '';
                                                                       ?>"
                                                                       required readonly></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="step1_cp"><span>Code postal * :</span> <input type="text" id="step1_cp" name="step1_cp"
                                                                          placeholder="00000"
                                                                          value="<?php
                                                                          echo (isset($value_form[0]->step1_cp) && !empty($value_form[0]->step1_cp)) ? $value_form[0]->step1_cp : '';
                                                                          ?>"
                                                                          required readonly></label>
            </p>
        </div>
    </div>

    <div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="step1_email"><span>Email de l’organisation :</span> <input type="email" id="step1_email"
                                                                                       name="step1_email"
                                                                                       placeholder="Email"
                                                                                       value="<?php
                                                                                       echo (isset($value_form[0]->step1_email) && !empty($value_form[0]->step1_email)) ? $value_form[0]->step1_email : '';
                                                                                       ?>"
                    ></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="step1_internet"><span>Site internet :</span> <input type="url" id="step1_internet"
                                                                                name="step1_internet"
                                                                                placeholder="Url du site"
                                                                                value="<?php
                                                                                echo (isset($value_form[0]->step1_internet) && !empty($value_form[0]->step1_internet)) ? $value_form[0]->step1_internet : '';
                                                                                ?>"
                    ></label>
            </p>
        </div>
    </div>

    <p><label for="step1_collaborateurs"><span>Nombre de collaborateurs en France * :</span>
            <select name="step1_collaborateurs" id="step1_collaborateurs" required>
                <?php
                if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['nombre_de_collaborateurs_en_france']['options']):
                    ?>
                    <option value="" disabled selected hidden>Choisir une réponse</option>
                    <?php
                    foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['nombre_de_collaborateurs_en_france']['options'] as $option):
                        ?>
                        <option value="<?= htmlspecialchars($option); ?>"<?php
                        echo ($value_form[0]->step1_collaborateurs == $option) ? 'selected' : '';
                        ?>><?= htmlspecialchars($option); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>

    <p><label for="step1_activite"><span>Secteur d’activité * :</span>
            <select name="step1_activite" id="step1_activite" required>
                <?php
                if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['secteur_dactivite']['options']):
                    ?>
                    <option value="" disabled selected hidden>Choisir une réponse</option>
                    <?php
                    foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['secteur_dactivite']['options'] as $option):
                        ?>
                        <option value="<?= htmlspecialchars($option); ?>" <?php
                        echo ($value_form[0]->step1_activite == $option) ? 'selected' : '';
                        ?>><?= htmlspecialchars($option); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>

    <p><label for="step1_structure"><span>Type de structure * :</span>
            <select name="step1_structure" id="step1_structure" required>
                <?php
                if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['type_de_structure']['options']):
                    ?>
                    <option value="" disabled selected hidden>Choisir une réponse</option>
                    <?php
                    foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['type_de_structure']['options'] as $option):
                        ?>
                        <option value="<?= htmlspecialchars($option); ?>" <?php
                        echo ($value_form[0]->step1_structure == $option) ? 'selected' : '';
                        ?>><?= htmlspecialchars($option); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>

    <p><label for="step1_connaissance"><span>Comment avez-vous eu connaissance de la Charte de la diversité ? * :</span>
            <select name="step1_connaissance" id="step1_connaissance" required>
                <?php
                if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['comment_avez_vous_eu_connaissance_de_la_charte_de_la_diversite']['options']):
                    ?>
                    <option value="" disabled selected hidden>Choisir une réponse</option>
                    <?php
                    foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['comment_avez_vous_eu_connaissance_de_la_charte_de_la_diversite']['options'] as $option):
                        ?>
                        <option value="<?= htmlspecialchars($option); ?>" <?php
                        echo ($value_form[0]->step1_connaissance == $option) ? 'selected' : '';
                        ?>><?= htmlspecialchars($option); ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>


    <p>
        <label for="step1_politique"><span>Présentation de votre politique diversité et des raisons de votre engagement (1000 caractères max) * </span>
            <textarea id="step1_politique" name="step1_politique" rows="10"
                      placeholder="Présentation (1000 caractères max)" required><?php
                echo (isset($value_form[0]->step1_politique) && !empty($value_form[0]->step1_politique)) ? $value_form[0]->step1_politique : '';
                ?></textarea>
        </label>
    </p>

    <p>
        <label for="step1_signature"><span>Date de la dernière signature de la Charte : <i class="value">
                    <?php
                    if (isset($value_form[0]->resign) && !empty($value_form[0]->resign)) {
                        if (isset($value_form[0]->date_de_signature) && !empty($value_form[0]->date_de_signature)) {
                            $dateString = $value_form[0]->date_de_signature;
                            $date = new DateTime($dateString);
                            $formattedDate = $date->format('d/m/Y');
                        } else {
                            $formattedDate = ' ... ';
                        }
                        echo $formattedDate;
                    } else {
                        echo ' ... ';
                    }
                    ?>
                </i></span></label>
    </p>


    <input type="hidden" id="step1_formStartTime" name="step1_formStartTime">
    <script>document.getElementById('step1_formStartTime').value = Date.now();</script>
    <input type="text" name="step1_honeypot" id="step1_honeypot" style="display:none;">
    <input type="hidden" id="step1_csrf_token" name="step1_csrf_token" value="<?php echo $_SESSION['lmc_data'][$id_session]['csrf_token']; ?>">
    <input type="hidden" name="step" value="1">
    <p class="block! w-full! text-center! text-[var(--color-blanc)]! text-[20px]! font-light! py-[20px]! opacity-50!">*
        champs nécessaires pour valider l’étape</p>
    <p class="block! w-full! text-center!">
        <button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
    </p>




    <script>

        const step1_siret = document.getElementById('step1_siret');

        if (step1_siret) {
            step1_siret.addEventListener('input', () => {
                step1_siret.value = step1_siret.value.replace(/[^0-9]/g, '');
            });
        }


        const autocompleteInput = new autocomplete.GeocoderAutocomplete(
            document.getElementById("autocomplete"),
            '9719cc4df0794d95b89c69609983e4cd',
            {
                lang: 'fr',
                allowNonVerifiedHouseNumber: false,
                allowNonVerifiedStreet: false,
                placeholder: "Tapez l'adresse pour remplir automatiquement les champs suivants",
                limit: 5
            });

        autocompleteInput.on('select', (location) => {
            /*
            {
            "type":"Feature",
            "properties":
                {
                "country":"France",
                "country_code":"fr",
                "region":"France métropolitaine",
                "state":"Île-de-France",
                "city":"Paris",
                "municipality":"Paris",
                "postcode":"75004",
                "district":"Le Village Saint-Paul",
                "suburb":"Le Marais",
                "street":"Rue de Rivoli",
                "other_names":
                    {
                    "name":"Rue de Rivoli",
                    "name:de":"Rue de Rivoli",
                    "name:es":"Rue de Rivoli",
                    "name:fr":"Rue de Rivoli",
                    "name:ru":"Улица Риволи"
                    },
                "iso3166_2":"FR-75C",
                "datasource":
                    {
                    "sourcename":"openstreetmap",
                    "attribution":"© OpenStreetMap contributors",
                    "license":"Open Database License",
                    "url":"https://www.openstreetmap.org/copyright"
                    },
                "state_code":"IDF",
                "state_COG":"11",
                "lon":2.358812,
                "lat":48.8557199,
                "housenumber":"6",
                "result_type":"building",
                "formatted":"6 Rue de Rivoli, 75004 Paris, France",
                "address_line1":"6 Rue de Rivoli",
                "address_line2":"75004 Paris, France",
                "timezone":
                    {
                    "name":"Europe/Paris",
                    "offset_STD":"+01:00",
                    "offset_STD_seconds":3600,
                    "offset_DST":"+02:00",
                    "offset_DST_seconds":7200,
                    "abbreviation_STD":"CET",
                    "abbreviation_DST":"CEST"
                    },
                "plus_code":"8FW4V945+7G",
                "plus_code_short":"45+7G Paris, Île-de-France, France",
                "rank":
                    {
                    "confidence":0.75,
                    "confidence_street_level":1,
                    "confidence_building_level":0.75,
                    "match_type":"full_match"},
                    "place_id":"517f4c6bd3d8de024059a884cc3a886d4840f00102f901fdab3e0a00000000c00203"
                    },
               "geometry":
                    {
                    "type":"Point",
                    "coordinates":[2.358812,48.8557199]},
                    "bbox":[2.3600815,48.8551111,2.3615537,48.8554573]
                    }
            */

            console.log(location);

            const step1_adresse = document.getElementById('step1_adresse');
            const step1_ville = document.getElementById('step1_ville');
            const step1_cp = document.getElementById('step1_cp');

            if(location['properties']['address_line1']) {
                step1_adresse.value = location['properties']['address_line1'];
            }else{
                step1_adresse.value = "";
            }

            if(location['properties']['city']) {
                step1_ville.value = location['properties']['city'];
            }else{
                step1_ville.value = "";
            }

            if(location['properties']['postcode']) {
                step1_cp.value = location['properties']['postcode'];
            }else{
                step1_cp.value = "";
            }



        });

        autocompleteInput.on('suggestions', (suggestions) => {
        });


    </script>


</div>