import{_ as s,L as g}from"./Layout-08f7d322.js";import{o as t,d as o,h as f,r as x,c as p,w as $,a as l,e as w,F as y,i as v}from"./app-9c8305ed.js";const b={},k={class:"text-danger background-danger border border-danger",style:{padding:"5px"}};function L(e,n){return t(),o("span",k,[f(e.$slots,"default")])}const d=s(b,[["render",L]]),A={},P={class:"text-primary",style:{padding:"5px"}};function B(e,n){return t(),o("span",P,[f(e.$slots,"default")])}const _=s(A,[["render",B]]),C={};function H(e,n){return t(),o("br")}const h=s(C,[["render",H]]),R={components:{Layout:g,Text:_,Highlight:d,Linebreak:h},data(){return{textParts:[],text:null}},methods:{init(){const e=new RegExp("(\\n|"+this.fixRegex(this.$page.props.entry.highlights.join("|"))+")","gm");var n=this.$page.props.entry.log.split(e);for(var r of n)if(r==`
`)this.textParts.push({content:"",component:h});else{var a=!1;for(var c of this.$page.props.entry.highlights)r==c&&(a=!0);a?this.textParts.push({content:r,component:d}):this.textParts.push({content:r,component:_})}},fixRegex(e){return e.replaceAll("(","\\(").replaceAll(")","\\)").replaceAll("[","\\[").replaceAll("]","\\]").replaceAll("{","\\{").replaceAll("}","\\}")}},computed:{},mounted(){this.init()},watch:{}},T={class:"row flex-center"},E={class:"col-8 col"},F={class:"border",style:{"word-wrap":"break-word","white-space":"pre-wrap","overflow-wrap":"break-word","line-height":"2"}};function M(e,n,r,a,c,S){const u=x("Layout");return t(),p(u,null,{default:$(()=>[l("div",T,[l("div",E,[l("pre",F,[(t(!0),o(y,null,w(c.textParts,(i,m)=>(t(),p(v(i.component),{key:m,innerHTML:i.content},null,8,["innerHTML"]))),128))])])])]),_:1})}const N=s(R,[["render",M]]);export{N as default};
