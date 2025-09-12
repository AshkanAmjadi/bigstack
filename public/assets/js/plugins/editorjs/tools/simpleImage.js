/**
 * Skipped minification because the original files appears to be already minified.
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
!function (e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? exports.SimpleImage = t() : e.SimpleImage = t()
}(window, function () {
    return function (e) {
        var t = {};

        function n(i) {
            if (t[i]) return t[i].exports;
            var r = t[i] = {i: i, l: !1, exports: {}};
            return e[i].call(r.exports, r, r.exports, n), r.l = !0, r.exports
        }

        return n.m = e, n.c = t, n.d = function (e, t, i) {
            n.o(e, t) || Object.defineProperty(e, t, {enumerable: !0, get: i})
        }, n.r = function (e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(e, "__esModule", {value: !0})
        }, n.t = function (e, t) {
            if (1 & t && (e = n(e)), 8 & t) return e;
            if (4 & t && "object" == typeof e && e && e.__esModule) return e;
            var i = Object.create(null);
            if (n.r(i), Object.defineProperty(i, "default", {
                enumerable: !0,
                value: e
            }), 2 & t && "string" != typeof e) for (var r in e) n.d(i, r, function (t) {
                return e[t]
            }.bind(null, r));
            return i
        }, n.n = function (e) {
            var t = e && e.__esModule ? function () {
                return e.default
            } : function () {
                return e
            };
            return n.d(t, "a", t), t
        }, n.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, n.p = "/", n(n.s = 0)
    }([function (e, t, n) {
        function i(e) {
            return function (e) {
                if (Array.isArray(e)) {
                    for (var t = 0, n = new Array(e.length); t < e.length; t++) n[t] = e[t];
                    return n
                }
            }(e) || function (e) {
                if (Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e)) return Array.from(e)
            }(e) || function () {
                throw new TypeError("Invalid attempt to spread non-iterable instance")
            }()
        }

        function r(e, t) {
            for (var n = 0; n < t.length; n++) {
                var i = t[n];
                i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
            }
        }

        function a(e, t, n) {
            return t && r(e.prototype, t), n && r(e, n), e
        }

        function o(e, t, n) {
            return t in e ? Object.defineProperty(e, t, {
                value: n,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = n, e
        }

        var s, l;
        n(1).toString();
        var c = function () {
            function e(t) {
                var n = this, i = t.data, r = (t.config, t.api);
                !function (e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, e), o(this, "uploadButtonClick", function () {
                    n.uploadFileInput.click()
                }), o(this, "onSelectFile", function () {
                    var e = document.getElementById("uploadedFile").files[0];
                    n.fileTypes.includes(e.type) ? (n.onDropHandler(e).then(function (e) {
                        n.data = e
                    }), n._createImage()) : n.api.notifier.show({
                        message: "Not a supported type, please try other",
                        style: "error"
                    })
                }), o(this, "initializeImageResize", function (e) {
                    n.disableImageSettingsTools(), s = e.clientX, l = parseInt(document.defaultView.getComputedStyle(n.nodes.imageHolder).width, 10), n.triggerImageResizeEvents(), e.preventDefault()
                }), o(this, "startResize", function (e) {
                    var t = n.nodes.image.naturalWidth, i = n.nodes.image.naturalHeight, r = l + e.clientX - s,
                        a = i / t, o = "".concat(r, "px"), c = "".concat(Math.round(r * a), "px"),
                        d = parseInt(document.defaultView.getComputedStyle(n.nodes.wrapper).width, 10);
                    parseInt(o) < n.minAspectRatioWidthHeight || parseInt(c) < n.minAspectRatioWidthHeight || parseInt(o) > d ? n.stopResize() : (n.nodes.imageHolder.style.width = o, n.nodes.imageHolder.style.height = c, n.nodes.image.setAttribute("width", o), n.nodes.image.setAttribute("height", c))
                }), o(this, "stopResize", function () {
                    window.document.removeEventListener("mousemove", n.startResize, !1)
                }), this.api = r, this.wrapper = void 0, this.uploadFileInput = void 0, this.buttonIcon = '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M3.15 13.628A7.749 7.749 0 0 0 10 17.75a7.74 7.74 0 0 0 6.305-3.242l-2.387-2.127-2.765 2.244-4.389-4.496-3.614 3.5zm-.787-2.303l4.446-4.371 4.52 4.63 2.534-2.057 3.533 2.797c.23-.734.354-1.514.354-2.324a7.75 7.75 0 1 0-15.387 1.325zM10 20C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10-4.477 10-10 10z"/></svg>', this.eventTypes = ["paste", "drop"], this.fileTypes = ["image/jpeg", "image/png"], this.blockIndex = this.api.blocks.getCurrentBlockIndex() + 1, this.CSS = {
                    baseClass: this.api.styles.block,
                    loading: this.api.styles.loader,
                    input: this.api.styles.input,
                    settingsButton: this.api.styles.settingsButton,
                    settingsButtonActive: this.api.styles.settingsButtonActive,
                    wrapper: "cdx-simple-image",
                    imageHolder: "cdx-simple-image__picture",
                    caption: "cdx-simple-image__caption",
                    resizeEnabled: "cdx-simple-image__resize",
                    resizePoint: "resize-point"
                }, this.minAspectRatioWidthHeight = 25, this.nodes = {
                    wrapper: null,
                    imageHolder: null,
                    image: null,
                    caption: null,
                    width: null,
                    height: null,
                    resizeElementPointer: null
                }, this.data = {
                    url: i.url || "",
                    caption: i.caption || "",
                    withBorder: void 0 !== i.withBorder && i.withBorder,
                    withBackground: void 0 !== i.withBackground && i.withBackground,
                    stretched: void 0 !== i.stretched && i.stretched,
                    width: void 0 !== i.width ? i.width : "100%",
                    height: void 0 !== i.height ? i.height : "100%"
                }, this.settings = [{
                    name: "withBorder",
                    icon: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M15.8 10.592v2.043h2.35v2.138H15.8v2.232h-2.25v-2.232h-2.4v-2.138h2.4v-2.28h2.25v.237h1.15-1.15zM1.9 8.455v-3.42c0-1.154.985-2.09 2.2-2.09h4.2v2.137H4.15v3.373H1.9zm0 2.137h2.25v3.325H8.3v2.138H4.1c-1.215 0-2.2-.936-2.2-2.09v-3.373zm15.05-2.137H14.7V5.082h-4.15V2.945h4.2c1.215 0 2.2.936 2.2 2.09v3.42z"/></svg>',
                    label: "With border"
                }, {
                    name: "stretched",
                    icon: '<svg width="17" height="10" viewBox="0 0 17 10" xmlns="http://www.w3.org/2000/svg"><path d="M13.568 5.925H4.056l1.703 1.703a1.125 1.125 0 0 1-1.59 1.591L.962 6.014A1.069 1.069 0 0 1 .588 4.26L4.38.469a1.069 1.069 0 0 1 1.512 1.511L4.084 3.787h9.606l-1.85-1.85a1.069 1.069 0 1 1 1.512-1.51l3.792 3.791a1.069 1.069 0 0 1-.475 1.788L13.514 9.16a1.125 1.125 0 0 1-1.59-1.591l1.644-1.644z"/></svg>',
                    label: "Stretched"
                }, {
                    name: "withBackground",
                    icon: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.043 8.265l3.183-3.183h-2.924L4.75 10.636v2.923l4.15-4.15v2.351l-2.158 2.159H8.9v2.137H4.7c-1.215 0-2.2-.936-2.2-2.09v-8.93c0-1.154.985-2.09 2.2-2.09h10.663l.033-.033.034.034c1.178.04 2.12.96 2.12 2.089v3.23H15.3V5.359l-2.906 2.906h-2.35zM7.951 5.082H4.75v3.201l3.201-3.2zm5.099 7.078v3.04h4.15v-3.04h-4.15zm-1.1-2.137h6.35c.635 0 1.15.489 1.15 1.092v5.13c0 .603-.515 1.092-1.15 1.092h-6.35c-.635 0-1.15-.489-1.15-1.092v-5.13c0-.603.515-1.092 1.15-1.092z"/></svg>',
                    label: "With Background"
                }]
            }

            return a(e, null, [{
                key: "toolbox", get: function () {
                    return {
                        title: "Image",
                        icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
                    }
                }
            }]), a(e, [{
                key: "render", value: function () {
                    (this.wrapper = this._make("div", [this.CSS.baseClass, this.CSS.wrapper]), this.data && this.data.url.length) ? this._createImage() : (this.createFileButton(), this.eventTypes.find(function (e) {
                        return e === event.type
                    }) || this.uploadFileInput.click());
                    return this.wrapper
                }
            }, {
                key: "createFileButton", value: function () {
                    var e = this._make("div", ["cdx-button"]);
                    e.innerHTML = "".concat(this.buttonIcon, " Select an Image"), this.uploadFileInput = this._make("input"), this.uploadFileInput.setAttribute("type", "file"), this.uploadFileInput.setAttribute("id", "uploadedFile"), this.uploadFileInput.setAttribute("accept", "image/*"), e.appendChild(this.uploadFileInput), e.addEventListener("click", this.uploadButtonClick), this.uploadFileInput.addEventListener("change", this.onSelectFile), this.wrapper.appendChild(e);
                    var t = document.createElement("input");
                    t.classList.add("hidden-element"), t.setAttribute("tabindex", 0), this.wrapper.appendChild(t)
                }
            }, {
                key: "_createImage", value: function () {
                    var e = this;
                    this.wrapper.innerHTML = "", loader = this._make("div", this.CSS.loading), imageHolder = this._make("div", [this.CSS.imageHolder, this.CSS.resizeEnabled], {
                        width: this.data.width,
                        height: this.data.height
                    }), image = this._make("img", "", {
                        width: this.data.width,
                        height: this.data.height
                    }), resizeElementPointer = this._make("div", this.CSS.resizePoint), caption = this._make("div", [this.CSS.input, this.CSS.caption], {
                        contentEditable: "true",
                        innerHTML: this.data.caption || ""
                    }), caption.dataset.placeholder = "Enter a caption", image.setAttribute("crossorigin", "anonymous"), this.wrapper.appendChild(loader), this.data.url && (image.src = this.data.url), image.onload = function () {
                        e.wrapper.classList.remove(e.CSS.loading), imageHolder.appendChild(image), imageHolder.appendChild(resizeElementPointer), e.wrapper.appendChild(imageHolder), e.wrapper.appendChild(caption), loader.remove(), e._acceptTuneView()
                    }, image.onerror = function (t) {
                        e.api.notifier.show({message: "Failed to load an image ".concat(t), style: "error"})
                    }, this.nodes.imageHolder = imageHolder, this.nodes.wrapper = this.wrapper, this.nodes.image = image, this.nodes.caption = caption, this.renderSettings(), this.nodes.resizeElementPointer = resizeElementPointer, this.nodes.resizeElementPointer.addEventListener("mousedown", this.initializeImageResize)
                }
            }, {
                key: "disableImageSettingsTools", value: function () {
                    var e = this;
                    Object.keys(this.data).forEach(function (t) {
                        e.data[t] && e._toggleTune(t)
                    })
                }
            }, {
                key: "save", value: function (e) {
                    var t = e.querySelector("img"), n = e.querySelector("." + this.CSS.input);
                    if (!t) return this.data;
                    var i = this.convertImageURLToBase64(t);
                    return Object.assign(this.data, {
                        url: i,
                        caption: n.innerHTML,
                        width: "".concat(t.width, "px"),
                        height: "".concat(t.height, "px")
                    })
                }
            }, {
                key: "convertImageURLToBase64", value: function (e) {
                    var t = document.createElement("canvas");
                    t.width = e.naturalWidth, t.height = e.naturalHeight;
                    var n = t.getContext("2d");
                    return n.clearRect(0, 0, t.width, t.height), n.drawImage(e, 0, 0, t.width, t.height), t.toDataURL("image/jpeg")
                }
            }, {
                key: "validate", value: function (e) {
                    return !!e.url.trim()
                }
            }, {
                key: "onDropHandler", value: function (e) {
                    var t = new FileReader;
                    return t.readAsDataURL(e), new Promise(function (n) {
                        t.onload = function (t) {
                            n({url: t.target.result, caption: e.name})
                        }
                    })
                }
            }, {
                key: "onPaste", value: function (e) {
                    var t = this;
                    switch (e.type) {
                        case"tag":
                            var n = e.detail.data;
                            this.data = {url: n.src}, this._createImage();
                            break;
                        case"pattern":
                            var i = e.detail.data;
                            this.data = {url: i}, this._createImage();
                            break;
                        case"file":
                            var r = e.detail.file;
                            this.onDropHandler(r).then(function (e) {
                                t.data = e
                            }), this._createImage()
                    }
                }
            }, {
                key: "renderSettings", value: function () {
                    var e = this, t = document.createElement("div");
                    return this.data.url && this.settings.forEach(function (n) {
                        var i = document.createElement("div"), r = e.api.i18n.t(n.label);
                        i.classList.add(e.CSS.settingsButton), i.innerHTML = n.icon, e.api.tooltip.onHover(i, r, {placement: "top"}), i.addEventListener("click", function () {
                            e._toggleTune(n.name), i.classList.toggle(e.CSS.settingsButtonActive)
                        }), i.classList.toggle(e.CSS.settingsButtonActive, e.data[n.name]), t.appendChild(i)
                    }), t
                }
            }, {
                key: "_make", value: function (e) {
                    var t, n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null,
                        r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {},
                        a = document.createElement(e);
                    Array.isArray(n) ? (t = a.classList).add.apply(t, i(n)) : n && a.classList.add(n);
                    for (var o in r) a[o] = r[o], "width" === o && ("IMG" === a.tagName ? a.setAttribute("width", r.width) : a.style.width = r.width), "height" === o && ("IMG" === a.tagName ? a.setAttribute("height", r.height) : a.style.height = r.height);
                    return a
                }
            }, {
                key: "_toggleTune", value: function (e) {
                    this.data[e] = !this.data[e], this._acceptTuneView()
                }
            }, {
                key: "triggerImageResizeEvents", value: function () {
                    window.document.addEventListener("mousemove", this.startResize, !1), window.document.addEventListener("mouseup", this.stopResize, !1)
                }
            }, {
                key: "_acceptTuneView", value: function () {
                    var e = this;
                    this.settings.forEach(function (t) {
                        e.nodes.imageHolder.classList.toggle(e.CSS.imageHolder + "--" + t.name.replace(/([A-Z])/g, function (e) {
                            return "-".concat(e[0].toLowerCase())
                        }), !!e.data[t.name]), "stretched" === t.name && e.api.blocks.stretchBlock(e.blockIndex, !!e.data.stretched)
                    })
                }
            }, {
                key: "data", get: function () {
                    return this._data
                }, set: function (e) {
                    this._data = Object.assign({}, this.data, e), this.nodes.image && (this.nodes.image.src = this.data.url), this.nodes.caption && (this.nodes.caption.innerHTML = this.data.caption)
                }
            }], [{
                key: "sanitize", get: function () {
                    return {url: {}, withBorder: {}, withBackground: {}, stretched: {}, caption: {br: !0}}
                }
            }, {
                key: "pasteConfig", get: function () {
                    return {
                        patterns: {image: /https?:\/\/\S+\.(gif|jpe?g|tiff|png)$/i},
                        tags: ["img"],
                        files: {mimeTypes: ["image/*"]}
                    }
                }
            }]), e
        }();
        e.exports = c
    }, function (e, t, n) {
        var i = n(2);
        "string" == typeof i && (i = [[e.i, i, ""]]);
        var r = {hmr: !0, transform: void 0, insertInto: void 0};
        n(4)(i, r);
        i.locals && (e.exports = i.locals)
    }, function (e, t, n) {
        (e.exports = n(3)(!1)).push([e.i, ".cdx-simple-image {}\n\n.cdx-simple-image .cdx-loader {\n  min-height: 200px;\n}\n\n.cdx-simple-image .cdx-input {\n  margin-top: 10px;\n}\n\n.cdx-simple-image img {\n  max-width: 100%;\n  vertical-align: bottom;\n  height: auto;\n}\n\n.cdx-simple-image__caption[contentEditable=true][data-placeholder]:empty::before {\n  position: absolute;\n  content: attr(data-placeholder);\n  color: #707684;\n  font-weight: normal;\n  opacity: 0;\n }\n\n.cdx-simple-image__caption[contentEditable=true][data-placeholder]:empty::before {\n  opacity: 1;\n}\n\n.cdx-simple-image__caption[contentEditable=true][data-placeholder]:empty:focus::before {\n  opacity: 0;\n}\n\n\n.cdx-simple-image__picture--with-background {\n  background: #eff2f5;\n  padding: 10px;\n}\n\n.cdx-simple-image__picture--with-background img {\n  display: block;\n  max-width: 60%;\n  margin: 0 auto;\n}\n\n.cdx-simple-image__picture--with-border {\n  border: 1px solid #e8e8eb;\n  padding: 1px;\n}\n\n.cdx-simple-image__picture--stretched img {\n  max-width: none;\n  width: 100%;\n}\n\n.cdx-simple-image__picture {\n  position: relative;\n  border: 2px solid transparent;\n  box-sizing: content-box;\n}\n .cdx-simple-image__resize:hover, .cdx-simple-image__picture:active {\n  border: 2px solid rgb(23, 90,226);\n}\n\n.cdx-simple-image__picture .resize-point {\n  visibility: hidden;\n}\n\n.cdx-simple-image__picture:hover .resize-point, .cdx-simple-image__picture:active .resize-point {\n  visibility: visible;\n  width: 10px;\n  height: 10px;\n  position: absolute;\n  background: rgb(23, 90,226);\n  right: 0;\n  bottom: 0;\n  cursor: se-resize;\n}\n\n.cdx-simple-image input {\n  display: none !important;\n}\n\n.hidden-element {\n  display: none;\n}", ""])
    }, function (e, t) {
        e.exports = function (e) {
            var t = [];
            return t.toString = function () {
                return this.map(function (t) {
                    var n = function (e, t) {
                        var n = e[1] || "", i = e[3];
                        if (!i) return n;
                        if (t && "function" == typeof btoa) {
                            var r = (o = i, "/*# sourceMappingURL=data:application/json;charset=utf-8;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(o)))) + " */"),
                                a = i.sources.map(function (e) {
                                    return "/*# sourceURL=" + i.sourceRoot + e + " */"
                                });
                            return [n].concat(a).concat([r]).join("\n")
                        }
                        var o;
                        return [n].join("\n")
                    }(t, e);
                    return t[2] ? "@media " + t[2] + "{" + n + "}" : n
                }).join("")
            }, t.i = function (e, n) {
                "string" == typeof e && (e = [[null, e, ""]]);
                for (var i = {}, r = 0; r < this.length; r++) {
                    var a = this[r][0];
                    "number" == typeof a && (i[a] = !0)
                }
                for (r = 0; r < e.length; r++) {
                    var o = e[r];
                    "number" == typeof o[0] && i[o[0]] || (n && !o[2] ? o[2] = n : n && (o[2] = "(" + o[2] + ") and (" + n + ")"), t.push(o))
                }
            }, t
        }
    }, function (e, t, n) {
        var i, r, a = {}, o = (i = function () {
            return window && document && document.all && !window.atob
        }, function () {
            return void 0 === r && (r = i.apply(this, arguments)), r
        }), s = function (e) {
            var t = {};
            return function (e) {
                if ("function" == typeof e) return e();
                if (void 0 === t[e]) {
                    var n = function (e) {
                        return document.querySelector(e)
                    }.call(this, e);
                    if (window.HTMLIFrameElement && n instanceof window.HTMLIFrameElement) try {
                        n = n.contentDocument.head
                    } catch (e) {
                        n = null
                    }
                    t[e] = n
                }
                return t[e]
            }
        }(), l = null, c = 0, d = [], u = n(5);

        function p(e, t) {
            for (var n = 0; n < e.length; n++) {
                var i = e[n], r = a[i.id];
                if (r) {
                    r.refs++;
                    for (var o = 0; o < r.parts.length; o++) r.parts[o](i.parts[o]);
                    for (; o < i.parts.length; o++) r.parts.push(b(i.parts[o], t))
                } else {
                    var s = [];
                    for (o = 0; o < i.parts.length; o++) s.push(b(i.parts[o], t));
                    a[i.id] = {id: i.id, refs: 1, parts: s}
                }
            }
        }

        function h(e, t) {
            for (var n = [], i = {}, r = 0; r < e.length; r++) {
                var a = e[r], o = t.base ? a[0] + t.base : a[0], s = {css: a[1], media: a[2], sourceMap: a[3]};
                i[o] ? i[o].parts.push(s) : n.push(i[o] = {id: o, parts: [s]})
            }
            return n
        }

        function g(e, t) {
            var n = s(e.insertInto);
            if (!n) throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
            var i = d[d.length - 1];
            if ("top" === e.insertAt) i ? i.nextSibling ? n.insertBefore(t, i.nextSibling) : n.appendChild(t) : n.insertBefore(t, n.firstChild), d.push(t); else if ("bottom" === e.insertAt) n.appendChild(t); else {
                if ("object" != typeof e.insertAt || !e.insertAt.before) throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");
                var r = s(e.insertInto + " " + e.insertAt.before);
                n.insertBefore(t, r)
            }
        }

        function f(e) {
            if (null === e.parentNode) return !1;
            e.parentNode.removeChild(e);
            var t = d.indexOf(e);
            t >= 0 && d.splice(t, 1)
        }

        function m(e) {
            var t = document.createElement("style");
            return void 0 === e.attrs.type && (e.attrs.type = "text/css"), v(t, e.attrs), g(e, t), t
        }

        function v(e, t) {
            Object.keys(t).forEach(function (n) {
                e.setAttribute(n, t[n])
            })
        }

        function b(e, t) {
            var n, i, r, a;
            if (t.transform && e.css) {
                if (!(a = t.transform(e.css))) return function () {
                };
                e.css = a
            }
            if (t.singleton) {
                var o = c++;
                n = l || (l = m(t)), i = x.bind(null, n, o, !1), r = x.bind(null, n, o, !0)
            } else e.sourceMap && "function" == typeof URL && "function" == typeof URL.createObjectURL && "function" == typeof URL.revokeObjectURL && "function" == typeof Blob && "function" == typeof btoa ? (n = function (e) {
                var t = document.createElement("link");
                return void 0 === e.attrs.type && (e.attrs.type = "text/css"), e.attrs.rel = "stylesheet", v(t, e.attrs), g(e, t), t
            }(t), i = function (e, t, n) {
                var i = n.css, r = n.sourceMap, a = void 0 === t.convertToAbsoluteUrls && r;
                (t.convertToAbsoluteUrls || a) && (i = u(i));
                r && (i += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(r)))) + " */");
                var o = new Blob([i], {type: "text/css"}), s = e.href;
                e.href = URL.createObjectURL(o), s && URL.revokeObjectURL(s)
            }.bind(null, n, t), r = function () {
                f(n), n.href && URL.revokeObjectURL(n.href)
            }) : (n = m(t), i = function (e, t) {
                var n = t.css, i = t.media;
                i && e.setAttribute("media", i);
                if (e.styleSheet) e.styleSheet.cssText = n; else {
                    for (; e.firstChild;) e.removeChild(e.firstChild);
                    e.appendChild(document.createTextNode(n))
                }
            }.bind(null, n), r = function () {
                f(n)
            });
            return i(e), function (t) {
                if (t) {
                    if (t.css === e.css && t.media === e.media && t.sourceMap === e.sourceMap) return;
                    i(e = t)
                } else r()
            }
        }

        e.exports = function (e, t) {
            if ("undefined" != typeof DEBUG && DEBUG && "object" != typeof document) throw new Error("The style-loader cannot be used in a non-browser environment");
            (t = t || {}).attrs = "object" == typeof t.attrs ? t.attrs : {}, t.singleton || "boolean" == typeof t.singleton || (t.singleton = o()), t.insertInto || (t.insertInto = "head"), t.insertAt || (t.insertAt = "bottom");
            var n = h(e, t);
            return p(n, t), function (e) {
                for (var i = [], r = 0; r < n.length; r++) {
                    var o = n[r];
                    (s = a[o.id]).refs--, i.push(s)
                }
                e && p(h(e, t), t);
                for (r = 0; r < i.length; r++) {
                    var s;
                    if (0 === (s = i[r]).refs) {
                        for (var l = 0; l < s.parts.length; l++) s.parts[l]();
                        delete a[s.id]
                    }
                }
            }
        };
        var w, y = (w = [], function (e, t) {
            return w[e] = t, w.filter(Boolean).join("\n")
        });

        function x(e, t, n, i) {
            var r = n ? "" : i.css;
            if (e.styleSheet) e.styleSheet.cssText = y(t, r); else {
                var a = document.createTextNode(r), o = e.childNodes;
                o[t] && e.removeChild(o[t]), o.length ? e.insertBefore(a, o[t]) : e.appendChild(a)
            }
        }
    }, function (e, t) {
        e.exports = function (e) {
            var t = "undefined" != typeof window && window.location;
            if (!t) throw new Error("fixUrls requires window.location");
            if (!e || "string" != typeof e) return e;
            var n = t.protocol + "//" + t.host, i = n + t.pathname.replace(/\/[^\/]*$/, "/");
            return e.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function (e, t) {
                var r, a = t.trim().replace(/^"(.*)"$/, function (e, t) {
                    return t
                }).replace(/^'(.*)'$/, function (e, t) {
                    return t
                });
                return /^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(a) ? e : (r = 0 === a.indexOf("//") ? a : 0 === a.indexOf("/") ? n + a : i + a.replace(/^\.\//, ""), "url(" + JSON.stringify(r) + ")")
            })
        }
    }])
});
