<div class="relative! w-full!">
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
    <h5 class="inline-block! w-full! text-center!"><?= $messageFin; ?></h5>
</div>

<?php if (isset($errors['step7']['name'])): ?>
    <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
        <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step7']['name'] ?></p>
        <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step7']['texte'] ?></p>
    </div>
<?php else: ?>

    <?php if(isset($_POST['step']) && $_POST['step'] == 7): ?>

        <h5>Veuillez patienter ...</h5>
        <div class="w-full! text-center!"><img src="<?= plugins_url('lmc-multistep-form/assets/img/loader.gif') ?>" alt="loader" class="loader inline-block!"></div>

    <?php endif; ?>

<?php endif; ?>

