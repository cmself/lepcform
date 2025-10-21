<h3>Étape 1 : Organisation signataire</h3>
<p><label for="step1_nom"><span>Nom de l’organisation * :</span> <input type="text" id="step1_nom" name="step1_nom" placeholder="Nom de l’organisation" value="<?php if($_SESSION['lmc_data']['contacts_valide']) {echo (isset($_SESSION['lmc_data']['structures_ohme'][0]['name']) && !empty($_SESSION['lmc_data']['structures_ohme'][0]['name'])) ? $_SESSION['lmc_data']['structures_ohme'][0]['name'] : '';} else { echo (isset($value_form[0]->step1_nom) && !empty($value_form[0]->step1_nom)) ? $value_form[0]->step1_nom : ''; }?>" required></label></p>
<p><label for="step1_siret"><span>Numéro de SIRET * :</span> <input type="text" id="step1_siret" pattern="\d{14}" maxlength="14" title="Veuillez entrer exactement 14 chiffres" name="step1_siret" placeholder="SIRET" value="<?php if($_SESSION['lmc_data']['contacts_valide']) {echo (isset($_SESSION['lmc_data']['structures_ohme'][0]['siren']) && !empty($_SESSION['lmc_data']['structures_ohme'][0]['siren'])) ? $_SESSION['lmc_data']['structures_ohme'][0]['siren'] : '';} else { echo (isset($value_form[0]->step1_siret) && !empty($value_form[0]->step1_siret)) ? $value_form[0]->step1_siret : ''; }?>" required><div id="result_siret"></div></label></p>
<p><label for="step1_logo"><span>Ajouter un logo :</span> <input type="hidden" name="step1_logoH" id="step1_logoH" value="<?=$value_form[0]->step1_logo; ?>"> <input type="file" accept=".jpg, .jpeg" id="step1_logo" name="step1_logo" placeholder="Logo"> <?php if($value_form[0]->step1_logo) { ?><div class="mb-[20px]!"> <img class="h-[60px]! w-auto!" src="<?= plugin_dir_url('') . 'lmc-multistep-form/src/actions/uploads/' .$value_form[0]->step1_logo ?>"></div> <?php } ?></label></p>
<p><label for="step1_ca"><span>Le chiffre d’affaires * :</span>
        <select name="step1_ca" id="step1_ca" required>
            <?php
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['chiffre_daffaires']['options']):
            ?>
                <option>Choisir une réponse</option>
            <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['chiffre_daffaires']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step1_ca == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
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
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['montant_des_frais_pour_la_charte_de_la_diversite']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['montant_des_frais_pour_la_charte_de_la_diversite']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step1_frais == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
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
            <input type="radio" name="step1_adherent" id="option-1" value="1" <?php echo ($value_form[0]->step1_adherent == 1) ? 'checked' : ''; ?>>
            <input type="radio" name="step1_adherent" id="option-2" value="0"  <?php echo ($value_form[0]->step1_adherent == 0) ? 'checked' : ''; ?>>
            <label for="option-1" class="option option-1">
                <div class="dot"></div>
                <span>Oui</span>
            </label>
            <label for="option-2" class="option option-2">
                <div class="dot"></div>
                <span>Non</span>
            </label>
        </div>
    </label>
</p>
<p><label for="step1_adresse"><span>Adresse postale * :</span> <input type="text" id="step1_adresse" name="step1_adresse" placeholder="Adresse" value="<?php echo (isset($value_form[0]->step1_adresse) && !empty($value_form[0]->step1_adresse)) ? $value_form[0]->step1_adresse : ''; ?>" required></label></p>

<div class="coltwo">
    <div class="w-full!">
        <p>
            <label for="step1_ville"><span>Ville * :</span> <input type="text" id="step1_ville" name="step1_ville" placeholder="ville" value="<?php echo (isset($value_form[0]->step1_ville) && !empty($value_form[0]->step1_ville)) ? $value_form[0]->step1_ville : ''; ?>" required></label>
        </p>
    </div>
    <div class="w-full!">
        <p>
            <label for="step1_cp"><span>Code postal * :</span> <input type="text" id="step1_cp" name="step1_cp" placeholder="00000" value="<?php echo (isset($value_form[0]->step1_cp) && !empty($value_form[0]->step1_cp)) ? $value_form[0]->step1_cp : ''; ?>" required></label>
        </p>
    </div>
</div>

<div class="coltwo">
    <div class="w-full!">
        <p>
            <label for="step1_email"><span>Email de l’organisation * :</span> <input type="email" id="step1_email" name="step1_email" placeholder="Email" value="<?php echo (isset($value_form[0]->step1_email) && !empty($value_form[0]->step1_email)) ? $value_form[0]->step1_email : ''; ?>" required></label>
        </p>
    </div>
    <div class="w-full!">
        <p>
            <label for="step1_internet"><span>Site internet * :</span> <input type="url" id="step1_internet" name="step1_internet" placeholder="Url du site" value="<?php echo (isset($value_form[0]->step1_internet) && !empty($value_form[0]->step1_internet)) ? $value_form[0]->step1_internet : ''; ?>" required></label>
        </p>
    </div>
</div>

<p><label for="step1_collaborateurs"><span>Nombre de collaborateurs en France * :</span>
        <select name="step1_collaborateurs" id="step1_collaborateurs" required>
            <?php
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['nombre_de_collaborateurs_en_france']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['nombre_de_collaborateurs_en_france']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>"  <?php echo ($value_form[0]->step1_collaborateurs == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step1_activite"><span>Secteur d’activité :</span>
        <select name="step1_activite" id="step1_activite">
            <?php
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['secteur_dactivite']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['secteur_dactivite']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>"  <?php echo ($value_form[0]->step1_activite == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step1_structure"><span>Type de structure :</span>
        <select name="step1_structure" id="step1_structure">
            <?php
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['type_de_structure']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['type_de_structure']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>"  <?php echo ($value_form[0]->step1_structure == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step1_connaissance"><span>Comment avez-vous eu connaissance de la Charte de la diversité ? :</span>
        <select name="step1_connaissance" id="step1_connaissance" required>
            <?php
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['comment_avez_vous_eu_connaissance_de_la_charte_de_la_diversite']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['comment_avez_vous_eu_connaissance_de_la_charte_de_la_diversite']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>"  <?php echo ($value_form[0]->step1_connaissance == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>


<p>
    <label for="step1_politique"><span>Présentation de votre politique diversité et des raisons de votre engagement (1000 caractères max)</span>
        <textarea id="step1_politique" name="step1_politique" rows="10" placeholder="Présentation (1000 caractères max)"><?php echo (isset($value_form[0]->step1_politique) && !empty($value_form[0]->step1_politique)) ? $value_form[0]->step1_politique : ''; ?></textarea>
    </label>
</p>

<p>
    <label for="step1_signature"><span>Date de la dernière signature de la Charte : <i class="value">17/12/2024</i></span></label>
</p>


<input type="hidden" id="step1_formStartTime" name="step1_formStartTime">
<script>document.getElementById('step1_formStartTime').value = Date.now();</script>
<input type="text" name="step1_honeypot" id="step1_honeypot" style="display:none;">
<input type="hidden" id="step1_csrf_token" name="step1_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">
<input type="hidden" name="step" value="2">
<p class="block! w-full! text-center! text-[var(--color-blanc)]! text-[20px]! font-light! py-[20px]! opacity-50!">* champs nécessaires pour valider l’étape</p>
<p class="block! w-full! text-center!"><button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button></p>


<script>
    const step1_siret = document.getElementById('step1_siret');

    if(step1_siret) {
        step1_siret.addEventListener('input', () => {
            // Supprime tout ce qui n'est pas un chiffre
            step1_siret.value = step1_siret.value.replace(/[^0-9]/g, '');
        });
    }
</script>