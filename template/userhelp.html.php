<div class="section-bg style-1" style="background-image: url('../users/images/background.jpg');">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 mb-5">
        <span class="caption">How?</span>
        <h2 class="text-black">How <strong>It Works</strong></h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        <div class="step">
          <span class="wrap-icon icon-user"></span>
          <h3>Register</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed consequatur quaerat magnam sequi nobis ut et iure.</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="step">
          <span class="wrap-icon icon-money"></span>
          <h3>Buy or Bid</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed consequatur quaerat magnam sequi nobis ut et iure.</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="step">
          <span class="wrap-icon icon-glass"></span>
          <h3>Submit a bid</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed consequatur quaerat magnam sequi nobis ut et iure.</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="step last">
          <span class="wrap-icon icon-trophy"></span>
          <h3>Win</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed consequatur quaerat magnam sequi nobis ut et iure.</p>
        </div>
      </div>
    </div>
  </div>
</div>



<style>
  .step .wrap-icon,
  .service .wrap-icon {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    line-height: 90px;
    text-align: center;
    display: inline-block;
    background: white;
    color: black;
    font-size: 40px;
    margin-bottom: 20px;
  }

  .wrap-icon {
    position: relative;
  }

  .step,
  .service {
    position: relative;
  }

  .step:after,
  .service:after {
    position: absolute;
    content: "\e315";
    top: 10%;
    font-size: 30px;
    color: white;
    right: 20%;
    font-family: 'icomoon';
  }

  
  .text-black {
    color: #000 !important;
  }

  .step h3, .service h3 {
    font-size: 20px;
    font-weight: 700;
    color: white;
    margin-bottom: 20px;
}

.step p, .service p {
    line-height: 1.5;
 color: white;
}

p {
    margin-top: 0;
    margin-bottom: 1rem;
}

.section-bg.style-1 {
        position: relative;
    }

    .section-bg.style-1:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #f37121;
        opacity: .9;
        z-index: 0;
    }

    .section-bg {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 4rem 0;
    }

</style>