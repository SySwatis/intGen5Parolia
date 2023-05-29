<?php
/*
    Codes reponse HTTP
    ------------------
    200 : OK - La requête a été traitée avec succès.
    201 : Created - La requête a été traitée avec succès et une nouvelle ressource a été créée.
    204 : No Content - La requête a été traitée avec succès, mais il n'y a pas de contenu à renvoyer.
    206 : Partial Content - La requête a été traitée avec succès, mais seulement une partie de la réponse est renvoyée. 

*/

define('API_URL','https://web.parolia.io/');

function checkHttpResponseCode($curl, $code = 200) 
{
    if(curl_errno($curl)) {
        $errNo = curl_error($curl);
        return array(false, $errNo);
    } else {
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode == $code) {
            return array(true, $httpCode);
        } else {
            return array(false, $httpCode);
        }
    }
}

function isUserIdExist($id, $response) 
{        // La requête a réussi, vous pouvez traiter la réponse ici

    $data = json_decode($response[0], true); // Convertir le JSON en tableau associatif
    if (isset($data['hydra:member'])) {
        $users = array_column($data['hydra:member'], 'external');
        if (in_array($id, $users)) {
            return true;
        }
    }
    return false;
}

function getUsersCollection($profil='users')
{

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => API_URL . 'api/' . $profil,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'accept: application/ld+json'
        ]
    ]);

    $response = curl_exec($curl);
    $http_code = checkHttpResponseCode($curl);

    curl_close($curl);
    return array($response,$http_code[1]);

    // Gestion d'erreurs
    // if ($http_code[0]) {
    //     // La requête a réussi, vous pouvez traiter la réponse ici
    //     $message = "Récupération des utilisateurs réussie. Code de réponse : " . $http_code[1];
    //     curl_close($curl);
    //     return array($response,$message);
    // } else {
    //     // La requête a échoué, gérer l'erreur ici
    //     curl_close($curl);
    //     $message = "Échec de la récupération des utilisateurs. Code de réponse : " . $http_code[1];
    //     return array($response,$message);
    // }
}

function getTrainersCollection()
{
    return getUsersCollection('trainers');
}

function userDatasRandom($trainer=false,$id=null)
{
        // Générer une adresse e-mail aléatoire
        $id = $id===null ? rand(0, 999) : $id;
        $email = 'user' . $id . '@generation-5.org';
        // Données de l'utilisateur à créer
        $data = array(
            'external' => strval($id),
            'email' => $email,
            'firstName' => 'string',
            'lastName' => 'string',
            'trainer' => $trainer
        );
        return $data;
}

function createUserApi($data)
{
    // URL de l'API distante pour créer un utilisateur
    $url = API_URL . 'api/users';

    // Configuration de la requête
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Content-Type: application/json'
        )
    );

    // Initialisation de cURL
    $curl = curl_init();

    // Configuration des options de cURL
    curl_setopt_array($curl, $options);

    // Exécution de la requête cURL
    $response = curl_exec($curl);

    // Gestion d'erreurs

    $http_code = checkHttpResponseCode($curl, 201);

    if ($http_code[0]) {
        if ($http_code[1] === 201) {
            // La requête a réussi, vous pouvez traiter la réponse ici
            $message = "Utilisateur id : " . $data['external'] . " créé avec succès. Code de réponse : " . $http_code[1];
            curl_close($curl);
            return array(true, $message);
        } else {
            // La requête a échoué, gérer l'erreur ici
            $message = "Échec de la création de l'utilisateur. Code de réponse : " . $http_code[1];
            curl_close($curl);
            return array(false, $message);
        }
    } else {
        // Erreur cURL
        $message = "Erreur cURL : " . $http_code[1];
        curl_close($curl);
        return array(false, $message);
    }
}

?>