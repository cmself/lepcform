<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=4" class="block! w-full!" id="back_step">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>

<div class="relative! w-full!">
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
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

    <?php if (isset($errors['step5']['name'])): ?>
        <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
            <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step5']['name'] ?></p>
            <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step5']['texte'] ?></p>
        </div>
    <?php endif; ?>

<p>
    <label for="step5_paiement"><span>Choisissez votre méthode de paiement :</span>
        <div class="wrapper flex! flex-col! gap-[5px]! w-full!">


            <?php
            if(isset($_SESSION['lmc_data'][$id_session]['step1_adherent']) && $_SESSION['lmc_data'][$id_session]['step1_adherent'] == 0) {
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


            <input type="radio" name="step5_paiement" id="option-5" value="MEMBER" checked>

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
<input type="hidden" name="step5_csrf_token" id="step5_csrf_token" value="<?php echo $_SESSION['lmc_data'][$id_session]['csrf_token']; ?>">
<input type="hidden" name="step" value="5">
<p class="block! w-full! text-center!"><button type="submit">Valider le formulaire <i class="fa-solid fa-arrow-right"></i></button></p>

<script>

    const option_1 = document.querySelector('.option-1');

    const content_2 = document.getElementById('content_2');
    const option_2 = document.querySelector('.option-2');

    const content_3 = document.getElementById('content_3');
    const option_3 = document.querySelector('.option-3');

    const content_4 = document.getElementById('content_4');
    const option_4 = document.querySelector('.option-4');

    if(option_1){
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
    }


    if(option_2) {
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
    }


    if(option_3) {
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
    }


    if(option_4) {
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
    }


        const step_loader = document.getElementById('step_loader');
        const step_content = document.getElementById('step_content');
        const back_step = document.getElementById('back_step');

        back_step.addEventListener('click', () => {
        step_loader.style.display = "block";
        step_content.style.display = "none";
    });



</script>


</div>