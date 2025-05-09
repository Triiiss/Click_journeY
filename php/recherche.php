<?php
    include 'fonctions.php';
    session_start();
?>

<!DOCTYPE php>
<php>
    <head>
        <meta charset="utf-8"/>
        <title>camping de l'extreme - Recherche</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body>
        <h1 class="titre">
            Camping de l'Extreme <img src="../images/logo.png" class="logo" alt="logo de l'image"/>
            <button class="chg_theme"> 
                <img src="../images/mode_sombre.png" class="mode_sombre" alt="Mode sombre"/>
            </button>
        </h1>
        
        <a class="accueil" href="accueil.php">Accueil</a><br/>

        <?php bandeau("recherche");?>
        
        <form action="recherche.php" method="get">
            <fieldset class="recherche">
                <legend>Filtres</legend>
                <div class="filtre">
                    <label for="lieu">Lieu</label>
                    <input class="recherche" type="text" name="lieu"> 
                </div>
                <div class="filtre">
                    <label for="depart">Date de départ</label>
                    <input class="recherche" type="Date" name="depart"> 
                </div>
                <div class="filtre">
                    <label for="duree">Durée (jours)</label>
                    <input class="recherche" type="number" name="duree" maxlength="3" min="1">  
                </div>                
            </fieldset>

            <fieldset class="recherche">
                <div class="filtre">
                    <label for="budget">Budget</label>
                    <?php
                        if(isset($_GET["budget"])){
                            echo '<input class="recherche" type="range" name="budget" min="10" max="5000" value="'.$_GET["budget"].'" oninput="majBudget(this.value)">
                            <span id="valBudget">'.$_GET["budget"].' €</span>';
                        }
                        else{
                           echo '<input class="recherche" type="range" name="budget" min="10" max="5000" value="1000" oninput="majBudget(this.value)">
                           <span id="valBudget">1000 €</span>';
                        }
                    ?>
                </div>   
                <div class="filtre">
                    <label for="nbpersonnes">Nombre de personnes</label>
                    <input class="recherche" type="number" name="nbpersonnes" min="1" max="10" value="1">
                </div>   
                <!--Sélectionnez votre destination
                <map name="map">
                </map>-->                 
            </fieldset>

            <fieldset class="recherche">
                <div class="filtre">
                    <label for="vacances">Type de vacances</label>
                    <div>
                        Plage<input class="recherche" type="checkbox" name="vacances" value="plage">
                        Montagne<input class="recherche" type="checkbox" name="vacances" value="montagne">
                        Ville <input class="recherche" type="checkbox" name="vacances" value="ville">
                        Forêt<input class="recherche" type="checkbox" name="vacances" value="forêt">
                    </div>
                </div>   
                <div class="filtre">
                    <label for="randonnée">Randonnée</label>
                    <div>
                        Oui<input class="recherche" type="radio" name="randonnée" value="oui">
                        Non<input class="recherche" type="radio" name="randonnée" value="non">
                    </div>
                </div>   
                <div class="filtre">
                    <label for="douches">Douches</label>
                    <div>
                        Oui<input class="recherche" type="radio" name="douches" value="oui">
                        Non<input class="recherche" type="radio" name="douches" value="non">
                    </div>
                </div>              
            </fieldset>

            <fieldset class="recherche">
                <label for="tri">Trier par :</label>
                <select id="tri" name="tri">
                    <option value="ajout" selected>Date d'ajout</option>
                    <option value="duree">Durée</option>
                    <option value="prix">Prix</option>                   
                </select>

                <label for="search">Recherche :</label>
                <input class="recherche" type="text" name="search">
            </fieldset>

            <div class="voyages" id="resultats">
            <?php 
                $json_voyages=file_get_contents("../json/voyages.json");
                $voyages=json_decode($json_voyages, true);

                if(isset($_GET["search"])){
                    $recherche=$_GET["search"];
                }
                else{
                    $recherche="";
                }
                if(isset($_GET["budget"])){
                    $budget=$_GET["budget"];
                }
                else{
                    $budget=1000;
                }
                $page=1;
                if(isset($_GET["page"])){
                    $page=$_GET["page"];
                }
            ?>
            <script>
                let voyages = <?php echo json_encode($voyages); ?>;
                let recherche = <?php echo json_encode($recherche); ?>;
                let budget = parseFloat(<?php echo json_encode($budget); ?>);
                let page = parseInt(<?php echo json_encode($page); ?>);
                
                function afficherVoyages(voyages, recherche, page) {
                    let count = 0;
                    const resultats = document.getElementById("resultats");
                    recherche = recherche.toLowerCase();

                    resultats.innerHTML = "";

                    //on compare la recherche avec les mots clés, le titre et le lieu de chaque voyage
                    for (let k in voyages) {
                        const voyage = voyages[k];
                        const mots_cles = voyage.mots_cles.toLowerCase();
                        const titre = voyage.titre.toLowerCase();
                        const lieu = voyage.lieu.toLowerCase();
                        const prix = parseFloat(voyage.prix);

                        if (
                            (mots_cles.includes(recherche) || titre.includes(recherche) || lieu.includes(recherche)) &&
                            recherche !== "" && prix <= budget &&
                            count < 9 * page
                        ) {
                            if (count >= 9 * (page - 1)) {
                                if (count % 3 === 0) {
                                    var pageDiv = document.createElement("div");
                                    pageDiv.className = "grpV";
                                    resultats.appendChild(pageDiv);
                                }

                                const itineraire = document.createElement("div");
                                itineraire.className = "itineraire";

                                const link = document.createElement("a");
                                link.href = 'voyage.php?id='+voyage.id;

                                const img = document.createElement("img");
                                img.src = voyage.image;
                                img.alt = "photo_voyage";
                                img.className = "imgVoyage";

                                const titreDiv = document.createElement("div");
                                titreDiv.className = "titreVoyage";
                                titreDiv.textContent = voyage.titre;

                                link.appendChild(img);
                                itineraire.appendChild(link);
                                itineraire.appendChild(titreDiv);
                                pageDiv.appendChild(itineraire);

                                if ((count + 1) % 3 === 0) {
                                    resultats.appendChild(pageDiv);
                                }
                            }
                            count++;
                        }
                    }

                    if (count % 3 !== 0) {
                        resultats.appendChild(pageDiv);
                    }
                    
                    //affichage du bouton page précédente si la page est supérieure à 1
                    if (page > 1) {
                        const btnPrec = document.createElement("a");
                        btnPrec.href = '#resultats';
                        btnPrec.innerHTML = '<button type="button" onclick="pagePrec()">Page précédente</button>';
                        resultats.appendChild(btnPrec);
                    }
                    //affichage du bouton page suivante s'il reste des voyages à afficher
                    if (count >= 9 * page) {
                        const btnSuiv = document.createElement("a");
                        btnSuiv.href = '#resultats';
                        btnSuiv.innerHTML = '<button type="button" onclick="pageSuiv()">Page suivante</button>';
                        resultats.appendChild(btnSuiv);
                    }
                }
                
                function pagePrec(){
                    page--;
                    afficherVoyages(voyages, recherche, page);
                }

                function pageSuiv(){
                    page++;
                    afficherVoyages(voyages, recherche, page);
                }

                function calcDureeVoyage(v) {
                    const depart = new Date(v.depart);
                    const fin = new Date(v.fin);
                    const duree = fin - depart;
                    return duree;
                }
                
                const tri = document.getElementById('tri');

                function compare(a, b) {
                    if(tri.value == "ajout"){
                        if (a.id > b.id){
                            return -1;
                        }
                        if (a.id < b.id){
                            return 1;
                        }
                        return 0;
                    }
                    else if(tri.value == "prix"){
                        if (a.prix < b.prix){
                        return -1;
                        }
                        if (a.prix > b.prix){
                            return 1;
                        }
                        return 0;
                    }
                    else if(tri.value == "duree"){
                        const dureeA = calcDureeVoyage(a);
                        const dureeB = calcDureeVoyage(b);
                        if (dureeA < dureeB){
                        return -1;
                        }
                        if (dureeA > dureeB){
                            return 1;
                        }
                        return 0;
                    }
                    
                }

                function trier(){
                    voyages = voyages.sort(compare);
                    afficherVoyages(voyages, recherche, page);
                }

                tri.addEventListener('change', trier);
                
                voyages = voyages.sort(compare);
                afficherVoyages(voyages, recherche, page);                             
            </script>

            </div>

            <fieldset class="recherche">
                <button class="recherche" type="reset" name="reset">Supprimer les filtres</button>
                <button class="recherche" type="submit" name="submit">Rechercher</button>
            </fieldset>
        </form>
   
        <h3 class="voyages">Les plus récents</h3>

        <div class="voyages all">
        <?php 
            for($i=count($voyages);$i>count($voyages)-7;$i--){
                if(isset($voyages[$i])){
                    echo '<div class="itineraire">';
                    echo '<a href="voyage.php?id='.$i.'"><img src="'.$voyages[$i]["image"].'" class="imgVoyage" alt="photo_voyage""/></a>';
                    echo '<div class="titreVoyage">'.$voyages[$i]["titre"].'</div>';   
                    echo '</div>';                
                }
            }
        ?>
        </div>

        <br><br>
        <div class="afterimage">
                <span class="first-afterimage">Nous contacter :</span>
                <p>Email : contact@campingextreme.com<br/>Téléphone : 01 23 45 67 89</p>
                <br/>
        </div>

        <script src="../javascript/chg_theme.js"></script>
        <script src="../javascript/recherche.js"></script>
    </body>
</php>

