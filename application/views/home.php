<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CI3</title>
    <meta name="generator" content="speculation-rules 1.3.1">
    <style type="text/css"></style>
    <link rel="icon" href="https://adminlte.io/wp-content/uploads/2021/03/cropped-logo-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://adminlte.io/wp-content/uploads/2021/03/cropped-logo-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://adminlte.io/wp-content/uploads/2021/03/cropped-logo-180x180.png" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
</head>

<body>
    <?php if ($this->session->userdata('userId')) : ?>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="d-flex profile-user-img img-responsive img-circle" src="<?= $this->session->userdata('pictureUrl') ?>" alt=" User profile picture">
                            <h3 class="profile-username text-center"><?= $this->session->userdata('displayName') ?></h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>userId</b> <a class="pull-right"><?= $this->session->userdata('userId') ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>line notify</b> <a class="pull-right"><?= $this->session->userdata('line_notify_access_token') ?></a>
                                </li>
                            </ul>
                            <br>
                            <a href="api/lineNotify" class="btn btn-primary btn-block"><b>subscribe our newsletter</b></a>
                            <a href="api/notify" class="btn btn-secondary btn-block"><b>Notify message</b></a>
                            <a href="api/revoke" class="btn btn-secondary btn-block"><b>Notify Revoke</b></a>
                            <a href="api/status" class="btn btn-secondary btn-block"><b>Notify status</b></a>
                            <br>
                            <a href="oauth/signout" class="btn btn-danger btn-block"><b>Signout</b></a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <textarea class="form-control" rows="15" placeholder=""><?= $this->session->flashdata('message') ?></textarea>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="login-page" style="height: 80vh; min-height: 496.781px;">
            <div class="login-box">
                <div class="login-logo">
                    <a><b>Admin</b>LTE</a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form method="post">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="social-auth-links text-center mb-3">
                            <p>- OR -</p>
                            <a href="login" class="btn btn-block btn-success" id="lineLoginBtn">
                                <i class="fab fa-line mr-2"></i> Sign in using LINE
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>