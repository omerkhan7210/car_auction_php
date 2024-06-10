

<div
      class="modal signUp-modal fade"
      id="logInModal01"
      tabindex="-1"
      aria-labelledby="logInModal01Label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="logInModal01Label">Log In</h4>
            <p>
              Don’t have any account?
              <button
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#signUpModal01"
              >
                Sign Up
              </button>
            </p>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            >
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <form  method="POST">
            <input type="hidden" name="form_type" value="login">

            <div class="row">
                <?= isset($_SESSION['login_error']) && $_SESSION['login_error'] != "" ?  $_SESSION['login_error']: "" ?>
              </div>
              <div class="row g-4">
                <div class="col-md-12">
                  <div class="form-inner">
                    <label>Enter your email address*</label>
                    <input type="email" placeholder="Type email" name="email"/>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-inner">
                    <label>Password*</label>
                    <input
                      id="password3"
                      type="password"
                      placeholder="*** ***" name="password"
                    />
                    <i class="bi bi-eye-slash" id="togglePassword3"></i>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div
                    class="form-agreement form-inner d-flex justify-content-between flex-wrap"
                  >
                    <div class="form-group">
                      <input type="checkbox" id="html" />
                      <label for="html">Remember Me</label>
                    </div>
                    <a href="#" class="forgot-pass">Forget Password?</a>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-inner">
                    <button class="primary-btn2" type="submit">Log In</button>
                  </div>
                </div>
              </div>
              <div class="terms-conditon">
                <p>
                  By sign up,you agree to the
                  <a href="#">‘terms & conditons’</a>
                </p>
              </div>
              <ul class="social-icon">
                <li>
                  <a href="#"
                    ><img src="assets/img/home1/icon/google.svg" alt
                  /></a>
                </li>
                <li>
                  <a href="#"
                    ><img src="assets/img/home1/icon/facebook.svg" alt
                  /></a>
                </li>
                <li>
                  <a href="#"
                    ><img src="assets/img/home1/icon/twiter.svg" alt
                  /></a>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </div>
    </div>