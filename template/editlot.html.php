<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Lot</h1>
    <div class="col-xl-114">
        <div class="card shadow mb-4">
            <!-- Card Body --> 
            <section class="w-100 p-4 pb-4">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="#edit" aria-controls="students" role="tab" data-toggle="tab">Edit Lot Info</a></li>
                <li role="presentation" class="nav-item"><a class="nav-link" href="#about" aria-controls="modules" role="tab" data-toggle="tab">Change Lot Image</a></li>
            </ul>
                <div class="row gutters">
                    <div class="col-xl-5">
                        <div class="card h-200">
                            <div class="card-body">
                                <div class="account-settings">
                                    <div class="user-profile">
                                        <div class="user-avatar">
                                            <p><strong>Lot Item: </strong> <?php echo $lot['lotname'] ?></p>
                                            <img width="410px" height="250" src="<?php echo '../img/lots/' . $lot['img']; ?>" alt="lot Image">
                                        </div>
                                    </div>
                                    &nbsp;
                                    <div class="about">
                                        <h5>Lot Item Details</h5>
                                        <p><strong>Lot ID: </strong><?php echo '00' . isset($lot['lotId']) ? $lot['lotId'] : ''; ?></p>
                                        <p><strong>Owner of Lot: </strong><?php echo $lots['firstname'] . ' ' . $lots['lastname'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <form class="col-xl-12" action="/admin/editlot" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="lotId" value="<?php echo $lot['lotId'] ?>"/>
                                        <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="edit">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <h6 class="mb-2 text-primary">Lot Item Details</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label >Lot Num</label>
                                                        <input type="number" name="lotnum" class="form-control" value="<?php echo $lot['lotnum'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label >Lot Item</label>
                                                        <input type="text" name="lotname" class="form-control" value="<?php echo $lot['lotname'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Item Description</label>
                                                        <textarea class="form-control" name="lotdesc" required><?php echo $lot['lotdesc']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="useremail">Assigned Auction</label>
                                                    <select name="auctionId" class="form-control">
                                                        <option selected></option>
                                                        <?php foreach ($auctions as $auction): ?>
                                                            <option value="<?php echo $auction['aucId']; ?>" <?php if($lot['auctionId'] == $auction['aucId']) echo 'selected'; ?>>
                                                                <?php echo $auction['title']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>                                                
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Estimated Price</label>
                                                    <input class="form-control" type="number" name="price" value="<?php echo $lot['price']; ?>">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Year Of Production</label>
                                                    <input class="form-control" type="number" name="year" value="<?php echo $lot['year']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="about">
                                            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                                <h1>Change Image</h1>
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <p><strong>Lot Item: </strong> <?php echo $lot['lotname'] ?></p>
                                                        <img width="410px" height="250" src="<?php echo '../img/lots/' . $lot['img']; ?>" alt="lot Image">
                                                        <label for="validationDefault05" class="form-label" style="margin-left: 0px;">Upload an Image</label>
                                                        <input type="file" class="form-control" name="auct_pic" accept="image/*" value="<?php echo '../img/lots/' . $lot['img']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="text-right">
                                                    <button type="submit" name="submit" class="btn btn-secondary">Update lot</button>
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