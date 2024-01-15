<?php
require '../database.php';
?>

<div class="site-section">
    <div class="container">
        <div class="row mb-12">
            <div class="col-md-9 order-2">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="float-md-left mb-4">
                            <a href="/user/catalogue">
                                <h2 class="text-black h5">Shop All</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-10">
                    <table class="table">
                        <h5>Ongoing Auctions</h5>
                        <tbody>
                            <!-- #region -->
                            <?php
                            $numColumns = 3; // Number of columns
                            $rowCount = 0;   // Initialize row count

                            foreach ($filteredAuctions as $auction) :
                                $startDate = strtotime($auction['startDate']);
                                $currentTime = time();

                                if ($currentTime >= $startDate) { // Auction has started
                                    $date = strtotime($auction['endDate']);
                                    $left_time = $date - $currentTime;

                                    $day = floor($left_time / (60 * 60 * 24));
                                    $left_time %= (60 * 60 * 24);

                                    $hour = floor($left_time / (60 * 60));
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

                                    // Open a new row for the first column
                                    if ($rowCount % $numColumns == 0) {
                                        echo '<tr>';
                                    }
                            ?>
                                    <td>
                                        <!-- Display ongoing auction details here -->
                                        <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['auctionimage']; ?>" alt="Auction Image"><br>
                                        <strong>Auction Name: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?><br>
                                        <strong>Category: </strong> <?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?><br>
                                        <strong>Start Date: </strong> <?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?>
                                        <p><strong>End Date: </strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>

                                        <?php if (!$isAuctionExpired) : ?>
                                            <p><a href="/user/userviewlots?aucId=<?php echo $auction['aucId'] ?>"><button class="btn btn-primary" type="submit">View Lots</button></a></p>
                                        <?php else : ?>
                                            <p><button class="btn btn-primary" type="submit" disabled>Auction Ended</button></p>
                                            <?php endif; ?>&nbsp;
                                    </td>
                                <?php
                                    // Close the row after the last column
                                    if ($rowCount % $numColumns == $numColumns - 1) {
                                        echo '</tr>';
                                    }

                                    // Increment the row count
                                    $rowCount++;
                                }
                            endforeach;

                            // If the last row is not complete, close it
                            if ($rowCount % $numColumns != 0) {
                                echo '</tr>';
                            }

                            if ($rowCount == 0) :
                                ?>
                                <tr>
                                    <td colspan="<?php echo $numColumns; ?>">No Ongoing Auctions</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mb-10">
                    <table class="table">
                        <h5>Upcoming Auctions</h5>
                        <tbody>
                            <!-- #region -->
                            <?php
                            $numColumns = 3; // Number of columns
                            $rowCount = 0;   // Initialize row count

                            foreach ($filteredAuctions as $auction) :
                                $startDate = strtotime($auction['startDate']);
                                $currentTime = time();

                                if ($currentTime < $startDate) { // Auction hasn't started yet
                                    // Open a new row for the first column
                                    if ($rowCount % $numColumns == 0) {
                                        echo '<tr>';
                                    }
                            ?>
                                    <td>
                                        <!-- Display upcoming auction details here -->
                                        <img width="150px" height="150" src="<?php echo '../img/auctions/' . $auction['auctionimage']; ?>" alt="Auction Image"><br>
                                        <strong>Auction Name: </strong> <?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?><br>
                                        <strong>Category: </strong> <?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?><br>
                                        <strong>Start Date: </strong> <?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?>
                                        <p><strong>End Date: </strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>

                                        <!-- Add any additional details or buttons for upcoming auctions here -->
                                    </td>
                                <?php
                                    // Close the row after the last column
                                    if ($rowCount % $numColumns == $numColumns - 1) {
                                        echo '</tr>';
                                    }

                                    // Increment the row count
                                    $rowCount++;
                                }
                            endforeach;

                            // If the last row is not complete, close it
                            if ($rowCount % $numColumns != 0) {
                                echo '</tr>';
                            }

                            if ($rowCount == 0) :
                                ?>
                                <tr>
                                    <td colspan="<?php echo $numColumns; ?>">No Upcoming Auctions</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-md-3 order-1 mb-5 mb-md-0">
                <div class="border p-4 rounded mb-4">
                    <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($categories as $category) : ?>
                            <?php
                            $catId = $category['catId']; // Assuming the category ID field is 'catId'
                            $sql1 = "SELECT COUNT(*) as totalAuctions FROM auction WHERE catId = :catId";
                            $query1 = $pdo->prepare($sql1);
                            $query1->bindParam(':catId', $catId, PDO::PARAM_INT);
                            $query1->execute();
                            $result1 = $query1->fetch(PDO::FETCH_OBJ);
                            $totalAuctions = $result1->totalAuctions;
                            ?>
                            <li class="mb-1">
                                <a href="filterCategory?catId=<?php echo $category['catId'] ?>" class="d-flex">
                                    <span><?php echo htmlspecialchars($category['catname'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span class="text-black ml-auto"> (<?php echo $totalAuctions; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </div>
        <div class="site-section">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-7 mb-5 text-center mx-auto">
                        <span class="caption">Auctions</span>
                        <h2 class="text-black">Current <strong>Auctions</strong></h2>
                    </div>
                </div>
                <div class="row auctions-entry">
                    <?php
                    $auctionCounter = 0; // Counter to track the number of auctions displayed
                    foreach ($auctions as $auction) :
                        if ($auctionCounter >= 4) {
                            break; // Exit the loop if 4 auctions have been displayed
                        }
                    ?>
                        <div class="col-7 col-md-3">
                            <div class="item">
                                <div>
                                    <a href="item-single.html"><img width="150px" src="<?php echo '../img/auctions/' . $auction['auctionimage']; ?>" alt="Image" class="img-fluid"></a>
                                </div>
                                <div class="p-4">
                                    <h3><a href="item-single.html"><?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                                    <div class="d-flex mb-2">
                                        <span><?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    </div>
                                    <a href="bidpage?aucId=<?php echo $auction['aucId'] ?>" class="btn btn-bid">Submit a Bid</a>
                                </div>
                            </div>
                        </div>
                    <?php
                        $auctionCounter++;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>


        <?php
        // Function to limit the number of words
        function limitWords($text, $limit)
        {
            $words = explode(" ", $text);
            $limitedWords = array_slice($words, 0, $limit);
            $limitedText = implode(" ", $limitedWords);
            if (count($words) > $limit) {
                $limitedText .= '...';
            }
            return $limitedText;
        }
        ?>