<?php
 // Check if the user is logged in or registered
$isLoggedInOrRegistered = isset($_SESSION['userDetails']);

// Check if the logged-in user's checkAdmin is "USER"
$isUser = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'USER';

if ($registrationSuccess) : ?>
    <script>
        // Display pop-up on page load
        window.onload = function() {
            alert("Registered Successfully");
        };
    </script>
<?php endif; ?>

<?php if ($loggedinSuccess) : ?>
    <script>
        // Display pop-up on page load
        window.onload = function() {
            alert("Logged in Successfully");
        };
    </script>
<?php endif; ?>

<?php if ($loggedoutSuccess) : ?>
    <script>
        // Display pop-up on page load
        window.onload = function() {
            alert("Logged out Successfully");
        };
    </script>
<?php endif; ?>

<div class="intro-section" style="background-image: url('../users/images/background.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                <h1>The Best Place to Buy and Sell</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, nihil.</p>
                <?php if ($isLoggedInOrRegistered || $isUser) : ?>
                    <p><a href="/user/catalogue" class="btn btn-primary">Place A Bid</a></p>
                <?php else :?>
                    <p><a href="/user/register" class="btn btn-primary">Register</a></p>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>



<?php require '../template/userauctions.html.php'; ?>

<?php require '../template/userhelp.html.php'; ?>

<?php require '../template/userabout.html.php'; ?>

<?php if (!$isLoggedInOrRegistered || !$isUser) : ?>
<div class="site-section">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-7">
        <h2 class="text-black mb-4">Create an account and start Buy, Bid or Sell Now!</h2>
        <a href="/user/register" class="btn btn-primary">Register</a>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>