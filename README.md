# notesIMT
Projet de visualisation des notes des étudiants de TSP et IMT-BS.

Aujourd'hui un étudiant met plusieurs clics avant de pouvoir récupérer ces notes. Il n'y a pas de lien direct.
Ce projet a donc pour but de minimiser le nombre de clics en proposant une page dédiée à l'affichage des moyennes de l'étudiant.

Le projet se base sur la récupération des notes en XML depuis le serveur de report connecté à la DB de l'école.
Celui-ci est sur une architecture MS SQL + IIS.

On récupère via une requête curl (login NTLM) ce fichier, on le parse en JSON et on le traite ainsi.

Ce code n'est pas optimal, utilise des langages désuets mais est fonctionnel et hébergé sur mon serveur.

Toute proposition est bien venue.
