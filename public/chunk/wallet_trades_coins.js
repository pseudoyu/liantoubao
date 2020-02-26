(window.webpackJsonp=window.webpackJsonp||[]).push([[25],{"316":function(e,t,n){"use strict";var o=n(1),r=n(333),i=n(210),a=n(334),c=n(55),s=n.n(c),l=n(57),u=n.n(l),p=n(56),f=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var h=function(e){function AtSearchBar(e){!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,AtSearchBar);var t=function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(AtSearchBar.__proto__||Object.getPrototypeOf(AtSearchBar)).apply(this,arguments));return t.handleFocus=function(){var e;t.setState({"isFocus":!0}),(e=t.props).onFocus.apply(e,arguments)},t.handleBlur=function(){var e;t.setState({"isFocus":!1}),(e=t.props).onBlur.apply(e,arguments)},t.handleChange=function(e){for(var n,o=arguments.length,r=Array(o>1?o-1:0),i=1;i<o;i++)r[i-1]=arguments[i];return(n=t.props).onChange.apply(n,[e.target.value].concat(r))},t.handleClear=function(){for(var e=arguments.length,n=Array(e),o=0;o<e;o++)n[o]=arguments[o];var r;t.props.onClear?t.props.onClear():(r=t.props).onChange.apply(r,[""].concat(n))},t.handleConfirm=function(){var e;return(e=t.props).onConfirm.apply(e,arguments)},t.handleActionClick=function(){var e;return(e=t.props).onActionClick.apply(e,arguments)},t.state={"isFocus":e.focus},t}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(AtSearchBar,p["a"]),f(AtSearchBar,[{"key":"render","value":function render(){var e=this.props,t=e.value,n=e.placeholder,c=e.maxLength,l=e.fixed,u=e.disabled,p=e.showActionButton,f=e.actionName,h=e.inputType,y=e.className,d=e.customStyle,b=this.state.isFocus,m=s()("at-search-bar",{"at-search-bar--fixed":l},y),_={},C={};b||!b&&t?(C.opacity=1,C.marginRight="0",_.flexGrow=0):b||t||(_.flexGrow=1,C.opacity=0,C.marginRight="-"+(14*(f.length+1)+7+10)+"px"),p&&(C.opacity=1,C.marginRight="0");var v={"display":"flex"},g={"visibility":"hidden"};return t.length||(v.display="none",g.visibility="visible"),o.l.createElement(r.a,{"className":m,"style":d},o.l.createElement(r.a,{"className":"at-search-bar__input-cnt"},o.l.createElement(r.a,{"className":"at-search-bar__placeholder-wrap","style":_},o.l.createElement(i.a,{"className":"at-icon at-icon-search"}),o.l.createElement(i.a,{"className":"at-search-bar__placeholder","style":g},b?"":n)),o.l.createElement(a.a,{"className":"at-search-bar__input","type":h,"confirmType":"search","value":t,"focus":b,"disabled":u,"maxLength":c,"onInput":this.handleChange,"onFocus":this.handleFocus,"onBlur":this.handleBlur,"onConfirm":this.handleConfirm}),o.l.createElement(r.a,{"className":"at-search-bar__clear","style":v,"onTouchStart":this.handleClear},o.l.createElement(i.a,{"className":"at-icon at-icon-close-circle"}))),o.l.createElement(r.a,{"className":"at-search-bar__action","style":C,"onClick":this.handleActionClick},f))}}]),AtSearchBar}();h.defaultProps={"value":"","placeholder":"搜索","maxLength":140,"fixed":!1,"focus":!1,"disabled":!1,"showActionButton":!1,"actionName":"搜索","inputType":"text","onChange":function onChange(){},"onFocus":function onFocus(){},"onBlur":function onBlur(){},"onConfirm":function onConfirm(){},"onActionClick":function onActionClick(){}},h.propTypes={"value":u.a.string,"placeholder":u.a.string,"maxLength":u.a.number,"fixed":u.a.bool,"focus":u.a.bool,"disabled":u.a.bool,"showActionButton":u.a.bool,"actionName":u.a.string,"inputType":u.a.oneOf(["text","number","idcard","digit"]),"onChange":u.a.func,"onFocus":u.a.func,"onBlur":u.a.func,"onConfirm":u.a.func,"onActionClick":u.a.func,"onClear":u.a.func},t.a=h},"345":function(e,t,n){"use strict";n.r(t);var o,r=n(1),i=n(2),a=n(63),c=n(333),s=n(64),l=n(316),u=n(16),p=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}(),f=function get(e,t,n){null===e&&(e=Function.prototype);var o=Object.getOwnPropertyDescriptor(e,t);if(void 0===o){var r=Object.getPrototypeOf(e);return null===r?void 0:get(r,t,n)}if("value"in o)return o.value;var i=o.get;return void 0!==i?i.call(n):void 0};function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}t.default=Object(u.b)(function(e){return{"session":e.session,"coins_tree":e.coins_tree}})(o=function(e){function Coins(){var e,t,n;!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Coins);for(var o=arguments.length,r=Array(o),i=0;i<o;i++)r[i]=arguments[i];return t=n=_possibleConstructorReturn(this,(e=Coins.__proto__||Object.getPrototypeOf(Coins)).call.apply(e,[this].concat(r))),n.config={"navigationBarTitleText":"新增交易"},n.state={"coins_tree":[],"searchValue":""},n.CoinsTree=[],_possibleConstructorReturn(n,t)}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Coins,a["a"]),p(Coins,[{"key":"componentWillMount","value":function componentWillMount(){f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentWillMount",this).call(this);var e=this.props.coins_tree;"0"!==this.props.session.viper&&this.props.session.viper||(e=e.map(function(e){var t=e.items.filter(function(e){return 0===e.isvip});return t.length>0&&{"title":e.title,"key":e.key,"items":t}}).filter(function(e){return!1!==e})),this.setState({"coins_tree":e}),this.CoinsTree=e}},{"key":"SearchChange","value":function SearchChange(e){this.setState({"searchValue":e})}},{"key":"SearchAction","value":function SearchAction(){var e=this,t=this.CoinsTree;this.state.searchValue&&(t=t.map(function(t){var n=t.items.filter(function(t){return-1!==(t.title+t.code).toLowerCase().indexOf(e.state.searchValue.toLowerCase())});return n.length>0&&{"title":t.title,"key":t.key,"items":n}}).filter(function(e){return!1!==e})),this.setState({"coins_tree":t})}},{"key":"SearchClear","value":function SearchClear(){this.setState({"searchValue":"","coins_tree":this.CoinsTree})}},{"key":"selectorIndexs","value":function selectorIndexs(e){var t="/pages/wallet/trades/create?coin_id="+e.id;i.default.redirectTo({"url":t})}},{"key":"render","value":function render(){return r.l.createElement(c.a,{"className":"jxh-app"},r.l.createElement(s.e,{"to":"/pages/wallet/index"}),r.l.createElement(c.a,{"style":"padding-left:20px;"},r.l.createElement(l.a,{"actionName":"搜一下","value":this.state.searchValue,"onChange":this.SearchChange.bind(this),"onClear":this.SearchClear.bind(this),"onActionClick":this.SearchAction.bind(this)})),r.l.createElement(s.g,{"list":this.state.coins_tree,"topKey":"#","isShowToast":!0,"onClick":this.selectorIndexs.bind(this)}),r.l.createElement(c.a,{"className":"jxh-bottom"}),r.l.createElement(s.j,{"current":0}))}},{"key":"componentDidMount","value":function componentDidMount(){f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentDidMount",this)&&f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentDidMount",this).call(this)}},{"key":"componentDidShow","value":function componentDidShow(){f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentDidShow",this)&&f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentDidShow",this).call(this)}},{"key":"componentDidHide","value":function componentDidHide(){f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentDidHide",this)&&f(Coins.prototype.__proto__||Object.getPrototypeOf(Coins.prototype),"componentDidHide",this).call(this)}}]),Coins}())||o},"63":function(e,t,n){"use strict";n.d(t,"a",function(){return i});var o=n(2),r=function(){function defineProperties(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,t,n){return t&&defineProperties(e.prototype,t),n&&defineProperties(e,n),e}}();var i=function(e){function Auth(){return function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Auth),function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(Auth.__proto__||Object.getPrototypeOf(Auth)).apply(this,arguments))}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Auth,o["default"].Component),r(Auth,[{"key":"componentWillMount","value":function componentWillMount(){var e=o.default.$store.getState().session.token;""!==e&&e||o.default.redirectTo({"url":"/pages/member/login"})}}]),Auth}()}}]);