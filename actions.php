<?php

include_once('functions.php');

// Vérifier si une action est définie dans les paramètres de la requête

if(isset($_GET['do'])) {
    $do = $_GET['do'];

    // Appeler la fonction correspondante à l'action

    switch ($do) {
        case 'getTrainersCollection':
            $response = getTrainersCollection();
            echo $response[0];
            break;
        case 'getUsersCollection':
            $response = getUsersCollection();
            echo $response[0];
            break;
        case 'createUserApi':
            $datasRand = userDatasRandom();
            $response = createUserApi($datasRand);
            echo $response[1];
            break;
        case 'createTrainerApi':
            $datasRand = userDatasRandom(true);
            $response = createUserApi($datasRand);
            echo $response[1];
            break;
        case 'isUserIdExist':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $response = getUsersCollection();
                $result = isUserIdExist($id, $response);
                echo $result == true ? 'Oui' : 'Non';
            }
            break;
        default:
            // Traitement par défaut si aucune correspondance n'est trouvée
            echo 'Action non prise en charge.';
            break;
    }
    
}

?>