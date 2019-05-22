<?php

function PrintHead()
{

    print '<head>
        <meta charset="UTF-8">
        <title>Vrije opdracht PHP</title>
        <link rel="stylesheet" href="/css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="/javascript/general.js">
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    </head>';
}

function PrintUpper()
{
    ?>
    <div id="info" class="container">
        <img src="/images/logo.png" alt="logo">
        <?php Login();
        if ( !isset($_SESSION["user"]))
        { print '<button id="goToLog" class="container" type="button">Login <span class="fas fa-arrow-circle-up"></span></button>'; }
        ?>
    </div>
    <?php
}

function PrintHeader()
{
    ?>
    <header id="mainheader" class="parallax-header" data-parallax="scroll">
        <?php PrintNavbar(); ?>
    </header>
    <?php
}

function PrintNavbar()
{
    ?>
    <nav id="mainnav">
        <ul class="unlist container">
            <li><a href="/index.php">Home</a></li>

            <?php
            //opvragen categorieën
            $sql = "SELECT * FROM vo_categorie";
            $res_cat = $_SERVER['conn']->query($sql);

            //<!--        for looping categorieën + link    -->
            while($row = $res_cat->fetch_assoc())
            {
                $cat = $row['cat_naam'];
                $id = $row['cat_id'];
                print'<li><a href="/cat/categorie.php?id='.$id.'">' .$cat.'</a></li>';
            }
            ?>

        </ul>
    </nav>
    <?php
}

function PrintCategoriën() {
    //opvragen categorieën
    $sql = "SELECT * FROM vo_categorie";
    $res_cat = $_SERVER['conn']->query($sql);
    //<!--    looping in categorielijst   -->
    while($row = $res_cat->fetch_assoc())
    {
        $id = $row['cat_id'];
        $cat = $row['cat_naam'];
        $src = $row['cat_foto'];
        $omschr = $row['cat_omschrijving'];
        print '<figure class="categorie">
              <h3>'.$cat.'</h3>
              <img src="images/'.$src. '" alt="">
              <figcaption>
                  <p>'.$omschr.'</p>
                  <a href="/cat/categorie.php?id='.$id.'">Bekijk de workshops</a>
              </figcaption>
        </figure>';
    }
}

function PrintWorkshopsVanCategorie() {
    $sql = "select * from vo_categorie where cat_id=" .$_GET["id"];
    $result = $_SERVER['conn']->query($sql);
    $row = $result->fetch_assoc();

    $cat = $row["cat_naam"];
    $cat_omschr = $row["cat_omschrijving"];

    //titel categorie
    print '<section class="flex flexC">
            <h2 class="align-center">'.$cat. '</h2>
            <p class="align-center">'.$cat_omschr. '</p>
        </section>';

    //opvragen workshop in deze categorie
    $sql = "SELECT * FROM vo_workshop where wor_cat_id=" .$_GET["id"];
    $res_wor = $_SERVER['conn']->query($sql);

    print '<section class="flex articles">';
    //<!--    looping in workshop   -->
    while($row = $res_wor->fetch_assoc())
    {
        $id = $row['wor_id'];
        $wor = $row['wor_naam'];
        $wor_src = $row['wor_foto'];
        $wor_omschr = $row['wor_omschrijving'];
        print '<div class="categorie workshop">
                <h3>'.$wor.'</h3>
                <figure>
                    <img src="../images/'.$wor_src. '" alt="">
                    <figcaption class="flex">
                        <a href="/det/detail.php?id='.$id.'">Bekijk deze workshop...</a>
                    </figcaption>
                </figure>
        </div>';
    }
    print '</section>';
}

function PrintScript()
{
    ?>
    <script>
        $(document).ready(function(){
            /*hoogte & offset van navbar opslaan bij laden pagina
            voor hoogte & plakpunt van sticky navbar*/
            var h = $('#mainnav').height();
            var offsetTop = $('#mainnav').offset().top;

            //bij scrollen link naar login + sticky navbar
            $(window).scroll(function () {

                var scroll = $(window).scrollTop();
                if (scroll >= 80) {
                    $('#goToLog').css('display', 'block');
                    $('#goToLog').on('click', function () {
                        window.scrollTo(0,0);
                    });
                    if (scroll >= 240) {
                        $('#goToLog').css('top', '60px');
                    } else { $('#goToLog').css('top', '.2rem'); }
                } else {
                    $('#goToLog').css('display', 'none');
                }

                if (scroll >= offsetTop) {
                    $('#mainnav').addClass('stickynav');
                    $('#mainnav').css('height', h);
                    $('#mainnav').offset().top = 0;
                } else {
                    $('#mainnav').removeClass('stickynav');
                }
            });

            /*werkt niet!!
            $('#mainnav ul li a').on('click', function () {
                $('#mainnav ul li a').removeClass('active');
                $(this).addClass('active');
            });*/

            //huidige pagina zichtbaar op navbar
            $('a').each(function(){

                if ($(this).prop('href') == window.location.href) {
                    var checkNav = $('#mainnav').has(this).length;
                    if (checkNav == 1) {
                        $(this).addClass('active');
                        $(this).parents('li').addClass('active_li');
                    } else {
                        $(this).css('color','#ed3b61');
                    }
                }

            });

            //div categorie klikbaar maken
            $('.categorie').on('click', function () {
                var link = $(this).find('a').attr('href');
                window.location.href = link;
            })

            //workshop hover
            $('.workshop').hover(
                function () {
                    $(this).find('img').css('opacity','.3');
                    $(this).find('a').css('visibility','visible');
                }, function () {
                    $(this).find('img').css('opacity','1');
                    $(this).find('a').css('visibility','hidden');
                }
            );

            //registratie: wwcontrole
            $("#regform").submit(function(event) {
                var ww = $(this).find("input[type='password']").first().val();
                var checkww = $(this).find("input[type='password']").last().val();
                if( ww != checkww) {
                    alert("Uw wachtwoorden komen niet overeen");
                    event.preventDefault();
                }
            });

            //telefooncheck
            $("form").submit(function (event) {
                var phone = $('input[name="reg_telefoon"]').val(),
                    intRegex = /[0-9 -()+]+$/;
                if((phone.length < 6) || (!intRegex.test(phone)))
                {
                    alert('Geen geldig telefoonnummer!');
                    event.preventDefault();
                }
            });

            //visuele wwcheck bij change psw
            $("#adjust-psw").submit(function (event) {
                var ww = $(".check-one").first().val();
                var checkww = $(".check-two").last().val();
                if (ww != checkww) {
                    $(".check-one, .check-two").css("border-color", "red");
                    alert("De controle op uw nieuw wachtwoord is foutief");
                    event.preventDefault();
                }

            });
            $(".check-one, .check-two").change(function(){
                $(this).css("border-bottom", "1px solid black");
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/parallax.js/1.4.2/parallax.min.js"></script>

    <script>
        $('.parallax-header').parallax({imageSrc: '/images/achtergrond.png'});
    </script>
    <?php
}
?>