<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=5" class="block! w-full!">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>
<div class="relative! w-full!">
    <h3>Étape 4 : Paiement</h3>
    <h4>Vous recevrez une facture acquittée ainsi que la charte dès réception de votre règlement.</h4>
</div>

<h4>STEP 1</h4>
<p><strong>Nom de l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_nom']); ?></p>
<p><strong>Numéro de SIRET :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_siret']); ?></p>
<p><strong>logo :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_logo']); ?></p>
<p><strong>Le chiffre d’affaires :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_ca']); ?></p>
<p><strong>Montant des frais pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_frais']); ?></p>
<p><strong>Adhérent Les entreprises pour la Cité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_adherent']); ?></p>
<p><strong>Adresse postale :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_adresse']); ?></p>
<p><strong>Ville :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_ville']); ?></p>
<p><strong>Code postal :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_cp']); ?></p>
<p><strong>Email de l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_email']); ?></p>
<p><strong>Site internet :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_internet']); ?></p>
<p><strong>Nombre de collaborateurs en France :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_collaborateurs']); ?></p>
<p><strong>Secteur d’activité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_activite']); ?></p>
<p><strong>Type de structure :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_structure']); ?></p>
<p><strong>Comment avez-vous eu connaissance de la Charte de la diversité ? :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_connaissance']); ?></p>
<p><strong>Présentation de votre politique diversité et des raisons de votre engagement :</strong> <?php echo esc_html($_SESSION['lmc_data']['step1_politique']); ?></p>
<br><br>
<h4>STEP 2</h4>
<h5>User 1</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_prenom_0']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_nom_0']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_fonction_0']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_email_0']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_role_0']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_signataire_0']); ?></p>
<h5>User 2</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_prenom_1']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_nom_1']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_fonction_1']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_email_1']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_role_1']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_signataire_1']); ?></p>
<h5>User 3</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_prenom_2']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_nom_2']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_fonction_2']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_email_2']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_role_2']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_signataire_2']); ?></p>
<h5>User 4</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_prenom_3']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_nom_3']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_fonction_3']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_email_3']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_role_3']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data']['step2_signataire_3']); ?></p>
<br><br>
<h4>STEP 3</h4>
<p><strong>2fa :</strong> <?php echo esc_html($_SESSION['lmc_data']['step3_2fa']); ?></p>
<br><br>
<h4>STEP 4</h4>
<p><strong>Engagement 1 :</strong> <?php echo esc_html($_SESSION['lmc_data']['step4_engagement_1']); ?></p>
<p><strong>Engagement 2 :</strong> <?php echo esc_html($_SESSION['lmc_data']['step4_engagement_2']); ?></p>
<p><strong>Engagement 3 :</strong> <?php echo esc_html($_SESSION['lmc_data']['step4_engagement_3']); ?></p>
<p><strong>Engagement 4 :</strong> <?php echo esc_html($_SESSION['lmc_data']['step4_engagement_4']); ?></p>
<p><strong>Engagement 5 :</strong> <?php echo esc_html($_SESSION['lmc_data']['step4_engagement_5']); ?></p>
<p><strong>Engagement 6 :</strong> <?php echo esc_html($_SESSION['lmc_data']['step4_engagement_6']); ?></p>
<br><br>
<h4>STEP 5</h4>
<p><strong>Méthode de paiement :</strong> <?php echo esc_html($_SESSION['lmc_data']['step5_paiement']); ?></p>

<p><strong>Numéro du bon de commande :</strong> <?php echo esc_html($_SESSION['lmc_data']['step5_bc']); ?></p>
<p><strong>Aide :</strong> <?php echo esc_html($_SESSION['lmc_data']['step5_help']); ?></p>
<p><strong>RGPD :</strong> <?php echo esc_html($_SESSION['lmc_data']['step5_rgpd']); ?></p>





<input type="hidden" id="step6_formStartTime" name="step6_formStartTime">
<script>document.getElementById('step6_formStartTime').value = Date.now();</script>
<input type="text" name="step6_honeypot" id="step6_honeypot" style="display:none;">
<input type="hidden" name="step6_csrf_token" id="step6_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">
<input type="hidden" name="step" value="7">
<div class="flex! flex-col md:flex-row gap-[10px] justify-center items-center w-full! text-center! mt-[20px]!">
<button type="submit">Envoyer</button>
</div>

