# REWORK DB CHECKLIST

## 1/ Suppression de toutes les traces de l'entity "locality" 

## 2/ Suppression des groups, et des fixtures liées à "locality"

## 3/ Création de l'entitée  liées à la Localitée de l'utilisateur :

[- table City: -]

    -id
    -name
    -zipcode

[-             -]

## 4/ Relations :

l'adresse de l'utilisateur est reliée à la ville correspondante dans la table city.
un utilisateur peut avoir une seule ville, une ville peut avoir plusieurs utilisateurs.

l'adresse est reliée à l'user, afin de pouvoir avoir accès à la ville dans cet ordre: User->Adress->City
un user peut avoir une seule adresse.
un post ne peut avoir qu'une seule ville et une ville peut avoir plusieurs posts.

## 5/ refaire les fixtures
### 5.1/ vider la db dev
#### 5.2/charger les fixtures

## 6/ refaire le controlleur pour city (make crud)

## 7/ refaire le controlleur api pour city 

## 8/ refaire les routes en GET. 

## 9/tester et merger sur la branche de dev et continuer les routes en POST.
