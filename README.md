## Jgallery

Objectif : réaliser un site web accessible au grand public.
Ce site hébergera, des centaines d’images appartenant à divers utilisateurs enregistrés.

# Gestionnaire utilisateurs

Système d’enregistrement des utilisateurs.
	Creation
	Modification
	suppression

	
# Le "wall" utilisateur

Chaque utilisateur dispose d’un "wall" (pour ne pas citer d’exemple connu...), sur lequel il 
pourra afficher l’ensemble de ses images.

Jquery organise et synchronise le mur d'image'.


# Gestion des images

Système "d’upload" d’images avancé en AJAX.
L’utilisateur peut, à sa guise, organiser ses images dans des dossiers (albums).
Sytème de gestion des images (suppression, renommage,déplacement, ...).
Une même image peut être présente dans plusieurs répertoires néanmoins, il ne peut 
pas y avoir de doublon. Un seul fichier unique.

# Gestion des droits

La consultation des fichiers est limitée (ou non, selon le type du
profil de l’utilisateur) et inclus un système de droits afin de controller les accès.

Les fichiers des utilisateurs ne sont pas accessibles àdes utilisateurs non-enregistrés

Un "wall" peut être public, ainsi l’ensemble des fichiers sera accessible
aux membres du site.

Si l’utilisateur le souhaite, il peut limiter certains albums à une liste d’utilisateurs
(amis).

Système de commentaires avancé.