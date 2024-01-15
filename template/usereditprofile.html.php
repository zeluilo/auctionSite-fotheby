<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form class="col-xl-12" action="/user/edituser" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="userId" value="<?php echo $user['userId'] ?>"/>
                    <h2 class="mb-4 text-black"><strong></strong></h2>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="useremail">First Name</label>
                            <input type="text" name="firstname" class="form-control form-control-user" value="<?php echo $user['firstname'] ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="useremail">Last Name</label>
                            <input type="text" name="lastname" class="form-control form-control-user" value="<?php echo $user['lastname'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="useremail">Email</label>
                            <input type="email" name="email" class="form-control form-control-user" value="<?php echo $user['email'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="useremail">Address</label>
                            <input type="text" name="address" class="form-control form-control-user" value="<?php echo $user['address'] ?>" required>
                        </div>
                        <div class="col-6 form-group">
                            <label for="useremail">Phone Number</label>
                            <input type="text" name="number" class="form-control form-control-user" value="<?php echo $user['number'] ?>" required>
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
