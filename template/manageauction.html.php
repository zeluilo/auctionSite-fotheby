<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List of Auctions</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
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
                            <th scope="col">Auction Item</th>
                            <th scope="col">Item Category</th>
                            <th scope="col">Auction Expiry Date</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($auctions as $auction): ?>
                            <tr>
                                <td><?php echo $rowNum; ?></td>
                                <td><?php echo htmlspecialchars($auction['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($auction['catname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($auction['endDate'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($auction['auction_datecreate'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($auction['auction_dateupdate'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="editauction?aucId=<?php echo $auction['aucId'] ?>"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="deleteauction?aucId=<?php echo $auction['aucId'] ?>"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if (count($auctions) === 0): ?>
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
