<?php
require '../database.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List of Auctions</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Auction List</h6>
            </div>
            <!-- Card Body -->
            <div>
                <?php
                // Sort the auctions by auction_datecreate in descending order
                usort($auctions, function ($a, $b) {
                    return strtotime($b['auction_datecreate']) - strtotime($a['auction_datecreate']);
                });
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Auction Title</th>
                            <th scope="col">Item Category</th>
                            <th scope="col">No. of Lots</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($auctions as $auction) : ?>
                            <?php
                            $aucId = $auction['aucId']; // Assuming the category ID field is 'aucId'
                            $sql1 = "SELECT COUNT(*) as totalLots FROM lot WHERE auctionId = :aucId";
                            $query1 = $pdo->prepare($sql1);
                            $query1->bindParam(':aucId', $aucId, PDO::PARAM_INT);
                            $query1->execute();
                            $result1 = $query1->fetch(PDO::FETCH_OBJ);
                            $totalLots = $result1->totalLots;
                            ?>
                            <tr>
                                <td><?php echo $rowNum; ?></td>
                                <td><?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo $totalLots; ?></td>
                                <td><?php echo isset($auction['startDate']) ? date('Y-m-d', strtotime($auction['startDate'])) : ''; ?></td>
                                <td><?php echo isset($auction['auction_datecreate']) ? date('Y-m-d', strtotime($auction['auction_datecreate'])) : ''; ?></td>
                                <td><?php echo isset($auction['auction_dateupdate']) ? date('Y-m-d', strtotime($auction['auction_dateupdate'])) : ''; ?></td>
                                <td>
                                    <?php
                                    $currentDate = time();
                                    $startDate = strtotime($auction['startDate']);

                                    if ($currentDate < $startDate) {
                                        echo "Upcoming";
                                    } elseif ($currentDate >= $startDate) {
                                        echo "Ongoing";
                                    } else {
                                        echo "Ended";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="editauction?aucId=<?php echo $auction['aucId'] ?>"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <?php
                                    $currentDate = time();
                                    $startDate = strtotime($auction['startDate']);

                                    if ($currentDate < $startDate) {
                                        echo '<a href="deleteauction?aucId=' . $auction['aucId'] . '"> <i class="fas fa-trash"></i></a>';
                                    } else {
                                        echo '<span style="color: red;">Cannot Delete</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if (count($auctions) === 0) : ?>
                            <tr>
                                <td colspan="6">Table is Empty :(</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>