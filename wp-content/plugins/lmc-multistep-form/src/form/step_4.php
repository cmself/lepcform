<div class="relative w-full min-h-[50px]">
    <button type="button" class="absolute top-0 left-0" id="go-back"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    <h3>Étape 3 : Votre politique de diversité</h3>
</div>

<p><label for="frais"><span>Engagement 1 -  Sensibiliser et former nos dirigeants et managers <i>impliqués dans le recrutement, la formation et la gestion des carrières, puis progressivement l’ensemble des collaborateurs aux enjeux de la non-discrimination et de la diversité</i></span>
        <select name="frais" id="frais" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="frais"><span>Engagement 2 -  Promouvoir l’application du principe de non-discrimination <i>sous toutes ses formes dans tous les actes de management et de décision de l’entreprise ou de l’organisation et en particulier dans toutes les étapes de la gestion des ressources humaines</i></span>
        <select name="frais" id="frais" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="frais"><span>Engagement 3 -  Favoriser la représentation de la diversité de la société française <i>dans toutes ses différences et ses richesses, culturelle, ethnique et sociale, au sein des effectifs et à tous les niveaux de responsabilité</i></span>
        <select name="frais" id="frais" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="frais"><span>Engagement 4 -  Communiquer sur notre engagement <i>auprès de l’ensemble de nos collaborateurs ainsi qu’à nos clients, partenaires et fournisseurs, afin de les encourager au respect et au déploiement de ces principes</i></span>
        <select name="frais" id="frais" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="frais"><span>Engagement 5 -  Faire de l’élaboration et de la mise en œuvre de la politique <i>de diversité un objet de dialogue social avec les représentants du personnel</i></span>
        <select name="frais" id="frais" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>

<p><label for="frais"><span>Engagement 6 -  Evaluer régulièrement les progrès réalisés, <i>informer en interne comme en externe des résultats pratiques résultant de la mise en œuvre de nos engagements</i></span>
        <select name="frais" id="frais" required>
            <?php
            if ($options):
                ?>
                <option>Choisir une réponse</option>
                <?php
                foreach ($options as $option):
                    ?>
                    <option value="<?= $option ;?>"><?= $option ;?></option>
                <?php
                endforeach;
            endif;
            ?>
        </select>
    </label>
</p>


<input type="hidden" name="step" value="5">
<p class="block w-full text-center text-[var(--color-blanc)] text-[20px] font-light py-[20px] opacity-50">* champs nécessaires pour valider l’étape</p>
<p class="block w-full text-center"><button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button></p>

