<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Review Auction</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Review Auction Item</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                </div>
            </div>
            <!-- Card Body --> 
            <section class="w-100 p-4 pb-4">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="#edit" aria-controls="students" role="tab" data-toggle="tab">Edit Auction Info</a></li>
                <li role="presentation" class="nav-item"><a class="nav-link" href="#about" aria-controls="modules" role="tab" data-toggle="tab">Change Auction Image</a></li>
            </ul>
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
                                        <h5>Auction Item Details</h5>
                                        <p><strong>Auction ID: </strong> 00<?php echo isset($auction['auctionId']) ? $auction['auctionId'] : ''; ?></p>
                                        <p><strong>Exp Date:</strong> <?php echo isset($auction['endDate']) ? date('Y-m-d', strtotime($auction['endDate'])) : ''; ?></p>
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
                                <form class="col-xl-12" enctype="multipart/form-data">
                                        <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="edit">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <h6 class="mb-2 text-primary">Auction Item Details</h6>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label >Auction Title</label>
                                                    <input type="text" name="title" class="form-control" value="<?php echo $auction['title'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label>Item Description</label>
                                                    <textarea class="form-control" name="description" required><?php echo $auction['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label>Expiry Date</label>
                                                    <input class="form-control" type="date" name="endDate" value="<?php echo date('Y-m-d', strtotime($auction['endDate'])) ?>" min="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Item Category</label>
                                                    <select name="catId" class="form-control">
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['catId']; ?>" <?php if($auction['catId'] == $category['catId']) echo 'selected'; ?>>
                                                                <?php echo $category['catname']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="text-right">
                                                    <a href="/admin/manageauction" class="btn btn-secondary">View All Auctions</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>