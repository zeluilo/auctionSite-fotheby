

<div class="intro-section" style="background-image: url('../users/images/background.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-7 mx-auto text-center aos-init aos-animate" data-aos="fade-up">
                <h1>Login</h1>
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
                <form action="/admin/login" method="post" class="user">
                    <h2 class="mb-4 text-black"><strong>Log In</strong></h2>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="useremail">Email</label>
                            <input type="email" name="email" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="passlogin">Password</label>
                            <input type="password" name="password" class="form-control form-control-user">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg px-5">
                        </div>
                    </div>
                </div>
            </form>     
            <?php echo $error; ?>
        </div>
    </div>
</div>
