import{T as d,o as l,c as m,w as t,a as o,u as a,Z as c,b as e,d as p,n as u,e as f}from"./app-CYDLOEjt.js";import{_}from"./GuestLayout-IBPO4UoH.js";import{_ as w,a as b,b as x}from"./TextInput-Bmgi-IG9.js";import{P as g}from"./PrimaryButton-uwrywDYC.js";import"./ApplicationLogo-e-CkfQRU.js";const y=e("div",{class:"mb-4 text-sm text-gray-600 dark:text-gray-400"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),h={class:"flex justify-end mt-4"},N={__name:"ConfirmPassword",setup(P){const s=d({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(V,r)=>(l(),m(_,null,{default:t(()=>[o(a(c),{title:"Confirm Password"}),y,e("form",{onSubmit:f(i,["prevent"])},[e("div",null,[o(w,{for:"password",value:"Password"}),o(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:a(s).password,"onUpdate:modelValue":r[0]||(r[0]=n=>a(s).password=n),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),o(x,{class:"mt-2",message:a(s).errors.password},null,8,["message"])]),e("div",h,[o(g,{class:u(["ms-4",{"opacity-25":a(s).processing}]),disabled:a(s).processing},{default:t(()=>[p(" Confirm ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{N as default};
