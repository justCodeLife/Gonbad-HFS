$('#image').on("change", function () {
    var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
    if ($.inArray(this.files[0].type, validImageTypes) < 0) {
        $(this).val('');
        $('#upload_image').text('');
        Swal.fire({
            type: 'error',
            title: 'خطا',
            text: 'تصویر فایل مورد نظر نامعتبر است',
        });
    } else {
        if (this.files[0].size > 5120000) {
            $(this).val('');
            $('#upload_image').text('');
            Swal.fire({
                type: 'error',
                title: 'خطا',
                text: 'حجم تصویر فایل مورد نظر بیش از حد مجاز است',
            });
        } else {
            $('#upload_image').text("حجم تصویر فایل : " + (this.files[0].size / 1000000).toFixed(2) + " مگابایت");
        }
    }
});
$('#file').on("change", function () {
    if (this.files[0].size > 2048000000) {
        $(this).val('');
        $('#upload_file').text('');
        Swal.fire({
            type: 'error',
            title: 'خطا',
            text: 'حجم فایل مورد نظر بیش از حد مجاز است',
        });
    } else {
        $('#upload_file').text("حجم فایل : " + (this.files[0].size / 1000000).toFixed(2) + " مگابایت");
    }
});
