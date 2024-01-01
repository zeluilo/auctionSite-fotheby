<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Bid Auction</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Place A Bid</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                </div>
            </div>
            <!-- Card Body --> 
            <section class="w-100 p-4 pb-4">
                <div class="row gutters">
                    <div class="col-xl-5">
                        <div class="card h-200">
                            <div class="card-body">
                                <div class="account-settings">
                                    <div class="user-profile">
                                        <div class="user-avatar">
                                            <p><strong>Auction Item: </strong> <?php echo $auction['title'] ?></p>
                                            <img width="410px" height="250" src="<?php echo '../img/auctions/' . $auction['img']; ?>" alt="Auction Image">
                                        </div>
                                    </div>
                                    &nbsp;
                                    <div class="about">
                                        <?php
                                            $fullname = $auction_users['firstname'] . " ". $auction_users['lastname'];

                                            $date = strtotime($auction['endDate']);
                                            $left_time = $date - time();
                                            
                                            $day = floor($left_time / (60 * 60 * 24));
                                            $left_time %= (60 * 60 * 24);
                                            
                                            $hour = floor($left_time / (60 * 60));  // Fix: Correct the division here
                                            $left_time %= (60 * 60);
                                            
                                            $minute = floor($left_time / 60);
                                            $left_time %= 60;
                                            
                                            if ($day > 0) {
                                                $showTime = "$day days $hour hours and $minute mins";
                                            } elseif ($hour > 0) {
                                                $showTime = "$hour hours and $minute mins";
                                            } elseif ($minute > 0) {
                                                $showTime = "$minute mins";
                                            } else {
                                                $showTime = 'Auction Expired';
                                            }
                                            
                                        ?>
                                        <h5>Auction Item Details</h5>
                                        <p><strong>Auction ID: </strong> 00<?php echo isset($auction['aucId']) ? $auction['aucId'] : '-'; ?></p>
                                        <p><strong>Auction Category: </strong><?php echo isset($auctions['catname']) ? $auctions['catname'] : '-'; ?></p>
                                        <p><strong>Auction Created By: </strong><?php echo isset($fullname) ? $fullname : '-'; ?></p>
                                        <p><strong>Auction Expiry Date:</strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : '-'; ?></p>
                                    </div>
                                    <!-- <?php if($auction['status'] == 'Withdrawn') { ?>
                                        <a href="deletestudent?aucId=<?php echo $auction['aucId'] ?>"><button class="btn btn-danger" type="button">Delete Student Record</button></a>
                                    <?php } ?> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="col-xl-12">
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="edit">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <h6 class="mb-2 text-primary">Auction Item Details</h6>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label >Auction Title</label>
                                                    <input type="text" name="title" class="form-control" value="<?php echo $auction['title'] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label>Item Description</label>
                                                    <textarea class="form-control" name="description" readonly><?php echo $auction['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label>Time left till Auction Expires</label>
                                                    <time class="form-control"><?php echo $showTime ?></time>
                                                </div>
                                            </div>
                                            <form action="/admin/bid" method="POST" class="row gutters">
                                                <input hidden name="auctionId" value=" <?php echo $auction['aucId'] ?>"/>
                                                <div class="col-xl-12">
                                                    <div class="form-group">
                                                        <label>Enter Bid Amount</label>
                                                        <input type="text" name="bidamount" class="form-control" placeholder="Enter bid amount">
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="text-right">
                                                        <button type="submit" name="submit" class="btn btn-secondary">Place Bid For Auction</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>