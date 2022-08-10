$(function() {

    // js load ảnh khi upload
    $(document).on('change', '.img-load-input', function() {
        let input = $(this);
        displayImage(input, '.wrap-load-image', '.img-load');
    });
    // js load nhiều ảnh khi upload
    $(document).on('change', '.img-load-input-multiple', function() {
        let input = $(this);
        displayMultipleImage(input, '.wrap-load-image', '.load-multiple-img');
    });
    // end js load ảnh khi upload

    // js render slug khi nhập tên
    $(document).on('change keyup', '#name', function() {
        let name = $(this).val();
        $('#slug').val(ChangeToSlug(name));
    });



    // js render slug khi nhập tên
    $(document).on('change keyup', '.nameChangeSlug', function() {
        let name = $(this).val();
        $(this).parents('.wrapChangeSlug').find('.resultSlug').val(ChangeToSlug(name));
    });
    // end js render slug khi nhập tên

    // js  show childs category đệ quy
    $(document).on('click', '.lb-toggle', function() {
        $(this).parent().parent().parent('li').children('ul').slideToggle();
        $(this).find('i').toggleClass('fa-plus').toggleClass('fa-minus');
    });
    // end js  show childs category đệ quy

    // js create select tag
    $(".tag-select-choose").select2({
        tags: true,
        tokenSeparators: [','],
    });
    $(".select-2-init").each(function(){
        let title= $(this).data('title')?$(this).data('title'):"--- Chọn danh mục ---";
        $(this).select2({
            placeholder: title,
            allowClear: true,
        });
    });

    // end create select tag

    // js tinymce
    var editor_config = {
        path_absolute: "/",
        selector: 'textarea.tinymce_editor_init',
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback: function(callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            let cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };
    if ($("textarea.tinymce_editor_init").length) {
        tinymce.init(editor_config);
    }
    // end  tinymce

    // js tab bootrap with tinymce and select init
    $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {

        if ($("textarea.tinymce_editor_init").length) {
            tinymce.init(editor_config);
        }
        if ($(".tag-select-choose").length) {
            $(".tag-select-choose").select2({
                tags: true,
                tokenSeparators: [','],
            });
        }
        if ($(".select-2-init").length) {
            $(".select-2-init").select2({
                placeholder: "--- Chọn danh mục ---",
                allowClear: true,
            });
        }
    });
    // end



    // js load change trạng thái hot và active
    $(document).on('click', '.lb-active', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-active');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn ẩn ' + type;
        } else {
            title = 'Bạn có chắc chắn muốn hiển thị ' + type;
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, next step!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.lb-active-user', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-active');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn ẩn ' + type;
        } else {
            title = 'Bạn có chắc chắn muốn kích hoạt ' + type;
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, next step!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.lb-hot', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-hot');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn bỏ nổi bật ' + type;
        } else {
            title = 'Bạn có chắc chắn muốn chuyển ' + type + ' sang nổi bật';
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, next step!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.lb-thanhtoan', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-thanhtoan');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn chuyển đơn hàng sang trạng thái chưa thanh toán ';
        } else {
            title = 'Bạn có chắc chắn muốn chuyển  đơn hàng sang trạng thái đã thanh toán';
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tiếp tục!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    // js load change trạng thái hot và active
    $(document).on('change', '.lb-order', function() {
        event.preventDefault();
        let wrap = $(this);
        let urlRequest = wrap.data("url");
        let value = $(this).val();

        if (value !== '') {
            var number_regex = /([0-9]{1,})/;
            if (number_regex.test(value) == false) {
                alert('Số thứ tự của bạn không đúng định dạng!');
            } else {
                let title = '';
                title = 'Bạn có chắc chắn muốn đổi số thứ tự ';
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    data: { order: value },
                    dataType: "json",
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.html,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.html,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                        // console.log( response.html);
                    },
                    error: function(response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.html,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        } else {
            alert('Bạn chưa điền số thứ tự');
        }


    });

    // end  js load change trạng thái hot và active

    // js chọn quyền
    $('.checkall').on('click', function() {
        $(this).parents('.wrap-permission').find('.check-children,.check-parent').prop('checked', $(this).prop('checked'));
    });
    $('.check-parent').on('click', function() {
        $(this).parents('.item-permission').find('.check-children').prop('checked', $(this).prop('checked'));
    });
    // end js chọn quyền

    // js load ajax đơn hàng
    $(document).on("click", "#btn-load-transaction-detail", function() {

        let contentWrap = $('#loadTransactionDetail');

        let urlRequest = $(this).data("url");
        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.htmlTransactionDetail;
                    contentWrap.html(html);
                    $('#transactionDetail').modal('show');
                }
            }
        });
    });
    // end js load ajax đơn hàng



    // js load ajax chuyển trạng thái đơn hàng
    $(document).on("click", ".status span", loadNextStepStatus);

    function loadNextStepStatus(event) {
        event.preventDefault();
        let statusWrap = $(this).parents('.status');
        // get url load ajax
        let urlRequest = statusWrap.data("url");
        // get giá trị status hiện tại
        let statusCurrent = parseInt($(this).data("status"));

        // set giá trị các trạng thái
        let arrListStatus = [
            { status: 'hủy bỏ', nextstep: 'Đơn hàng đã bị hủy bỏ không thể chuyển đến trạng thái tiếp theo' },
            { status: 'Đặt hàng thành công chờ xử lý', nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái đã tiếp nhận đơn hàng' },
            { status: 'Đã tiếp nhận', nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái đang vận chuyển' },
            { status: 'Đang vận chuyển', nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái hoàn thành' },
            { status: 'Hoàn thành', nextstep: 'Đơn hàng đã hoàn thành' },
        ]

        let swalOption = {
            //  title: "test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes, next step!'
        }
        if (statusCurrent > 0 && statusCurrent < 4) {
            swalOption.confirmButtonText = 'Yes, next step!';
            swalOption.title = arrListStatus[statusCurrent].nextstep;
        } else if (statusCurrent < 0) {
            swalOption.title = arrListStatus[0].nextstep;
            swalOption.showCancelButton = false;
        } else {
            swalOption.title = arrListStatus[statusCurrent].nextstep;
            swalOption.showCancelButton = false;
            swalOption.icon = 'success';
        }

        Swal.fire(swalOption).then((result) => {
            if (result.isConfirmed && statusCurrent > 0 && statusCurrent < 4) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.htmlStatus;
                            statusWrap.html(html);
                        }
                    }
                });
            }
        })
    }
    // end js load ajax chuyển trạng thái đơn hàng


    // js load ajax chuyển trạng thái thông tin liên hệ
    $(document).on("click", ".status-2 span", loadNextStepStatus_2);

    function loadNextStepStatus_2(event) {
        event.preventDefault();
        let statusWrap = $(this).parents('.status-2');
        // get url load ajax
        let urlRequest = statusWrap.data("url");
        // get giá trị status hiện tại
        let statusCurrent = parseInt($(this).data("status"));

        // set giá trị các trạng thái
        let arrListStatus = [
            { status: 'hủy bỏ', nextstep: 'Thông tin đã bị hủy bỏ không thể chuyển đến trạng thái tiếp theo' },
            { status: 'Đặt hàng thành công chờ xử lý', nextstep: 'Bạn có muốn chuyển sang trạng thái hoàn thành' },
            { status: 'Hoàn thành', nextstep: 'Thông tin liên hệ đã hoàn thành' },
        ]

        let swalOption = {
            //  title: "test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes, next step!'
        }
        if (statusCurrent > 0 && statusCurrent < 4) {
            swalOption.confirmButtonText = 'Yes, next step!';
            swalOption.title = arrListStatus[statusCurrent].nextstep;
        } else if (statusCurrent < 0) {
            swalOption.title = arrListStatus[0].nextstep;
            swalOption.showCancelButton = false;
        } else {
            swalOption.title = arrListStatus[statusCurrent].nextstep;
            swalOption.showCancelButton = false;
            swalOption.icon = 'success';
        }

        Swal.fire(swalOption).then((result) => {
            if (result.isConfirmed && statusCurrent > 0 && statusCurrent < 4) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.htmlStatus;
                            statusWrap.html(html);
                        }
                    }
                });
            }
        })
    }
    // end js load ajax chuyển trạng thái liên hệ
});
