<?php
    require_once 'inc/functions.php';
    $pageencours = "accueil";
    require 'inc/header.php';
    reconnexion();
    //phpinfo();
?>

<!-- MAIN -->
<main>

    <!-- Button trigger modal: enlevé et replacé dans le menu du site -->
    <!-- MODAL CONNEXION -->
    <div class="modal fade" id="connexionModal" aria-labelledby="connexionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="mx-auto bg-light rounded p-5 my-0" action="" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="#" class="">
                                <h2 class="text-danger">CONNEXION</h2>
                            </a>
                            <h3>Vous devez être enregistré</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="nom@exemple.fr">
                            <label for="floatingInput">Adresse mail</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
                            <label for="floatingPassword">Mot de passe</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Se rapeller</label>
                            </div>
                            <a href="">Mot de passe oublié?</a>
                        </div>
                        <button type="submit" class="btn btn-danger py-3 w-100 mb-4">Se connecter</button>
                        <p class="text-center mb-0">Pas encore de compte? <a href="#inscriptionModal" data-bs-toggle="modal" data-bs-target="#inscriptionModal" data-bs-dismiss="modal">S'inscrire</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Button trigger modal: enlevé et replacé dans le menu du site -->
    <!-- MODAL INSCRIPTION -->
    <div class="modal fade" id="inscriptionModal" aria-labelledby="inscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="mx-auto bg-light rounded p-5 my-0" action="" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="#" class="">
                                <h2 class="text-primary">INSCRIPTION</h2>
                            </a>
                            <h3>Si pas encore de compte</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" placeholder="pierre75">
                            <label for="floatingText">Nom d'utilisateur</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="nom@exemple.fr">
                            <label for="floatingInput">Adresse mail</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
                            <label for="floatingPassword">Mot de passe</label>
                        </div>
                        <div class="form-floating mb-4">                    
                            <input type="password" class="form-control" id="floatingConfirmPassword" placeholder="Vérifier mot de passe">
                            <label for="floatingConfirmPassword">Confirmer Mot de passe</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Se rapeller</label>
                            </div>                            
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">S'inscrire</button>
                        <p class="text-center mb-0">Déjà enregistré? <a href="#connexionModal" data-bs-toggle="modal" data-bs-target="#connexionModal" data-bs-dismiss="modal">Se connecter</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CAROUSSEL -->
    <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!--<div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>-->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./img/caroussel_01.jpg" class="d-block w-100" alt="...">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1 class="mb-2" style="font-weight:bold;color: white;">Investisseurs ou constructeurs?</h1>
                            <h2 class="mb-2" style="font-weight:bold;color: white;">Pour implanter des panneaux photovoltaïques sur des hectares!</h2>
                            <p><a class="btn btn-carou btn-danger" href="#prix">S'inscrire maintenant!</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/caroussel_02.jpg" class="d-block w-100" alt="...">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1 class="mb-2" style="font-weight:bold;">Utilisez Geopv pour vos recherches</h1>
                            <h2 class="mb-2" style="font-weight:bold;">Produisez pour votre consommation ou revendez!</h2>
                            <p><a class="btn btn-carou btn-danger" href="#fonctionnement">En savoir +</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/caroussel_04.jpg" class="d-block w-100" alt="...">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1 class="mb-2" style="font-weight:bold;color: white;">Recherche de cadastres par critères</h1>
                            <h2 class="mb-2" style="font-weight:bold;color: white;">Base de données d'informations sur les cadastres qui peuvent vous intéresser</h2>
                            <p><a class="btn btn-carou btn-danger" href="#fonctionnement">Voir</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/caroussel_03.jpg" class="d-block w-100" alt="...">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1 class="mb-2" style="font-weight:bold;">Pas de demi-mesures! Abonnez-vous vite!</h1>
                            <h2 class="mb-2" style="font-weight:bold;">Investissez-vous dans le devenir énergétique de grand ampleur!</h2>
                            <p><a class="btn btn-carou btn-danger" href="#prix">Voir</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédemment</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    <!-- FIN CAROUSSEL -->


    <!-- SECTION 1 : PRESENTATION APP -->
    <section id="presentation" class="py-3">
        <div class="container py-2">
            <h1 class="titre-presentation text-center my-3">Présentation du service</h1>
        </div>
        <!--<div class="bloc-presentation mx-auto my-3">
            <p class="desc-presentation">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error repellat, ipsum libero nesciunt vero sit. Soluta tenetur accusantium eum facere molestiae neque non at aperiam, adipisci quo repellat? Voluptatibus, accusantium?</p>
            <img src="./img/presentation.svg" class="image-presentation" alt="">
        </div>-->

        <div class="bloc-presentation mx-auto my-0">
            
            <div class="presentation align-items-center my-0">
                <!--<div class="col-lg-7"><img class="image-card rounded mb-4 mb-lg-0" src="https://dummyimage.com/900x400/dee2e6/6c757d.jpg" alt="..." /></div>-->
                <div class="col-lg-5">
                    <h1 class="titre-para-presentation font-weight-light my-4">Application cartographique GeoPV</h1>
                    <p class="paragraphe">Comment procéder pour obtenir l'accès à l'application GeoPV via le site web : commencer par la création d'un compte, c'est rapide et vous n'aurez plus qu'à prendre le temps de lire la description de nos différentes offres d'accès à l'application cartographique GeoPV.</br> Ne perdez pas de temps!</p>
                    <a class="btn btn-danger w-100 my-4" href="#connexionModal">Création d'un compte</a>
                </div>
                <img src="./img/presentation.svg" class="image-presentation" alt="">
            </div>
            
            <div class="card text-white bg-secondary mb-5 py-1 text-center">
                <div class="card-body"><p class="text-white m-0">Simplement suivre les étapes décritent ci-dessous afin de profiter des différents accès à l'application en prenant soin de choisir l'offre qui vous correspond!</p></div>
            </div>
            
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Étape 1</h2>
                            <p class="paragraphe card-text">Création d'un compte GeoPV de suite pour accéder à nos 3 offres dont une formule de paiement à la recherche ainsi qu'un abonnement.</p>
                        </div>
                        <div class="card-footer"><a class="btn btn-danger btn-sm" href="#prix">Voir les offres</a></div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Étape 2</h2>
                            <p class="paragraphe card-text">Compléter correctement votre profil via l'interface et démarrer une recherche de votre choix sur le formulaire de l'outil cartographique.</p>
                        </div>
                        <div class="card-footer"><a class="btn btn-danger btn-sm" href="#prix">Voir les offres</a></div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Étape 3</h2>
                            <p class="paragraphe card-text">Visualisation de données issues des couches d'informations disponibles pour les cadastres, les zones urbaines, et les éléments de l'ensemble du réseau électique.</p>
                        </div>
                        <div class="card-footer"><a class="btn btn-danger btn-sm" href="#prix">Voir les offres</a></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- FIN SECTION 1 : PRESENTATION APP -->

    <hr class="grad">
        <div class="bg-service">
            <q>Un savoir-faire pour répondre à vos besoins au mieux possible</q>          
        </div>
    <hr class="grad">

    <!-- SECTION 2 : ATOUTS APP -->
    <section id="atouts" class="py-3">
        <div class="container py-2">
            <h1 class="titre-atouts text-center my-3">Les atouts</h1>
        </div>
        <div class="bloc-atouts mx-auto my-3">
            <img src="./img/atouts.svg" class="img2-atouts mb-5" alt="">
            <p class="paragraphe desc2-atouts">Bénéficiez d'un accès à une multitude d'informations provenant d'une expérience de long termes dans la récolte de données concrètes concernant toute la métropole.</p>        
        </div>        
    </section>
    <!-- FIN SECTION 2 : ATOUTS APP -->

    <hr class="grad">
        <div class="bg-service">
            <q>Rapidité d'interaction, facilité d'utilisation</q>            
        </div>
    <hr class="grad">

    <!-- SECTION 3 : FONCTIONNEMENT APP -->
    <section id="fonctionnement" class="py-3">
        <div class="container py-2">
            <h1 class="titre-fonctionnement text-center my-3">Fonctionnement</h1>
        </div>
        <div class="bloc-fonctionnement mx-auto my-3">
            <p class="paragraphe desc-fonctionnement">Possibilité d'extraire les informations obtenues par la recherche effectuée sur les couches de données au format adéquat.</p>        
            <img src="./img/fonctionnement.svg" class="img-fonctionnement" alt="">
        </div> 
    </section>
    <!-- FIN SECTION 3 : FONCTIONNEMENT APP -->

    <hr class="grad">
        <div class="bg-service">
            <q>Recherche précise, visualisation des données de l'API et extraction!</q>            
        </div>
    <hr class="grad">

    <!-- SECTION 4 : NOS OFFRES APP -->
    <section id="prix" class="py-3">
        <div class="container pt-2">
            <h1 class="titre-prix text-center my-3">Nos prix et abonnements</h1>
            
        </div>
        <div class="mx-auto text-center py-2">
            <img src="./img/prix.svg" class="svg-prix" alt="">
        </div>
        <div class="bloc-prix mx-auto my-0">
            <p class="paragraphe desc3-prix2">Ne perdez plus de temps! Vous avez besoin de plus d'informations sur un cadastre, essayez la formule 10 jetons sans hésitations!</p>
        </div>
        <div class="bloc-prix mx-auto my-0">
            <p class="paragraphe desc3-prix2">Déjà adepte de notre système? Veuillez passer en status d'abonné sans tarder!</p>          
        </div>        
       
        <div class="container mx-auto my-5 row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">10 jetons</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">12€<small class="text-muted fw-light"></small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                    <li>10 jetons à utiliser</li>
                    <li>Accès limité</li>
                    <li>Email de support</li>
                    </ul>
                    <button type="button" class="w-100 btn btn-lg btn-outline-danger">Essayez!</button>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">Pro</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">30€<small class="text-muted fw-light"></small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                    <li>30 jetons à utiliser</li>
                    <li>Accès full listes</li>
                    <li>Email de support</li>
                    </ul>
                    <button type="button" class="w-100 btn btn-lg btn-danger">Commencez!</button>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm border-danger">
                <div class="card-header py-3 text-white bg-danger border-danger">
                    <h4 class="my-0 fw-normal">Abonnement</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">29€<small class="text-muted fw-light">/mois</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                    <li>Accès illimité</li>
                    <li>Accès full listes</li>
                    <li>Plus de 500 communes</li>
                    <li>Email de support</li>
                    </ul>
                    <button type="button" class="w-100 btn btn-lg btn-danger">De suite!</button>
                </div>
                </div>
            </div>
        </div>

        <h2 class="text-center mb-4">Comparaison des offres</h2>

        <div class="container mx-auto my-5 table-responsive">
            <table class="table text-center table-striped">
                <thead>
                <tr>
                    <th style="width: 34%;"></th>
                    <th style="width: 22%;">10 jetons</th>
                    <th style="width: 22%;">Pro</th>
                    <th style="width: 22%;">Abonnement</th>           
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" class="text-start">Compte securisé</th>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th scope="row" class="text-start">Permissions</th>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th scope="row" class="text-start">Accès département</th>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th scope="row" class="text-start">Accès région</th>
                    <td></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th scope="row" class="text-start">Rétractation</th>
                    <td></td>
                    <td></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th scope="row" class="text-start">Jetons illimités</th>
                    <td></td>
                    <td></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                </tbody>
            </table>
        </div>

    </section>
    <!-- FIN SECTION 4 : NOS OFFRES APP -->

    <hr class="grad">
        <div class="bg-service">
            <q>Investisseurs ou constructeurs, l'application GeoPV vous tient!</q>           
        </div>
    <hr class="grad">

    <!-- SECTION 5 : À PROPOS APP -->
    <section id="apropos" class="py-3">
        <div class="container py-2">
            <h1 class="titre-apropos text-center my-3">À propos</h1>
        </div>
        <div class="bloc-apropos mx-auto mt-3">
            <p class="paragraphe dsc-apropos my-5">
            À la base fondée par des professionnels expérimentés dans leur domaine, Renergies est une société spécialisé dans le secteur du photovoltaïque basée sur la région Lyonnaise. Nous intervenons sur la France entière. <br><br>
            À travers l'application GeoPV, nous souhaitons faciliter l'accès aux recherches effectuées par les investisseurs et constructeurs du domaine du solaire sur l'ensemble du territoire de l'hexagone.<br><br>
            Notre mission a pour objectif de réduire le temps de recherche pour certains types de données précises, tout en ayant la possibilité d'en sauvegarder les resultats.</p>        
            <img src="./img/apropos.svg" class="img-apropos" alt="">
        </div> 

        <!-- A PROPOS -->
        <div class="container-fluid mx-auto my-5">
            <div class="row w-100 h-100 mx-auto justify-content-center align-items-start">  <!--style="min-height: 100vh;"-->
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">

                    <form class="mx-auto bg-light rounded p-4 p-sm-5 my-4 mx-3" action="" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h2 class="text-primary">À PROPOS</h2>
                            </a>
                            <h3>Si vous avez une question</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" placeholder="Dupont">
                            <label for="floatingText">Nom</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" placeholder="Jacques">
                            <label for="floatingText">Prénom</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" placeholder="AlphaBâti69">
                            <label for="floatingText">Société</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="nom@exemple.fr">
                            <label for="floatingInput">Adresse mail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="floatingTextarea" placeholder="Laisser un message ici.." style="height:75px;"></textarea>
                            <label for="floatingTextarea">Message</label>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Envoyer</button>                    
                    </form>

                </div>
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="mx-auto bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d89077.17183972045!2d4.765090345653721!3d45.75792930291083!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4ea516ae88797%3A0x408ab2ae4bb21f0!2sLyon!5e0!3m2!1sfr!2sfr!4v1651826526913!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="width:25%"></iframe>                       
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN A PROPOS -->  
    </section>
    <!-- FIN SECTION 5 : À PROPOS APP -->

</main>
<!-- MAIN -->  
 
<?php    
    require 'inc/footer.php';
?>

