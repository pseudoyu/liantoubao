(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{"319":function(t,e,n){},"351":function(t,e,n){"use strict";n.r(e);var o=n(1),r=n(2),i=n(322),a=n(324),u=n(156),c=n(326),l=(n(75),n(81)),s=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])}return t},f=function(){function defineProperties(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(t,e,n){return e&&defineProperties(t.prototype,e),n&&defineProperties(t,n),t}}();var p=function(t){function RichText(){return function _classCallCheck(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,RichText),function _possibleConstructorReturn(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}(this,(RichText.__proto__||Object.getPrototypeOf(RichText)).apply(this,arguments))}return function _inherits(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{"constructor":{"value":t,"enumerable":!1,"writable":!0,"configurable":!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}(RichText,o["l"].Component),f(RichText,[{"key":"renderNodes","value":function renderNodes(t){if("text"===t.type)return o.l.createElement("span",{},t.text);var e=this.renderChildrens(t.children),n={"className":"","style":""};if(t.hasOwnProperty("attrs"))for(var r in t.attrs)"class"===r?n.className=t.attrs[r]||"":n[r]=t.attrs[r]||"";return o.l.createElement(t.name,n,e)}},{"key":"renderChildrens","value":function renderChildrens(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[];if(0!==e.length)return e.map(function(e,n){return"text"===e.type?e.text:t.renderNodes(e)})}},{"key":"render","value":function render(){var t=this,e=this.props,n=e.nodes,r=e.className,i=function _objectWithoutProperties(t,e){var n={};for(var o in t)e.indexOf(o)>=0||Object.prototype.hasOwnProperty.call(t,o)&&(n[o]=t[o]);return n}(e,["nodes","className"]);return Array.isArray(n)?o.l.createElement("div",s({"className":r},Object(l.a)(this.props,["nodes","className"]),i),n.map(function(e,n){return t.renderNodes(e)})):o.l.createElement("div",s({"className":r},Object(l.a)(this.props,["className"]),i,{"dangerouslySetInnerHTML":{"__html":n}}))}}]),RichText}(),d=n(155),b=n(55);n(319);n.d(e,"default",function(){return h});var m=function(){function defineProperties(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(t,e,n){return e&&defineProperties(t.prototype,e),n&&defineProperties(t,n),t}}(),y=function get(t,e,n){null===t&&(t=Function.prototype);var o=Object.getOwnPropertyDescriptor(t,e);if(void 0===o){var r=Object.getPrototypeOf(t);return null===r?void 0:get(r,e,n)}if("value"in o)return o.value;var i=o.get;return void 0!==i?i.call(n):void 0};function about_possibleConstructorReturn(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}var h=function(t){function About(){var t,e,n;!function about_classCallCheck(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,About);for(var o=arguments.length,r=Array(o),i=0;i<o;i++)r[i]=arguments[i];return e=n=about_possibleConstructorReturn(this,(t=About.__proto__||Object.getPrototypeOf(About)).call.apply(t,[this].concat(r))),n.config={"navigationBarTitleText":"关于我们"},n.state={"banner":"","title":"关于介绍","context":""},about_possibleConstructorReturn(n,e)}return function about_inherits(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{"constructor":{"value":t,"enumerable":!1,"writable":!0,"configurable":!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}(About,r["default"].Component),m(About,[{"key":"componentWillMount","value":function componentWillMount(){var t=this;r.default.$http.get("/system/about").then(function(e){t.setState(e.data)}).catch(function(t){console.log(t)})}},{"key":"render","value":function render(){var t=r.default.$store.getState().session.token?"/pages/member/index":"/pages/member/login",e=this.state,n=e.banner,l=e.title,s=e.context;return o.l.createElement(i.a,{"className":"about"},n&&o.l.createElement(a.a,{"className":"about-items about-img","src":n}),o.l.createElement(i.a,{"className":"about-items about-title"},o.l.createElement(i.a,{"className":"about-title-fab","hoverClass":"about-title-fab-hover","onClick":b.g.bind(this,t)},o.l.createElement(d.a,{"value":"chevron-left","size":"24","color":"#9C9C9C"})),o.l.createElement(i.a,{"className":"about-title-content"},o.l.createElement(u.a,null,l))),o.l.createElement(i.a,{"className":"about-contents jxh-mt-20"},o.l.createElement(c.a,{"scrollY":!0,"className":"about-contents-scroll"},o.l.createElement(p,{"nodes":s}))))}},{"key":"componentDidMount","value":function componentDidMount(){y(About.prototype.__proto__||Object.getPrototypeOf(About.prototype),"componentDidMount",this)&&y(About.prototype.__proto__||Object.getPrototypeOf(About.prototype),"componentDidMount",this).call(this)}},{"key":"componentDidShow","value":function componentDidShow(){y(About.prototype.__proto__||Object.getPrototypeOf(About.prototype),"componentDidShow",this)&&y(About.prototype.__proto__||Object.getPrototypeOf(About.prototype),"componentDidShow",this).call(this)}},{"key":"componentDidHide","value":function componentDidHide(){y(About.prototype.__proto__||Object.getPrototypeOf(About.prototype),"componentDidHide",this)&&y(About.prototype.__proto__||Object.getPrototypeOf(About.prototype),"componentDidHide",this).call(this)}}]),About}()},"55":function(t,e,n){"use strict";n.d(e,"g",function(){return go}),n.d(e,"b",function(){return delayQuerySelector}),n.d(e,"j",function(){return uuid}),n.d(e,"h",function(){return isTest}),n.d(e,"f",function(){return formatPrice}),n.d(e,"e",function(){return formatNumber}),n.d(e,"d",function(){return filterZero}),n.d(e,"i",function(){return timeToString}),n.d(e,"a",function(){return calcDay}),n.d(e,"c",function(){return digit});var o=n(2),r=n(18),i=n(77),a=n.n(i),u=o.default.getEnv();function go(t,e){var n="";for(var r in e=e||{})n+="&"+r+"="+encodeURIComponent(e[r]);""!==n&&(t+="?"+n.substr(1)),o.default.redirectTo({"url":t})}function delayQuerySelector(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:500,i=u===o.default.ENV_TYPE.WEB?t:t.$scope,a=Object(r.a)().in(i);return new Promise(function(t){(function delay(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:500;return new Promise(function(e){[o.default.ENV_TYPE.WEB,o.default.ENV_TYPE.SWAN].includes(u)?setTimeout(function(){e()},t):e()})})(n).then(function(){a.select(e).boundingClientRect().exec(function(e){t(e)})})})}function uuid(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:8,e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:16,n="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""),o=[],r=0;if(e=e||n.length,t)for(r=0;r<t;r++)o[r]=n[0|Math.random()*e];else{var i=void 0;for(o[8]=o[13]=o[18]=o[23]="-",o[14]="4",r=0;r<36;r++)o[r]||(i=0|16*Math.random(),o[r]=n[19===r?3&i|8:i])}return o.join("")}function isTest(){return!1}function befNumber(t){var e={"num":t,"unit":""};return t>=1e8?(e.num=t/1e8,e.unit="亿"):t>=1e4&&(e.num=t/1e4,e.unit="万"),e}function formatPrice(t,e){return t=e?{"num":t,"unit":""}:befNumber(t),a.a.formatMoney(t.num,"",2)+t.unit}function formatNumber(t,e,n){t=n?{"num":t,"unit":""}:befNumber(t),e=0===e||e?e:3;var o=Math.pow(10,e);return t.num=Math.floor(t.num*o)/o,t.num=a.a.formatNumber(t.num,e),filterZero(t.num)+t.unit}function filterZero(t){return/\.\d*0$/.test(t="string"!=typeof t?t+"":t)&&"."===(t=t.replace(/0*$/,"")).substr(-1)&&(t=t.substr(0,t.length-1)),t}function digit(t,e){var n="";t=String(t),e=e||2;for(var o=t.length;o<e;o++)n+="0";return t<Math.pow(10,e)?n+(0|t):t}function timeToString(t,e){var n=new Date(t||new Date),o=[digit(n.getFullYear(),4),digit(n.getMonth()+1),digit(n.getDate())],r=[digit(n.getHours()),digit(n.getMinutes()),digit(n.getSeconds())];return(e=e||"yyyy-MM-dd HH:mm:ss").replace(/yyyy/g,o[0]).replace(/MM/g,o[1]).replace(/dd/g,o[2]).replace(/HH/g,r[0]).replace(/mm/g,r[1]).replace(/ss/g,r[2])}function calcDay(t,e){var n=timeToString(!1,"yyyy-MM-dd");return t=Date.parse(t?timeToString(t,"yyyy-MM-dd"):n),((e=Date.parse(e?timeToString(e,"yyyy-MM-dd"):n))-t)/864e5}}}]);