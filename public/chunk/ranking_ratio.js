(window.webpackJsonp=window.webpackJsonp||[]).push([[20],{"175":function(e,t,n){"use strict";var o=n(1),r=n(2),a=n(333),i=n(210),l=n(71),c=n(57),s=n.n(c),p=n(55),u=n.n(p),f=n(68),d=n.n(f),h=n(56),m=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var b=function(e){function AtModalHeader(){return function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtModalHeader),function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtModalHeader.__proto__||Object.getPrototypeOf(AtModalHeader)).apply(this,arguments))}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtModalHeader,h["a"]),m(AtModalHeader,[{"key":"render","value":function render(){var e=u()("at-modal__header",this.props.className);return o.l.createElement(a.a,{"className":e},this.props.children)}}]),AtModalHeader}(),y=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var _=function(e){function AtModalAction(){return function action_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtModalAction),function action_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtModalAction.__proto__||Object.getPrototypeOf(AtModalAction)).apply(this,arguments))}return function action_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtModalAction,h["a"]),y(AtModalAction,[{"key":"render","value":function render(){var e=u()("at-modal__footer",{"at-modal__footer--simple":this.props.isSimple},this.props.className);return o.l.createElement(a.a,{"className":e},o.l.createElement(a.a,{"className":"at-modal__action"},this.props.children))}}]),AtModalAction}();_.defaultProps={"isSimple":!1},_.propTypes={"isSimple":s.a.bool};var v=n(337),g=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var O=function(e){function AtModalContent(){return function content_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtModalContent),function content_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtModalContent.__proto__||Object.getPrototypeOf(AtModalContent)).apply(this,arguments))}return function content_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtModalContent,h["a"]),g(AtModalContent,[{"key":"render","value":function render(){var e=u()("at-modal__content",this.props.className);return o.l.createElement(v.a,{"scrollY":!0,"className":e},this.props.children)}}]),AtModalContent}(),C=n(103);n.d(t,"a",function(){return E});var w=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var E=function(e){function AtModal(e){!function modal_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtModal);var t=function modal_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtModal.__proto__||Object.getPrototypeOf(AtModal)).apply(this,arguments));t.handleClickOverlay=function(){t.props.closeOnClickOverlay&&t.setState({"_isOpened":!1},t.handleClose)},t.handleClose=function(){d()(t.props.onClose)&&t.props.onClose()},t.handleCancel=function(){d()(t.props.onCancel)&&t.props.onCancel()},t.handleConfirm=function(){d()(t.props.onConfirm)&&t.props.onConfirm()},t.handleTouchMove=function(e){e.stopPropagation()};var n=e.isOpened;return t.state={"_isOpened":n,"isWEB":r.default.getEnv()===r.default.ENV_TYPE.WEB},t}return function modal_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtModal,h["a"]),w(AtModal,[{"key":"componentWillReceiveProps","value":function componentWillReceiveProps(e){var t=e.isOpened;this.props.isOpened!==t&&Object(C.a)(t),t!==this.state._isOpened&&this.setState({"_isOpened":t})}},{"key":"render","value":function render(){var e=this.state,t=e._isOpened,n=e.isWEB,r=this.props,c=r.title,s=r.content,p=r.cancelText,f=r.confirmText,d=u()("at-modal",{"at-modal--active":t},this.props.className);if(c||s){var h=p||f;return o.l.createElement(a.a,{"className":d},o.l.createElement(a.a,{"onClick":this.handleClickOverlay,"className":"at-modal__overlay"}),o.l.createElement(a.a,{"className":"at-modal__container"},c&&o.l.createElement(b,null,o.l.createElement(i.a,null,c)),s&&o.l.createElement(O,null,o.l.createElement(a.a,{"className":"content-simple"},n?o.l.createElement(i.a,{"dangerouslySetInnerHTML":{"__html":s.replace(/\n/g,"<br/>")}}):o.l.createElement(i.a,null,s))),h&&o.l.createElement(_,{"isSimple":!0},p&&o.l.createElement(l.a,{"onClick":this.handleCancel},p),f&&o.l.createElement(l.a,{"onClick":this.handleConfirm},f))))}return o.l.createElement(a.a,{"onTouchMove":this.handleTouchMove,"className":d},o.l.createElement(a.a,{"className":"at-modal__overlay","onClick":this.handleClickOverlay}),o.l.createElement(a.a,{"className":"at-modal__container"},this.props.children))}}]),AtModal}();E.defaultProps={"closeOnClickOverlay":!0},E.propTypes={"title":s.a.string,"isOpened":s.a.bool,"onCancel":s.a.func,"onConfirm":s.a.func,"onClose":s.a.func,"content":s.a.string,"closeOnClickOverlay":s.a.bool,"cancelText":s.a.string,"confirmText":s.a.string}},"354":function(e,t,n){"use strict";n.r(t);var o,r=n(1),a=n(2),i=n(333),l=n(210),c=n(337),s=n(209),p=n(175),u=n(105),f=n(16),d=n(64),h=n(61),m=(n(84),function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}()),b=function get(e,t,n){null===e&&(e=Function.prototype);var o=Object.getOwnPropertyDescriptor(e,t);if(void 0===o){var r=Object.getPrototypeOf(e);return null===r?void 0:get(r,t,n)}if("value"in o)return o.value;var a=o.get;return void 0!==a?a.call(n):void 0};function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}t.default=Object(f.b)(function(e){return{"coins":e.coins}})(o=function(e){function Ratio(){var e,t,n;!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Ratio);for(var o=arguments.length,r=Array(o),a=0;a<o;a++)r[a]=arguments[a];return t=n=_possibleConstructorReturn(this,(e=Ratio.__proto__||Object.getPrototypeOf(Ratio)).call.apply(e,[this].concat(r))),n.config={"navigationBarTitleText":"排行榜币种占比"},n.memberId=n.$router.params.id,n.state={"income":"0","coins":[],"chartColor":["#1890FF","#2FC25A","#FACC14","#F04766","#8543E1"],"incomeSize":50,"incomeText":20,"charHeight":0,"tips":!1,"errmsg":""},_possibleConstructorReturn(n,t)}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Ratio,a["default"].Component),m(Ratio,[{"key":"componentDidMount","value":function componentDidMount(){var e=this;a.default.$http.get("/trades/has_coin_percent",{"member_id":this.memberId}).then(function(t){var n=t.data.data.map(function(t){var n=e.props.coins[t.coin_id];return{"id":t.coin_id,"title":n.title||"","value":100*t.percent,"name":n.code||""}}),o=parseInt(100*t.data.rate);e.setState({"coins":n,"income":o})}).catch(function(t){e.setState({"errmsg":t.msg,"tips":!0})})}},{"key":"calcHeight","value":function calcHeight(){var e=document.getElementsByTagName("html")[0],t=e.style.fontSize.match(/[\d\.]+/)[0],n=a.default.pxTransform(60).match(/[\d\.]+/)[0]*t,o=a.default.pxTransform(40).match(/[\d\.]+/)[0]*t,r=e.clientHeight/100*55;return{"incomeSize":n,"incomeTop":r/2-n/1.5+"px","incomeText":o,"incomeTtop":r/2+o+"px","charHeight":r}}},{"key":"render","value":function render(){var e=this,t="/pages/ranking/detail?id="+this.memberId,n=this.calcHeight(),o=n.charHeight+"px",a=this.state.chartColor.length,f=this.state.coins.map(function(t,n){var o=e.state.chartColor[n<a?n:n%a],c="ratio-graphic-item"+(n%4==3?"":" ratio-graphic-item-mr");return r.l.createElement(i.a,{"className":c},r.l.createElement(i.a,{"className":"ratio-graphic-item-icon"},r.l.createElement(s.a,{"prefixClass":"jxh","value":"yuandian","size":"15","color":o})),r.l.createElement(i.a,{"className":"ratio-graphic-item-content"},r.l.createElement(l.a,{"className":"ratio-graphic-item-content-name"},"比特币",r.l.createElement("br",null)),r.l.createElement(l.a,{"className":"ratio-graphic-item-content-code"},t.name)))});return r.l.createElement(i.a,{"className":"jxh-app"},r.l.createElement(p.a,{"isOpened":this.state.tips,"title":"提醒","confirmText":"确认","onClose":h.g.bind(this,"/pages/ranking/follow"),"onConfirm":h.g.bind(this,"/pages/ranking/follow"),"content":this.state.errmsg}),r.l.createElement(i.a,{"className":"ratio-container"},r.l.createElement(u.a,{"height":o,"option":{"color":this.state.chartColor,"graphic":{"elements":[{"type":"text","left":"center","top":n.incomeTop,"style":{"text":this.state.income+"%","textAlign":"center","fill":"#82B1E1","fontSize":n.incomeSize}},{"type":"text","left":"center","top":n.incomeTtop,"style":{"text":"收益率","textAlign":"center","fill":"#767676","fontSize":n.incomeText}}]},"series":[{"name":"访问来源","type":"pie","radius":["35%","65%"],"x":"center","avoidLabelOverlap":!1,"label":{"normal":{"show":!0,"position":"outside","color":"#9C9C9C","formatter":"{b}\n{d}%"}},"data":this.state.coins}]}}),r.l.createElement(i.a,{"className":"jxh-hr"}),r.l.createElement(i.a,{"className":"ratio-graphic"},r.l.createElement(c.a,{"scrollY":!0,"className":"ratio-graphic-scroll"},f)),r.l.createElement(i.a,{"className":"jxh-bottom"})),r.l.createElement(d.e,{"to":t}),r.l.createElement(d.j,{"current":2}))}},{"key":"componentDidShow","value":function componentDidShow(){b(Ratio.prototype.__proto__||Object.getPrototypeOf(Ratio.prototype),"componentDidShow",this)&&b(Ratio.prototype.__proto__||Object.getPrototypeOf(Ratio.prototype),"componentDidShow",this).call(this)}},{"key":"componentDidHide","value":function componentDidHide(){b(Ratio.prototype.__proto__||Object.getPrototypeOf(Ratio.prototype),"componentDidHide",this)&&b(Ratio.prototype.__proto__||Object.getPrototypeOf(Ratio.prototype),"componentDidHide",this).call(this)}}]),Ratio}())||o},"59":function(e,t,n){var o=n(60);"string"==typeof o&&(o=[[e.i,o,""]]);var r={"sourceMap":!1,"insertAt":"top","hmr":!0,"transform":void 0,"insertInto":void 0};n(66)(o,r);o.locals&&(e.exports=o.locals)},"60":function(e,t,n){(e.exports=n(65)(!1)).push([e.i,"button {\n  position: relative;\n  display: block;\n  width: 100%;\n  margin-left: auto;\n  margin-right: auto;\n  padding-left: 14px;\n  padding-right: 14px;\n  box-sizing: border-box;\n  font-size: 18px;\n  text-align: center;\n  text-decoration: none;\n  line-height: 2.55555556;\n  border-radius: 5px;\n  -webkit-tap-highlight-color: transparent;\n  overflow: hidden;\n  color: #000000;\n  background-color: #F8F8F8;\n}\n\nbutton[plain] {\n  color: #353535;\n  border: 1px solid #353535;\n  background-color: transparent;\n}\n\nbutton[plain][disabled] {\n  color: rgba(0, 0, 0, 0.3);\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  background-color: #F7F7F7;\n}\n\nbutton[type=primary] {\n  color: #FFFFFF;\n  background-color: #1AAD19;\n}\n\nbutton[type=primary][plain] {\n  color: #1aad19;\n  border: 1px solid #1aad19;\n  background-color: transparent;\n}\n\nbutton[type=primary][plain][disabled] {\n  color: rgba(0, 0, 0, 0.3);\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  background-color: #F7F7F7;\n}",""])},"71":function(e,t,n){"use strict";n(62);var o=n(1),r=n(67),a=n(55),i=n.n(a),l=(n(59),Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e}),c=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{"value":n,"enumerable":!0,"configurable":!0,"writable":!0}):e[t]=n,e}var s=function(e){function Button(){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Button);var e=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Button.__proto__||Object.getPrototypeOf(Button)).apply(this,arguments));return e.state={"hover":!1,"touch":!1},e}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Button,o["l"].Component),c(Button,[{"key":"render","value":function render(){var e,t=this,n=this.props,a=n.children,c=n.disabled,s=n.className,p=n.style,u=n.onClick,f=n.onTouchStart,d=n.onTouchEnd,h=n.hoverClass,m=void 0===h?"button-hover":h,b=n.hoverStartTime,y=void 0===b?20:b,_=n.hoverStayTime,v=void 0===_?70:_,g=n.size,O=n.plain,C=n.loading,w=void 0!==C&&C,E=n.type,P=void 0===E?"default":E,j=s||i()("weui-btn",(_defineProperty(e={},""+m,this.state.hover&&!c),_defineProperty(e,"weui-btn_plain-"+P,O),_defineProperty(e,"weui-btn_"+P,!O&&P),_defineProperty(e,"weui-btn_mini","mini"===g),_defineProperty(e,"weui-btn_loading",w),_defineProperty(e,"weui-btn_disabled",c),e));return o.l.createElement("button",l({},Object(r.a)(this.props,["hoverClass","onTouchStart","onTouchEnd"]),{"className":j,"style":p,"onClick":u,"disabled":c,"onTouchStart":function _onTouchStart(e){t.setState(function(){return{"touch":!0}}),m&&!c&&setTimeout(function(){t.state.touch&&t.setState(function(){return{"hover":!0}})},y),f&&f(e)},"onTouchEnd":function _onTouchEnd(e){t.setState(function(){return{"touch":!1}}),m&&!c&&setTimeout(function(){t.state.touch||t.setState(function(){return{"hover":!1}})},v),d&&d(e)}}),w&&o.l.createElement("i",{"class":"weui-loading"}),a)}}]),Button}();t.a=s},"84":function(e,t,n){}}]);