<?php
    require_once 'inc/functions.php';    
    reconnexion();
    ob_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" />
    <title>GEOPV</title>

    <!-- Bootstrap -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome-4.3.0.min.css /"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script src="https://kit.fontawesome.com/d40df77f00.js" crossorigin="anonymous"></script> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- JQUERY -->
    <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>   
    
    <!-- CSS -->    
    <link rel="stylesheet" type="text/css" href="css/normalize-3.0.3.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- GOOGLE FONT --> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- JAVASCRIPT Libraries -->    
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar navbar-dark" > 
    <div class="container-fluid">
        <a class="navbar-brand px-3" href="index.php"><img src="./img/geopv_logo.png" alt="geopv_logo" style="width:200px;"/></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-center navbar-text" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item mx-1">
                    <a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <li class="nav-item">                
                    <a class="nav-link" href="#presentation"><i class="fas fa-newspaper"></i> Le service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#atouts"><i class="fas fa-chart-line"></i> Les atouts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#fonctionnement"><i class="fas fa-users-cog"></i> Fonctionnement</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="#prix"><i class="fas fa-hand-holding-usd"></i> Nos prix</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#apropos"><i class="fas fa-info"></i> À propos</a>
                </li>         
            <?php if(isset($_SESSION['auth'])): ?>                
                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user"></i> Connecté
                  </a>
                  <ul class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="profile.php?id=<?php echo $_SESSION['auth']->id ?>"><i class="fas fa-address-card"></i> Mon profil</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="profile_edit.php?id=<?php echo $_SESSION['auth']->id ?>"><i class="fas fa-user-edit"></i> Éditer profil</a>
                    </li>                     
                    <li>
                        <a class="dropdown-item" href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </li>                                        
                  </ul>
                </div> 
            <?php else: ?> 
                <li class="nav-item mx-1">
                    <a class="nav-link"  href="#" data-bs-toggle="modal" data-bs-target="#connexionModal"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
        
<!--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0974F1" fill-opacity="1" d="M0,256L1440,160L1440,0L0,0Z"></path></svg>--> 

<div class="container">

    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="w-50 mx-auto text-center alert alert-<?= $type; ?>">
                <?= $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
</div>

<!-- GO TOP BUTTON -->
<div id="scrollUp" >
    <a href="#top"><img src="./img/to top.png" alt="GO TOP"></a>
</div>


