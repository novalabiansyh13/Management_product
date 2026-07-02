</div>
</div>
</div>
<input type="hidden" id="csrf_token" value="<?= base_encode(csrf_hash()) ?>">
<input type="hidden" id="list_dtids" value="">
</body>
<!-- Modal Preview -->
<div class="modal fade" id="modalprev" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalprevLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modalprev-title"></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalprev')">&times;</button>
                </div>
            </div>
            <div class="modal-body dflex align-center justify-center form-preview" style="padding: 12px;" id="modelbodyprev">
            </div>
        </div>
    </div>
</div>
<!-- Modal Form -->
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" id="modaldetail-size" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="modaldetail-id" id="modaldetail-id">
                <input type="hidden" name="modaldetail-link" id="modaldetail-link">
                <div class="dflex justify-between align-center" style="width: 100%;border-bottom: 1px solid rgba(25, 75, 120, 0.15); padding-block: 4px;">
                    <span class="modal-title fs-6set fw-normal text-dark" id="modaldetail-title" style="width: 90% !important;"></span>
                    <button type="button" class="btn text-dark" style="height:max-content;font-size: 24px;padding: 0px !important;padding-block: 0px !important;" id="btn-close-modaldetail" onclick="close_modal('modaldetail')">&times;</button>
                </div>
            </div>
            <div class="modal-body margin-t-2" id="modaldetail-form">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaldetailtwo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" id="modaldetailtwo-size" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="modaldetailtwo-id" id="modaldetailtwo-id">
                <input type="hidden" name="modaldetailtwo-link" id="modaldetailtwo-link">
                <div class="dflex justify-between align-center" style="width: 100%;border-bottom: 1px solid rgba(25, 75, 120, 0.15); padding-block: 4px;">
                    <span class="modal-title fs-6set fw-normal text-dark" id="modaldetailtwo-title"></span>
                    <button type="button" class="btn text-dark" style="height:max-content;font-size: 24px;padding: 0px !important;padding-block: 0px !important;" id="btn-close-modaldetail" onclick="close_modal('modaldetailtwo')">&times;</button>
                </div>
            </div>
            <div class="modal-body margin-t-2" id="modaldetailtwo-form">

            </div>
        </div>
    </div>
</div>
<!-- Modal Log Out -->
<div class="modal fade" id="modalout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="modalout-link" id="modalout-link" />
                <div class="dflex justify-center align-center" style="width: 100%">
                    <div class="spans text-center">
                        <span class="modal-title fs-6set fw-normal text-dark" id="modalout-title">Log Out</span>
                    </div>
                </div>
            </div>
            <div class="modal-body p-x-2" style="padding-bottom: 1rem;">
                <div class="dflex justify-center align-center text-center">
                    <span class="fw-normal fs-7">Are you sure want to Log Out ?</span>
                </div>
                <div class="dflex justify-center align-center text-center margin-t-2">
                    <span class="fw-normal fs-7set text-dark">your unsaved data will be lost</span>
                </div>
                <div class="dflex justify-center align-center margin-t-18p">
                    <button class="btn btn-success dflex align-center margin-r-2" onclick="return logOut('yes')">
                        <span class="fw-normal fs-7set">Yes, Continue</span>
                    </button>
                    <button class="btn btn-danger dflex align-center" onclick="return close_modal('modalout')">
                        <span class="fw-normal fs-7set">No, Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Release -->
<div class="modal fade" id="modalrel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modalrel-title"></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalrel')">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark" id="all-release-message">Are you sure to <span id="type-release"></span> this data? Make sure the data is correct before you <span id="type-release-two"></span> it</span>
                <span class="fw-normal fs-7set text-dark" id="custom-message-release"></span>
                <div class="plus-message">

                </div>
                <div id="modalrel-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-warning" id="cancel-release" onclick="close_modal('modalrel')"><span class="fw-normal fs-7">No, Cancel</span></button>
                <button type="button" class="btn btn-primary" id="confirm-release"><span class="fw-normal fs-7">Yes, Continue</span></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cropper -->
<div class="modal fade" id="modalCropper" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans">
                        <h5 class="modal-title fs-6set text-dark" id="modalCropperLabel">Pre-Process Photo Profile</h5>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalCropper')">&times;</button>
                </div>
            </div>
            <div class="modal-body text-center" style="margin-bottom:18px;">
                <div class="row">
                    <div class="col-8" style="padding-right: 8px;border-right:1px solid rgba(108, 108, 108, 0.25)">
                        <div style="width: 100%;height:100%;">
                            <img src="" alt="profile-img" loading="lazy" id="profile-img">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="dflex align-center justify-center">
                            <div style="width: 90%;height:250px;padding:4px;margin-block:4px;border:1px solid rgba(108, 108, 108, 0.25)">
                                <img src="<?= getURL('public/images/blank.jpg') ?>" loading="lazy" alt="preview" id="preview-alt" style="width: 100%;height:100%;object-fit:contain;">
                            </div>
                        </div>
                        <div class="dflex align-center justify-center">
                            <button class="btn btn-primary dflex align-center justify-center" style="width: 90%;" id="btn-crop">
                                <i class="bx bx-crop margin-r-3"></i>
                                <span class="fw-normal fs-7">Save Images</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cancel Booking -->
<div class="modal fade" id="modalcancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <input type="hidden" name="hdid" id="modalcancel-hdid">
                    <input type="hidden" name="link" id="modalcancel-link">
                    <input type="hidden" name="types" id="modalcancel-type">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modalcancel-title"><span id="modalcancel-typetitle" style="text-transform: capitalize;"></span> Booking Stock</span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalcancel')">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark">Are you sure to <span id="modalcancel-typecancel"></span> this booking stock ?</span>
                <div class="plus-message">

                </div>
                <div id="modalcancel-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-warning" id="cancel-cancel" onclick="close_modal('modalcancel')"><span class="fw-normal fs-7">No, Cancel</span></button>
                <button type="button" class="btn btn-primary" id="confirm-cancel-booking"><span class="fw-normal fs-7">Yes, Continue</span></button>
            </div>
        </div>
    </div>
</div>
<!-- Move to Order -->
<div class="modal fade" id="modalmulti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <input type="hidden" name="hdid" id="modalmulti-hdid">
                    <input type="hidden" name="link" id="modalmulti-link">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modalmulti-title"><span id="modalmulti-typetitle" style="text-transform: capitalize;"></span></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalmulti')">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark" id="modalmulti-message"></span>
                <div class="plus-message">

                </div>
                <div id="modalmulti-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-warning" id="modalmulti-cancel" onclick="close_modal('modalmulti')"><span class="fw-normal fs-7">No, Cancel</span></button>
                <button type="button" class="btn btn-primary" id="modalmulti-confirm"><span class="fw-normal fs-7">Yes, Continue</span></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal fade" id="modaldel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row w-100 dflex justify-between" style="padding:0px;height:max-content;">
                    <div class="col-10 dflex align-center">
                        <span class="modal-title fs-6set fw-normal" id="modaldel-title">
                        </span>
                    </div>
                    <div class="col-1 dflex align-center justify-end">
                        <button type="button" class="btn text-dark" style="font-size: 24px;width:max-content;height:max-content;padding: 0px;margin-right:8px;" onclick="close_modal('modaldel')">×</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark">Are you sure to delete this data ?</span>
                <div class="plus-message">

                </div>
                <div id="modaldel-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-secondary" id="cancel-delete" onclick="close_modal('modaldel')"><span class="fw-normal fs-7">No, Keep It</span></button>
                <button type="button" class="btn btn-danger" id="confirm-delete"><span class="fw-normal fs-7">Yes, Delete It</span></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaldeltwo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modaldeltwo-title"></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modaldeltwo')">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark">Are you sure to delete this data ?</span>
                <div class="plus-message">

                </div>
                <div id="modaldeltwo-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-secondary" id="cancel-delete" onclick="close_modal('modaldeltwo')"><span class="fw-normal fs-7">No, Keep It</span></button>
                <button type="button" class="btn btn-danger" id="confirm-delete"><span class="fw-normal fs-7">Yes, Delete It</span></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Synchronize -->
<div class="modal fade" id="modalsync" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans" style="width: 90%;">
                        <span class="modal-title fs-6set fw-normal" id="sync-title"></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalsync')">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <div>
                    <span class="fw-normal fs-7set text-dark">Do you want to pull this machine data?</span>
                    <div class="plus-message">
                    </div>
                </div>
                <div id="sync-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-secondary" id="cancel-sync" onclick="close_modal('modalsync')"><span class="fw-normal fs-7">Cancel</span></button>
                <button type="button" class="btn btn-primary" id="confirm-sync"><span class="fw-normal fs-7">Pull</span></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Slide Up -->
<div class="slideUp-form" id="slideUp-form">
    <div class="slideUp-content">
        <div class="slideUp-title">
            <div class="title-span">
                <span id="title-slideUp"></span>
                <i class='bx bx-x' onclick="hideSlide()"></i>
            </div>
        </div>
        <div class="form-slideUp" id="form-slideUp">
        </div>
    </div>
</div>
<!-- Modal Cancel Request -->
<div class="modal fade" id="modal-cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row w-100 dflex justify-between" style="padding:0px;height:max-content;">
                    <div class="col-10 dflex align-center">
                        <span class="modal-title fs-6set fw-normal" id="modal-title">
                            Cancel Request
                        </span>
                    </div>
                    <div class="col-1 dflex align-center justify-end">
                        <button type="button" class="btn text-dark" style="font-size: 24px;width:max-content;height:max-content;padding: 0px;margin-right:8px;" onclick="close_modal('modal-cancel')">×</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark">Are you sure to cancel this request?</span>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-secondary" id="cancel-delete" onclick="close_modal('modal-cancel')"><span class="fw-normal fs-7">No, Keep It</span></button>
                <button type="button" class="btn btn-danger" id="confirm-cancel"><span class="fw-normal fs-7">Yes, Cancel It</span></button>
            </div>
        </div>
    </div>
</div>
<!-- <div id="google_translate_element"></div> -->
</html>
<script>
    function openFilter() {
        $('#filter-tab').slideToggle(100);
    }

    function logOut(type = '') {
        if (type == '') {
            $('#modalout').modal('show');
        } else {
            showSuccess('Logging Out..')
            setTimeout(() => {
                window.location.href = "<?= getURL('logout') ?>";
            }, 150);
        }
    }

    function showSuccess(msg) {
        notyf.success(msg);
    }

    function showError(msg) {
        notyf.error(msg);
    }

    function showNotif(type, msg, duration = 2000) {
        notyf.open({
            type: type,
            message: msg,
            duration: duration
        })
    }

    function zoom() {
        document.body.style.zoom = '90%';
    }
</script>