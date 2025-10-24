
<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=4" class="block! w-full!">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>
<div class="relative! w-full!">
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
</div>

<p>
    <label for="step5_paiement"><span>Choisissez votre méthode de paiement :</span>
        <div class="wrapper flex! flex-col! gap-[5px]! w-full!">


            <?php
            if(isset($_SESSION['lmc_data']['step1_adherent']) && $_SESSION['lmc_data']['step1_adherent'] == 'false') {
            ?>

            <input type="radio" name="step5_paiement" id="option-1" value="CB" <?php echo ($value_form[0]->step5_paiement == "CB") ? 'checked' : ''; ?>>
            <input type="radio" name="step5_paiement" id="option-2" value="VIREMENT" <?php echo ($value_form[0]->step5_paiement == "VIREMENT") ? 'checked' : ''; ?>>
            <input type="radio" name="step5_paiement" id="option-3" value="FACTURE" <?php echo ($value_form[0]->step5_paiement == "FACTURE") ? 'checked' : ''; ?>>
            <input type="radio" name="step5_paiement" id="option-4" value="AIDE" <?php echo ($value_form[0]->step5_paiement == "AIDE") ? 'checked' : ''; ?>>

                <label for="option-1" class="option option-1">
                    <div class="dot"></div>
                    <div class="flex! flex-row! justify-between! items-center! w-full!">
                        <span>Régler par carte bancaire via le service de paiement sécurisé HelloAsso</span> <img src="<?php echo plugin_dir_url('/') . 'lmc-multistep-form/assets/img/helloasso.png'; ?>">
                    </div>
                </label>

                <label for="option-2" class="option option-2">
                    <div class="dot"></div>
                    <div class="flex! flex-row! justify-between! items-center! w-full!">
                        <span>Régler par virement </span><i class="fa-solid fa-building-columns"></i>
                    </div>
                </label>

                <label for="option-3" class="option option-3">
                    <div class="dot"></div>
                    <div class="flex! flex-row! justify-between! items-center! w-full!">
                        <span>Demander une facture non acquittée</span><i class="fa-regular fa-file-lines"></i>
                    </div>
                </label>

                <label for="option-4" class="option option-4">
                    <div class="dot"></div>
                    <div class="flex! flex-row! justify-between! items-center! w-full!">
                        <span>Besoin d'aide ? Contactez nous</span><i class="fa-regular fa-envelope"></i>
                    </div>
                </label>

            <?php
            }else{
            ?>


            <input type="radio" name="step5_paiement" id="option-5" value="MEMBER" <?php echo ($value_form[0]->step5_paiement == "CB") ? 'checked' : ''; ?>>

                <label for="option-5" class="option option-5">
                    <div class="dot"></div>
                    <div class="flex! flex-row! justify-between! items-center! w-full!">
                        <span>Mon entreprise est adhérente du Réseau LEPC : je ne règle rien</span>
                    </div>
                </label>

            <?php
            }
            ?>


        </div>
    </label>
</p>

<div id="content_2" class="block! w-full! text-left! font-normal! text-[var(--color-blanc)]! text-[24px]! mb-[20px]!">
    <?php if(isset($value_form[0]->step5_paiement) && $value_form[0]->step5_paiement == "VIREMENT"){ ?>
        <div class="div_2">
            Pour régler les frais de signature de la Charte de la diversité, merci d’effectuer un virement sur l’IBAN [insérer IBAN], en veillant à indiquer votre numéro de SIRET dans le libellé du virement. Vous pouvez également télécharger nos coordonnées bancaires en <a href="#" class="text-[var(--color-rose)]!">cliquant ici</a>
        </div>
    <?php  } ?>
</div>
<div id="content_3" class="block! w-full!">
    <?php if(isset($value_form[0]->step5_paiement) && $value_form[0]->step5_paiement == "FACTURE"){ ?>
        <div class="div_3">
           <h4>Vous avez besoin d’une facture non acquittée ou d’un bon de commande ?</h4>
            <p>
                <label for="bc"><span>Numéro du bon de commande * :</span>
                    <input type="text" id="step5_bc" name="step5_bc" placeholder="Numéro" value="<?php echo (isset($value_form[0]->step5_bc) && !empty($value_form[0]->step5_bc)) ? $value_form[0]->step5_bc : ''; ?>" required>
                </label>
            </p>
        </div>
    <?php  } ?>
</div>
<div id="content_4" class="block! w-full!">
    <?php if(isset($value_form[0]->step5_paiement) && $value_form[0]->step5_paiement == "AIDE"){ ?>
        <div class="div_4">
           <p>
               <label for="help"><span>Vous avez besoin d'aide pour réaliser le paiement, merci de nous envoyer un message. (1000 caractères max)</span>
                   <textarea id="step5_help" name="step5_help" rows="10" placeholder="(1000 caractères max)"><?php echo (isset($value_form[0]->step5_help) && !empty($value_form[0]->step5_help)) ? $value_form[0]->step5_help : ''; ?></textarea>
               </label>
           </p>
        </div>
    <?php  } ?>
</div>

<p>
    <label for="step5_rgpd" class="checkbox">
        <input type="checkbox" id="step5_rgpd" name="step5_rgpd" value="1" <?php echo ($value_form[0]->step5_rgpd == 1) ? 'checked' : ''; ?>/>
        <span class="opacity-100!">J'accepte que les informations saisies soient utilisées dans le cadre de la relation qui découle de cette prise de contact. Pour plus d’information, consulter la <a href="#" class="text-[var(--color-rose)]!">politique de confidentialité</a></span>
    </label>
</p>

<p>
<div class="g-recaptcha flex! flex-row! justify-center! items-center! w-full! mb-[40px]!" data-sitekey="6LfNBOorAAAAADz2yypqgW6kOxvqCeBB4T80Ycdt"></div>
</p>

<input type="hidden" id="step5_formStartTime" name="step5_formStartTime">
<script>document.getElementById('step5_formStartTime').value = Date.now();</script>
<input type="text" name="step5_honeypot" id="step5_honeypot" style="display:none;">
<input type="hidden" name="step5_csrf_token" id="step5_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">
<input type="hidden" name="step" value="6">
<p class="block! w-full! text-center!"><button type="submit">Valider le formulaire <i class="fa-solid fa-arrow-right"></i></button></p>

<script>

    const option_1 = document.querySelector('.option-1');

    const content_2 = document.getElementById('content_2');
    const option_2 = document.querySelector('.option-2');

    const content_3 = document.getElementById('content_3');
    const option_3 = document.querySelector('.option-3');

    const content_4 = document.getElementById('content_4');
    const option_4 = document.querySelector('.option-4');

    option_1.addEventListener('click', () => {

        const element_2 = document.querySelector('.div_2');
        const element_3 = document.querySelector('.div_3');
        const element_4 = document.querySelector('.div_4');

        if(element_2){
            element_2.remove();
        }
        if(element_3){
            element_3.remove();
        }
        if(element_4){
            element_4.remove();
        }

    });



    option_2.addEventListener('click', () => {

        const element_2 = document.querySelector('.div_2');
        const element_3 = document.querySelector('.div_3');
        const element_4 = document.querySelector('.div_4');



            if (element_2) {
                element_2.remove();
            }
            if (element_3) {
                element_3.remove();
            }
            if (element_4) {
                element_4.remove();
            }

            const div_2 = document.createElement('div');
            div_2.classList.add('div_2');
            div_2.innerHTML = `Pour régler les frais de signature de la Charte de la diversité, merci d’effectuer un virement sur l’IBAN [insérer IBAN], en veillant à indiquer votre numéro de SIRET dans le libellé du virement. Vous pouvez également télécharger nos coordonnées bancaires en <a href="#" class="text-[var(--color-rose)]!">cliquant ici</a>.`;
            content_2.appendChild(div_2);


    });



    option_3.addEventListener('click', () => {

        const element_2 = document.querySelector('.div_2');
        const element_3 = document.querySelector('.div_3');
        const element_4 = document.querySelector('.div_4');


            if (element_2) {
                element_2.remove();
            }
            if (element_3) {
                element_3.remove();
            }
            if (element_4) {
                element_4.remove();
            }

            const div_3 = document.createElement('div');
            div_3.classList.add('div_3');
            div_3.innerHTML = `<h4>Vous avez besoin d’une facture non acquittée ou d’un bon de commande ?</h4><p><label for="bc"><span>Numéro du bon de commande * :</span> <input type="text" id="step5_bc" name="step5_bc" placeholder="Numéro" value="<?php echo (isset($value_form[0]->step5_bc) && !empty($value_form[0]->step5_bc)) ? $value_form[0]->step5_bc : ''; ?>" required></label></p>`;
            content_3.appendChild(div_3);

    });



    option_4.addEventListener('click', () => {

        const element_2 = document.querySelector('.div_2');
        const element_3 = document.querySelector('.div_3');
        const element_4 = document.querySelector('.div_4');

            if (element_2) {
                element_2.remove();
            }
            if (element_3) {
                element_3.remove();
            }
            if (element_4) {
                element_4.remove();
            }

            const div_4 = document.createElement('div');
            div_4.classList.add('div_3');
            div_4.innerHTML = `<p><label for="help"><span>Vous avez besoin d'aide pour réaliser le paiement, merci de nous envoyer un message. (1000 caractères max)</span><textarea id="step5_help" name="step5_help" rows="10" placeholder="(1000 caractères max)"><?php echo (isset($value_form[0]->step5_help) && !empty($value_form[0]->step5_help)) ? $value_form[0]->step5_help : ''; ?></textarea></label></p>`;
            content_4.appendChild(div_4);


    });


</script>
