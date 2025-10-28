<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=3" class="block! w-full!">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>


<div class="relative! w-full!">
    <h3>Étape 3 : Votre politique de diversité</h3>
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

    <?php if (isset($errors['step4']['name'])): ?>
        <div class="error bg-[var(--color-error)] border border-[var(--color-blanc)] px-4 py-3 my-[20px] relative w-full!">
            <p class="text-[26px] texte-[var(--color-blanc)]"><?=$errors['step4']['name'] ?></p>
            <p class="text-[16px] texte-[var(--color-blanc)]"><?=$errors['step4']['texte'] ?></p>
        </div>
    <?php endif; ?>


<p><label for="step4_engagement_1"><span>Engagement 1 -  Sensibiliser et former nos dirigeants et managers <i>impliqués dans le recrutement, la formation et la gestion des carrières, puis progressivement l’ensemble des collaborateurs aux enjeux de la non-discrimination et de la diversité</i></span>
        <select name="step4_engagement_1" id="step4_engagement_1" required>
            <?php
            if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_1_sensibiliser_et_former_nos_dirigeants_et_managers']['options']):
                ?>
                <option value="">Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_1_sensibiliser_et_former_nos_dirigeants_et_managers']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step4_engagement_1 == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step4_engagement_2"><span>Engagement 2 -  Promouvoir l’application du principe de non-discrimination <i>sous toutes ses formes dans tous les actes de management et de décision de l’entreprise ou de l’organisation et en particulier dans toutes les étapes de la gestion des ressources humaines</i></span>
        <select name="step4_engagement_2" id="step4_engagement_2" required>
            <?php
            if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_2_promouvoir_lapplication_du_principe_de_non_discrimination']['options']):
                ?>
                <option value="">Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_2_promouvoir_lapplication_du_principe_de_non_discrimination']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step4_engagement_2 == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step4_engagement_3"><span>Engagement 3 -  Favoriser la représentation de la diversité de la société française <i>dans toutes ses différences et ses richesses, culturelle, ethnique et sociale, au sein des effectifs et à tous les niveaux de responsabilité</i></span>
        <select name="step4_engagement_3" id="step4_engagement_3" required>
            <?php
            if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_3_favoriser_la_representation_de_la_diversite_de_la_societe_francaise']['options']):
                ?>
                <option value="">Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_3_favoriser_la_representation_de_la_diversite_de_la_societe_francaise']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step4_engagement_3 == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step4_engagement_4"><span>Engagement 4 -  Communiquer sur notre engagement <i>auprès de l’ensemble de nos collaborateurs ainsi qu’à nos clients, partenaires et fournisseurs, afin de les encourager au respect et au déploiement de ces principes</i></span>
        <select name="step4_engagement_4" id="step4_engagement_4" required>
            <?php
            if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_4_communiquer_sur_notre_engagement']['options']):
                ?>
                <option value="">Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_4_communiquer_sur_notre_engagement']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step4_engagement_4 == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step4_engagement_5"><span>Engagement 5 -  Faire de l’élaboration et de la mise en œuvre de la politique <i>de diversité un objet de dialogue social avec les représentants du personnel</i></span>
        <select name="step4_engagement_5" id="step4_engagement_5" required>
            <?php
            if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_5_faire_de_lelaboration_et_de_la_mise_en_oeuvre_de_la_politique_de_diversite_un_objet_de_dialogue_social_avec_les_representants_du_personnel']['options']):
                ?>
                <option value="">Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_5_faire_de_lelaboration_et_de_la_mise_en_oeuvre_de_la_politique_de_diversite_un_objet_de_dialogue_social_avec_les_representants_du_personnel']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step4_engagement_5 == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="step4_engagement_6"><span>Engagement 6 -  Evaluer régulièrement les progrès réalisés, <i>informer en interne comme en externe des résultats pratiques résultant de la mise en œuvre de nos engagements</i></span>
        <select name="step4_engagement_6" id="step4_engagement_6" required>
            <?php
            if ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_6_evaluer_regulierement_les_progres_realises']['options']):
                ?>
                <option value="">Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data'][$id_session]['ohme_data']['Structure']['engagement_6_evaluer_regulierement_les_progres_realises']['options'] as $option):
                    ?>
                    <option value="<?= htmlspecialchars($option) ;?>" <?php echo ($value_form[0]->step4_engagement_6 == htmlspecialchars($option)) ? 'selected' : ''; ?>><?= htmlspecialchars($option) ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<input type="hidden" id="step4_formStartTime" name="step4_formStartTime">
<script>document.getElementById('step4_formStartTime').value = Date.now();</script>
<input type="text" name="step4_honeypot" id="step4_honeypot" style="display:none;">
<input type="hidden" name="step4_csrf_token" id="step4_csrf_token" value="<?php echo $_SESSION['lmc_data'][$id_session]['csrf_token']; ?>">
<input type="hidden" name="step" value="4">
<p class="block! w-full! text-center! text-[var(--color-blanc)]! text-[20px]! font-light! py-[20px]! opacity-50!">* champs nécessaires pour valider l’étape</p>
<p class="block! w-full! text-center!"><button formnovalidate type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button></p>

</div>