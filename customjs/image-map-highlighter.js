(function webpackUniversalModuleDefinition(root, factory) {
    if (typeof exports === 'object' && typeof module === 'object')
        module.exports = factory();
    else if (typeof define === 'function' && define.amd)
        define([], factory);
    else if (typeof exports === 'object')
        exports["ImageMapHighlighter"] = factory();
    else
        root["ImageMapHighlighter"] = factory();
})(this, function() {
    return (function(modules) {
            var installedModules = {};


            function __webpack_require__(moduleId) {
                if (installedModules[moduleId])
                    return installedModules[moduleId].exports;
                var module = installedModules[moduleId] = { exports: {}, id: moduleId, loaded: false };
                modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
                module.loaded = true;
                return module.exports;
            }
            __webpack_require__.m = modules;
            __webpack_require__.c = installedModules;
            __webpack_require__.p = "";
            return __webpack_require__(0);
        })
        ([function(module, exports) {
            'use strict';
            var _createClass = function() {
                function defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }
                return function(Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; };
            }();

            function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
            var ImageMapHighlighter = function() {
                function ImageMapHighlighter(element) {
                    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
                    _classCallCheck(this, ImageMapHighlighter);
                    this.element = element;
                    this.options = Object.assign({}, this._getDefaultOptions(), options);
                }
                _createClass(ImageMapHighlighter, [{
                        key: 'init',
                        value: function init() {
                            var selectedArea = false;
                            var _this = this;
                            var map = this._getAssociatedMap(this.element);
                            var canvas = this._createCanvasFor(this.element);
                            var container = this._createContainerFor(this.element);
                            this.element.parentNode.insertBefore(container, this.element);
                            container.appendChild(this.element);
                            container.insertBefore(canvas, this.element);
                            if (this.options.alwaysOn) {

                            } else {

                                //Added to highlight the selected are
                                for (var i = 0; i < map.areas.length; i++) {
                                    var area = map.areas[i];
                                    // var projectName = localStorage.getItem("panelName");
                                    //if (area.id == projectName) {

                                    //CollapsePanelInfo(projectName);

                                    //}
                                }

                                map.addEventListener('mouseover', function(event) {
                                    if (selectedArea === false) {
                                        _this._clearHighlights(canvas);
                                        _this._drawHighlightByArea(canvas, event.target);
                                    }
                                });
                                map.addEventListener('mouseout', function(event) { if (selectedArea === false) { _this._clearHighlights(canvas); } });
                                map.addEventListener('click', function(event) {
                                    selectedArea = true;
                                    _this._clearHighlights(canvas);
                                    _this._drawHighlightByArea(canvas, event.target);
                                });
                            }
                        }
                    },
                    {
                        key: '_getDefaultOptions',
                        value: function _getDefaultOptions() { return { fill: true, fillColor: '000000', fillOpacity: 0.2, stroke: true, strokeColor: 'ff0000', strokeOpacity: 1, strokeWidth: 1, alwaysOn: false }; }
                    },
                    {
                        key: '_createContainerFor',
                        value: function _createContainerFor(element) {
                            var container = document.createElement('div');
                            container.classList.add('map-container');
                            container.style.backgroundImage = 'url(' + element.src + ')';
                            container.style.height = element.height + 'px';
                            container.style.width = element.width + 'px';
                            return container;
                        }
                    },
                    {
                        key: '_createCanvasFor',
                        value: function _createCanvasFor(element) {
                            var canvas = document.createElement('canvas');
                            canvas.height = element.height;
                            canvas.width = element.width;
                            return canvas;
                        }
                    },
                    {
                        key: '_getAssociatedMap',
                        value: function _getAssociatedMap(element) {
                            if (!element.useMap) { throw new Error('The "useMap" attribute for this image element has not been set.'); }
                            var map = document.querySelector('map[name=' + element.useMap.substr(1) + ']');
                            if (map === null) { throw new Error('The requested map "' + element.useMap + '" could not be found.'); }
                            return map;
                        }
                    },
                    {
                        key: '_clearHighlights',
                        value: function _clearHighlights(canvas) {
                            var context = canvas.getContext('2d');
                            context.clearRect(0, 0, canvas.width, canvas.height);
                        }
                    },
                    {
                        key: '_drawHighlightByArea',
                        value: function _drawHighlightByArea(canvas, area) {
                            var coords = area.coords.split(',').map(function(coord) { return parseInt(coord); });
                            var shape = area.shape;
                            this._drawHighlight(canvas, shape, coords);
                        }
                    },
                    {
                        key: '_drawHighlight',
                        value: function _drawHighlight(canvas, shape, coords) {
                            var context = canvas.getContext('2d');
                            context.beginPath();
                            switch (shape) {
                                case 'circle':
                                    context.arc(coords[0], coords[1], coords[2], 0, Math.PI * 2, false);
                                    break;
                                case 'poly':
                                    context.moveTo(coords[0], coords[1]);
                                    for (var i = 2; i < coords.length; i += 2) { context.lineTo(coords[i], coords[i + 1]); }
                                    break;
                                case 'rect':
                                    context.rect(coords[0], coords[1], coords[2] - coords[0], coords[3] - coords[1]);
                                    break;
                                default:
                            }
                            context.closePath();
                            if (this.options.fill) {
                                context.fillStyle = this.css3Colour(this.options.fillColor, this.options.fillOpacity);
                                context.fill();
                            }
                            if (this.options.stroke) {
                                context.strokeStyle = this.css3Colour(this.options.strokeColor, this.options.strokeOpacity);
                                context.lineWidth = this.options.strokeWidth;
                            }
                            context.stroke();
                        }
                    },
                    { key: 'hexToDecimal', value: function hexToDecimal(hex) { return Math.max(0, Math.min(parseInt(hex, 16), 255)); } }, { key: 'css3Colour', value: function css3Colour(colour, opacity) { var r = +this.hexToDecimal(colour.substr(0, 2)); var g = +this.hexToDecimal(colour.substr(2, 2)); var b = +this.hexToDecimal(colour.substr(4, 2)); return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + opacity + ')'; } }
                ]);
                return ImageMapHighlighter;
            }();
            module.exports = ImageMapHighlighter;
        }])
});;