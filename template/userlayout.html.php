<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
  <link rel="stylesheet" href="../users/fonts/icomoon/style.css">

  <link rel="stylesheet" href="../users/css/bootstrap.min.css">
  <link rel="stylesheet" href="../users/css/magnific-popup.css">
  <link rel="stylesheet" href="../users/css/jquery-ui.css">
  <link rel="stylesheet" href="../users/css/owl.carousel.min.css">
  <link rel="stylesheet" href="../users/css/owl.theme.default.min.css">


  <link rel="stylesheet" href="../users/css/aos.css">

  <link rel="stylesheet" href="../users/css/style.css">

</head>

<body>

  <div class="site-wrap">
    <?php // Check if the user is logged in or registered
    $isLoggedInOrRegistered = isset($_SESSION['userDetails']);

    // Check if the logged-in user's checkAdmin is "USER"
    $isUser = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'USER';
    $isSeller = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'SELLER';
?>

    <?php require '../template/userheader.html.php'; ?>

    <?= $output ?>

    <?php require '../template/userfooter.html.php'; ?>

    <style>
      body {
        background-image: '../../images/background.jpg';
      }

      .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
      }

      .btn {
        padding: 14px 20px;
        border-radius: 0;
      }

      .btn-primary {
        color: #fff;
        background-color: #f37121;
        border-color: #f37121;
      }

      .caption {
        color: #f37121;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: .2rem;
        font-weight: 700;
      }

      h1,
      h2,
      h3,
      h5,
      .h1,
      .h2,
      .h3,
      .h5 {
        font-family: "Muli", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        color: #f37121;
      }

      .auctions-entry .item h3 a {
        color: #000;
      }

      .intro-section:before {
        content: "";
        position: absolute;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.2);
        border-bottom-right-radius: 0px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }

      .auctions-entry .btn-bid {
        padding: 7px 15px;
        text-transform: none;
        border-radius: 0;
        background: #f8f9fa;
        color: #000;
      }

      .intro-section,
      .intro-section .container .row {
        height: 100vh;
        min-height: 500px;
      }

      .intro-section {
        background-size: cover;
        position: relative;
      }

      [data-aos^=fade][data-aos^=fade].aos-animate {
        opacity: 1;
        transform: translate(0);
      }

      [data-aos][data-aos][data-aos-duration="800"],
      body[data-aos-duration="800"] [data-aos] {
        transition-duration: .8s;
      }

      [data-aos^=fade][data-aos^=fade] {
        opacity: 0;
        transition-property: opacity, transform;
      }

      [data-aos=fade-up] {
        transform: translateY(100px);
      }

      .text-center {
        text-align: center !important;
      }

      .ml-auto,
      .mx-auto {
        margin-left: auto !important;
      }

      .mr-auto,
      .mx-auto {
        margin-right: auto !important;
      }

      .intro-section h1 {
        font-size: 60px;
        font-weight: 900;
        line-height: 1;
        color: #fff;
      }

      .intro-section p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 20px;
      }

      .container {
        width: 100%;

        margin-right: auto;
        margin-left: auto;
      }

      a {
        color: black;
        text-decoration: none;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
      }

      .auctions-entry .item .price {
        position: absolute;
        display: inline-block;
        width: 55px;
        height: 55px;
        line-height: 60px;
        border-radius: 50%;
        background: rgb(243, 113, 33);
        font-size: 20px;
        text-align: center;
        color: rgb(255, 255, 255);
        font-weight: 700;
      }
    </style>

  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

</body>

</html>