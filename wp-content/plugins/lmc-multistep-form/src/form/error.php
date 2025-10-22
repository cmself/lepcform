
    <div class="w-full! mb-[20px]!">
        <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=<?= $_SESSION['lmc_data']['error_step']; ?>" class="block! w-full!">
            <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
        </a>
    </div>

    <div class="relative! w-full!">
        <h4>Nous sommes désolés ....</h4>
        <div class="w-full! text-center!">
            <h5><?= $_SESSION['lmc_data']['$error_message']; ?></h5>
        </div>
    </div>
