<style>
    .badge-notif {
        position: absolute;
        top: -24%;
        bottom: 38%;
        left: 50%;
        font-size: 8.8px;
        padding: 5px;
        border-radius: 5rem;
        background-color: rgba(237, 41, 57);
        color: #fff;
        text-align: center;
    }

    .dps {
        width: 100%;
        background-color: rgba(255, 255, 255);
        padding-inline: 5px;
        padding-block: 6px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .dps .dropdown-content.company {
        left: 0;
    }
</style>
<nav class="navbar sc-sm">
    <div class="navbar-head">
        <div class="row">
            <div class="col-12 dflex align-center justify-between">
                <div class="dflex align-center justify-between">
                    <div class="dflex align-center">
                        <i class="bx bx-menu-alt-left margin-r-3 side-toggle slide"></i>
                        <h5><?= empty($title) ? 'System Management Product' : esc($title) ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<nav class="navbar sc-lg">
    <i class="bx bx-chevron-right side-toggle slide"></i>\
    <div class="nav-item dflex align-center justify-between p-x">
        <div class="row bc">
            <h5 class="fw-semibold fs-5"><?= empty($title) ? 'System Management Product' : esc($title) ?></h5>
        </div>
        <a href="javascript:void();" onclick="return logOut()" class="nav-icon" aria-label="Log Out" data-microtip-position="bottom" role="tooltip">
            <i class="bx bx-log-out text-danger fs-4"></i>
        </a>
    </div>
</nav>