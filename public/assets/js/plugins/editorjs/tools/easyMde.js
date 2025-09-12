

class EasyMDETool {
    // 1) toolbox
    static get toolbox() {
        return {
            title: 'MD',
            icon: '<svg viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>',
        };
    }

    // 2) به Editor.js می‌گوییم هنگام Enter این بلاک را نشکند
    static get enableLineBreaks() {
        return true;
    }

    constructor({ data, api, config }) {
        this.api    = api;
        this.data   = { text: data.text || '' };
        this.config = config || {};
    }

    render() {
        // کانتینر اصلی
        this.wrapper = document.createElement('div');
        this.wrapper.classList.add('cdx-easymde-tool');

        // textarea خام
        this.textarea = document.createElement('textarea');
        this.textarea.value       = this.data.text;
        this.textarea.placeholder = this.config.placeholder || '';

        this.wrapper.appendChild(this.textarea);

        // ساخت EasyMDE
        this.easymde = new EasyMDE({
            element: this.textarea,
            initialValue: this.data.text || '',
            ...this.config,
        });

        // 3) جلوگیری از انتشار رویداد Enter به بالا
        //    تا Editor.js بلوک جدید نسازد
        const cm = this.easymde.codemirror;
        cm.on('keydown', (_cmInstance, event) => {
            if (event.key === 'Enter' || event.keyCode === 13) {
                // جلوی رفتار پیش‌فرض CodeMirror نمی‌گیریم
                // ولی انتشار event را متوقف می‌کنیم
                event.stopPropagation();
            }
        });

        return this.wrapper;
    }

    save() {
        return {
            text: this.easymde.value(),
        };
    }

    validate(savedData) {
        return savedData.text.trim().length > 0;
    }

    destroy() {
        if (this.easymde) {
            this.easymde.toTextArea();
            this.easymde = null;
        }
    }
}


