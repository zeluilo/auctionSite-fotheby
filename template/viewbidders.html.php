<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List of Bidders</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Bidder List</h6>
            </div>
            <!-- Card Body -->
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Auction</th>
                            <th scope="col">Auction Item</th>
                            <th scope="col">Bid Amount</th>
                            <th scope="col">Date Bidded</th>
                            <th scope="col">UserType</th>
                            <th scope="col">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowNum = 1; ?>
                        <?php foreach ($bidders as $bidder): ?>
                                <tr>
                                    <td><?php echo $rowNum; ?></td>
                                    <td><?php echo htmlspecialchars($bidder['firstname'] . ' ' . $bidder['lastname'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($bidder['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($bidder['title'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($bidder['lotname'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo '$' . htmlspecialchars($bidder['bidamount'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($bidder['bidDateCreate'])) ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($bidder['checkAdmin'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <a href="edituser?userId=<?php echo $bidder['UserId'] ?>"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                <?php $rowNum++; ?>
                        <?php endforeach; ?>
                        <?php if ($rowNum === 1): ?>
                            <tr>
                                <td colspan="6">No current Bidders :?</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
