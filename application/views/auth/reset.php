<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center mt-5 pt-5">

    <div class="col-xl-6 col-lg-7 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-3">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Account Recovery</h1>
                  <hr>
                </div>
                <?php
                  $resetMessage = $this->session->flashdata('password_reset_message');
                  if ($resetMessage) {
                     echo '<div id="flash-message" class="alert alert-danger">' . $resetMessage . '</div>';
                  }
                  ?>
                <?= $this->session->flashdata('message'); ?>
                <form class="user" method="post" action="<?= base_url('auth/password'); ?>">
                <div class="form-outline">
                   <label class="form-label" for="typeEmail">Enter your Email..</label>
                   <input type="email" name="email" id="typeEmail" class="form-control" required />  
                </div>
                <div class="form-outline">
                    <label class="form-label" for="typeText">What is Your School Name?</label>
                    <input type="text" name="security" id="typeText" class="form-control" required />
                </div>
                  <button class="btn btn-primary bg-gradient-primary btn-user btn-block mt-4" type="submit">
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<script>
    // Wait for the DOM to be ready
    document.addEventListener("DOMContentLoaded", function () {
        var flashMessage = document.getElementById("flash-message");

        // Check if the flash message element exists
        if (flashMessage) {
            // Automatically dismiss the message after 3 seconds
            setTimeout(function () {
                flashMessage.style.display = "none";
            }, 3000); // 3000 milliseconds (3 seconds)
        }
    });
</script>