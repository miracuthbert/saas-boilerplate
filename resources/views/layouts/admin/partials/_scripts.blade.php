<!-- Scripts -->
<!-- Included in admin js
     jQuery
     bootstrap
     VueJs
     + Core UI js
 -->
<script src="{{ asset('js/admin.js') }}"></script>

<!-- Include modules below in 'admin.js'
        Pace Progress
        Chart Js
 -->

<!-- Text Editor -->
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
<script>
    var editor_config = {
        path_absolute: "/",
        selector: "textarea.custom-editor",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };

    if (typeof tinymce !== 'undefined') {
	    tinymce.init(editor_config);
    }
</script>

<!-- Checkbox Selector -->
<script>
    $('.checkbox-selector').each(function() {
        const checkboxSelector = $(this)
        const uniqueKey = checkboxSelector.data('key')
        const perms = $(`.${uniqueKey}-item`)

        const updateChecked = function () {
            const checked = $(`.${uniqueKey}-item:checked`).length

            if (checked === 0) {
                checkboxSelector.prop('checked', false)
                checkboxSelector.prop('indeterminate', false)
            } else if (perms.length > checked) {
                checkboxSelector.prop('checked', false)
                checkboxSelector.prop('indeterminate', true)
            } else {
                checkboxSelector.prop('indeterminate', false)
                checkboxSelector.prop('checked', true)
            }
        }

        checkboxSelector.change(function() {
            if ($(this).prop('checked')) {
                $(`.${uniqueKey}-item`).prop('checked', true)
            } else {
                $(`.${uniqueKey}-item`).prop('checked', false)
            }
        })

        $(`.${uniqueKey}-item`).change(function() {
            updateChecked()
        })

        updateChecked()
    })
</script>

<!-- Custom Scripts -->
@stack('scripts')