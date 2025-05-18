function recupCookie(nom) {
    nom = nom + "=";
    let listeCookie = document.cookie.split(';');
    for(let i = 0; i <listeCookie.length; i++) {
      let c = listeCookie[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(nom) == 0) {
        return c.substring(nom.length, c.length);
      }
    }
    return "";
}

function changerTheme(){
    if(document.body.classList.toggle('sombre')==true){
        document.cookie = 'mode=sombre; max-age=86400; path=/';
    }
    else{
        document.cookie = 'mode=clair; max-age=86400; path=/';
    }  
}

function appliquerTheme(){
    let res = recupCookie('mode');
    if(res=='sombre'){
        document.body.classList.add("sombre");
    }
    else{
        document.body.classList.remove("sombre");
    }
}

document.addEventListener('DOMContentLoaded',appliquerTheme);

const btnTheme = document.querySelector('.chg_theme');
btnTheme.addEventListener('click',changerTheme);