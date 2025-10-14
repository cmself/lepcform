<div class="relative! w-full! min-h-[50px]!">
    <button type="button" class="absolute! top-0! left-0!" id="go-back"><i class="fa-solid fa-arrow-left"></i> Retour</button>
    <h3>Étape 2 : Interlocuteurs</h3>
    <h4>Informations du contact principal</h4>
</div>

    <div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="prenom_0"><span>Prénom * :</span> <input type="text" id="prenom_0" name="prenom_0"
                                                                   placeholder="Prénom" required></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="nom_0"><span>Nom * :</span> <input type="text" id="nom_0" name="nom_0" placeholder="Nom" required></label>
            </p>
        </div>
    </div>

    <p><label for="fonction_0"><span>Fonction dans l’organisation * :</span>
            <select name="fonction_0" id="fonction_0" required>
                <?php
                if ($options):
                    ?>
                    <option>Choisir une réponse</option>
                    <?php
                    foreach ($options as $option):
                        ?>
                        <option value="<?= $option; ?>"><?= $option; ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>

    <p>
        <label for="email_0"><span>Email * :</span> <input type="email" id="email_0" name="email_0" placeholder="Email"
                                                         required></label>
    </p>

    <p><label for="role_0"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
            <select name="role_0" id="role_0" required>
                <?php
                if ($options):
                    ?>
                    <option>Choisir une réponse</option>
                    <?php
                    foreach ($options as $option):
                        ?>
                        <option value="<?= $option; ?>"><?= $option; ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </label>
    </p>

    <p>
        <label for="signataire_0" class="checkbox"><input type="checkbox" id="signataire_0"
                                                  name="signataire_0"/><span>Contact signataire</span> <i
                    class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
    </p>

    <div class="useradd"></div>


    <input type="hidden" name="step" value="3">
    <p class="block! w-full! text-center! text-[var(--color-blanc)]! text-[20px]! font-light! py-[20px]! opacity-50!">* champs
        nécessaires pour valider l’étape</p>
    <p class="block! w-full! text-center!">
        <button type="button" id="addBtn"><i class="fa-solid fa-user-plus mr-[20px]"></i> Ajouter un contact</button>
        <button type="submit">Valider <i class="fa-solid fa-arrow-right"></i></button>
    </p>


<style>
    .tippy-box[data-theme~='lmc'] {
        background-color: var(--color-purple);
        color: var(--color-blanc);
        padding: 10px;
    }
    .tippy-box[data-theme~='lmc'][data-placement^='top'] > .tippy-arrow::before {
        border-top-color: var(--color-purple);
    }
    .tippy-box[data-theme~='lmc'][data-placement^='bottom'] > .tippy-arrow::before {
        border-bottom-color: var(--color-purple);
    }
    .tippy-box[data-theme~='lmc'][data-placement^='left'] > .tippy-arrow::before {
        border-left-color: var(--color-purple);
    }
    .tippy-box[data-theme~='lmc'][data-placement^='right'] > .tippy-arrow::before {
        border-right-color: var(--color-purple);
    }
</style>

<script>

    const container = document.querySelector('.useradd');
    const addBtn = document.getElementById('addBtn');
    const maxContacts = 3;    

    addBtn.addEventListener('click', () => {
        const currentContacts = container.querySelectorAll('.user').length;

        if (currentContacts < maxContacts) {
            const newDiv = document.createElement('div');
            newDiv.classList.add('user');
            newDiv.id = 'N_' + (currentContacts+1);
            newDiv.innerHTML = `
            <div class="relative! w-full! min-h-[50px]!">
            <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_` + (currentContacts+1) + `')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
                <h4>` + (currentContacts+2) + `ème contact </h4>
            </div>


<div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="prenom_` + (currentContacts+1) + `"><span>Prénom * :</span> <input type="text" id="prenom_` + (currentContacts+1) + `" name="prenom_` + (currentContacts+1) + `"
                                                                   placeholder="Prénom" required></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="nom-` + (currentContacts+1) + `"><span>Nom * :</span> <input type="text" id="nom_` + (currentContacts+1) + `" name="nom_` + (currentContacts+1) + `" placeholder="Nom" required></label>
            </p>
        </div>
    </div>

    <p><label for="fonction_` + (currentContacts+1) + `"><span>Fonction dans l’organisation * :</span>
            <select name="fonction_` + (currentContacts+1) + `" id="fonction_` + (currentContacts+1) + `" required>
                <?php
            if ($options):
            ?>
                <option>Choisir une réponse</option>
            <?php
            foreach ($options as $option):
            ?>
                        <option value="<?= $option; ?>"><?= $option; ?></option>
                    <?php
            endforeach;
            endif;
            ?>
            </select>
        </label>
    </p>

    <p>
        <label for="email_` + (currentContacts+1) + `"><span>Email * :</span> <input type="email" id="email_` + (currentContacts+1) + `" name="email_` + (currentContacts+1) + `" placeholder="Email"
                                                         required></label>
    </p>

    <p><label for="role_` + (currentContacts+1) + `"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
            <select name="role_` + (currentContacts+1) + `" id="role_` + (currentContacts+1) + `" required>
                <?php
            if ($options):
            ?>
                <option>Choisir une réponse</option>
            <?php
            foreach ($options as $option):
            ?>
                        <option value="<?= $option; ?>"><?= $option; ?></option>
                    <?php
            endforeach;
            endif;
            ?>
            </select>
        </label>
    </p>

    <p>
        <label class="checkbox"><input type="checkbox" id="signataire_` + (currentContacts+1) + `"
                                                  name="signataire_` + (currentContacts+1) + `"/><span>Contact signataire</span> <i
                    class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
    </p>`;
            container.appendChild(newDiv);
            if (currentContacts == 2){
                addBtn.style.display = 'none';
            }

            tippy('[data-tippy-content]', {
                theme: 'lmc',
            });

        } else {
            addBtn.style.display = 'none';
        }
    });

    function suppUser(id) {
        const element = document.getElementById(id);
        if (element) {
            element.remove();
            reorderContacts();
            addBtn.style.display = 'inline-block';


        } else {
            alert('Élément introuvable : ' + id);
        }
    }

    function reorderContacts() {
        const containerUser = document.querySelector('.useradd');
        const users = container.querySelectorAll('.user');
        const currentUsers = users.length;
        users.forEach((user, index) => {
            user.remove();
        });

        for (let i = 0; i < currentUsers; i++) {

            const newUser = document.createElement('div');
            newUser.classList.add('user');
            newUser.id = 'N_' + (i + 1);
            newUser.innerHTML = `
 <div class="relative! w-full! min-h-[50px]!">
 <button type="button" class="absolute! top-0! right-0!" onclick="suppUser('N_` + (i+1) + `')"><i class="fa-solid fa-user-minus mr-[20px]"></i> Supprimer le contact</button>
                <h4>` + (i+2) + `ème contact </h4>

            </div>
            <div class="coltwo">
        <div class="w-full!">
            <p>
                <label for="prenom_` + (i + 1) + `"><span>Prénom * :</span> <input type="text" id="prenom_` + (i + 1) + `" name="prenom_` + (i + 1) + `"
                                                                   placeholder="Prénom" required></label>
            </p>
        </div>
        <div class="w-full!">
            <p>
                <label for="nom-` + (i + 1) + `"><span>Nom * :</span> <input type="text" id="nom_` + (i + 1) + `" name="nom_` + (i + 1) + `" placeholder="Nom" required></label>
            </p>
        </div>
    </div>

    <p><label for="fonction_` + (i + 1) + `"><span>Fonction dans l’organisation * :</span>
            <select name="fonction_` + (i + 1) + `" id="fonction_` + (i + 1) + `" required>
                <?php
            if ($options):
            ?>
                <option>Choisir une réponse</option>
            <?php
            foreach ($options as $option):
            ?>
                        <option value="<?= $option; ?>"><?= $option; ?></option>
                    <?php
            endforeach;
            endif;
            ?>
            </select>
        </label>
    </p>

    <p>
        <label for="email_` + (i + 1) + `"><span>Email * :</span> <input type="email" id="email_` + (i + 1) + `" name="email_` + (i + 1) + `" placeholder="Email"
                                                         required></label>
    </p>

    <p><label for="role_` + (i + 1) + `"><span>Rôle dans l’organisation pour la Charte de la diversité :</span>
            <select name="role_` + (i + 1) + `" id="role_` + (i + 1) + `" required>
                <?php
            if ($options):
            ?>
                <option>Choisir une réponse</option>
            <?php
            foreach ($options as $option):
            ?>
                        <option value="<?= $option; ?>"><?= $option; ?></option>
                    <?php
            endforeach;
            endif;
            ?>
            </select>
        </label>
    </p>

    <p>
        <label class="checkbox"><input type="checkbox" id="signataire_` + (i + 1) + `"
                                                  name="signataire_` + (i + 1) + `"/><span>Contact signataire</span> <i
                    class="fa-regular fa-circle-question" data-tippy-content="Tempore quo primis auspiciis in mundanum fulgorem"></i></label>
    </p>`;
            containerUser.appendChild(newUser);

        }

        tippy('[data-tippy-content]', {
            theme: 'lmc',
        });


    }


    tippy('[data-tippy-content]', {
        theme: 'lmc',
    });
</script>
