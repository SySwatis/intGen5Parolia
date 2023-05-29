<!DOCTYPE html>
<html>
<head>
    <title>Test Api Parolia</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .logo {
            width: 90px;
            margin: 0 auto;
        }

        .logo img {
            max-width:100%;
            min-width: 100%;
            height:auto;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-top: 0;
        }

        button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .response-container {
            height: 400px; /* Hauteur fixe de la fenêtre de réponse */
            overflow-y: scroll; /* Activer le débordement vertical */
            margin-top: 20px;
            background-color: #000000;
            color: #ffffff;
            padding: 10px;
            white-space: pre-wrap;
            text-align:left;
        }
  
    .loader {
        border: 4px solid #f3f3f3; /* Couleur de la bordure */
        border-top: 4px solid #3498db; /* Couleur de la bordure du dessus */
        border-radius: 50%; /* Forme circulaire */
        width: 30px; /* Largeur */
        height: 30px; /* Hauteur */
        animation: spin 1s linear infinite; /* Animation de rotation */
        margin: 0 auto; /* Centrage horizontal */
        display: none; /* Masqué par défaut */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

</head>
<body>
    <div class="container">
    
        <div class="logo">
            <img src="https://parolia-academie.com/wp-content/uploads/2023/01/cropped-logo.webp" alt="Parolia Acadmie">
        </div>
        <h1>Appel de fonctions</h1>

        <h3>Utilisateurs</h3>
        <button onclick="doAction('createUserApi', false)">Créer un utilisateur (aléatoire)</button>
        <button onclick="doAction('isUserIdExist&id=126', false)">Check Id 126</button>
        <button onclick="doAction('getUsersCollection', true)">Récupérer la collection</button>

        <h3>Formateur</h3>
        <button onclick="doAction('getTrainersCollection', true)">Récupérer la collection</button>
        <button onclick="doAction('createTrainerApi', false)">Créer un formateur aléatoire</button>
        <div id="loader" class="loader"></div>
        <div id="response" class="response-container">
        
        </div>
        
    </div>

   

<script>
    function doAction(func, json) {
        var xhr = new XMLHttpRequest();

        // Afficher le spinner au début de la requête
        document.getElementById("loader").style.display = "block";

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                // Masquer le spinner à la fin de la requête
                document.getElementById("loader").style.display = "none";

                if (xhr.status === 201 || xhr.status === 200) {
                    if (json) {
                        var response = JSON.parse(xhr.responseText);
                        var formattedResponse = JSON.stringify(response, null, 2);
                        document.getElementById("response").innerHTML = "<pre>" + formattedResponse + "</pre>";
                    } else {
                        var response = xhr.responseText;
                        document.getElementById("response").innerText = response;
                    }
                } else {
                    // Gérer les erreurs ici
                    document.getElementById("response").innerText = "Erreur de la requête. Statut : " + xhr.status;
                }
            }
        };

        xhr.open("GET", "actions.php?do=" + func, true);
        xhr.send();
    }
</script>

</body>
</html>
