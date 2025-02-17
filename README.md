# 🚀 BarkaPay Laravel

BarkaPay Laravel est un package Laravel qui permet d'intégrer facilement les services de paiement BarkaPay dans vos applications. Il fournit une interface simple pour effectuer des transactions via BarkaPay, y compris les paiements mobiles et les services SCI.

---

## 📌 Installation

### 1️⃣ Installer le package via Composer
```sh
composer require barkapay-sa/barkapay-laravel
```

### 2️⃣ Publier le fichier de configuration
```sh
php artisan vendor:publish --provider="BarkapayLaravel\BarkaPayServiceProvider"
php artisan vendor:publish --tag=barkapay-config
```

### 3️⃣ Configurer les clés API
Ajoutez vos informations d'identification BarkaPay dans votre fichier `.env` :
```env
BKP_API_KEY=your_api_key
BKP_API_SECRET=your_api_secret
BKP_SCI_KEY=your_sci_key
BKP_SCI_SECRET=your_sci_secret
BKP_BASE_URL=https://api.barkapay.com/api/client/
```

---

## ⚙️ Configuration
Après la publication, un fichier de configuration **`config/barkapay.php`** sera généré. Vous pouvez y modifier les paramètres selon vos besoins :
```php
return [
    'api_key' => env('BKP_API_KEY', ''),
    'api_secret' => env('BKP_API_SECRET', ''),
    'sci_key' => env('BKP_SCI_KEY', ''),
    'sci_secret' => env('BKP_SCI_SECRET', ''),
    'base_url' => env('BKP_BASE_URL', 'https://api.barkapay.com/api/client/'),
    'currency' => 'xof',
];
```

---

## 🚀 Utilisation
Une fois installé et configuré, vous pouvez utiliser **BarkaPay** via la **Façade Laravel** ou directement via le **Service Container**.

### 📌 Accéder aux Services
BarkaPay expose **trois services principaux** sous une seule interface :
```php
$barkapay = app('barkapay');

// Service de base
$baseService = $barkapay->base();

// Service API
$apiService = $barkapay->api();

// Service SCI
$sciService = $barkapay->sci();
```

---

## 📌 Services Disponibles

| **Service**                            | **Description**                                      |
|-----------------------------------------|------------------------------------------------------|
| `APIBarkaPayPaymentService`            | Service principal pour les paiements mobiles via API |
| `SCIBarkaPayPaymentService`            | Service pour créer des liens de paiement en ligne (SCI) |
| `MoovMoneyBFBarkaPayPaymentService`    | Service spécifique pour Moov Money au Burkina Faso |
| `OrangeMoneyBFBarkaPayPaymentService`  | Service spécifique pour Orange Money au Burkina Faso |
| `BaseBarkaPayPaymentService`           | Service de base utilisé par les autres services |
| `APIService`                            | Vérification des identifiants et récupération des services disponibles |

---

## 📌 Liste des fonctions disponibles

| **Nom de la fonction**              | **Description**                                       | **Appel** |
|--------------------------------------|------------------------------------------------------|-----------|
| `verifyCredentials()`                | Vérifie si les identifiants API sont valides        | `BarkaPay::api()->verifyCredentials();` |
| `getUserInfos()`                     | Récupère les informations du compte utilisateur     | `BarkaPay::api()->getUserInfos();` |
| `getAccountsBalances()`              | Récupère les soldes des comptes associés           | `BarkaPay::api()->getAccountsBalances();` |
| `getOperatorsInfos()`                | Récupère les informations sur les opérateurs de paiement | `BarkaPay::api()->getOperatorsInfos();` |
| `getAvailableServices()`             | Liste les services BarkaPay disponibles pour l'utilisateur | `BarkaPay::api()->getAvailableServices();` |
| `getPaymentDetails($publicId)`       | Récupère les détails d'un paiement spécifique       | `BarkaPay::api()->getPaymentDetails($publicId);` |
| `getTransferDetails($publicId)`      | Récupère les détails d'un transfert spécifique      | `BarkaPay::api()->getTransferDetails($publicId);` |
| `createMobilePayment($details)`      | Crée une transaction de paiement mobile            | `BarkaPay::api()->createMobilePayment([...]);` |
| `createPaymentLink($data)`           | Crée un lien de paiement SCI                        | `BarkaPay::sci()->createPaymentLink([...]);` |

---

## 🔥 Pourquoi utiliser BarkaPay Laravel ?

✅ **Intégration simple et rapide** dans vos applications Laravel  
✅ **Interface fluide** avec une **façade Laravel**  
✅ **Gestion complète** des paiements mobiles et des liens SCI  
✅ **Sécurisé** avec l’utilisation des clés API et des bonnes pratiques Laravel  

## 🔍 Débogage et Assistance

### 📌 Vider le cache en cas d’erreur
Si vous rencontrez des erreurs après l'installation, essayez les commandes suivantes :

sh
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear



### 📌 Contacter le support
Pour toute question ou problème, veuillez contacter notre support technique :  
- 📧 [support@barkapay.com](mailto:support@barkapay.com)
- 🌐 [https://barkapay.com/help-center](https://barkapay.com/help-center)


---

🔥 **Avec BarkaPay Laravel, boostez vos paiements en toute simplicité ! 🚀**

