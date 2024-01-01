<?php
$isLoggedInOrRegistered = isset($_SESSION['userDetails']);

// Check if the logged-in user's checkAdmin is "USER"
$isUser = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'USER';
$isSeller = $isLoggedInOrRegistered && $_SESSION['userDetails']['checkAdmin'] === 'SELLER';
require '../database.php';


$date = strtotime($auction['endDate']);
$left_time = $date - time();

$day = floor($left_time / (60 * 60 * 24));
$left_time %= (60 * 60 * 24);

$hour = floor($left_time / (60 * 60));  // Fix: Correct the division here
$left_time %= (60 * 60);

$minute = floor($left_time / 60);
$left_time %= 60;

if ($day > 0) {
  $showTime = "$day ds $hour hrs $minute ms";
} elseif ($hour > 0) {
  $showTime = "$hour hrs $minute ms";
} elseif ($minute > 0) {
  $showTime = "$minute ms";
} else {
  $showTime = 'Auction Expired';
}

$isAuctionExpired = $left_time <= 0;

?>

<div class="intro-section" style="background-image: url('<?php echo '../img/auctions/' . $auctions['img']; ?>');">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
        <h1><?php echo $auctions['title'] ?></h1>
        <p>
          <a href="#" class="btn btn-primary">Bid Now</a>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 order-lg-2">
        <div class="side-box mb-4">
          <?php
          $aucId = $auction['aucId'];
          $sql1 = "SELECT COUNT(*) as totalBids FROM bidding WHERE auctionId = :aucId";
          $query1 = $pdo->prepare($sql1);
          $query1->bindParam(':aucId', $aucId, PDO::PARAM_INT);
          $query1->execute();
          $result1 = $query1->fetch(PDO::FETCH_OBJ);
          $totalBids = $result1->totalBids;

          ?>
          <p><strong>Artist/Owner: </strong><?php echo $auction_users['firstname'] . ' ' . $auction_users['lastname']; ?></p>

          <p>Bidding Ends:<br><strong class="text-black"><?php echo $showTime ?></strong></p>
          <p>
            Highest Bid: <strong class="text-black"><?php echo isset($highestBid) ? '$' . number_format($highestBid) : 'No bids yet'; ?></strong>
          </p>
          <form action="/user/bid" enctype="multipart/form-data" method="POST" onsubmit="return validateBid()">
            <input type="hidden" name="auctionId" value="<?php echo $aucId; ?>" />
            <div class="mb-4">
              <input type="number" id="bidAmountInput" name="bidamount" class="form-control mb-2" placeholder="Enter bid amount" required>
              <small class="text-muted">Bid must be greater than <?php echo '$' . number_format($highestBid); ?></small>
              <?php if (!$isAuctionExpired) : ?>
                <input type="submit" name="submit" value="Submit a Bid" class="btn btn-block" id="submitButton" disabled />
              <?php else : ?>
                <p><button class="btn btn-primary" type="submit" disabled>Bid Expired</button></p>
                <?php endif; ?>&nbsp;
            </div>
          </form>
          <?php if (!$isUser && !$isSeller) : ?>
            <p><span class="d-block text-center my-2">or</span></p>
            <p class="mb-0"><a href="/admin/login">Sign In</a> / <a href="/user/register">Register</a></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-lg-8 pr-lg-5">
        <img width="693.986px" src="<?php echo '../img/auctions/' . $auctions['img']; ?>" alt="Auction Image">
        <p></p>
        <p><?php echo $auctions['description']; ?></p>
        <h2 class="my-4">Bidders</h2>
        <ul class="list-unstyled bidders">
          <?php $rowNum = 1; ?>
          <?php foreach ($bidders as $bidder) : ?>
            <li class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <span class="mr-2"><?php echo $rowNum; ?>.</span>
                <div class="d-flex align-items-center">
                  <span><?php echo htmlspecialchars($bidder['firstname'] . " " . $bidder['lastname'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
              </div>
              <span class="price"><strong><?php echo '$' . $bidder['highestBid']; ?></strong></span>
            </li>
            <?php $rowNum++; ?>
          <?php endforeach; ?>
        </ul>
        <p>
          Number of Bids: <strong class="text-black"><?php echo $totalBids; ?></strong>
        </p>
      </div>
    </div>
  </div>
</div>

<style>
  .bidders li .price {
    font-weight: 700;
    color: #000;
  }

  .bidders li {
    border-bottom: 1px solid #efefef;
    padding-bottom: 10px;
    margin-bottom: 10px;
  }
</style>

<script>
  function validateBid() {
    var bidAmount = parseFloat(document.getElementById('bidAmountInput').value);
    var highestBid = <?php echo isset($highestBid) ? $highestBid : 0; ?>;

    if (bidAmount > highestBid) {
      return true; // Allow form submission
    } else {
      alert("Bid amount should be higher than the current highest bid!");
      return false; // Prevent form submission
    }
  }

  // Attach an event listener to the input for real-time validation
  document.getElementById('bidAmountInput').addEventListener('input', function() {
    var submitButton = document.getElementById('submitButton');
    var bidAmount = parseFloat(this.value);
    var highestBid = <?php echo isset($highestBid) ? $highestBid : 0; ?>;

    if (bidAmount > highestBid) {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
    }
  });
</script>