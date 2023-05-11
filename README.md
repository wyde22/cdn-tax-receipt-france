CDN Tax Receipts France
==============

Module CiviCRM pour la gestion des reçus fiscaux pour les organisations françaises. Ce module a été créé via un fork du repository CDNTaxReceipts. Extension développée par KarinG, DaveD, samulesov : https://lab.civicrm.org/extensions/cdntaxreceipts

Installation de l'extension :
------------

1. Assurez-vous que votre répertoire d'extensions CiviCRM est défini (Administrer > Paramètres système > Répertoires).
2. Assurez-vous que votre URL de ressource d'extensions CiviCRM est définie (Administrer > Paramètres système > URL de ressource).
3. Décompressez le code
    - répertoire d'extensions cd
    - clone git git@github.com:wyde22/cdn-tax-receipt-france.git
4. Activez l'extension dans Administrer > Paramètres système > Gérer les extensions
5. Configurez les reçus fiscaux CDN dans Administrer > CiviContribute > Reçus fiscaux CDN.
6. Autorisations de révision : l'extension a ajouté une nouvelle autorisation appelée "Reçus fiscaux CDN CiviCRM : émettre des reçus fiscaux".

Remarque : si vous l'installez sur Drupal 8 ou Drupal 9 -> n'oubliez pas de vider le cache Drupal ou vous ne pourrez peut-être pas accéder à l'écran des paramètres CiviCRM CDNTaxReceipts.

Vous devriez maintenant pouvoir utiliser le module.

**Remarque : problème de compatibilité avec open_basedir**

Cette extension utilise la bibliothèque TCPDF de CiviCRM. Si votre serveur a défini open_basedir initialiser la bibliothèque
provoque un avertissement. Pour éviter cela, veuillez ajouter ce qui suit à votre civicrm.settings.php n'importe où après $civicrm_root
est défini:

    /**
     * Définition précoce des constantes tcpdf pour éviter les avertissements avec open_basedir.
     */
    si (!defined('K_PATH_MAIN')) {
      définir('K_PATH_MAIN', $civicrm_root . '/packages/tcpdf/');
    }

    si (!defined('K_PATH_IMAGES')) {
      définir('K_PATH_IMAGES', K_PATH_MAIN . 'images');
    }


Opérations
------------

**Reçus fiscaux individuels ou uniques**
Il s'agit de reçus délivrés comme un reçu pour une contribution.

Pour émettre un reçu individuel, ouvrez l'enregistrement du contact, accédez à l'onglet "contributions", affichez la contribution et cliquez sur le bouton "Reçu fiscal". Suivez les instructions à l'écran à partir de là.
Des reçus uniques peuvent être émis en bloc pour plusieurs contributions. Ce processus délivre un reçu par contribution.
Pour émettre des reçus en masse, accédez à Contributions > Rechercher des contributions, lancez une recherche, sélectionnez un ou plusieurs résultats de recherche, puis sélectionnez « Émettre des reçus fiscaux » dans le menu déroulant des actions. Suivez les instructions à l'écran à partir de là.

**Test des reçus fiscaux**

- Pour tester les paramètres de votre modèle et afficher un reçu sans envoyer d'e-mail au contact ni créer d'enregistrement dans la base de données, suivez les instructions pour l'émission groupée de reçus : accédez à Contributions > Rechercher des contributions, lancez une recherche, sélectionnez un résultat de recherche, puis sélectionnez "Émettre des reçus fiscaux" dans le menu déroulant des actions. Sur l'écran suivant, assurez-vous de sélectionner "Exécuter en mode aperçu ?", et suivez les instructions à l'écran pour les autres options, un pdf sera généré.

**Suivi des ouvertures par e-mail**

- Les versions antérieures de cette extension nécessitaient une autorisation -> "Reçus fiscaux CDN CiviCRM : suivi ouvert". Ce n'est plus nécessaire - mais assurez-vous que le paramètre $openTracking est dans le modèle de message !

hook
------------

Cette extension embarque tous les hooks du fork. Cependant, un arbitrage sera effectué pour conserver, modifier ou supprimer certains hooks.

Clause de non-responsabilité
------------

Cette extension a été développée en consultation avec un certain nombre d'organisations à but non lucratif et avec l'aide d'un consultant senior.
