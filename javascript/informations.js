function edit_infos(number, data){
        var info_list = document.getElementsByClassName(data + "_info_" + number);
        var edit_list = document.getElementsByClassName(data + "_edit_" + number);

        for (let i=0; i<info_list.length; i++){
                info_list[i].style.display = "none";
                edit_list[i].style.display = "block";
        }
}

function cancel_edit(number, data){
        var info_list = document.getElementsByClassName(data + "_info_" + number);
        var edit_list = document.getElementsByClassName(data + "_edit_" + number);

        for (let i=0; i<info_list.length; i++){
                info_list[i].style.display = "block";
                edit_list[i].style.display = "none";
        }
}

async function waiting_time(event, formId, id=-1, page=-1) {
        event.preventDefault();

        if(formId=="form_profil"){
                const form = document.getElementById(formId);
                const btnSubmit = event.target;

                const name = btnSubmit.name;
                btnSubmit.disabled = true; // Désactive le bouton pour éviter plusieurs clics
                const champModif = form.querySelector('[name="'+name+'_value"]'); //input ou l'utilisateur entre du texte

                if (!champModif) {
                        console.error("Champ de valeur introuvable pour :", name);
                        return;
                }

                const champ = name.replace("new_", ""); //champ a modifier
                const value = champModif.value.trim();

                const affichageInfo = document.querySelector('.'+champ+'_info_'); //span ou l'ancienne valeur est affichée
                const ancienneVal = affichageInfo.textContent;

                await new Promise(resolve => setTimeout(resolve, 1000)); //timer d'1 seconde

                try{
                        const reponse = await fetch("modif_profil.php", {
                                method: "POST",
                                headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: new URLSearchParams({ champ, value })
                        });

                        if (!reponse.ok) {
                                console.error('La requete n’a pas abouti ${reponse.status} ${reponse.statusText}');
                                return ;
                        }
                        
                        const obj = await reponse.json();

                        if (obj.success) {
                                affichageInfo.textContent = value;
                        } else {
                                alert(obj.message);
                                affichageInfo.textContent = ancienneVal;
                        }

                        cancel_edit('', champ); // Cache les champs de modification
                } catch (e) {
                        affichageInfo.textContent = ancienneVal;
                        console.error("Erreur avec fetch : ", e);
                        alert("Une erreur est survenue lors de la mise à jour");
                }

                btnSubmit.disabled = false; // Réactive le bouton
        }

        else if(formId=="form_admin"){
                if(id==-1){
                        console.error("id non fourni");
                        return ;
                }
                if(page<1){
                        console.error("numéro de page incorrect");
                        return ;
                }

                const index_user=id+4*(page-1);

                const form = document.getElementById(formId);
                const btnSubmit = event.target;

                const name = btnSubmit.name;
                const username = name.replace("new","").split('_')[0];
                btnSubmit.disabled = true; // Désactive le bouton pour éviter plusieurs clics
                const champModif = form.querySelector('[name="'+name+'_value"]'); //input ou l'utilisateur entre du texte

                if (!champModif) {
                        console.error("Champ de valeur introuvable pour :", name);
                        return;
                }

                const champ = name.replace("new"+username+"_", ""); //champ a modifier
                const value = champModif.value.trim();

                const affichageInfo = document.querySelector('.'+champ+'_info_'+id); //span ou l'ancienne valeur est affichée
                const ancienneVal = affichageInfo.textContent;

                await new Promise(resolve => setTimeout(resolve, 1000)); //timer d'1 seconde

                try{
                        const reponse = await fetch("modif_profil.php", {
                                method: "POST",
                                headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: new URLSearchParams({ champ, value, index_user })
                        });

                        if (!reponse.ok) {
                                console.error('La requete n’a pas abouti ${reponse.status} ${reponse.statusText}');
                                return ;
                        }
                        
                        const obj = await reponse.json();

                        if (obj.success) {
                                affichageInfo.textContent = value;
                        } else {
                                alert(obj.message);
                                affichageInfo.textContent = ancienneVal;
                        }

                        cancel_edit(id, champ); // Cache les champs de modification
                } catch (e) {
                        affichageInfo.textContent = ancienneVal;
                        console.error("Erreur avec fetch : ", e);
                        alert("Une erreur est survenue lors de la mise à jour");
                }

                btnSubmit.disabled = false; // Réactive le bouton
        }
}