<?php
session_start();

$loggedIn = false;

if (isset($_SESSION['loggedIn']) && isset($_SESSION['name'])) {
    $loggedIn = true;
}

$conn = new mysqli('localhost', 'root', '', 'ytCommentSystem');

function createCommentRow($data) {
    global $conn;

    $response = '
            <div class="comment">
                <div class="user">'.$data['name'].' on <span class="time">'.$data['createdOn'].'</span></div>
                <div class="userComment">'.$data['comment'].'</div>
                <div class="reply"><a href="javascript:void(0)" data-commentID="'.$data['id'].'" onclick="reply(this)">reply</a></div>
                <div class="replies">';

    $sql = $conn->query("SELECT replies.id, name, comment, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies INNER JOIN users ON replies.userID = users.id WHERE replies.commentID = '".$data['id']."' ORDER BY replies.id DESC LIMIT 1");
    while($dataR = $sql->fetch_assoc())
        $response .= createCommentRow($dataR);

    $response .= '
                        </div>
            </div><hr>
        ';

    return $response;
}


if (isset($_POST['getAllComments'])) {
    $start = $conn->real_escape_string($_POST['start']);

    $response = "";
    $sql = $conn->query("SELECT comments.id, name, comment, DATE_FORMAT(comments.createdOn, '%Y-%m-%d') AS createdOn FROM comments INNER JOIN users ON comments.userID = users.id ORDER BY comments.id DESC LIMIT $start, 20");
    while($data = $sql->fetch_assoc())
        $response .= createCommentRow($data);

    exit($response);
	
}

if (isset($_POST['addComment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $isReply = $conn->real_escape_string($_POST['isReply']);
    $commentID = $conn->real_escape_string($_POST['commentID']);

    if ($isReply != 'false') {
        $conn->query("INSERT INTO replies (comment, commentID, userID, createdOn) VALUES ('$comment', '$commentID', '1', NOW())");
        $sql = $conn->query("SELECT replies.id, name, comment, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies INNER JOIN users ON replies.userID = users.id ORDER BY replies.id DESC LIMIT 1");
    } else {
        $conn->query("INSERT INTO comments (userID, comment, createdOn) VALUES ('2','$comment',NOW())");
        $sql = $conn->query("SELECT comments.id, name, comment, DATE_FORMAT(comments.createdOn, '%Y-%m-%d') AS createdOn FROM comments INNER JOIN users ON comments.userID = users.id ORDER BY comments.id DESC LIMIT 1");
    }

    $data = $sql->fetch_assoc();
    exit(createCommentRow($data));
}

if (isset($_POST['register'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = $conn->query("SELECT id FROM users WHERE email='$email'");
        if ($sql->num_rows > 0)
            exit('failedUserExists');
        else {
            $ePassword = password_hash($password, PASSWORD_BCRYPT);
            $conn->query("INSERT INTO users (name,email,password,createdOn) VALUES ('$name', '$email', '$ePassword', NOW())");

            $sql = $conn->query("SELECT id FROM users ORDER BY id DESC LIMIT 1");
            $data = $sql->fetch_assoc();

            $_SESSION['loggedIn'] = 1;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['userID'] = $data['id'];

            exit('success');
        }
    } else
        exit('failedEmail');
}

if (isset($_POST['logIn'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = $conn->query("SELECT id, password, name FROM users WHERE email='$email'");
        if ($sql->num_rows == 0)
            exit('failed');
        else {
            $data = $sql->fetch_assoc();
            $passwordHash = $data['password'];

            if (password_verify($password, $passwordHash)) {
                $_SESSION['loggedIn'] = 1;
                $_SESSION['name'] = $data['name'];
                $_SESSION['email'] = $email;
                $_SESSION['userID'] = $data['id'];

                exit('success');
            } else
                exit('failed');
        }
    } else
        exit('failed');
}

$sqlNumComments = $conn->query("SELECT id FROM comments");
$numComments = $sqlNumComments->num_rows;
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <!--jquerry for rating-->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  
  <!--Custom CSS-->
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/product_page.css">
  <link rel="stylesheet" href="../styles/rating.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <!--Fonts & Icons-->
  <script src="https://kit.fontawesome.com/7b5b4fcd9f.js" crossorigin="anonymous"></script>
  
  <title>SuperMart</title>
	
	<style type="text/css">
        .comment {
            margin-bottom: 20px;
        }

        .user {
            font-weight: bold;
            color: black;
			font-size: 10px;
        }

        .time, .reply {
            color: gray;
        }

        .userComment {
            color: #000;
        }

        .replies .comment {
            margin-top: 20px;

        }
		
		.reply a{
			color: grey;
		}

        .replies {
            margin-left: 20px;
        }

        #registerModal input, #logInModal input {
            margin-top: 10px;
        }
		
		body {
			font-family: Arial, Helvetica, sans-serif;
		}

    /* The Modal (background) */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 30px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
      background-color: white;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }
	
	.btnpost {
		background-color: #364F6B;
		width: 100px;
	}
	
	.btnreply {
		background-color: #364F6B;
	}

    /* The Close Button */
    .close {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
 
    </style>
</head>
<body>

<!--Navigation bar section start here-->

<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="container">
      <div class="row justify-content-between align-items-center mt-3">
        <div class="col-6 col-md-4">
          <a href="../index.html">
            <img src="../images/SuperMART.png" class="img-fluid" alt="...">
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
                  <a class="nav-link" aria-current="page" href="../index.html">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="../promotions.html">
                    <span class="fa-solid fa-tag"></span>
                    Promotions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="../stores.html">
                    <span class="fa-solid fa-store"></span>
                    Stores</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="../wishlist.html">
                    <span class="fa-solid fa-heart"></span>
                    Wishlist</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown"
                     role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-grip"></i> Categories
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                    <li><a class="dropdown-item" href="./fruitsAndVegitables.html">Fruits & Vegetables</a></li>
                    <li><a class="dropdown-item" href="./meanAndPoultry.html">Meat & Poultry</a></li>
                    <li><a class="dropdown-item" href="./beverages.html">Beverages</a></li>
                    <li><a class="dropdown-item" href="./homewareItems.html">Homeware items</a></li>
                    <li><a class="dropdown-item" href="./snacks.html">Snacks</a></li>
                    <li><a class="dropdown-item" href="./beautyProducts.html">Beauty Products</a></li>
                  </ul>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
      <div class="row mt-4 mb-4 justify-content-center">
        <div class="col-11">
          <row class="d-flex">
            <button class="btn fa-solid fa-qrcode fa-lg qr-btn" onclick="openNav()"></button>
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn fa-solid fa-magnifying-glass fa-lg text-light search-btn"></button>
          </row>
        </div>
      </div>
    </div>
  </div>
</nav>

<!--navigation bar section ends here-->

<!--product info section-->
<div class="container px-4  mb-5">
  <div class="row gx-4 gx-lg-5">
    <div class="col-md-6 border border-secondary rounded image ">
      <img class="card-img-top mb-md-0" src="../images/Beverages/ginger-ale.jpg" alt="coffee"/>
    </div>
    <div class="col-md-6">
      <h1 class="fw-bolder">Ginger Ale, 200ml</h1>
      <div class="fs-5 mb-3">
        <span>Rs. 380.00</span>
      </div>
      <div class="row buy-buttons">
        <div class="col-12 mb-3">
          <p class="mb-1 quantity">Quantity</p>
          <input class="form-control text-center me-5" value="1" style="max-width: 3rem"/>
        </div>
        <div class="col-12 mb-2">
          <button type="button" class="btn shadow btn-outline-secondary md-5 cart-button">Add to Cart</button>
        </div>
        <div class="col-12 mb-2">
          <button type="button" class="btn shadow buy-button">Buy it Now</button>
        </div>
      </div>
      <h5 class="fw-bold mt-2">Product Info</h5>
      <p>Ginger ale is a carbonated soft drink flavoured with ginger. It is consumed on its own or used as a mixer, often with spirit-based drinks.
            There are two main types of ginger ale. The golden style is credited to the Irish doctor Thomas Joseph Cantrell.</p>
      <div class="row ms-1">
        <div class="col">
          <div class="d-flex flex-nowrap" onclick="window.open('https://facebook.com')">
            <button class="btn btn-outline-dark flex-shrink-0" type="button">
              <i class="fa fa-facebook me-1 text-primary"></i>
              Facebook
            </button>
          </div>
        </div>
        <div class="col ms-1">
          <div class="d-flex flex-nowrap" onclick="window.open('https://twitter.com')">
            <button class="btn btn-outline-dark flex-shrink-0" type="button">
              <i class="fa fa-twitter me-1 text-info"></i>
              Tweet
            </button>
          </div>
        </div>
        <div class="col">
          <div class="d-flex flex-nowrap" onclick="window.open('https://pinterest.com')">
            <button class="btn btn-outline-dark flex-shrink-0" type="button">
              <i class="fa fa-pinterest me-1 text-danger"></i>
              Pin it
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="text-center">
    <button type="button" class="btn mt-4 shadow go-back-btn" onclick="window.location.href='../categories/beverages.html'">
      <i class="fa fa-arrow-left p-1 me-1"></i>
      Go back
    </button>
  </div>
</div>

<!--Review Section-->
<div class="text-center">
  <h1 class="fw-bolder">Product Reviews</h1>
  <br>
</div>

<div class="container">
	<div class="row">
		<div class="col-8">
			<span id="Star1" class="fa fa-star star-color"></span>
            <span id="Star2" class="fa fa-star star-color"></span>
            <span id="Star3" class="fa fa-star star-color"></span>
            <span id="Star4" class="fa fa-star star-color"></span>
            <span id="Star5" class="fa fa-star star-color"></span>
            <span><div style="display: flex;">
                <h1 style="font-size: 24px; position: relative;" id ="numberOut1">5</h1><h1 style="font-size: 24px;">.0</h1>
            </div>Based on <?php echo $numComments ?> reviews</span>
		</div>
		<div class="col-4">
			<p id="myBtn"><u>Write a review</u></p>
		</div>
	</div>
	<hr>
</div>


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <div class="col-md-12">
			<div class="text-center">
				<h1 class="fw-bolder">Leave us a review</h1>
			</div>
			<div class="text-center">
				<p class="fw-bolder">Rate us with stars</p>
				<span class="fa fa-star star"style="font-size: 1rem;"></span>
                <span class="fa fa-star star"style="font-size: 1rem;"></span>
                <span class="fa fa-star star"style="font-size: 1rem;"></span>
                <span class="fa fa-star star"style="font-size: 1rem;"></span>
                <span class="fa fa-star star"style="font-size: 1rem;"></span>
                <p class="output1" hidden> Ratings</p>
			</div></br>
			<!-- Script for ratings -->
			<script>
                    const stars = document.querySelectorAll('.star');
                    const output1 = document.querySelector('.output1');

                    for(let x=0; x<stars.length; x++){
                        stars[x].starValue = (x+1);
                        //stars[x].addEventListener('click', function () {
                        //console.log("I am clicked");
                        // })

                        ["click", "mouseover", "mouseout"].forEach(function (e){
                            stars[x].addEventListener(e, showRating);
                        })
                    }

                    function showRating(e){
                        let type = e.type;
                        //console.log(type);
                        starValue = this.starValue;
                        //console.log(starValues)

                        if(type === 'click'){
                            if(starValue > 0){
                                output1.innerHTML = " You have rated this " + starValue + "stars .";
                                numberOut1.innerHTML = starValue;
                                for (let i=1; i <= 5; i++){
                                    if (starValue >= i){
                                        $(`#Star${i}`).removeClass("fa-star-o");
                                        $(`#Star${i}`).addClass("fa-star").css("color", "orange");
                                    }else{
                                        $(`#Star${i}`).removeClass("fa-star");
                                        $(`#Star${i}`).addClass("fa-star-o");
                                    }

                                }

                            }

                        }

                        stars.forEach(function (elem, ind){
                            if(type === 'click'){
                                if(ind < starValue){
                                    elem.classList.add("orange");
                                }else {
                                    elem.classList.remove("orange");
                                }
                            }

                            if(type === 'mouseover'){
                                if(ind < starValue){
                                    elem.classList.add("yellow");
                                }else {
                                    elem.classList.remove("yellow");
                                }
                            }

                            if(type === "mouseout"){
                                if(ind < starValue) {
                                    elem.classList.remove("yellow");
                                }
                            }
                        })
                    }
                </script>
			<!-- Script for ratings end -->
            <textarea class="form-control" id="mainComment" placeholder="Enter your review here" cols="20" rows="2"></textarea><br>
			<div class="text-center">
				<button class="btn-primary rounded-pill btn btnpost" onclick="isReply = false;" id="addComment">Post</button>
			</div>
        </div>
    </div>
  </div>

</div>

<div class="container" style="margin-top:30px;">
    
    <div class="row">
        <div class="col-md-12">
            <div class="userComments">

            </div>
        </div>
    </div>
</div>

<div class="row replyRow" style="display:none">
    <div class="col-md-12">
        <textarea class="form-control" id="replyComment" placeholder="Reply here" cols="30" rows="2"></textarea><br>
        <button style="float:right" class="btn-primary btn btnreply" onclick="isReply = true;" id="addReply">Add Reply</button>
        <button style="float:right" class="btn-default btn" onclick="$('.replyRow').hide();">Close</button>
    </div>
</div>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");
  
  // Get the button that post comments in modal
  var btnpost = document.getElementById("addComment");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }
  
  // When the user clicks on post utton, close the modal
  btnpost.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>


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

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>




<script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">
    var isReply = false, commentID = 0, max = <?php echo $numComments ?>;

    $(document).ready(function () {
        $("#addComment, #addReply").on('click', function () {
            var comment;

            if (!isReply)
                comment = $("#mainComment").val();
            else
                comment = $("#replyComment").val();

            if (comment.length > 5) {
                $.ajax({
                    url: 'gingerAle.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        addComment: 1,
                        comment: comment,
                        isReply: isReply,
                        commentID: commentID
                    }, success: function (response) {
                        max++;
                        $("#numComments").text(max + " Comments");

                        if (!isReply) {
                            $(".userComments").prepend(response);
                            $("#mainComment").val("");
                        } else {
                            commentID = 0;
                            $("#replyComment").val("");
                            $(".replyRow").hide();
                            $('.replyRow').parent().next().append(response);
                        }
                    }
                });
            } else
                alert('Please Check Your Inputs');
        });

        $("#registerBtn").on('click', function () {
            var name = $("#userName").val();
            var email = $("#userEmail").val();
            var password = $("#userPassword").val();

            if (name != "" && email != "" && password != "") {
                $.ajax({
                    url: 'gingerAle.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        register: 1,
                        name: name,
                        email: email,
                        password: password
                    }, success: function (response) {
                        if (response === 'failedEmail')
                            alert('Please insert valid email address!');
                        else if (response === 'failedUserExists')
                            alert('User with this email already exists!');
                        else
                            window.location = window.location;
                    }
                });
            } else
                alert('Please Check Your Inputs');
        });

        $("#loginBtn").on('click', function () {
            var email = $("#userLEmail").val();
            var password = $("#userLPassword").val();

            if (email != "" && password != "") {
                $.ajax({
                    url: 'gingerAle.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        logIn: 1,
                        email: email,
                        password: password
                    }, success: function (response) {
                        if (response === 'failed')
                            alert('Please check your login details!');
                        else
                            window.location = window.location;
                    }
                });
            } else
                alert('Please Check Your Inputs');
        });

        getAllComments(0, max);
    });

    function reply(caller) {
        commentID = $(caller).attr('data-commentID');
        $(".replyRow").insertAfter($(caller));
        $('.replyRow').show();
    }

    function getAllComments(start, max) {
        if (start > max) {
            return;
        }

        $.ajax({
            url: 'gingerAle.php',
            method: 'POST',
            dataType: 'text',
            data: {
                getAllComments: 1,
                start: start
            }, success: function (response) {
                $(".userComments").append(response);
                getAllComments((start+20), max);
            }
        });
    }
</script>
</body>
</html>