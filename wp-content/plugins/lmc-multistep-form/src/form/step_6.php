<div class="relative! w-full! min-h-[50px]!">
    <button type="button" class="absolute! top-0! left-0!" id="go-back"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
</div>

<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data']['nom']); ?></p>
<p><strong>Email :</strong> <?php echo esc_html($_SESSION['lmc_data']['email']); ?></p>
<p><strong>Adresse :</strong> <?php echo esc_html($_SESSION['lmc_data']['adresse']); ?></p>
<p><strong>Ville :</strong> <?php echo esc_html($_SESSION['lmc_data']['ville']); ?></p>
<input type="hidden" name="step" value="6">
    <p class="block! w-full! text-center!"><button type="submit">Envoyer</button></p>

