(window.webpackJsonp=window.webpackJsonp||[]).push([[21],{"104":function(e,t,n){"use strict";var o=n(1),r=n(2),a=n(333),i=n(71),s=(n(62),function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}());var l=function(e){function Form(){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Form);var e=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Form.__proto__||Object.getPrototypeOf(Form)).apply(this,arguments));return e.Forms=[],e.onSubmit=e.onSubmit.bind(e),e.onReset=e.onReset.bind(e),e}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Form,o["l"].Component),s(Form,[{"key":"onSubmit","value":function onSubmit(e){e.preventDefault();for(var t=o.l.findDOMNode(this),n=[],r=t.getElementsByTagName("input"),a=0;a<r.length;a++)n.push(r[a]);var i={},s={};n.forEach(function(e){-1===e.className.indexOf("weui-switch")?"radio"!==e.type?"checkbox"!==e.type?i[e.name]=e.value:e.checked?s[e.name]?i[e.name].push(e.value):(s[e.name]=!0,i[e.name]=[e.value]):s[e.name]||(i[e.name]=[]):e.checked?(s[e.name]=!0,i[e.name]=e.value):s[e.name]||(i[e.name]=""):i[e.name]=e.checked});for(var l=t.getElementsByTagName("textarea"),c=[],u=0;u<l.length;u++)c.push(l[u]);c.forEach(function(e){i[e.name]=e.value}),Object.defineProperty(e,"detail",{"enumerable":!0,"value":{"value":i}}),this.props.onSubmit(e)}},{"key":"onReset","value":function onReset(e){e.preventDefault(),this.props.onReset()}},{"key":"render","value":function render(){var e=this.props,t=e.className,n=e.style;return o.l.createElement("form",{"className":t,"style":n,"onSubmit":this.onSubmit,"onReset":this.onReset},this.props.children)}}]),Form}(),c=n(57),u=n.n(c),p=n(55),f=n.n(p),m=n(56),d=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var h=function(e){function AtLoading(){return function loading_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtLoading),function loading_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtLoading.__proto__||Object.getPrototypeOf(AtLoading)).apply(this,arguments))}return function loading_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtLoading,m["a"]),d(AtLoading,[{"key":"render","value":function render(){var e=this.props,t=e.color,n=e.size,i={"width":n?""+r.default.pxTransform(parseInt(n)):"","height":n?""+r.default.pxTransform(parseInt(n)):""},s={"border":t?"1px solid "+t:"","border-color":t?t+" transparent transparent transparent":""},l=Object.assign({},s,i);return o.l.createElement(a.a,{"className":"at-loading","style":i},o.l.createElement(a.a,{"className":"at-loading__ring","style":l}),o.l.createElement(a.a,{"className":"at-loading__ring","style":l}),o.l.createElement(a.a,{"className":"at-loading__ring","style":l}))}}]),AtLoading}();h.defaultProps={"size":0,"color":""},h.propTypes={"size":u.a.oneOfType([u.a.string,u.a.number]),"color":u.a.oneOfType([u.a.string,u.a.number])},n.d(t,"a",function(){return _});var b=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{"value":n,"enumerable":!0,"configurable":!0,"writable":!0}):e[t]=n,e}var y={"normal":"normal","small":"small"},g={"primary":"primary","secondary":"secondary"},_=function(e){function AtButton(){!function button_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtButton);var e=function button_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtButton.__proto__||Object.getPrototypeOf(AtButton)).apply(this,arguments));return e.state={"isWEB":r.default.getEnv()===r.default.ENV_TYPE.WEB,"isWEAPP":r.default.getEnv()===r.default.ENV_TYPE.WEAPP,"isALIPAY":r.default.getEnv()===r.default.ENV_TYPE.ALIPAY},e}return function button_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtButton,m["a"]),b(AtButton,[{"key":"onClick","value":function onClick(){var e;this.props.disabled||this.props.onClick&&(e=this.props).onClick.apply(e,arguments)}},{"key":"onGetUserInfo","value":function onGetUserInfo(){var e;this.props.onGetUserInfo&&(e=this.props).onGetUserInfo.apply(e,arguments)}},{"key":"onContact","value":function onContact(){var e;this.props.onContact&&(e=this.props).onContact.apply(e,arguments)}},{"key":"onGetPhoneNumber","value":function onGetPhoneNumber(){var e;this.props.onGetPhoneNumber&&(e=this.props).onGetPhoneNumber.apply(e,arguments)}},{"key":"onError","value":function onError(){var e;this.props.onError&&(e=this.props).onError.apply(e,arguments)}},{"key":"onOpenSetting","value":function onOpenSetting(){var e;this.props.onOpenSetting&&(e=this.props).onOpenSetting.apply(e,arguments)}},{"key":"onSumit","value":function onSumit(){(this.state.isWEAPP||this.state.isWEB)&&this.$scope.triggerEvent("submit",arguments[0].detail,{"bubbles":!0,"composed":!0})}},{"key":"onReset","value":function onReset(){(this.state.isWEAPP||this.state.isWEB)&&this.$scope.triggerEvent("reset",arguments[0].detail,{"bubbles":!0,"composed":!0})}},{"key":"render","value":function render(){var e,t=this.props,n=t.size,r=void 0===n?"normal":n,s=t.type,c=void 0===s?"":s,u=t.circle,p=t.full,m=t.loading,d=t.disabled,b=t.customStyle,_=t.formType,v=t.openType,E=t.lang,w=t.sessionFrom,P=t.sendMessageTitle,O=t.sendMessagePath,j=t.sendMessageImg,C=t.showMessageCard,N=t.appParameter,k=this.state,T=k.isWEAPP,S=k.isALIPAY,x=k.isWEB,I=["at-button"],A=(_defineProperty(e={},"at-button--"+y[r],y[r]),_defineProperty(e,"at-button--disabled",d),_defineProperty(e,"at-button--"+c,g[c]),_defineProperty(e,"at-button--circle",u),_defineProperty(e,"at-button--full",p),e),D="primary"===c?"#fff":"",F="small"===r?"30":0,M=void 0;m&&(M=o.l.createElement(a.a,{"className":"at-button__icon"},o.l.createElement(h,{"color":D,"size":F})),I.push("at-button--icon"));var R=o.l.createElement(i.a,{"className":"at-button__wxbutton","lang":E,"type":"submit"===_||"reset"===_?_:"button"}),B=o.l.createElement(i.a,{"className":"at-button__wxbutton","formType":_,"openType":v,"lang":E,"sessionFrom":w,"sendMessageTitle":P,"sendMessagePath":O,"sendMessageImg":j,"showMessageCard":C,"appParameter":N,"onGetUserInfo":this.onGetUserInfo.bind(this),"onGetPhoneNumber":this.onGetPhoneNumber.bind(this),"onOpenSetting":this.onOpenSetting.bind(this),"onError":this.onError.bind(this),"onContact":this.onContact.bind(this)});return o.l.createElement(a.a,{"className":f()(I,A,this.props.className),"style":b,"onClick":this.onClick.bind(this)},x&&!d&&R,T&&!d&&o.l.createElement(l,{"reportSubmit":!0,"onSubmit":this.onSumit.bind(this),"onReset":this.onReset.bind(this)},B),S&&!d&&B,M,o.l.createElement(a.a,{"className":"at-button__text"},this.props.children))}}]),AtButton}();_.defaultProps={"size":"normal","type":"","circle":!1,"full":!1,"loading":!1,"disabled":!1,"customStyle":{},"onClick":function onClick(){},"formType":"","openType":"","lang":"en","sessionFrom":"","sendMessageTitle":"","sendMessagePath":"","sendMessageImg":"","showMessageCard":!1,"appParameter":"","onGetUserInfo":function onGetUserInfo(){},"onContact":function onContact(){},"onGetPhoneNumber":function onGetPhoneNumber(){},"onError":function onError(){},"onOpenSetting":function onOpenSetting(){}},_.propTypes={"size":u.a.oneOf(["normal","small"]),"type":u.a.oneOf(["primary","secondary",""]),"circle":u.a.bool,"full":u.a.bool,"loading":u.a.bool,"disabled":u.a.bool,"onClick":u.a.func,"customStyle":u.a.oneOfType([u.a.object,u.a.string]),"formType":u.a.oneOf(["submit","reset",""]),"openType":u.a.oneOf(["contact","share","getUserInfo","getPhoneNumber","launchApp","openSetting","feedback","getRealnameAuthInfo",""]),"lang":u.a.string,"sessionFrom":u.a.string,"sendMessageTitle":u.a.string,"sendMessagePath":u.a.string,"sendMessageImg":u.a.string,"showMessageCard":u.a.bool,"appParameter":u.a.string,"onGetUserInfo":u.a.func,"onContact":u.a.func,"onGetPhoneNumber":u.a.func,"onError":u.a.func,"onOpenSetting":u.a.func}},"139":function(e,t,n){"use strict";var o,r,a,i=n(1),s=n(2),l=n(333),c=n(335),u=n(16),p=n(55),f=n.n(p),m=n(61),d=(n(140),function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}());function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}t.a=Object(u.b)(function(e){return{"coins":e.coins,"status":e.status}})((a=r=function(e){function Info(){var e,t,n;!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Info);for(var o=arguments.length,r=Array(o),a=0;a<o;a++)r[a]=arguments[a];return t=n=_possibleConstructorReturn(this,(e=Info.__proto__||Object.getPrototypeOf(Info)).call.apply(e,[this].concat(r))),n.state={},_possibleConstructorReturn(n,t)}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Info,s["default"].Component),d(Info,[{"key":"componentWillMount","value":function componentWillMount(){var e=this;this.props.coinId&&s.default.$http.get("/trades/single_coin_info",{"coin_id":this.props.coinId}).then(function(t){e.setState(t.data),e.props.onFetch&&e.props.onFetch(t.data)}).catch(function(e){console.log(e)})}},{"key":"render","value":function render(){var e=this.state,t=this.props.coins[this.props.coinId]||{"icon":"","code":"","title":""},n=Object(m.d)(parseFloat(100*e.income_rate).toFixed(2)),o=this.props.status.money.symbol,r=f()("coin-info-row-item-value",e.having_income>0?"coin-info-up":e.having_income<0?"coin-info-down":"");return i.l.createElement(l.a,{"className":"jxh-mt-40"},i.l.createElement(l.a,{"className":"coin-info-dashboard"},i.l.createElement(l.a,{"className":"coin-info-dashboard-info"},i.l.createElement(l.a,null,i.l.createElement(l.a,{"className":"coin-info-dashboard-icon"},i.l.createElement(c.a,{"className":"coin-info-dashboard-img","src":t.icon||""})),i.l.createElement(l.a,{"className":"coin-info-dashboard-code"},t.code))),i.l.createElement(l.a,{"className":"coin-info-dashboard-value"},i.l.createElement(l.a,{"className":"coin-info-dashboard-content"},i.l.createElement(l.a,{"className":"coin-info-dashboard-content-title"},"币种总价值"),i.l.createElement(l.a,{"className":"coin-info-dashboard-content-value"},o," ",Object(m.f)(e.price))))),i.l.createElement(l.a,{"className":"coin-info-card jxh-mt-20"},i.l.createElement(l.a,{"className":"coin-info-row"},i.l.createElement(l.a,{"className":"coin-info-row-item"},i.l.createElement(l.a,{"className":"coin-info-row-item-title"},"当前交易价"),i.l.createElement(l.a,{"className":"coin-info-row-item-value"},o," ",Object(m.f)(e.coin_price))),i.l.createElement(l.a,{"className":"coin-info-row-item"},i.l.createElement(l.a,{"className":"coin-info-row-item-title"},"持有收益"),i.l.createElement(l.a,{"className":r},o," ",Object(m.f)(e.having_income))),i.l.createElement(l.a,{"className":"coin-info-row-item"},i.l.createElement(l.a,{"className":"coin-info-row-item-title"},"收益率"),i.l.createElement(l.a,{"className":r},n,"%"))),i.l.createElement(l.a,{"className":"coin-info-row jxh-mt-30"},i.l.createElement(l.a,{"className":"coin-info-row-item"},i.l.createElement(l.a,{"className":"coin-info-row-item-title"},"持有数量"),i.l.createElement(l.a,{"className":"coin-info-row-item-value"},Object(m.e)(e.nums))),i.l.createElement(l.a,{"className":"coin-info-row-item"},i.l.createElement(l.a,{"className":"coin-info-row-item-title"},"总投入成本"),i.l.createElement(l.a,{"className":"coin-info-row-item-value"},o," ",Object(m.f)(e.costs))),i.l.createElement(l.a,{"className":"coin-info-row-item"},i.l.createElement(l.a,{"className":"coin-info-row-item-title"},"平均单币投入"),i.l.createElement(l.a,{"className":"coin-info-row-item-value"},o," ",Object(m.f)(e.costs/e.buy_number))))))}}]),Info}(),r.defaultProps={"id":1},o=a))||o},"140":function(e,t,n){},"314":function(e,t,n){},"340":function(e,t,n){"use strict";n.r(t),n.d(t,"default",function(){return m});var o=n(1),r=n(2),a=n(63),i=n(333),s=n(64),l=n(139),c=n(104),u=n(61),p=(n(314),function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}()),f=function get(e,t,n){null===e&&(e=Function.prototype);var o=Object.getOwnPropertyDescriptor(e,t);if(void 0===o){var r=Object.getPrototypeOf(e);return null===r?void 0:get(r,t,n)}if("value"in o)return o.value;var a=o.get;return void 0!==a?a.call(n):void 0};function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}var m=function(e){function Detail(){var e,t,n;!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Detail);for(var o=arguments.length,r=Array(o),a=0;a<o;a++)r[a]=arguments[a];return t=n=_possibleConstructorReturn(this,(e=Detail.__proto__||Object.getPrototypeOf(Detail)).call.apply(e,[this].concat(r))),n.config={"navigationBarTitleText":"单币种详情"},n.CoinId=n.$router.params.coin_id,n.state={"quotes":[],"buy":[],"sale":[]},_possibleConstructorReturn(n,t)}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Detail,a["a"]),p(Detail,[{"key":"componentWillMount","value":function componentWillMount(){var e=this;this.CoinId&&(r.default.$http.get("/ws/single_coin",{"coin_id":this.CoinId}).then(function(t){var n=t.data.map(function(e){return[Object(u.i)(1e3*e.timer,"yyyy-MM-dd HH:mm:ss"),e.unit_price]});e.setState({"quotes":n})}).catch(function(e){console.log(e)}),r.default.$http.get("/trades/coin_trade_list",{"coin_id":this.CoinId}).then(function(t){var n=[],o=[];t.data.map(function(e){var t=[Object(u.i)(1e3*e.create_time,"yyyy-MM-dd HH:mm:ss"),e.unit_price];1===e.act?n.push(t):o.push(t)}),e.setState({"buy":n,"sale":o})}).catch(function(e){console.log(e)}))}},{"key":"calcHeight","value":function calcHeight(e){var t=document.getElementsByTagName("html")[0].style.fontSize.match(/[\d\.]+/)[0];return r.default.pxTransform(e).match(/[\d\.]+/)[0]*t+"px"}},{"key":"render","value":function render(){return o.l.createElement(i.a,{"className":"jxh-app"},o.l.createElement(i.a,{"className":"jxh-container"},o.l.createElement(l.a,{"coinId":this.CoinId}),o.l.createElement(i.a,{"className":"jxh-hr jxh-mt-20 jxh-mb-20"}),o.l.createElement(i.a,null,o.l.createElement(s.c,{"coin_id":this.CoinId})),o.l.createElement(i.a,{"className":"jxh-hr jxh-mt-20"}),o.l.createElement(i.a,{"className":"wallet-coin-detail-actions"},o.l.createElement(i.a,{"className":"wallet-coin-detail-actions-item"},o.l.createElement(c.a,{"type":"secondary","className":"wallet-coin-detail-actions-button","onClick":u.g.bind(this,"/pages/quotation/detail",{"id":this.CoinId})},"货币详情")),o.l.createElement(i.a,{"className":"wallet-coin-detail-actions-item"},o.l.createElement(c.a,{"type":"secondary","className":"wallet-coin-detail-actions-button","onClick":u.g.bind(this,"/pages/wallet/trades/index",{"coin_id":this.CoinId})},"交易历史"))),o.l.createElement(i.a,null,o.l.createElement(c.a,{"type":"primary","onClick":u.g.bind(this,"/pages/wallet/coins/warn",{"coin_id":this.CoinId})},"设置预警"))),o.l.createElement(i.a,{"className":"jxh-bottom"}),o.l.createElement(s.e,{"to":"/pages/wallet/index"}),o.l.createElement(s.j,{"current":0}))}},{"key":"componentDidMount","value":function componentDidMount(){f(Detail.prototype.__proto__||Object.getPrototypeOf(Detail.prototype),"componentDidMount",this)&&f(Detail.prototype.__proto__||Object.getPrototypeOf(Detail.prototype),"componentDidMount",this).call(this)}},{"key":"componentDidShow","value":function componentDidShow(){f(Detail.prototype.__proto__||Object.getPrototypeOf(Detail.prototype),"componentDidShow",this)&&f(Detail.prototype.__proto__||Object.getPrototypeOf(Detail.prototype),"componentDidShow",this).call(this)}},{"key":"componentDidHide","value":function componentDidHide(){f(Detail.prototype.__proto__||Object.getPrototypeOf(Detail.prototype),"componentDidHide",this)&&f(Detail.prototype.__proto__||Object.getPrototypeOf(Detail.prototype),"componentDidHide",this).call(this)}}]),Detail}()},"59":function(e,t,n){var o=n(60);"string"==typeof o&&(o=[[e.i,o,""]]);var r={"sourceMap":!1,"insertAt":"top","hmr":!0,"transform":void 0,"insertInto":void 0};n(66)(o,r);o.locals&&(e.exports=o.locals)},"60":function(e,t,n){(e.exports=n(65)(!1)).push([e.i,"button {\n  position: relative;\n  display: block;\n  width: 100%;\n  margin-left: auto;\n  margin-right: auto;\n  padding-left: 14px;\n  padding-right: 14px;\n  box-sizing: border-box;\n  font-size: 18px;\n  text-align: center;\n  text-decoration: none;\n  line-height: 2.55555556;\n  border-radius: 5px;\n  -webkit-tap-highlight-color: transparent;\n  overflow: hidden;\n  color: #000000;\n  background-color: #F8F8F8;\n}\n\nbutton[plain] {\n  color: #353535;\n  border: 1px solid #353535;\n  background-color: transparent;\n}\n\nbutton[plain][disabled] {\n  color: rgba(0, 0, 0, 0.3);\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  background-color: #F7F7F7;\n}\n\nbutton[type=primary] {\n  color: #FFFFFF;\n  background-color: #1AAD19;\n}\n\nbutton[type=primary][plain] {\n  color: #1aad19;\n  border: 1px solid #1aad19;\n  background-color: transparent;\n}\n\nbutton[type=primary][plain][disabled] {\n  color: rgba(0, 0, 0, 0.3);\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  background-color: #F7F7F7;\n}",""])},"63":function(e,t,n){"use strict";n.d(t,"a",function(){return a});var o=n(2),r=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var a=function(e){function Auth(){return function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Auth),function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Auth.__proto__||Object.getPrototypeOf(Auth)).apply(this,arguments))}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Auth,o["default"].Component),r(Auth,[{"key":"componentWillMount","value":function componentWillMount(){var e=o.default.$store.getState().session.token;""!==e&&e||o.default.redirectTo({"url":"/pages/member/login"})}}]),Auth}()},"71":function(e,t,n){"use strict";n(62);var o=n(1),r=n(67),a=n(55),i=n.n(a),s=(n(59),Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e}),l=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{"value":n,"enumerable":!0,"configurable":!0,"writable":!0}):e[t]=n,e}var c=function(e){function Button(){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Button);var e=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Button.__proto__||Object.getPrototypeOf(Button)).apply(this,arguments));return e.state={"hover":!1,"touch":!1},e}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Button,o["l"].Component),l(Button,[{"key":"render","value":function render(){var e,t=this,n=this.props,a=n.children,l=n.disabled,c=n.className,u=n.style,p=n.onClick,f=n.onTouchStart,m=n.onTouchEnd,d=n.hoverClass,h=void 0===d?"button-hover":d,b=n.hoverStartTime,y=void 0===b?20:b,g=n.hoverStayTime,_=void 0===g?70:g,v=n.size,E=n.plain,w=n.loading,P=void 0!==w&&w,O=n.type,j=void 0===O?"default":O,C=c||i()("weui-btn",(_defineProperty(e={},""+h,this.state.hover&&!l),_defineProperty(e,"weui-btn_plain-"+j,E),_defineProperty(e,"weui-btn_"+j,!E&&j),_defineProperty(e,"weui-btn_mini","mini"===v),_defineProperty(e,"weui-btn_loading",P),_defineProperty(e,"weui-btn_disabled",l),e));return o.l.createElement("button",s({},Object(r.a)(this.props,["hoverClass","onTouchStart","onTouchEnd"]),{"className":C,"style":u,"onClick":p,"disabled":l,"onTouchStart":function _onTouchStart(e){t.setState(function(){return{"touch":!0}}),h&&!l&&setTimeout(function(){t.state.touch&&t.setState(function(){return{"hover":!0}})},y),f&&f(e)},"onTouchEnd":function _onTouchEnd(e){t.setState(function(){return{"touch":!1}}),h&&!l&&setTimeout(function(){t.state.touch||t.setState(function(){return{"hover":!1}})},_),m&&m(e)}}),P&&o.l.createElement("i",{"class":"weui-loading"}),a)}}]),Button}();t.a=c}}]);