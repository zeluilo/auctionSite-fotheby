<div class="intro-section" style="background-image: url('../users/images/background.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                <h1>Add an Auction</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, nihil.</p>
                <p><a href="/user/catalogue" class="btn btn-primary">Explore Now</a></p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="" method="post" enctype="multipart/form-data" class="user">
                    <h2 class="mb-4 text-black"><strong></strong></h2>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="useremail">Item Title</label>
                            <input type="text" name="title" class="form-control form-control-user" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="useremail">Item Original Price</label>
                            <input type="number" name="price" class="form-control form-control-user" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="useremail">Item Description</label>
                            <textarea type="text" name="description" class="form-control form-control-user" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="useremail">End Date for Auction</label>
                            <input type="date" name="endDate" min="<?php echo date('Y-m-d'); ?>" class="form-control form-control-user" required>
                        </div>
                        <div class="col-4 form-group">
                            <label for="useremail">Upload an Image</label>
                            <input type="file" class="form-control form-control-user" name="auct_pic" accept="image/*" required>
                        </div>
                        <div class="col-4 form-group">
                            <label for="useremail">Pick a Category</label>
                            <select class="form-control form-control-user" name="catId" required>
                            <?php
                            foreach ($category as $row) {
                                echo '<option value="' . $row['catId'] . '">' . $row['catname'] . '</option>';
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" name="submit" value="Request Auction" class="btn btn-primary btn-lg px-5">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
