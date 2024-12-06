<?php
function menu(): int {
    echo "
     1. Ajouter client \n
     2. Lister les clients\n
     3. Rechercher client par téléphone\n
     4. Lister les dettes d'un client\n
     5. Enregistrer les dettes\n
     6. Payer une dette\n
     7. Quitter\n";
    return (int)readline("Faites votre choix: ");
}
$dettes = [];
function enregistrerDette(array &$dettes, string $telephone, float $montant): void {
    $dettes[] = [
        "telephone" => $telephone,
        "montant" => $montant,
        "statut" => "impayée"
    ];
    echo "Dette enregistrée avec succès.\n";
}
function listerDettes(array $dettes, string $telephone): void {
    $trouve = false;
    foreach ($dettes as $dette) {
        if ($dette["telephone"] === $telephone) {
            $trouve = true;
            echo "Montant : " . $dette["montant"] . " | Statut : " . $dette["statut"] . "\n";
        }
    }
    if (!$trouve) {
        echo "Aucune dette trouvée pour ce client.\n";
    }
}
function payerDette(array &$dettes, string $telephone): void {
    $trouve = false;
    foreach ($dettes as &$dette) {
        if ($dette["telephone"] === $telephone && $dette["statut"] === "impayée") {
            $dette["statut"] = "payée";
            echo "Dette de " . $dette["montant"] . " payée avec succès.\n";
            $trouve = true;
            break;
        }
    }
    if (!$trouve) {
        echo "Aucune dette impayée trouvée pour ce client.\n";
    }
}
function principal() {
    $clients = selectClients();
    $dettes = [];

    do {
        $choix = menu();
        switch ($choix) {
            case 1:
                $client = saisieClient($clients);
                if (enregistrerClient($clients, $client)) {
                    echo "Client enregistré avec succès.\n";
                } else {
                    echo "Le numéro de téléphone existe déjà.\n";
                }
                break;
            case 2:
                afficheClient($clients);
                break;
            case 3:
                $tel = saisieChampObligatoire("Entrez le téléphone du client : ");
                $client = selectClientByTel($clients, $tel);
                if ($client) {
                    print_r($client);
                } else {
                    echo "Client introuvable.\n";
                }
                break;
            case 4:
                $tel = saisieChampObligatoire("Entrez le téléphone du client : ");
                listerDettes($dettes, $tel);
                break;
            case 5:
                $tel = saisieChampObligatoire("Entrez le téléphone du client : ");
                $montant = (float)readline("Entrez le montant de la dette : ");
                enregistrerDette($dettes, $tel, $montant);
                break;
            case 6:
                $tel = saisieChampObligatoire("Entrez le téléphone du client : ");
                payerDette($dettes, $tel);
                break;
            case 7:
                echo "Au revoir !\n";
                break;
            default:
                echo "Veuillez faire un choix valide.\n";
                break;
        }
    } while ($choix != 7);
}
