(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d221c2f"],{cc70:function(t,n,c){"use strict";c.r(n);var a=c("a27e");n["default"]={namespaced:!0,state:{coins:{}},getters:{},mutations:{setter:function(t,n){t.coins=n}},actions:{fetch:function(t){var n=t.commit;a["default"].get("/coins").then(function(t){var c={};for(var a in t.data)c[t.data[a].id]=t.data[a];n("setter",c)}).catch(function(t){console.log(t)})}}}}}]);