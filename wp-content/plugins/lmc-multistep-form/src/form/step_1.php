<h3>Étape 1 : Organisation signataire</h3>
<p><label for="nom"><span>Nom de l’organisation * :</span> <input type="text" id="nom" name="nom" placeholder="Nom de l’organisation" required></label></p>
<p><label for="siret"><span>Numéro de SIRET * :</span> <input type="text" id="siret" name="siret" placeholder="SIRET" required></label></p>
<p><label for="logo"><span>Ajouter un logo :</span> <input type="file" id="logo" name="logo" placeholder="Logo"></label></p>
<p><label for="ca"><span>Le chiffre d’affaires * :</span>
        <select name="ca" id="ca" required>
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
<p><label for="frais"><span>Montant des frais pour la Charte de la diversité * :</span>
        <select name="frais" id="frais" required>
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
            <input type="radio" name="select" id="option-1">
            <input type="radio" name="select" id="option-2">
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
<p><label for="adresse"><span>Adresse postale * :</span> <input type="text" id="adresse" name="adresse" placeholder="Adresse" required></label></p>

<div class="coltwo">
    <div class="w-full">
        <p>
            <label for="ville"><span>Ville * :</span> <input type="text" id="ville" name="ville" placeholder="ville" required></label>
        </p>
    </div>
    <div class="w-full">
        <p>
            <label for="cp"><span>Code postal * :</span> <input type="text" id="cp" name="cp" placeholder="00000" required></label>
        </p>
    </div>
</div>

<div class="coltwo">
    <div class="w-full">
        <p>
            <label for="email"><span>Email de l’organisation * :</span> <input type="email" id="email" name="email" placeholder="Email" required></label>
        </p>
    </div>
    <div class="w-full">
        <p>
            <label for="internet"><span>Site internet * :</span> <input type="url" id="internet" name="internet" placeholder="Url du site" required></label>
        </p>
    </div>
</div>

<p><label for="collaborateurs"><span>Nombre de collaborateurs en France * :</span>
        <select name="collaborateurs" id="collaborateurs" required>
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

<p><label for="activite"><span>Secteur d’activité :</span>
        <select name="activite" id="activite">
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

<p><label for="structure"><span>Type de structure :</span>
        <select name="structure" id="structure">
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

<p><label for="connaissance"><span>Comment avez-vous eu connaissance de la Charte de la diversité ? :</span>
        <select name="connaissance" id="connaissance" required>
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
    <label for="politique"><span>Présentation de votre politique diversité et des raisons de votre engagement (1000 caractères max)</span>
        <textarea id="politique" name="politique" rows="10" placeholder="Présentation (1000 caractères max)"></textarea>
    </label>
</p>

<p>
    <label for="politique"><span>Date de la dernière signature de la Charte : <i class="value">17/12/2024</i></span></label>
</p>

<input type="hidden" name="step" value="2">
<p class="block w-full text-center text-[var(--color-blanc)] text-[20px] font-light py-[20px] opacity-50">* champs nécessaires pour valider l’étape</p>
<p class="block w-full text-center"><button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button></p>
