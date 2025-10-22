<div class="w-full! mb-[20px]!">
    <a href="<?= lmc_multistep_form__getCurrentUrl();?>?reload_step=3" class="block! w-full!">
        <button type="button"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    </a>
</div>
<div class="relative! w-full!">
    <h3>Étape 3 : Votre politique de diversité</h3>
</div>

<p><label for="step4_engagement_1"><span>Engagement 1 -  Sensibiliser et former nos dirigeants et managers <i>impliqués dans le recrutement, la formation et la gestion des carrières, puis progressivement l’ensemble des collaborateurs aux enjeux de la non-discrimination et de la diversité</i></span>
        <select name="step4_engagement_1" id="step4_engagement_1" required>
            <?php
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_1_sensibiliser_et_former_nos_dirigeants_et_managers']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_1_sensibiliser_et_former_nos_dirigeants_et_managers']['options'] as $option):
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
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_2_promouvoir_lapplication_du_principe_de_non_discrimination']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_2_promouvoir_lapplication_du_principe_de_non_discrimination']['options'] as $option):
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
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_3_favoriser_la_representation_de_la_diversite_de_la_societe_francaise']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_3_favoriser_la_representation_de_la_diversite_de_la_societe_francaise']['options'] as $option):
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
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_4_communiquer_sur_notre_engagement']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_4_communiquer_sur_notre_engagement']['options'] as $option):
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
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_5_faire_de_lelaboration_et_de_la_mise_en_oeuvre_de_la_politique_de_diversite_un_objet_de_dialogue_social_avec_les_representants_du_personnel']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_5_faire_de_lelaboration_et_de_la_mise_en_oeuvre_de_la_politique_de_diversite_un_objet_de_dialogue_social_avec_les_representants_du_personnel']['options'] as $option):
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
            if ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_6_evaluer_regulierement_les_progres_realises']['options']):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($_SESSION['lmc_data']['ohme_data']['Structure']['engagement_6_evaluer_regulierement_les_progres_realises']['options'] as $option):
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
<input type="hidden" name="step4_csrf_token" id="step4_csrf_token" value="<?php echo $_SESSION['lmc_data']['csrf_token']; ?>">
<input type="hidden" name="step" value="5">
<p class="block! w-full! text-center! text-[var(--color-blanc)]! text-[20px]! font-light! py-[20px]! opacity-50!">* champs nécessaires pour valider l’étape</p>
<p class="block! w-full! text-center!"><button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button></p>

