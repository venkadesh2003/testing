<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5 pt-5">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Password Reset</h1>
                                        <hr>
                                    </div>
                                    <div id="passwordMismatchError" class="alert alert-danger" style="display: none;">
    New Password and Confirm Password do not match.
</div>
<?php
                  $resetMessage = $this->session->flashdata('password_reset_message');
                  if ($resetMessage) {
                     echo '<div id="flash-message" class="alert alert-danger">' . $resetMessage . '</div>';
                  }
                  ?>
                                    <form class="user" action="reset_password" method="post">
                                    <div class="form-group">
                                                <label for="newPassword">New Password</label>
                                    <div class="input-group">
                                                    <input type="password" name="new_password" id="newPassword" class="form-control" required minlength="6">
                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-eye" id="toggleNewPassword"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                    <div class="form-group">
                                                <label for="confirmPassword">Confirm Password</label>
                                    <div class="input-group">
                                                    <input type="password" name="confirm_password" id="confirmPassword" class="form-control" required minlength="6">
                                     <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-eye" id="toggleConfirmPassword"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                                        <input type="hidden" name="security" value="<?php echo $security;?>">
                                        <button class="btn btn-primary bg-gradient-primary btn-user btn-block mt-4" type="submit">
                                            Reset Password
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.getElementById('toggleNewPassword').addEventListener('click', function () {
        const newPasswordInput = document.getElementById('newPassword');
        togglePasswordVisibility(newPasswordInput, this);
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const confirmPasswordInput = document.getElementById('confirmPassword');
        togglePasswordVisibility(confirmPasswordInput, this);
    });

    function togglePasswordVisibility(input, icon) {
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<script>
    document.getElementById('toggleNewPassword').addEventListener('click', function () {
        togglePasswordVisibility('newPassword', this);
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        togglePasswordVisibility('confirmPassword', this);
    });

    function togglePasswordVisibility(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const passwordMismatchError = document.getElementById('passwordMismatchError');

    newPasswordInput.addEventListener('input', checkPasswordMatch);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    function checkPasswordMatch() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (newPassword === confirmPassword) {
            passwordMismatchError.style.display = 'none';
        } else {
            passwordMismatchError.style.display = 'block';
        }
    }
</script>


</body>
</html>
