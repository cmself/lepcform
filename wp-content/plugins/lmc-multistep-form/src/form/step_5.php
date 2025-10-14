<div class="relative w-full min-h-[50px]">
    <button type="button" class="absolute top-0 left-0" id="go-back"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
</div>

<p>
    <label for="nom"><span>Choisissez votre méthode de paiement :</span>
        <div class="wrapper">
            <input type="radio" name="select" id="option-1">
            <input type="radio" name="select" id="option-2">
            <input type="radio" name="select" id="option-3">
            <input type="radio" name="select" id="option-4">
            <div class="flex flex-col w-full gap-[5px]">
                <label for="option-1" class="option option-1">
                    <div class="dot"></div>
                    <div class="flex flex-row justify-between items-center w-full">
                    <span>Régler par carte bancaire via le service de paiement sécurisé HelloAsso</span> <img src="<?php echo plugin_dir_url('/') . 'lmc-multistep-form/assets/img/helloasso.png'; ?>">
                    </div>
                </label>
                <label for="option-2" class="option option-2">
                    <div class="dot"></div>
                    <div class="flex flex-row justify-between items-center w-full">
                    <span>Régler par virement </span><i class="fa-solid fa-building-columns"></i>
                    </div>
                </label>
                <label for="option-3" class="option option-3">
                    <div class="dot"></div>
                    <div class="flex flex-row justify-between items-center w-full">
                    <span>Demander une facture non acquittée</span><i class="fa-regular fa-file-lines"></i>
                    </div>
                </label>
                <label for="option-4" class="option option-4">
                    <div class="dot"></div>
                    <div class="flex flex-row justify-between items-center w-full">
                    <span>Besoin d'aide ? Contactez nous</span><i class="fa-regular fa-envelope"></i>
                    </div>
                </label>
            </div>
        </div>
    </label>
</p>

<p>
    <label for="politique" class="checkbox">
        <input type="checkbox" id="politique" name="politique"/>
        <span>J'accepte que les informations saisies soient utilisées dans le cadre de la relation qui découle de cette prise de contact. Pour plus d’information, consulter la <a href="#" class="text-[var(--color-rose)]!">politique de confidentialité</a></span>
    </label>
</p>

<input type="hidden" name="step" value="6">
<p class="block w-full text-center"><button type="submit">Valider le formulaire <i class="fa-solid fa-arrow-right"></i></button></p>

