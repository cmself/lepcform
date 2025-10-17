<h3>Étape 1 : Organisation signataire</h3>
<p><label for="step1_nom"><span>Nom de l’organisation * :</span> <input type="text" id="step1_nom" name="step1_nom" placeholder="Nom de l’organisation" required></label></p>
<p><label for="step1_siret"><span>Numéro de SIRET * :</span> <input type="text" id="step1_siret" name="step1_siret" placeholder="SIRET" required></label></p>
<p><label for="step1_logo"><span>Ajouter un logo :</span> <input type="file" id="step1_logo" name="step1_logo" placeholder="Logo"></label></p>
<p><label for="step1_ca"><span>Le chiffre d’affaires * :</span>
        <select name="step1_ca" id="step1_ca" required>
            <?php
            if ($options):
            ?>
                <option>Choisir une réponse</option>
            <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
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
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
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
            <input type="radio" name="step1_adherent" id="option-1" value="1">
            <input type="radio" name="step1_adherent" id="option-2" value="0">
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
<p><label for="step1_adresse"><span>Adresse postale * :</span> <input type="text" id="step1_adresse" name="step1_adresse" placeholder="Adresse" required></label></p>

<div class="coltwo">
    <div class="w-full!">
        <p>
            <label for="step1_ville"><span>Ville * :</span> <input type="text" id="step1_ville" name="step1_ville" placeholder="ville" required></label>
        </p>
    </div>
    <div class="w-full!">
        <p>
            <label for="step1_cp"><span>Code postal * :</span> <input type="text" id="step1_cp" name="step1_cp" placeholder="00000" required></label>
        </p>
    </div>
</div>

<div class="coltwo">
    <div class="w-full!">
        <p>
            <label for="step1_email"><span>Email de l’organisation * :</span> <input type="email" id="step1_email" name="step1_email" placeholder="Email" required></label>
        </p>
    </div>
    <div class="w-full!">
        <p>
            <label for="step1_internet"><span>Site internet * :</span> <input type="url" id="step1_internet" name="step1_internet" placeholder="Url du site" required></label>
        </p>
    </div>
</div>

<p><label for="step1_collaborateurs"><span>Nombre de collaborateurs en France * :</span>
        <select name="step1_collaborateurs" id="step1_collaborateurs" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
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
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
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
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
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
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>


<p>
    <label for="step1_politique"><span>Présentation de votre politique diversité et des raisons de votre engagement (1000 caractères max)</span>
        <textarea id="step1_politique" name="step1_politique" rows="10" placeholder="Présentation (1000 caractères max)"></textarea>
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
