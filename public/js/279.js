"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[279],{279:(e,t,n)=>{n.r(t),n.d(t,{default:()=>d});var r=n(6598),o=n(6252),a={style:{"text-align":"center",margin:"auto"}},u={style:{margin:"0.5rem auto"}},i=(0,r.createTextVNode)("Go Back"),l=(0,r.createTextVNode)(" | "),c=(0,r.createTextVNode)("Go Home"),s={layout:null};const d=Object.assign(s,{props:{status:[Number,String],message:String},setup:function(e){var t=e.status,n=e.message,s={503:"Service Unavailable",500:"Internal Server Error",404:"Not found",403:"Forbidden",400:"Bad Request"},d=(0,o.Fl)((function(){return n.length?n:s[t]})),f=function(){window.history.back()};return function(t,n){var o=(0,r.resolveComponent)("n-h1"),s=(0,r.resolveComponent)("n-p"),p=(0,r.resolveComponent)("Link");return(0,r.openBlock)(),(0,r.createElementBlock)("div",a,[(0,r.createVNode)(o,null,{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)("Error "+(0,r.toDisplayString)(e.status),1)]})),_:1}),(0,r.createVNode)(s,null,{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)((0,r.unref)(d)),1)]})),_:1}),(0,r.createElementVNode)("div",u,[(0,r.createVNode)(p,{href:"#",onClick:f},{default:(0,r.withCtx)((function(){return[i]})),_:1}),l,(0,r.createVNode)(p,{href:"/"},{default:(0,r.withCtx)((function(){return[c]})),_:1})])])}}})}}]);