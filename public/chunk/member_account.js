(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{"103":function(e,t,n){"use strict";var o=n(1),r=n(2),a=n(329),i=n(71),s=(n(60),function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}());var c=function(e){function Form(){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Form);var e=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Form.__proto__||Object.getPrototypeOf(Form)).apply(this,arguments));return e.Forms=[],e.onSubmit=e.onSubmit.bind(e),e.onReset=e.onReset.bind(e),e}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Form,o["l"].Component),s(Form,[{"key":"onSubmit","value":function onSubmit(e){e.preventDefault();for(var t=o.l.findDOMNode(this),n=[],r=t.getElementsByTagName("input"),a=0;a<r.length;a++)n.push(r[a]);var i={},s={};n.forEach(function(e){-1===e.className.indexOf("weui-switch")?"radio"!==e.type?"checkbox"!==e.type?i[e.name]=e.value:e.checked?s[e.name]?i[e.name].push(e.value):(s[e.name]=!0,i[e.name]=[e.value]):s[e.name]||(i[e.name]=[]):e.checked?(s[e.name]=!0,i[e.name]=e.value):s[e.name]||(i[e.name]=""):i[e.name]=e.checked});for(var c=t.getElementsByTagName("textarea"),u=[],l=0;l<c.length;l++)u.push(c[l]);u.forEach(function(e){i[e.name]=e.value}),Object.defineProperty(e,"detail",{"enumerable":!0,"value":{"value":i}}),this.props.onSubmit(e)}},{"key":"onReset","value":function onReset(e){e.preventDefault(),this.props.onReset()}},{"key":"render","value":function render(){var e=this.props,t=e.className,n=e.style;return o.l.createElement("form",{"className":t,"style":n,"onSubmit":this.onSubmit,"onReset":this.onReset},this.props.children)}}]),Form}(),u=n(57),l=n.n(u),p=n(55),f=n.n(p),h=n(56),d=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var b=function(e){function AtLoading(){return function loading_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtLoading),function loading_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtLoading.__proto__||Object.getPrototypeOf(AtLoading)).apply(this,arguments))}return function loading_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtLoading,h["a"]),d(AtLoading,[{"key":"render","value":function render(){var e=this.props,t=e.color,n=e.size,i={"width":n?""+r.default.pxTransform(parseInt(n)):"","height":n?""+r.default.pxTransform(parseInt(n)):""},s={"border":t?"1px solid "+t:"","border-color":t?t+" transparent transparent transparent":""},c=Object.assign({},s,i);return o.l.createElement(a.a,{"className":"at-loading","style":i},o.l.createElement(a.a,{"className":"at-loading__ring","style":c}),o.l.createElement(a.a,{"className":"at-loading__ring","style":c}),o.l.createElement(a.a,{"className":"at-loading__ring","style":c}))}}]),AtLoading}();b.defaultProps={"size":0,"color":""},b.propTypes={"size":l.a.oneOfType([l.a.string,l.a.number]),"color":l.a.oneOfType([l.a.string,l.a.number])},n.d(t,"a",function(){return v});var m=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{"value":n,"enumerable":!0,"configurable":!0,"writable":!0}):e[t]=n,e}var y={"normal":"normal","small":"small"},g={"primary":"primary","secondary":"secondary"},v=function(e){function AtButton(){!function button_classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtButton);var e=function button_possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtButton.__proto__||Object.getPrototypeOf(AtButton)).apply(this,arguments));return e.state={"isWEB":r.default.getEnv()===r.default.ENV_TYPE.WEB,"isWEAPP":r.default.getEnv()===r.default.ENV_TYPE.WEAPP,"isALIPAY":r.default.getEnv()===r.default.ENV_TYPE.ALIPAY},e}return function button_inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtButton,h["a"]),m(AtButton,[{"key":"onClick","value":function onClick(){var e;this.props.disabled||this.props.onClick&&(e=this.props).onClick.apply(e,arguments)}},{"key":"onGetUserInfo","value":function onGetUserInfo(){var e;this.props.onGetUserInfo&&(e=this.props).onGetUserInfo.apply(e,arguments)}},{"key":"onContact","value":function onContact(){var e;this.props.onContact&&(e=this.props).onContact.apply(e,arguments)}},{"key":"onGetPhoneNumber","value":function onGetPhoneNumber(){var e;this.props.onGetPhoneNumber&&(e=this.props).onGetPhoneNumber.apply(e,arguments)}},{"key":"onError","value":function onError(){var e;this.props.onError&&(e=this.props).onError.apply(e,arguments)}},{"key":"onOpenSetting","value":function onOpenSetting(){var e;this.props.onOpenSetting&&(e=this.props).onOpenSetting.apply(e,arguments)}},{"key":"onSumit","value":function onSumit(){(this.state.isWEAPP||this.state.isWEB)&&this.$scope.triggerEvent("submit",arguments[0].detail,{"bubbles":!0,"composed":!0})}},{"key":"onReset","value":function onReset(){(this.state.isWEAPP||this.state.isWEB)&&this.$scope.triggerEvent("reset",arguments[0].detail,{"bubbles":!0,"composed":!0})}},{"key":"render","value":function render(){var e,t=this.props,n=t.size,r=void 0===n?"normal":n,s=t.type,u=void 0===s?"":s,l=t.circle,p=t.full,h=t.loading,d=t.disabled,m=t.customStyle,v=t.formType,_=t.openType,P=t.lang,O=t.sessionFrom,w=t.sendMessageTitle,E=t.sendMessagePath,k=t.sendMessageImg,j=t.showMessageCard,C=t.appParameter,A=this.state,S=A.isWEAPP,T=A.isALIPAY,M=A.isWEB,N=["at-button"],x=(_defineProperty(e={},"at-button--"+y[r],y[r]),_defineProperty(e,"at-button--disabled",d),_defineProperty(e,"at-button--"+u,g[u]),_defineProperty(e,"at-button--circle",l),_defineProperty(e,"at-button--full",p),e),F="primary"===u?"#fff":"",R="small"===r?"30":0,I=void 0;h&&(I=o.l.createElement(a.a,{"className":"at-button__icon"},o.l.createElement(b,{"color":F,"size":R})),N.push("at-button--icon"));var D=o.l.createElement(i.a,{"className":"at-button__wxbutton","lang":P,"type":"submit"===v||"reset"===v?v:"button"}),B=o.l.createElement(i.a,{"className":"at-button__wxbutton","formType":v,"openType":_,"lang":P,"sessionFrom":O,"sendMessageTitle":w,"sendMessagePath":E,"sendMessageImg":k,"showMessageCard":j,"appParameter":C,"onGetUserInfo":this.onGetUserInfo.bind(this),"onGetPhoneNumber":this.onGetPhoneNumber.bind(this),"onOpenSetting":this.onOpenSetting.bind(this),"onError":this.onError.bind(this),"onContact":this.onContact.bind(this)});return o.l.createElement(a.a,{"className":f()(N,x,this.props.className),"style":m,"onClick":this.onClick.bind(this)},M&&!d&&D,S&&!d&&o.l.createElement(c,{"reportSubmit":!0,"onSubmit":this.onSumit.bind(this),"onReset":this.onReset.bind(this)},B),T&&!d&&B,I,o.l.createElement(a.a,{"className":"at-button__text"},this.props.children))}}]),AtButton}();v.defaultProps={"size":"normal","type":"","circle":!1,"full":!1,"loading":!1,"disabled":!1,"customStyle":{},"onClick":function onClick(){},"formType":"","openType":"","lang":"en","sessionFrom":"","sendMessageTitle":"","sendMessagePath":"","sendMessageImg":"","showMessageCard":!1,"appParameter":"","onGetUserInfo":function onGetUserInfo(){},"onContact":function onContact(){},"onGetPhoneNumber":function onGetPhoneNumber(){},"onError":function onError(){},"onOpenSetting":function onOpenSetting(){}},v.propTypes={"size":l.a.oneOf(["normal","small"]),"type":l.a.oneOf(["primary","secondary",""]),"circle":l.a.bool,"full":l.a.bool,"loading":l.a.bool,"disabled":l.a.bool,"onClick":l.a.func,"customStyle":l.a.oneOfType([l.a.object,l.a.string]),"formType":l.a.oneOf(["submit","reset",""]),"openType":l.a.oneOf(["contact","share","getUserInfo","getPhoneNumber","launchApp","openSetting","feedback","getRealnameAuthInfo",""]),"lang":l.a.string,"sessionFrom":l.a.string,"sendMessageTitle":l.a.string,"sendMessagePath":l.a.string,"sendMessageImg":l.a.string,"showMessageCard":l.a.bool,"appParameter":l.a.string,"onGetUserInfo":l.a.func,"onContact":l.a.func,"onGetPhoneNumber":l.a.func,"onError":l.a.func,"onOpenSetting":l.a.func}},"355":function(e,t,n){"use strict";n.r(t);var o,r=n(1),a=n(2),i=n(22),s=n(21),c=n(61),u=n(331),l=n(329),p=n(207),f=n(74),h=n(103),d=n(64),b=n(16),m=n(90),y=(n(79),function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}()),g=function get(e,t,n){null===e&&(e=Function.prototype);var o=Object.getOwnPropertyDescriptor(e,t);if(void 0===o){var r=Object.getPrototypeOf(e);return null===r?void 0:get(r,t,n)}if("value"in o)return o.value;var a=o.get;return void 0!==a?a.call(n):void 0};function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}t.default=Object(b.b)(function(e){return{"session":e.session}},function(e){return{"setSession":function setSession(t){e(Object(m.b)(t))}}})(o=function(e){function Account(){var e,t,n;!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Account);for(var o=arguments.length,r=Array(o),a=0;a<o;a++)r[a]=arguments[a];return t=n=_possibleConstructorReturn(this,(e=Account.__proto__||Object.getPrototypeOf(Account)).call.apply(e,[this].concat(r))),n.state={"submiting":!1,"avatar":"","form":{"nick":"","mobile":""}},n.uploadConf={"url":"/wxapi/member/avatar","filePath":"","name":"file","header":{"X-Requested-With":"XMLHttpRequest","token":n.props.session.token}},n.config={"navigationBarTitleText":"个人信息设置"},_possibleConstructorReturn(n,t)}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Account,c["a"]),y(Account,[{"key":"componentWillReceiveProps","value":function componentWillReceiveProps(e){this.setState({"avatar":e.session.avatar,"form":{"nick":e.session.nick,"mobile":e.session.mobile}})}},{"key":"handleAvatarError","value":function handleAvatarError(e){this.setState({"avatar":"https://jdc.jd.com/img/200"})}},{"key":"handleChange","value":function handleChange(e,t){var n=this.state.form;n[e]=t,this.setState({"form":n})}},{"key":"handleSubmit","value":function handleSubmit(){var e=this,t=this.state.form;try{if(!t.nick)throw"请填写昵称";if(!t.mobile)throw"请填写手机号码";a.default.$http.post("/member/update",t).then(function(n){200===n.code?(e.props.setSession({"nick":t.nick,"mobile":t.mobile}),e.chowMessage(n.msg,"success")):e.chowMessage(n.msg)}).catch(function(t){e.chowMessage(t.msg)})}catch(e){this.chowMessage(e)}}},{"key":"chowMessage","value":function chowMessage(e,t){return t=t||"warning",a.default.atMessage({"message":e,"type":t}),!1}},{"key":"chooseImage","value":function chooseImage(){var e=this;Object(i.a)({"count":1}).then(function(t){var n="chooseImage:ok"===t.errMsg&&t.tempFiles[0]||!1;return n?-1===["image/jpeg","image/jpg","image/png","image/gif"].indexOf(n.type)?e.chowMessage("只能上传图片文件"+n.type):(e.uploadConf.filePath=n.path,void Object(s.a)(e.uploadConf).then(function(t){var n=200===t.statusCode?JSON.parse(t.data):{"code":500,"msg":"上传失败"};200===n.code?(e.props.setSession({"avatar":n.data.avatar}),e.chowMessage("头像更新成功","success")):e.chowMessage(n.msg)}).catch(function(t){e.chowMessage(t.errMsg)})):e.chowMessage("请选择头像图片")}).catch(function(e){console.error("chooseImage Error",e)})}},{"key":"render","value":function render(){var e=this.state.avatar?r.l.createElement(u.a,{"className":"member-avatar-img","src":this.state.avatar,"onError":this.handleAvatarError.bind(this)}):r.l.createElement(p.a,{"value":"camera","size":"30","color":"#FFFFFF"});return r.l.createElement(l.a,null,r.l.createElement(f.a,null),r.l.createElement(d.e,{"to":"/pages/member/index"}),r.l.createElement(l.a,{"className":"jxh-row jxh-center jxh-pt-40 jxh-mb-80"},r.l.createElement(l.a,{"className":"member-avatar account-avatar","onClick":this.chooseImage.bind(this)},e)),r.l.createElement(l.a,{"className":"jxh-container"},r.l.createElement(d.h,{"title":"昵称","placeholder":"请填写","value":this.state.form.nick,"onChange":this.handleChange.bind(this,"nick")}),r.l.createElement(d.h,{"title":"手机号码","placeholder":"+86","value":this.state.form.mobile,"onChange":this.handleChange.bind(this,"mobile")})),r.l.createElement(l.a,{"className":"account-button"},r.l.createElement(l.a,{"className":"jxh-pl-30 jxh-pr-30"},r.l.createElement(h.a,{"type":"primary","onClick":this.handleSubmit.bind(this),"loading":this.state.submiting},"提交"))))}},{"key":"componentDidMount","value":function componentDidMount(){g(Account.prototype.__proto__||Object.getPrototypeOf(Account.prototype),"componentDidMount",this)&&g(Account.prototype.__proto__||Object.getPrototypeOf(Account.prototype),"componentDidMount",this).call(this)}},{"key":"componentDidShow","value":function componentDidShow(){g(Account.prototype.__proto__||Object.getPrototypeOf(Account.prototype),"componentDidShow",this)&&g(Account.prototype.__proto__||Object.getPrototypeOf(Account.prototype),"componentDidShow",this).call(this)}},{"key":"componentDidHide","value":function componentDidHide(){g(Account.prototype.__proto__||Object.getPrototypeOf(Account.prototype),"componentDidHide",this)&&g(Account.prototype.__proto__||Object.getPrototypeOf(Account.prototype),"componentDidHide",this).call(this)}}]),Account}())||o},"61":function(e,t,n){"use strict";n.d(t,"a",function(){return a});var o=n(2),r=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var a=function(e){function Auth(){return function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Auth),function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Auth.__proto__||Object.getPrototypeOf(Auth)).apply(this,arguments))}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Auth,o["default"].Component),r(Auth,[{"key":"componentWillMount","value":function componentWillMount(){var e=o.default.$store.getState().session.token;""!==e&&e||o.default.redirectTo({"url":"/pages/member/login"})}}]),Auth}()},"62":function(e,t,n){var o=n(63);"string"==typeof o&&(o=[[e.i,o,""]]);var r={"sourceMap":!1,"insertAt":"top","hmr":!0,"transform":void 0,"insertInto":void 0};n(67)(o,r);o.locals&&(e.exports=o.locals)},"63":function(e,t,n){(e.exports=n(66)(!1)).push([e.i,"button {\n  position: relative;\n  display: block;\n  width: 100%;\n  margin-left: auto;\n  margin-right: auto;\n  padding-left: 14px;\n  padding-right: 14px;\n  box-sizing: border-box;\n  font-size: 18px;\n  text-align: center;\n  text-decoration: none;\n  line-height: 2.55555556;\n  border-radius: 5px;\n  -webkit-tap-highlight-color: transparent;\n  overflow: hidden;\n  color: #000000;\n  background-color: #F8F8F8;\n}\n\nbutton[plain] {\n  color: #353535;\n  border: 1px solid #353535;\n  background-color: transparent;\n}\n\nbutton[plain][disabled] {\n  color: rgba(0, 0, 0, 0.3);\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  background-color: #F7F7F7;\n}\n\nbutton[type=primary] {\n  color: #FFFFFF;\n  background-color: #1AAD19;\n}\n\nbutton[type=primary][plain] {\n  color: #1aad19;\n  border: 1px solid #1aad19;\n  background-color: transparent;\n}\n\nbutton[type=primary][plain][disabled] {\n  color: rgba(0, 0, 0, 0.3);\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  background-color: #F7F7F7;\n}",""])},"71":function(e,t,n){"use strict";n(60);var o=n(1),r=n(65),a=n(55),i=n.n(a),s=(n(62),Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e}),c=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{"value":n,"enumerable":!0,"configurable":!0,"writable":!0}):e[t]=n,e}var u=function(e){function Button(){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Button);var e=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Button.__proto__||Object.getPrototypeOf(Button)).apply(this,arguments));return e.state={"hover":!1,"touch":!1},e}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Button,o["l"].Component),c(Button,[{"key":"render","value":function render(){var e,t=this,n=this.props,a=n.children,c=n.disabled,u=n.className,l=n.style,p=n.onClick,f=n.onTouchStart,h=n.onTouchEnd,d=n.hoverClass,b=void 0===d?"button-hover":d,m=n.hoverStartTime,y=void 0===m?20:m,g=n.hoverStayTime,v=void 0===g?70:g,_=n.size,P=n.plain,O=n.loading,w=void 0!==O&&O,E=n.type,k=void 0===E?"default":E,j=u||i()("weui-btn",(_defineProperty(e={},""+b,this.state.hover&&!c),_defineProperty(e,"weui-btn_plain-"+k,P),_defineProperty(e,"weui-btn_"+k,!P&&k),_defineProperty(e,"weui-btn_mini","mini"===_),_defineProperty(e,"weui-btn_loading",w),_defineProperty(e,"weui-btn_disabled",c),e));return o.l.createElement("button",s({},Object(r.a)(this.props,["hoverClass","onTouchStart","onTouchEnd"]),{"className":j,"style":l,"onClick":p,"disabled":c,"onTouchStart":function _onTouchStart(e){t.setState(function(){return{"touch":!0}}),b&&!c&&setTimeout(function(){t.state.touch&&t.setState(function(){return{"hover":!0}})},y),f&&f(e)},"onTouchEnd":function _onTouchEnd(e){t.setState(function(){return{"touch":!1}}),b&&!c&&setTimeout(function(){t.state.touch||t.setState(function(){return{"hover":!1}})},v),h&&h(e)}}),w&&o.l.createElement("i",{"class":"weui-loading"}),a)}}]),Button}();t.a=u},"74":function(e,t,n){"use strict";n.d(t,"a",function(){return f});var o=n(1),r=n(2),a=n(57),i=n.n(a),s=n(329),c=n(55),u=n.n(c),l=n(56),p=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var f=function(e){function AtMessage(){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtMessage);var e=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtMessage.__proto__||Object.getPrototypeOf(AtMessage)).apply(this,arguments));return e.state={"_isOpened":!1,"_message":"","_type":"info","_duration":3e3},e._timer=null,e}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtMessage,l["a"]),p(AtMessage,[{"key":"bindMessageListener","value":function bindMessageListener(){var e=this;r.default.eventCenter.on("atMessage",function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n={"_isOpened":!0,"_message":t.message,"_type":t.type,"_duration":t.duration||e.state._duration};e.setState(n,function(){clearTimeout(e._timer),e._timer=setTimeout(function(){e.setState({"_isOpened":!1})},e.state._duration)})}),r.default.atMessage=r.default.eventCenter.trigger.bind(r.default.eventCenter,"atMessage")}},{"key":"componentDidShow","value":function componentDidShow(){this.bindMessageListener()}},{"key":"componentDidMount","value":function componentDidMount(){this.bindMessageListener()}},{"key":"componentDidHide","value":function componentDidHide(){r.default.eventCenter.off("atMessage")}},{"key":"componentWillUnmount","value":function componentWillUnmount(){r.default.eventCenter.off("atMessage")}},{"key":"render","value":function render(){var e=this.props,t=e.className,n=e.customStyle,r=this.state,a=r._message,i=r._isOpened,c=r._type,l=u()({"at-message":!0,"at-message--show":i,"at-message--hidden":!i},"at-message--"+c,t);return o.l.createElement(s.a,{"className":l,"style":n},a)}}]),AtMessage}();f.defaultProps={"customStyle":"","className":""},f.propTypes={"customStyle":i.a.oneOfType([i.a.object,i.a.string]),"className":i.a.oneOfType([i.a.array,i.a.string])}},"79":function(e,t,n){},"90":function(e,t,n){"use strict";n.d(t,"b",function(){return a}),n.d(t,"a",function(){return i});var o=n(12),r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e},a=function set(e){return r({"type":o.b},e)},i=function remove(){return{"type":o.a}}}}]);