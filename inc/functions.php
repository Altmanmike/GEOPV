<?php

function estConnecte()
{
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(!isset($_SESSION['auth']))
    {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('refresh:0, url: connexion.php');        
    }
}

function seDeconnecter()
{  
    session_start();
    setcookie('serappeler', NULL, -1);
    unset($_SESSION['auth']);
}

function reconnexion()
{
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(isset($_COOKIE['serappeler']) && !isset($_SESSION['auth']))
    {
        require_once 'db.php';

        if(!isset($pdo)){
            global $pdo;
        }

        $serappeler_jeton = $_COOKIE['serappeler'];
        $parts = explode('==', $serappeler_jeton);
        $formateur_id = $parts[0];

        $req = $pdo->prepare('SELECT * FROM formateur WHERE id = ?');
        $req->execute([$formateur_id]);
        $formateur = $req->fetch();

        if($formateur)
        {
            $expected = $formateur_id . '==' . $formateur->serappeler_jeton . sha1($formateur_id . 'epsi');

            if($expected == $serappeler_jeton)
            {
                session_start();

                $_SESSION['auth'] = $formateur;
                setcookie('serappeler', $serappeler_jeton, time() + 60 * 60 * 24 * 7);
            }
            else
            {
                setcookie('serappeler', null, -1);
            }
        }
        else
        {
            setcookie('serappeler', null, -1);
        }
    }
}

function str_random($length)
{
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function diffdatetime($date, $now)
{
    if(strlen($now) == strlen($date))
    {
        $annee = (substr($now, 0, 4) - substr($date, 0, 4));
        $mois  = (substr($now, 5, 2) - substr($date, 5, 2));
        $jour  = (substr($now, 8, 2) - substr($date, 8, 2));  
        $heure = (substr($now, 11, 2) - substr($date, 11, 2));   

        if($annee == 1)
        {
            echo ' 1 an.';
        } 
        elseif($annee > 0)
        {
            echo ' '.$annee.' ans.';
        } 
        else 
        {
            if($mois == 1)
            {
                echo ' 1 mois.'; 
            }
            elseif($mois > 0)
            {
                echo ' '.$mois.' mois.';
            }
            else
            {                
            
                if($jour == 1)
                {
                    echo ' 1 jour.'; 
                }
                elseif($jour > 0)
                {
                    echo ' '.$jour.' jours.';
                }
                else
                {
                    if($heure == 1)
                    {
                        echo ' 1 heure.'; 
                    }
                    elseif($heure > 0)
                    {
                        echo ' '.$heure.' heures.';
                    }
                    else echo ' quelques minutes.';
                }
            }
        }            
    }
    else die('Mauvaise date');
}