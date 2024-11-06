#### BarkaPay Laravel
barkapay-laravel est un package Laravel permettant d'intégrer les services de paiement BarkaPay dans vos applications Laravel. Il fournit une interface simple pour effectuer des transactions via BarkaPay, y compris des services de SCI et des paiements.

### Installation

##Installer le package via Composer :

    composer require barkapay-sa/barkapay-laravel

## Publier le fichier de configuration :

Publiez le fichier de configuration pour personnaliser vos clés API et les autres options.

    php artisan vendor:publish --provider="BarkapayLaravel\BarkaPayServiceProvider"

## Configurer les clés API :

Ajoutez vos informations d'identification BarkaPay dans votre fichier .env :

BKP_API_KEY=your_api_key
BKP_API_SECRET=your_api_secret
BKP_SCI_KEY=your_sci_key
BKP_SCI_SECRET=your_sci_secret
BKP_BASE_URL=https://api.barkapay.com/api/client/

### Configuration
Après la publication, un fichier de configuration config/barkapay. sera créé. Vous pouvez y ajuster les paramètres de votre intégration BarkaPay :

return [
    'api_key' => env('BKP_API_KEY', ''),
    'api_secret' => env('BKP_API_SECRET', ''),
    'sci_key' => env('BKP_SCI_KEY', ''),
    'sci_secret' => env('BKP_SCI_SECRET', ''),
    'base_url' => env('BKP_BASE_URL', 'https://api.barkapay.com/api/client/'),
    'currency' => 'xof',
];


### Utilisation
Une fois installé et configuré, vous pouvez utiliser les services de BarkaPay via la Facade BarkaPay depuis n'importe quel endroit de votre application Laravel.

## Exemple d'utilisation
# Récupérer les informations d'un utilisateur


use BarkapayLaravel\Facades\BarkaPay;

$userInfo = BarkaPay::getUserInfos();

if ($userInfo) {
    // Traitez les informations de l'utilisateur
    echo "Nom : " . $userInfo->name;
}

# Effectuer une transaction

try {
    $transaction = BarkaPay::createTransaction([
        'amount' => 1000,
        'currency' => 'xof',
        'callback_url' => 'https://votre-site.com/callback',
        'return_url' => 'https://votre-site.com/success',
        'metadata' => [
            'order_id' => '12345',
            'description' => 'Achat de produit XYZ'
        ]
    ]);

    echo "Transaction créée avec succès : " . $transaction->transaction_id;
} catch (Exception $e) {
    echo "Erreur lors de la création de la transaction : " . $e->getMessage();
}


### Services Disponibles
Ce package contient les services suivants pour gérer les paiements mobiles :

1)APIBarkaPayPaymentService : Service de base pour les paiements mobiles génériques.
2)SCIBarkaPayPaymentService : Service pour créer des liens de paiement en ligne.
3)MoovMoneyBFBarkaPayPaymentService : Service spécifique pour Moov Money au Burkina Faso.
4)OrangeMoneyBFBarkaPayPaymentService : Service spécifique pour Orange Money au Burkina Faso.

### Assistance

Pour toute question ou problème, veuillez contacter le support technique via support@barkapay.com.