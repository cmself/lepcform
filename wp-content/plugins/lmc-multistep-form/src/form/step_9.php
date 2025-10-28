<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=8" class="block! w-full!">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>

<div class="relative! w-full!">
    <h3>Renouvellement de la signature</h3>
    <h4>Vous êtes le contact principal pour la Charte de la diversité de votre Organisation</h4>
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

    <?php if (isset($errors['step9']['name'])): ?>
        <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
            <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step9']['name'] ?></p>
            <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step9']['texte'] ?></p>
        </div>
    <?php endif; ?>


    <p class="block! w-full! text-center!">
        <label for="code" class="w-full! text-center!"><span class="w-full! text-center!">Entrez le code reçu à l’adresse : <i><?= $_SESSION['lmc_data'][$id_session]['step8_email'] ?></i></span></label>
    </p>
    <p class="flex! flex-row! justify-center! items-center! gap-[10px]! w-full! mb-[40px]!">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step9_pin1" id="step9_pin1" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step9_pin2" id="step9_pin2" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step9_pin3" id="step9_pin3" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step9_pin4" id="step9_pin4" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step9_pin5" id="step9_pin5" data-hs-pin-input-item="">
    </p>

<input type="hidden" id="step9_resend" name="step9_resend" value="0">
<input type="hidden" id="step9_formStartTime" name="step9_formStartTime">
<script>document.getElementById('step9_formStartTime').value = Date.now();</script>
<input type="text" name="step9_honeypot" id="step9_honeypot" style="display:none;">
<input type="hidden" name="step9_csrf_token" id="step9_csrf_token" value="<?php echo $_SESSION['lmc_data'][$id_session]['csrf_token']; ?>">
<input type="hidden" name="step" value="9">
<div class="flex! flex-col md:flex-row gap-[10px] justify-center items-center w-full! text-center!">
    <button type="button" id="resend"><i class="fa-solid fa-rotate-left"></i> Renvoyer le code</button>
    <button formnovalidate type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
</div>

<script>
    const step_loader = document.getElementById('step_loader');
    const step_content = document.getElementById('step_content');
    const form = document.getElementById('form-lmc-multistep-form');
    const resend = document.getElementById('resend');
    const input = document.getElementById('step9_resend');
    resend.addEventListener('click', () => {
        step_loader.style.display = "block";
        step_content.style.display = "none";
        input.value = '1';
        form.submit();
    });
</script>

</div>