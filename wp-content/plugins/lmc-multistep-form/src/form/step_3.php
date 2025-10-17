<div class="relative! w-full! min-h-[50px]!">
    <button type="button" class="absolute! top-0! left-0!" id="go-back"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    <h3>Étape 2 : Interlocuteurs</h3>
    <h4>Validation du contact principal</h4>
    <?php
    if(isset($stepMAJ) && $stepMAJ == 4){
        ?>
        <h5>Validation en cours. Veuillez patienter</h5>
        <div class="w-full! text-center!"><img src="<?= plugins_url('lmc-multistep-form/assets/img/loader.gif') ?>" alt="loader" class="loader inline-block!"></div>
        <?php
    }else{
    if(isset($step3_otp) && !empty($step3_otp)){
    ?>
    <h5><?= $step3_otp ?></h5>
        <?php
    }}
    ?>
</div>

    <p class="block! w-full! text-center!">
        <label for="code" class="w-full! text-center!"><span class="w-full! text-center!">Entrez le code reçu à l’adresse : <i><?= $_SESSION['lmc_data']['step2_email_0'] ?></i></span></label>
    </p>
    <p class="flex! flex-row! justify-center! items-center! gap-[10px]! w-full! mb-[40px]!">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step3_pin1" id="step3_pin1" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step3_pin2" id="step3_pin2" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step3_pin3" id="step3_pin3" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step3_pin4" id="step3_pin4" data-hs-pin-input-item="">
        <input type="text" maxlength="1" pattern="[0-9]{1}" class="twofpin" placeholder="0" name="step3_pin5" id="step3_pin5" data-hs-pin-input-item="">
    </p>

<input type="hidden" id="step3_otp" name="step3_otp" value="1">
<input type="hidden" id="step3_formStartTime" name="step3_formStartTime">
<script>document.getElementById('step3_formStartTime').value = Date.now();</script>
<input type="text" name="step3_honeypot" id="step3_honeypot" style="display:none;">
<input type="hidden" name="step3_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">
<?php
if(isset($stepMAJ) && $stepMAJ == 4){
    ?>
    <input type="hidden" name="step" value="4">
    <?php
} else {
    ?>
    <input type="hidden" name="step" value="3">
    <?php
}
?>
<p class="block! w-full! text-center!">
    <button type="button" id="resend"><i class="fa-solid fa-rotate-left"></i> Renvoyer le code</button>
    <button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
</p>

<script>
    const form = document.getElementById('form-lmc-multistep-form');
    const resend = document.getElementById('resend');
    const input = document.getElementById('step3_otp');
    resend.addEventListener('click', () => {
        input.value = '2';
        form.submit();
    });

    <?php
    if(isset($stepMAJ) && $stepMAJ == 4){
    ?>
    form.submit();
    <?php
    }
    ?>




</script>
