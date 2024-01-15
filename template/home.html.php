<?php require '../database.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <?php if ($registrationSuccess) : ?>
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


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Categories</div>
                            <?php
                            $sql1 = "SELECT catId from category ";
                            $query1 = $pdo->prepare($sql1);
                            $query1->execute();
                            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                            $totalcategories = $query1->rowCount();

                            $sql2 = "SELECT aucId from auction ";
                            $query2 = $pdo->prepare($sql2);
                            $query2->execute();
                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                            $totalauctions = $query2->rowCount();

                            $sql3 = "SELECT bidId from user_bid ";
                            $query3 = $pdo->prepare($sql3);
                            $query3->execute();
                            $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                            $totalbidders = $query3->rowCount();

                            $sql4 = "SELECT userId from users ";
                            $query4 = $pdo->prepare($sql4);
                            $query4->execute();
                            $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                            $totalusers = $query4->rowCount();
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalcategories; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Registered Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalusers; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Auctions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalauctions; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Buyers -->
        <div class="col-xl-7 col-lg-7">
        <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Newly Registered Accounts</h6>
                </div>
                <!-- Card Body -->
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rowNum = 1;
                                // Sort the reviewAuctions by date in descending order
                                usort($users, function ($a, $b) {
                                    return strtotime($b['datecreate']) - strtotime($a['datecreate']);
                                });

                                // Limit the auctions to 4
                                $limitedUsers = array_slice($users, 0, 4);
                                ?>
                                <?php foreach ($limitedUsers as $user) : ?>
                                    <?php if ($user['checkAdmin'] === 'USER' || $user['checkAdmin'] === 'SELLER'): ?>
                                    <?php $name = $user['firstname'] . ' ' . $user['lastname'] ?>
                                    <tr>
                                        <td><?php echo $rowNum; ?></td>
                                        <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user['number'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo isset($user['datecreate']) ? date('Y-m-d', strtotime($user['datecreate'])) : ''; ?></td>
                                        <td><a href="edituser?userId=<?php echo $user['userId'] ?>"><i class="fas fa-eye"></i></a></td>
                                    </tr>
                                    <?php $rowNum++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (empty($limitedUsers)) : ?>
                                    <tr>
                                        <td colspan="3">No Registered User :(</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
            </div>
            
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recently Added Lots</h6>
                </div>
                <!-- Card Body -->
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Item</th>
                                <th scope="col">Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowNum = 1;
                            // Sort the reviewAuctions by date in descending order
                            usort($reviewAuctions, function ($a, $b) {
                                return strtotime($b['datecreate']) - strtotime($a['datecreate']);
                            });

                            // Limit the auctions to 4
                            $limitedReviewAuctions = array_slice($reviewAuctions, 0, 4);
                            ?>
                            <?php foreach ($limitedReviewAuctions as $reviewAuction) : ?>
                                <?php $name = $reviewAuction['firstname'] . ' ' . $reviewAuction['lastname'] ?>
                                <tr>
                                    <td><?php echo $rowNum; ?></td>
                                    <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($reviewAuction['lotname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><a href="editlot?lotId=<?php echo $reviewAuction['lotId'] ?>"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <?php $rowNum++; ?>
                            <?php endforeach; ?>
                            <?php if (empty($limitedReviewAuctions)) : ?>
                                <tr>
                                    <td colspan="3">No Auction :(</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

    <div class="col-xl-2 col-lg-5">
    </div>

       <!-- Pie Chart -->
       <div class="col-xl-7 col-lg-5">
       <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Bidders</h6>
                </div>
                <!-- Card Body -->
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Number</th>
                                <th scope="col">Items Bidded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rowNum = 1; ?>
                            <?php foreach ($bidsGroupedByBidder as $bidder => $bids) : ?>
                                <tr>
                                    <td><?php echo $rowNum; ?></td>
                                    <td><?php echo htmlspecialchars($bidder, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($bids[0]['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($bids[0]['number'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo count($bids); ?></td>
                                    <!-- Add other columns as needed -->
                                </tr>
                                <?php $rowNum++; ?>
                            <?php endforeach; ?>
                            <?php if (empty($bidsGroupedByBidder)) : ?>
                                <tr>
                                    <td colspan="3">Table is Empty :(</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-5">
    </div>
</div>