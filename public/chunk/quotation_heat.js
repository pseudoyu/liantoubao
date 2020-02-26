(window.webpackJsonp=window.webpackJsonp||[]).push([[15],{"321":function(e,t,a){},"350":function(e,t,a){"use strict";a.r(t);var n,o=a(1),r=a(2),l=a(333),c=a(210),i=a(337),s=a(64),p=a(16),u=a(55),m=a.n(u),h=(a(69),a(321),function(){function defineProperties(e,t){for(var a=0;a<t.length;a++){var n=t[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(e,t,a){return t&&defineProperties(e.prototype,t),a&&defineProperties(e,a),e}}()),f=function get(e,t,a){null===e&&(e=Function.prototype);var n=Object.getOwnPropertyDescriptor(e,t);if(void 0===n){var o=Object.getPrototypeOf(e);return null===o?void 0:get(o,t,a)}if("value"in n)return n.value;var r=n.get;return void 0!==r?r.call(a):void 0};function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}t.default=Object(p.b)(function(e){return{"coins":e.coins}})(n=function(e){function Heat(){var e,t,a;!function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,Heat);for(var n=arguments.length,o=Array(n),r=0;r<n;r++)o[r]=arguments[r];return t=a=_possibleConstructorReturn(this,(e=Heat.__proto__||Object.getPrototypeOf(Heat)).call.apply(e,[this].concat(o))),a.config={"navigationBarTitleText":"行情信息"},a.itemRank=[5,10,15,20],a.TagLabel=[-20,-15,-10,-5,0,5,10,15,20],a.state={"data":[]},_possibleConstructorReturn(a,t)}return function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{"constructor":{"value":e,"enumerable":!1,"writable":!0,"configurable":!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(Heat,r["default"].Component),h(Heat,[{"key":"componentWillMount","value":function componentWillMount(){var e=this;r.default.$http.get("/ws/heat_map").then(function(t){e.setState({"data":t.data})}).catch(function(e){console.log(e)})}},{"key":"styles","value":function styles(e){var t="heat-rank-",a="0";if(0!==e)for(var n in t+=e>0?"u-":"d-",e=Math.abs(e),this.itemRank)if(e<=this.itemRank[n]){a=this.itemRank[n];break}return t+a}},{"key":"params","value":function params(e,t,a){var n=this.props.coins[e.coin_id];if(!n)return!1;var o=n.code,r=100*e.rate,l=this.styles(r),c=t||0===t?"heat-coins-row-item-"+t:"";return a=a?"":"heat-coins-row-item",{"code":o,"Cls":m()(a,c,l),"Rate":(0===r?"0":(r>0?"+":"")+r.toFixed(2))+"%"}}},{"key":"render","value":function render(){var e=this,t=this.TagLabel.length,a=this.TagLabel.map(function(e,a){var n=0===e?"":e>0?"u-":"d-",r=m()("heat-tags-item","heat-rank-"+n+Math.abs(e)),c=0==a?"≤":a+1===t?"≥":"";return o.l.createElement(l.a,{"className":r},c,e,"%")}),n=this.state.data,r="",p="",u="";if(n.length){if(r=n.slice(0,3).map(function(t,a){var n=e.params(t,a);return n?o.l.createElement(l.a,{"className":n.Cls},o.l.createElement(l.a,null,o.l.createElement(c.a,null,n.code,o.l.createElement("br",null),n.Rate))):""}),n.length>3){var h=this.params(n[3],4,!0),f=h?o.l.createElement(l.a,{"className":h.Cls},o.l.createElement(l.a,null,o.l.createElement(c.a,null,h.code,o.l.createElement("br",null),h.Rate))):"",d="";if(n[4]){var y=this.params(n[4],4,!0);d=y?o.l.createElement(l.a,{"className":y.Cls},o.l.createElement(l.a,null,o.l.createElement(c.a,null,y.code,o.l.createElement("br",null),y.Rate))):""}p=o.l.createElement(l.a,{"className":"heat-coins-row-item-3"},f,d)}n.length>5&&(u=n.slice(5).map(function(t,a){var n=e.params(t);return n?o.l.createElement(l.a,{"className":n.Cls},o.l.createElement(l.a,null,o.l.createElement(c.a,null,n.code,o.l.createElement("br",null),n.Rate))):""}))}return o.l.createElement(l.a,{"className":"jxh-app"},o.l.createElement(l.a,{"className":"jxh-content"},o.l.createElement(l.a,{"className":"jxh-content-items"},o.l.createElement(l.a,{"className":"jxh-container jxh-pt-20"},o.l.createElement(s.k,{"current":1}))),o.l.createElement(l.a,{"className":"jxh-content-items"},o.l.createElement(l.a,{"className":"jxh-container jxh-pt-20"},o.l.createElement(l.a,{"className":"heat-tags"},a))),o.l.createElement(l.a,{"className":"jxh-content-lists jxh-pt-20"},o.l.createElement(i.a,{"className":"jxh-content-lists-scroll","scrollY":!0},o.l.createElement(l.a,{"className":"heat-coins"},o.l.createElement(l.a,{"className":"heat-coins-row"},r,p,u)))),o.l.createElement(l.a,{"className":"jxh-bottom"})),o.l.createElement(s.j,{"current":1}))}},{"key":"componentDidMount","value":function componentDidMount(){f(Heat.prototype.__proto__||Object.getPrototypeOf(Heat.prototype),"componentDidMount",this)&&f(Heat.prototype.__proto__||Object.getPrototypeOf(Heat.prototype),"componentDidMount",this).call(this)}},{"key":"componentDidShow","value":function componentDidShow(){f(Heat.prototype.__proto__||Object.getPrototypeOf(Heat.prototype),"componentDidShow",this)&&f(Heat.prototype.__proto__||Object.getPrototypeOf(Heat.prototype),"componentDidShow",this).call(this)}},{"key":"componentDidHide","value":function componentDidHide(){f(Heat.prototype.__proto__||Object.getPrototypeOf(Heat.prototype),"componentDidHide",this)&&f(Heat.prototype.__proto__||Object.getPrototypeOf(Heat.prototype),"componentDidHide",this).call(this)}}]),Heat}())||n},"69":function(e,t,a){}}]);