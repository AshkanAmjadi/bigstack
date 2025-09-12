

@if(config('view')['cdn'])
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@2.8.7/dist/header.umd.min.js"></script><!-- header -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@1.4.0/dist/delimiter.umd.min.js"></script><!-- delimiter -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.10.0/dist/list.umd.min.js"></script><!-- list -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@2.6.0/dist/quote.umd.min.js"></script><!-- quote -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@2.7.4/dist/embed.umd.js"></script><!-- Embed -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/underline@1.1.0/dist/bundle.min.js"></script><!-- underline -->
    <script src="https://cdn.jsdelivr.net/npm/editorjs-text-color-plugin@2.0.3/dist/bundle.js"></script>
    <!-- Load Editor.js's Core -->

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.28.0/dist/editorjs.umd.min.js"></script>
@else
    <script src="{{asset('assets/js/plugins/editorjs/tools/header.js')}}"></script><!-- Header -->
    <script src="{{asset('assets/js/plugins/editorjs/tools/delimeter.js')}}"></script><!-- Delimiter -->
    <script src="{{asset('assets/js/plugins/editorjs/tools/list.js')}}"></script><!-- List -->
    <script src="{{asset('assets/js/plugins/editorjs/tools/quote.js')}}"></script><!-- Quote -->
    <script src="{{asset('assets/js/plugins/editorjs/tools/embed.js')}}"></script><!-- Embed -->
    <script src="{{asset('assets/js/plugins/editorjs/tools/underline.js')}}"></script><!-- underline -->
    <script src="{{asset('assets/js/plugins/editorjs/tools/textColor.js')}}"></script>
    <script src="{{asset('assets/js/plugins/editorjs/editor.js')}}"></script>

@endif

<script src="{{asset('assets/js/plugins/editorjs/tools/allert.js')}}"></script><!-- allert -->


<script>
    let editortools = {

        /**
         * Each Tool is a Plugin. Pass them via 'class' option with necessary settings {@link docs/tools.md}
         */
        header: {
            class: Header,
            inlineToolbar: true,
            config: {
                placeholder: 'Header'
            },
            shortcut: 'CMD+SHIFT+H'
        },
        allert: {
            class: allert,

        },

        /**
         * Or pass class directly without any configuration
         */

        list: {
            class: List,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+L'
        },


        quote: {
            class: Quote,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+O'
        },





        delimiter: Delimiter,




        embed: {
            class: Embed,
            inlineToolbar: true
        },


        Color: {
            class: ColorPlugin, // if load from CDN, please try: window.ColorPlugin
            config: {
                colorCollections: ['#EC7878','#9C27B0','#673AB7','#3F51B5','#0070FF','#03A9F4','#00BCD4','#4CAF50','#8BC34A','#CDDC39', '#FFF'],
                defaultColor: '#FF1300',
                type: 'text',
                customPicker: true // add a button to allow selecting any colour
            }
        },

        underline: Underline
    }
    let i18n = {
        /**
         * Text direction
         */
        direction: 'ltr',

    };
</script>
