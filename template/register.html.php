<div class="intro-section" style="background-image: url('../users/images/background.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                <h1>Register</h1>
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
                <form action="/user/register" method="post" class="user">
                    <h2 class="mb-4 text-black"><strong>Register</strong></h2>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="useremail">First Name</label>
                            <input type="text" name="firstname" class="form-control form-control-user">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="useremail">Last Name</label>
                            <input type="text" name="lastname" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="useremail">Email</label>
                            <input type="email" name="email" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="useremail">Password</label>
                            <input type="password" name="password" class="form-control form-control-user">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="useremail">Repeat Password</label>
                            <input type="password" name="repeat_password" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="useremail">Address</label>
                            <input type="text" name="address" class="form-control form-control-user">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="passlogin">Phone Number</label>
                            <input type="text" name="number" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" name="submit" value="Register" class="btn btn-primary btn-lg px-5">
                        </div>
                    </div>
                </form>
                <?php echo $error; ?>
            </div>
        </div>
    </div>
</div>
