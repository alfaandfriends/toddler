import{_ as y}from"./AuthenticatedLayout-DfP7PIwA.js";import{r as x,o as d,f as h,a as t,u as a,w as e,F as w,Z as b,b as u,d as s,c as g,g as $,k as v,t as p}from"./app-CYDLOEjt.js";import{_ as C,a as D,b as B,c as m,d as r,e as N,f as l,h as E}from"./moment-CjSGTqJO.js";import{P as S}from"./Pagination-Cgu2bDh4.js";import"./ApplicationLogo-e-CkfQRU.js";import"./CardContent-B9v-RSgU.js";const T=u("h2",{class:"font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"},"Dashboard",-1),V={class:"py-6"},Y={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2"},A=u("div",{class:"p-3"}," No Record Found ",-1),F={methods:{launch(f){const c=route("launch",{key:f}),o=document.createElement("form");o.action=c,o.method="POST",o.target="_blank";const _=document.querySelector('meta[name="csrf-token"]').getAttribute("content"),n=document.createElement("input");n.type="hidden",n.name="_token",n.value=_,o.appendChild(n),document.body.appendChild(o),o.submit(),document.body.removeChild(o)}}},q=Object.assign(F,{__name:"Dashboard",setup(f){return(c,o)=>{const _=x("Button");return d(),h(w,null,[t(a(b),{title:"Dashboard"}),t(y,null,{header:e(()=>[T]),default:e(()=>[u("div",V,[u("div",Y,[t(C,null,{title:e(()=>[s("Toddler App Keys")]),content:e(()=>[t(a(D),null,{default:e(()=>[t(a(B),{class:"bg-gray-100"},{default:e(()=>[t(a(m),null,{default:e(()=>[t(a(r),null,{default:e(()=>[s("#")]),_:1}),t(a(r),{class:"whitespace-nowrap"},{default:e(()=>[s("Device Name")]),_:1}),t(a(r),{class:"whitespace-nowrap"},{default:e(()=>[s("Kit")]),_:1}),t(a(r),{class:"whitespace-nowrap text-center"},{default:e(()=>[s("Swap Count")]),_:1}),t(a(r),{class:"whitespace-nowrap text-center"},{default:e(()=>[s("Expiry Date")]),_:1}),t(a(r),{class:"whitespace-nowrap text-center"},{default:e(()=>[s("Action")]),_:1})]),_:1})]),_:1}),t(a(N),null,{default:e(()=>[c.$page.props.keys.data.length?$("",!0):(d(),g(a(m),{key:0},{default:e(()=>[t(a(l),{class:"text-center",colspan:"10"},{default:e(()=>[A]),_:1})]),_:1})),(d(!0),h(w,null,v(c.$page.props.keys.data,(n,k)=>(d(),g(a(m),null,{default:e(()=>[t(a(l),null,{default:e(()=>[s(p(c.$page.props.keys.from+k),1)]),_:2},1024),t(a(l),{class:"whitespace-nowrap"},{default:e(()=>[s(p(n.device_name),1)]),_:2},1024),t(a(l),{class:"whitespace-nowrap"},{default:e(()=>{var i;return[s(p((i=n.kit_ref)==null?void 0:i.name),1)]}),_:2},1024),t(a(l),{class:"whitespace-nowrap text-center"},{default:e(()=>[s(p(n.swap_count),1)]),_:2},1024),t(a(l),{class:"whitespace-nowrap text-center"},{default:e(()=>[s(p(a(E)(n.expiry_date).format("DD MMM YYYY")),1)]),_:2},1024),t(a(l),{class:"whitespace-nowrap text-center"},{default:e(()=>[t(_,{onClick:i=>c.launch(n.key)},{default:e(()=>[s("Launch")]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})]),_:1}),t(S,{page_data:c.$page.props.keys},null,8,["page_data"])])])]),_:1})],64)}}});export{q as default};
