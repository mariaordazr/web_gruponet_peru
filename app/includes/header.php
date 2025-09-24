<?php
session_start();

if(empty($_SESSION['active'])){
    header('location: login.php');
}
?>
    <!--================ HEADER ================-->
    <header class="header">
        <div class="header__container">
            <img src="views/img/perfil-vanessa.jpg" alt="" class="header__img">

            <p class="header__logo">Lima, <?php echo fechaC(); ?></p>

            <div class="header__search">
                <input type="search" placeholder="Search" class="header__input">
                <i class='bx bx-search header__icon'></i>
            </div>

            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
        </div>
        <?php include ("nav.php"); ?>
    </header> 