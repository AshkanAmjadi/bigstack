<script src="{{asset('assets/js/plugins/editorjs/tools/header.js')}}"></script><!-- Header -->
{{--<script src="{{asset('assets/js/plugins/editorjs/tools/simpleImage.js')}}"></script>--}}
<script src="{{asset('assets/js/plugins/editorjs/tools/image.js')}}"></script>
<script src="{{asset('assets/js/plugins/editorjs/tools/allert.js')}}"></script><!-- allert -->
<script src="{{asset('assets/js/plugins/editorjs/tools/delimeter.js')}}"></script><!-- Delimiter -->
<script src="{{asset('assets/js/plugins/editorjs/tools/list.js')}}"></script><!-- List -->
<script src="{{asset('assets/js/plugins/editorjs/tools/quote.js')}}"></script><!-- Quote -->
<script src="{{asset('assets/js/plugins/editorjs/tools/code.js')}}"></script><!-- Code -->
<script src="{{asset('assets/js/plugins/editorjs/tools/embed.js')}}"></script><!-- Embed -->
<script src="{{asset('assets/js/plugins/editorjs/tools/table.js')}}"></script><!-- Table -->
<script src="{{asset('assets/js/plugins/editorjs/tools/link.js')}}"></script><!-- Link -->
<script src="{{asset('assets/js/plugins/editorjs/tools/underline.js')}}"></script><!-- underline -->
<script src="{{asset('assets/js/plugins/editorjs/tools/inline-code.js')}}"></script><!-- Inline Code -->
<script src="{{asset('assets/js/plugins/editorjs/tools/textColor.js')}}"></script>
<script src="{{asset('assets/js/plugins/easyMde/easyMde.js')}}"></script>

<!-- Load Editor.js's Core -->

<script src="{{asset('assets/js/plugins/editorjs/tools/columns.js')}}"></script>
<script src="{{asset('assets/js/plugins/editorjs/tools/easyMde.js')}}"></script>
<script src="{{asset('assets/js/plugins/editorjs/editor.js')}}"></script>

<script>

    class HeaderH3 extends Header {
        static get toolbox() {
            return {
                title: 'تیتر سطح 3',   // اسم دلخواه ابزار
                icon: '3'
            };
        }
        save(blockContent) {
            const data = super.save(blockContent);
            // اینجا چیزی تغییر نمی‌دیم، چون خروجی ابزار مهم نیست، بلکه اسم type مهمه
            return data;
        }
    }
    class HeaderH4 extends Header {
        static get toolbox() {
            return {
                title: 'تیتر سطح 4',   // اسم دلخواه ابزار
                icon: '4'
            };
        }
        save(blockContent) {
            const data = super.save(blockContent);
            // اینجا چیزی تغییر نمی‌دیم، چون خروجی ابزار مهم نیست، بلکه اسم type مهمه
            return data;
        }

    }

    let column_tools = {

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
        header3: {
            class: Header,
            inlineToolbar: true,
            config: {
                placeholder: 'Header3'
            },
            shortcut: 'CMD+ALT+3'
        },
        allert: {
            class: allert,

        },

        /**
         * Or pass class directly without any configuration
         */




        quote: {
            class: Quote,
            inlineToolbar: true,
            config: {
                quotePlaceholder: 'Enter a quote',
                captionPlaceholder: 'Quote\'s author',
            },
            shortcut: 'CMD+SHIFT+O'
        },



        code: {
            class:  CodeTool,
            shortcut: 'CMD+SHIFT+C'
        },

        delimiter: Delimiter,

        inlineCode: {
            class: InlineCode,
            shortcut: 'CMD+SHIFT+C'
        },

        embed: Embed,

        table: {
            class: Table,
            inlineToolbar: true,
            shortcut: 'CMD+ALT+T'
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
    let editortools = {

        easymde: {
            class: EasyMDETool,
            config: {
                autofocus: true,
                spellChecker: false,
                placeholder: 'متن MD بنویس…',
                toolbar: [
                    'bold',
                    'italic',
                    'strikethrough',
                    'heading',
                    '|',
                    'code',
                    'unordered-list',
                    'ordered-list',
                    '|',
                    'link',
                    'clean-block',
                    '|',
                    'preview',{
                        name: "toggleDir",
                        action: function(editor){
                            const wrapper = editor.codemirror.getWrapperElement();
                            wrapper.style.direction = wrapper.style.direction === 'rtl' ? 'ltr' : 'rtl';
                        },
                        className: "fa fa-align-justify",
                        title: "Toggle RTL/LTR"
                    }
                ],
            }
        },
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
        header3: {
            class: HeaderH3,
            inlineToolbar: true,
            shortcut: 'CTRL+ALT+3',
            config: {
                placeholder: 'عنوان خود را وارد کنید',
                levels: [1, 2, 3],
                defaultLevel: 3
            }
        },
        header4: {
            class: HeaderH4,
            inlineToolbar: true,
            shortcut: 'CTRL+ALT+4',
            config: {
                placeholder: 'عنوان خود را وارد کنید',
                levels: [1, 2, 4],
                defaultLevel: 4
            }
        },

        allert: {
            class: allert,

        },

        /**
         * Or pass class directly without any configuration
         */
        image: {
            class : image
        },

        list: {
            class: List,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+L'
        },


        quote: {
            class: Quote,
            inlineToolbar: true,
            config: {
                quotePlaceholder: 'Enter a quote',
                captionPlaceholder: 'Quote\'s author',
            },
            shortcut: 'CMD+SHIFT+O'
        },



        code: {
            class:  CodeTool,
            shortcut: 'CMD+SHIFT+C'
        },

        delimiter: Delimiter,

        inlineCode: {
            class: InlineCode,
            shortcut: 'CMD+SHIFT+C'
        },


        embed: Embed,

        table: {
            class: Table,
            inlineToolbar: true,
            shortcut: 'CMD+ALT+T'
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
        columns : {
            class : editorjsColumns,
            config : {
                EditorJsLibrary : EditorJS, // Pass the library instance to the columns instance.
                tools : column_tools // IMPORTANT! ref the column_tools
            }
        },
        underline: Underline
    }
    let i18n = {
        /**
         * Text direction
         */
        direction: 'rtl',
        messages: {
            /**
             * Other below: translation of different UI components of the editor.js core
             */
            ui: {
                "blockTunes": {
                    "toggler": {
                        "Click to tune": "اعمال",
                        "or drag to move": "یا جابهجا کنید"
                    },
                },
                "inlineToolbar": {
                    "converter": {
                        "Convert to": "تبدیل به"
                    }
                },
                "toolbar": {
                    "toolbox": {
                        "Add": "اضافه کردن"
                    }
                }
            },

            /**
             * Section for translation Tool Names: both block and inline tools
             */
            toolNames: {
                "Text": "پاراگراف",
                "Heading": "تیتر",
                "List": "لیست",
                "Warning": "هشدار",
                "Checklist": "چک لیست",
                "Quote": "نقل قول",
                "Code": "حالت کد",
                "Delimiter": "جداکننده",
                "Raw HTML": "سطر html",
                "Table": "جدول",
                "Link": "لینک",
                "Marker": "مارک",
                "Bold": "چاق",
                "Italic": "ایتالیک",
                "InlineCode": "حالت کد",
                "Tooltip": "تولتیپ یا برچسب",
                "Color": "رنگ",
                "Image": "عکس",
                "Columns": "ستون بندی",
            },

            /**
             * Section for passing translations to the external tools classes
             */
            tools: {
                /**
                 * Each subsection is the i18n dictionary that will be passed to the corresponded plugin
                 * The name of a plugin should be equal the name you specify in the 'tool' section for that plugin
                 */
                "warning": { // <-- 'Warning' tool will accept this dictionary section
                    "Title": "عنوان",
                    "Message": "پیام",
                },


                /**
                 * Link is the internal Inline Tool
                 */
                "link": {
                    "Add a link": "یک لینک اضافه کنید"
                },
                /**
                 * The "stub" is an internal block tool, used to fit blocks that does not have the corresponded plugin
                 */
                "stub": {
                    'The block can not be displayed correctly.': 'محتوی قابل پخش نیست'
                }
            },

            /**
             * Section allows to translate Block Tunes
             */
            blockTunes: {
                /**
                 * Each subsection is the i18n dictionary that will be passed to the corresponded Block Tune plugin
                 * The name of a plugin should be equal the name you specify in the 'tunes' section for that plugin
                 *
                 * Also, there are few internal block tunes: "delete", "moveUp" and "moveDown"
                 */
                "delete": {
                    "Delete": "پاک کردن",
                    "Click to delete": "برای پاک شدن کلیک کنید"
                },
                "moveUp": {
                    "Move up": "یک پله به سمت بالا"
                },
                "moveDown": {
                    "Move down": "یک پله به سمت پایین"
                }
            },
        }
    };
</script>
