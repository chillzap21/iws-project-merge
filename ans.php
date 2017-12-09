<!DOCTYPE html>
<html>
    <head>
        <title> Write Answers - Quora </title>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
        <style>
            aside{
                width: 200px;
            }
            aside a{
                color: darkgray;
            }
        </style>
    </head>
    <body  background="back.jpg">
<?php
session_start();
            if($_SESSION['valid']==false){
            header('Location:login.php');
            }
        ?>
        <header>
        <ul id="navbar">
            <li> <a href="index.php"> <img src="quora.png" width="80" height="40"></a>  </li>
            <li> <a href="index.php">Home</a></li>
            <li> <a href="ans.php" class="active">Answer</a></li>
            <li> <a href="notif.php">Notifications</a></li>
            <li> <input type="text" name="searchbar" placeholder="Search on Quora" style= "height:1.4em; width:27em;"> </li>
            <li> <a href="logout.php"><input type="button" name="ask" value="Logout" href="logout.php" style= "background-color: #AA2200; color: white; height: 2em;"> </a></li>
        </ul>
        </header>
        <aside style="float:left; margin-left:120px;">
            <p style="border-bottom:0.5px solid lightgray;">Questions</p>
            <a href=""> Questions For You</a>
            <br>
            <a href=""> Answer Requests</a>
            <br>
            <a href=""> Answer Later</a>
            <br>
            <a href=""> Drafts </a>
        </aside>
        <section id="qa">
            <article>
                <p class="ques"> Sample Question 1? </p>
                <p style="font-size:10px;color: gray;"> x Answers</p>
                <button class="blue"> Answer </button>
                <button class="blue"> Pass </button>
                <a class="links">Follow</a>
                <a class="links"> Downvote</a>
            </article>
            <article>
                <p class="ques"> Sample Question 2? </p>
                <p style="font-size:10px;color: gray;"> x Answers</p>
                <button class="blue"> Answer </button>
                <button class="blue"> Pass </button>
                <a class="links">Follow</a>
                <a class="links"> Downvote</a>
            </article>
        </section>
    </body>