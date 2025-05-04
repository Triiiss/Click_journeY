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

function waiting_time(event, formId) {
        event.preventDefault(); // Empêche l'envoi immédiat
    
        const form = document.getElementById(formId);
        const button = event.target;
        const buttonName = button.getAttribute('name'); 
        const buttonValue = button.getAttribute('value'); 
        button.style.backgroundcolor = "rgb(153, 60, 6)";
        button.style.color = "rgb(253, 232, 213)";
        button.disabled = true; // Désactive le bouton pour éviter plusieurs clics

        if (buttonName) {               // Envoie la form du bouton aussi
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = buttonName;
                hiddenInput.value = buttonValue;
                form.appendChild(hiddenInput);
        }

        setTimeout(function() {
            form.submit(); // Après 1 seconde
        }, 1500);
}
