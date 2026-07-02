<style>
    img[alt="side-avatar"] {
        margin-right: 0px !important;
        margin-bottom: 0px !important;
        width: 85px !important;
        height: 100% !important;
        border: 1px solid rgba(108, 108, 108, 0.35);
        border-radius: 5rem;
        padding: 2px;
    }
</style>
<aside>
<div class="sidebar">
    <div class="project-logo">
        <div class="dflex align-center justify-center" style="width: 100%;">
            <div class="text-center" style="display:flex;flex-direction:column;align-items: center;">\
                <div style="width:max-content; height:max-content; position:relative">
                    <img src="<?= getAvatar() ?>" class="side-avatar" alt="side-avatar" loading="lazy">
                </div>
                <div class="side-name">
                    <span class="fw-semibold"><?= getSession('username') ?></span>
                </div>
                <div class="side-role">
                </div>
            </div>
        </div>
        <i class="bx bx-chevron-left side-toggle shrink lg"></i>
    </div>
    <div class="sidebar-nav">
        <a class="no-parent" href="<?= site_url('products') ?>">
            <div class="sidebar-item">
                <span class="fw-normal fs-7">Products</span>
            </div>
        </a>
        <a class="no-parent" href="<?= site_url('category') ?>">
            <div class="sidebar-item">
                <span class="fw-normal fs-7">Category</span>
            </div>
        </a>
    </div>
</div>
</aside>