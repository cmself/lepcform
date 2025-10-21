
<?php if(isset($stepMAJ) && $stepMAJ === 1){ ?>


<div class="w-full! mb-[20px]!">
    <a href="<?= getCurrentUrl();?>?reload_step=8" class="block! w-full!">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>

    <div class="relative! w-full!">
        <h3>Renouvellement de la signature</h3>
       <?php if(isset($step0_message)) { ?>
        <h5><?= $step0_message; ?></h5>
        <?php } ?>
    </div>

    <p class="block! w-full! text-center!">
        <label for="code" class="w-full! text-center!"><span class="w-full! text-center!">Entrez le code reçu à l’adresse : <i><?= $_SESSION['lmc_data']['step0_email'] ?></i></span></label>
    </p>
    <p class="flex! flex-row! justify-center! items-center! gap-[10px]! w-full! mb-[40px]!">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step0_pin1" id="step0_pin1" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step0_pin2" id="step0_pin2" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step0_pin3" id="step0_pin3" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step0_pin4" id="step0_pin4" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step0_pin5" id="step0_pin5" data-hs-pin-input-item="">
    </p>

    <input type="hidden" id="step0_email" name="step0_email" placeholder="Email" value="<?= $_SESSION['lmc_data']['step0_email'] ?>">
    <input type="hidden" id="step0_otp" name="step0_otp" value="1">
    <input type="hidden" name="step" value="8">
    <input type="hidden" id="step0_formStartTime" name="step0_formStartTime">
    <script>document.getElementById('step0_formStartTime').value = Date.now();</script>
    <input type="text" name="step0_honeypot" id="step0_honeypot" style="display:none;">
    <input type="hidden" name="step0_csrf_token" id="step0_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">

    <div class="flex! flex-col md:flex-row gap-[10px] justify-center items-center w-full! text-center!">
        <button type="button" id="resend"><i class="fa-solid fa-rotate-left"></i> Renvoyer le code</button>
        <button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
    </div>

    <script>
        const form = document.getElementById('form-lmc-multistep-form');
        const resend = document.getElementById('resend');
        const input = document.getElementById('step0_otp');
        resend.addEventListener('click', () => {
            input.value = '0';
            form.submit();
        });
    </script>


<?php }elseif(isset($stepMAJ) && $stepMAJ === 2){ ?>

    <div class="w-full! mb-[20px]!">
        <a href="<?= getCurrentUrl();?>?reload_step=8" class="block! w-full!">
            <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
        </a>
    </div>

    <div class="relative! w-full!">
        <h3>Renouvellement de la signature</h3>
        <h5>Validation en cours. Veuillez patienter</h5>
        <div class="w-full! text-center!"><img src="<?= plugins_url('lmc-multistep-form/assets/img/loader.gif') ?>" alt="loader" class="loader inline-block!"></div>
    </div>


<?php } else { ?>

    <div class="relative! w-full!">
        <h3>Renouvellement de la signature</h3>
        <h4>Vous êtes le contact principal pour la Charte de la diversité de votre Organisation</h4>
        <?php if(isset($step0_message)) { ?>
        <h5><?= $step0_message; ?></h5>
        <?php } ?>
    </div>
    <p>
        <label for="step1_email"><span>Entrer l'email du contact principal de la signature initiale * :</span> <input type="email" id="step0_email" name="step0_email" placeholder="Email" required></label>
    </p>

    <div class="relative! w-full! text-center! mb-[100px]">
        <button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
    </div>

    <input type="hidden" id="step0_otp" name="step0_otp" value="0">
    <input type="hidden" name="step" value="8">
    <input type="hidden" id="step0_formStartTime" name="step0_formStartTime">
    <script>document.getElementById('step0_formStartTime').value = Date.now();</script>
    <input type="text" name="step0_honeypot" id="step0_honeypot" style="display:none;">
    <input type="hidden" name="step0_csrf_token" id="step0_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">
    <div class="flex! flex-col md:flex-row gap-[10px] justify-between items-center w-full!">
        <div class="w-2/3! text-center!">
            <p>Le contact principal de la Charte pour votre entreprise a changé ?</p>
            <button type="button" id="change" class="mt-[20px]!">Demander un accès en tant que nouveau contact principal <i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div class="w-1/3! text-center!">
            <p>Besoin d'aide ?</p>
            <button type="button" id="faq" class="mt-[20px]!">Consultez la FAQ <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
<?php } ?>
