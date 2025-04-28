function hide_view(num){
        if (num === 0){
                var icon = document.getElementById("icon");
                var mdp = document.getElementById("password");
        }
        else if (num === 1){
                var icon = document.getElementById("icon_first");
                var mdp = document.getElementById("password_first");
        }
        else{
                var icon = document.getElementById("icon_second");
                var mdp = document.getElementById("password_second");
        }

        
        if (mdp.type === "password"){
                mdp.type = "text";
                icon.src = "../images/hide.png";
        }
        else{
                mdp.type = "password";
                icon.src = "../images/view.png";
        }
}

function verification_connexion(){
        const login = document.querySelector('input[name="login"]').value.trim();
        const mdp = document.querySelector('input[name="mdp"]').value.trim();
        const button = document.querySelector('button[name="submit"]');

        if (login === "" || mdp === "") {
            alert("Veuillez remplir tous les champs.");
            return false;
        }
    
        if (login.length < 2) {
            alert("L'identifiant doit contenir au moins 2 caractères.");
            return false;
        }
    
        if (mdp.length < 8) {
            alert("Le mot de passe doit contenir au moins 8 caractères.");
            return false;
        }
        
        button.type = "submit";
}

function verification_inscription(){
        const prenom = document.querySelector('input[name="prenom"');
        const nom = document.querySelector('input[name="nom"');
        const email = document.querySelector('input[name="email"').value.trim();
        const tel = document.querySelector('input[name="tel"');
        const age = document.querySelector('input[name="age"').value.trim();
        const login = document.querySelector('input[name="login"]').value.trim();
        const mdp = document.querySelector('input[name="mdp"]').value.trim();
        const mdpcfrm = document.querySelector('input[name="mdpcfrm"]').value.trim();
        const button = document.querySelector('button[name="submit"]');
        const confirm = document.querySelector('input[name="conditions"]').checked;


        /*Vérifie que les champs sont remplis */
        if (prenom.value.trim() === "" || nom.value.trim() === "" || email === "" || login === "" || mdp === "" || mdpcfrm === ""){
                alert("Veuillez remplir tous les champs obligatoires.");
                return false;
        }

        /*Les conditions d'utilisation */
        if(!confirm){
                alert("Veuillez accepter les conditions d'utilisation");
                return false;
        }

        /*Les champs sont minimum 2 caractères */
        if (prenom.value.trim().length < 2){
                alert("Le prénom doit contenir au moins 2 caractères.");
                return false;
        }
        if (nom.value.trim().length < 2){
                alert("Le nom doit contenir au moins 2 caractères.");
                return false;
        }
        if (login.length < 2){
                alert("L'identifiant doit contenir au moins 2 caractères.");
                return false;
        }
        if (email.length < 2){
                alert("L'email doit contenir au moins 2 caractères.");
                return false;
        }
        if (mdp.length < 8){
                alert("Le mot de passe doit contenir au moins 8 caractères.");
                return false;
        }
        
        /*Teste si le mot de passe est assez sécurisé */
        if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!*#%_])/.test(mdp)){
                alert("Le mot de passe n'est pas assez sécurisé");
                return false;
        }
   
        /*Les mots de passe sont les mêmes */
        if (mdp !== mdpcfrm){
                alert("Les deux mots de passe doivent être identiques");
                return false;
        }

        /*Si le tel n'a pas assez de caractères on le erase */
        if (tel.value.trim().length != 14){
                tel.value = "";
        }

        /*Vérifie si + de 18 ans */
        const date = new Date();
        
        if (parseInt(age.split("-")[0])+18 > parseInt(date.getFullYear())){
                alert("Il faut au moins avoir 18 ans pour s'inscrire");
                return false;
        }
        else if (parseInt(age.split("-")[0])+18 === parseInt(date.getFullYear()) && parseInt(age.split("-")[1]) > parseInt(date.getMonth())+1){
                alert("Il faut au moins avoir 18 ans pour s'inscrire");
                return false;
        }
        else if (parseInt(age.split("-")[0])+18 === parseInt(date.getFullYear()) && parseInt(age.split("-")[1]) === parseInt(date.getMonth())+1 && parseInt(age.split("-")[2]) > parseInt(date.getDate())){
                alert("Il faut au moins avoir 18 ans pour s'inscrire");
                return false;
        }


        /*Mise en forme des prénoms*/
        const prenomFormatted = prenom.value.trim().charAt(0).toUpperCase() + prenom.value.trim().slice(1).toLowerCase();
        const nomFormatted = nom.value.trim().charAt(0).toUpperCase() + nom.value.trim().slice(1).toLowerCase();

        prenom.value = prenomFormatted;
        nom.value = nomFormatted;
        
        button.type = "submit";
}

function waiting_time(event, formId) {
        event.preventDefault(); // Empêche l'envoi immédiat
    
        const form = document.getElementById(formId);
        const button = event.target;
        const buttonName = button.getAttribute('name'); 
        const buttonValue = button.getAttribute('value'); 
        button.disabled = true; // Désactive le bouton pour éviter plusieurs clics

        if (buttonName) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = buttonName;
                hiddenInput.value = buttonValue;
                form.appendChild(hiddenInput);
        }
    
        setTimeout(function() {
            form.submit(); // Après 1 seconde
        }, 1000);
}
