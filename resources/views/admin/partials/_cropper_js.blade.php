<script src="{{ asset('assets/backend/vendor/cropperjs/cropper.js') }}"></script>

<script>
    function setCropper(modal_selector, modal_image_selector, show_image_wrapper, hidden_file_input_selector, hidden_val_input_selector, callbackFunction=null) {
        $galleryModal = $(modal_selector);
        gallery_image = $(modal_image_selector)[0];
        hidden_file_input = hidden_file_input_selector;
        hidden_val_input = hidden_val_input_selector;
        cropCallBackFunction = callbackFunction;
        show_image_wrapper = show_image_wrapper;
    }
    /*crop gallery image start*/
    var $galleryModal = $('#galleryModal');
    var gallery_image = document.getElementById('galleryModalShowImage');
    var hidden_file_input = ".galary_img_file_input";
    var hidden_val_input = ".gallery_crop_img";
    var show_image_wrapper = ".gallery-image";
    var gallery_cropper;
    var galary_img_file_input;
    var cropCallBackFunction = null;
    $("body").on("change", hidden_file_input, function(e){
        galary_img_file_input = this;
        var files = e.target.files;
        var done = function (url) {
            showLoader('Loading...', 'Please Wait');
            gallery_image.src = url;
            $galleryModal.modal('show');
            console.log('s');
            $(galary_img_file_input).val('');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    });
    $galleryModal.on('shown.bs.modal', function () {
        gallery_cropper = new Cropper(gallery_image, {
            aspectRatio: 7 / 3.5,
            // viewMode: 3,
            preview: '.preview',
            ready() {
                setTimeout(function () {
                    hideLoader();
                }, 500);
            },
        });

    }).on('hidden.bs.modal', function () {
        gallery_cropper.destroy();
        gallery_cropper = null;
        $(".imgCropModal .modal-body").removeAttr('style');
    }).on('loaded.bs.modal', function (e) {

        setTimeout(function () {
            hideLoader();
        }, 500);
    });

    $("#galleryCrop").click(function(){
        var canvas = gallery_cropper.getCroppedCanvas({
            width: 700,
            height: 350
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $(galary_img_file_input).parent().find(show_image_wrapper).html(`<img src="${base64data}" class="sss-img w-100">`);
                $(galary_img_file_input).parent().find(hidden_val_input).val(base64data);
                $(galary_img_file_input).parent().parent().append(`
                        <div class="gallery-remove-icon">
                            <a href="javascript:void(0);" onclick="removeGalleryImage(this)"><i class="fa fa-times"></i></a>
                        </div>
                    `);
                $(galary_img_file_input).remove();
                //addNewGallery();
                if (cropCallBackFunction !== null) {
                    cropCallBackFunction();
                }
                $galleryModal.modal('hide');
            }
        });
    });
    /*crop gallery image end*/
</script>
