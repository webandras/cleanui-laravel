<script src="{{ asset('/assets/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script nonce="{{ csp_nonce() }}">
    var editor_config = {
        path_absolute : "/",
        selector: 'textarea#update-content-editor',
        plugins: 'link table lists image code media',
        height: 700,
        browser_spellcheck: true,
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | image media | bullist numlist | code | table | indent outdent',
        forced_root_block: '',
        extended_valid_elements : "iframe[src|frameborder|style|allowfullscreen|scrolling|class|width|height|name|align]",
        image_dimensions: true,

        file_picker_callback : function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            tinymce.activeEditor.windowManager.openUrl({
                url : '/file-manager/tinymce5',
                title : 'Laravel File manager',
                width : x * 0.8,
                height : y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content, { text: message.text })
                }
            })
        }
    }


    tinymce.init(editor_config);
</script>
