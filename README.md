# SuperMart
Starter Tempalte

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Custom CSS-->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/index.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!--Fonts & Icons-->
    <script src="https://kit.fontawesome.com/7b5b4fcd9f.js" crossorigin="anonymous"></script>


    <title>Hello, world!</title>
</head>
<body>
<!--<nav class="navbar navbar-light bg-light">-->
<!--    <div class="container-fluid">-->
<!--        <a class="navbar-brand" href="#">SuperMart</a>-->
<!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">-->
<!--            <span class="navbar-toggler-icon"></span>-->
<!--        </button>-->
<!--    </div>-->
<!--    <div class="collapse navbar-collapse" id="navbarToggleExternalContent">-->
<!--        <div class="bg-dark p-4">-->
<!--            <h5 class="text-white h4">Collapsed content</h5>-->
<!--            <span class="text-muted">Toggleable via the navbar brand.</span>-->
<!--        </div>-->
<!--    </div>-->
<!--</nav>-->

<!--Navigation bar section start here-->

<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <div class="container">
            <div class="row justify-content-between align-items-center mt-3">
                <div class="col-6 col-md-4">
                    <a  href="#">
                        <img src="images/SuperMART.png" class="img-fluid" alt="...">
                    </a>
                </div>
                <div class="col-6 text-end">
                    <button type="button" class="p-2 btn">
                        <a href="myprofile.html" class="fas fa-user text-dark fa-lg"></a>
                    </button>
                    <button type="button" class="p-2 btn">
                        <a href="cart.html" class="fas fa-shopping-cart text-dark fa-lg"></a>
                    </button>
                    <button type="button" class="p-2 btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="fas fa-bars fa-2x fa-lg"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-start" tabindex="-1" id="offcanvasNavbar"
                         aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">SuperMart</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="promotions.html">
                                        <span class="fa-solid fa-tag"></span>
                                          Promotions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="stores.html">
                                        <span class="fa-solid fa-store"></span>
                                          Stores</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="wishlist.html">
                                        <span class="fa-solid fa-heart"></span>
                                          Wishlist</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown"
                                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-grip"></i> Categories
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                                        <li><a class="dropdown-item" href="#">Fruits & Vegetables</a></li>
                                        <li><a class="dropdown-item" href="#">Meat & Poultry</a></li>
                                        <li><a class="dropdown-item" href="#">Beverages</a></li>
                                        <li><a class="dropdown-item" href="#">Homeware items</a></li>
                                        <li><a class="dropdown-item" href="#">Snacks</a></li>
                                        <li><a class="dropdown-item" href="#">Beauty Products</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4 justify-content-center">
                <div class="col-11">
                    <form class="d-flex">
                        <button class="btn btn-outline-success fa-solid fa-qrcode fa-lg text-green"></button>
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success fa-solid fa-magnifying-glass fa-lg btn-success text-light"></button>
                    </form>
                </div>
            </div>

        </div>


    </div>
</nav>

<!--navigation bar section ends here-->




<!--Footer section-->
<div class="container-fluid background-color footer">
    <div class="container">
        <div class="row fs-2 fw-bold p-2">
            <div class="col-sm-12 p-2" onclick="window.location.href='index.html'">
                SuperMart
            </div>
        </div>
        <div class="row p-2">
            <div class="col-sm-12 col-md-4 col-lg-4 p-2">
                <div class="fw-bold fs-4">Need Help?</div>
                Call our customer support at <br>123-456-7890
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 p-2">
                <div class="fw-bold fs-4">Menu</div>
                <div onclick="window.location.href='promotions.html'">Promotions</div>
                <div onclick="window.location.href='index.html'">Categories</div>
                <div onclick="window.location.href='stores.html'">Stores</div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 p-2">
                <div class="fw-bold fs-4">Info</div>
                <div onclick="window.location.href='stores.html'">About Us</div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-12">
                <i class="fa fa-facebook p-1 fs-1" onclick="window.open('https://facebook.com')"></i>
                <i class="fa fa-instagram p-1 fs-1" onclick="window.open('https://instagram.com')"></i>
                <i class="fa fa-twitter p-1 fs-1" onclick="window.open('https://twitter.com')"></i>
            </div>
        </div>
        <div class="row p-2 text-center">
            <div class="col-sm-12">
                ©2021 - SuperMart, LLC. All Rights Reserved
            </div>
        </div>
    </div>
</div>
<!--End of footer section-->

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
</html>

