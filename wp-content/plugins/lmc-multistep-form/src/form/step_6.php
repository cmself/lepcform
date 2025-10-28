<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=5" class="block! w-full!" id="back_step">
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

    <?php if (isset($errors['step6']['name'])): ?>
        <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
            <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step6']['name'] ?></p>
            <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step6']['texte'] ?></p>
        </div>
    <?php endif; ?>



<h4>STEP 1</h4>
<p><strong>Nom de l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_nom']); ?></p>
<p><strong>Numéro de SIRET :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_siret']); ?></p>
<p><strong>logo :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_logo']); ?></p>
<p><strong>Le chiffre d’affaires :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_ca']); ?></p>
<p><strong>Montant des frais pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_frais']); ?></p>
<p><strong>Adhérent Les entreprises pour la Cité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_adherent']); ?></p>
<p><strong>Adresse postale :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_adresse']); ?></p>
<p><strong>Ville :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_ville']); ?></p>
<p><strong>Code postal :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_cp']); ?></p>
<p><strong>Email de l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_email']); ?></p>
<p><strong>Site internet :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_internet']); ?></p>
<p><strong>Nombre de collaborateurs en France :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_collaborateurs']); ?></p>
<p><strong>Secteur d’activité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_activite']); ?></p>
<p><strong>Type de structure :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_structure']); ?></p>
<p><strong>Comment avez-vous eu connaissance de la Charte de la diversité ? :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_connaissance']); ?></p>
<p><strong>Présentation de votre politique diversité et des raisons de votre engagement :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step1_politique']); ?></p>
<br><br>
<h4>STEP 2</h4>
<h5>User 1</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_prenom_0']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_nom_0']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_fonction_0']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_email_0']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_role_0']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_signataire_0']); ?></p>
<h5>User 2</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_prenom_1']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_nom_1']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_fonction_1']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_email_1']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_role_1']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_signataire_1']); ?></p>
<h5>User 3</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_prenom_2']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_nom_2']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_fonction_2']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_email_2']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_role_2']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_signataire_2']); ?></p>
<h5>User 4</h5>
<p><strong>Prénom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_prenom_3']); ?></p>
<p><strong>Nom :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_nom_3']); ?></p>
<p><strong>Fonction dans l’organisation :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_fonction_3']); ?></p>
<p><strong>Email  :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_email_3']); ?></p>
<p><strong>Rôle dans l’organisation pour la Charte de la diversité :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_role_3']); ?></p>
<p><strong>Contact signataire :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step2_signataire_3']); ?></p>
<br><br>
<h4>STEP 3</h4>
<p><strong>2fa :</strong> Validée</p>
<br><br>
<h4>STEP 4</h4>
<p><strong>Engagement 1 :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step4_engagement_1']); ?></p>
<p><strong>Engagement 2 :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step4_engagement_2']); ?></p>
<p><strong>Engagement 3 :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step4_engagement_3']); ?></p>
<p><strong>Engagement 4 :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step4_engagement_4']); ?></p>
<p><strong>Engagement 5 :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step4_engagement_5']); ?></p>
<p><strong>Engagement 6 :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step4_engagement_6']); ?></p>
<br><br>
<h4>STEP 5</h4>
<p><strong>Méthode de paiement :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step5_paiement']); ?></p>

<p><strong>Numéro du bon de commande :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step5_bc']); ?></p>
<p><strong>Aide :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step5_help']); ?></p>
<p><strong>RGPD :</strong> <?php echo esc_html($_SESSION['lmc_data'][$id_session]['step5_rgpd']); ?></p>





<input type="hidden" id="step6_formStartTime" name="step6_formStartTime">
<script>document.getElementById('step6_formStartTime').value = Date.now();</script>
<input type="text" name="step6_honeypot" id="step6_honeypot" style="display:none;">
<input type="hidden" name="step6_csrf_token" id="step6_csrf_token" value="<?php echo $_SESSION['lmc_data'][$id_session]['csrf_token']; ?>">
<input type="hidden" name="step" value="6">
<div class="flex! flex-col md:flex-row gap-[10px] justify-center items-center w-full! text-center! mt-[20px]!">
<button type="submit">Envoyer</button>
</div>

    <script>
        const step_loader = document.getElementById('step_loader');
        const step_content = document.getElementById('step_content');
        const back_step = document.getElementById('back_step');

        back_step.addEventListener('click', () => {
            step_loader.style.display = "block";
            step_content.style.display = "none";
        });
    </script>


</div>


