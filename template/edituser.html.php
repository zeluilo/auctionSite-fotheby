<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit this User</h1>
    <div class="col-xl-114">

        <div class="col-xl-12">
            <div class="card h-100">
                <div class="card-body">
                    <form class="col-xl-12" action="/admin/editUser" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="userId" value="<?php echo $user['userId'] ?>" />
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="edit">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="useremail">First Name</label>
                                        <input type="text" name="firstname" class="form-control" value="<?php echo $user['firstname'] ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="useremail">Last Name</label>
                                        <input type="text" name="lastname" class="form-control" value="<?php echo $user['lastname'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="useremail">Email</label>
                                        <input type="text" name="email" class="form-control" value="<?php echo $user['email'] ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="useremail">Phone Number</label>
                                        <input type="text" name="number" class="form-control" value="<?php echo $user['number'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="useremail">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?php echo $user['address'] ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="passlogin">Change to Seller</label>
                                        <select class="form-control" name="checkAdmin" >
                                            <option selected="">USER</option>
                                            <option>SELLER</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="submit" name="submit" value="Update User" class="btn btn-primary btn-lg px-5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>