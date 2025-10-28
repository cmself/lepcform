<div class="relative! w-full!">
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
</div>

<div class="w-full!" id="step_content">
    <h5 class="inline-block! w-full! text-center!"><?= isset($messageFin) ? $messageFin : "";  ?></h5>
</div>

<?php
sleep(10);
header('Location: ' . lmc_multistep_form__getCurrentUrlWithoutQuery() .'?reload_step=1');
?>


