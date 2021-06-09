<style>
.w-4\/12{
    width: 33.333333%;
}
.w-3\/12{
    width: 25%;
}
.w-1\/12{
    width: 8.333333%;
}
.remove{
/* font-bold */
font-weight: 700;
/* text-red-500 */
--tw-text-opacity: 1;
color: rgba(239, 68, 68, var(--tw-text-opacity));
/* other */
--tw-bg-opacity: 0;
background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
--tw-divide-opacity: 0;
border-color: rgba(255, 255, 255, var(--tw-divide-opacity));
}
.big-title{
    /* text-3xl */
    font-size: 1.875rem;
    line-height: 2.25rem;
    /* font-semibold */
    font-weight: 600;
    /* text-gray-800 */
    --tw-text-opacity: 1;
    color: rgba(31, 41, 55, var(--tw-text-opacity));
}
.projbutton{
    --tw-bg-opacity: 0;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    --tw-divide-opacity: 0;
    border-color: rgba(255, 255, 255, var(--tw-divide-opacity));
    height: 100%;
    width: 100%;
    /* font-bold */
    font-weight: 700;
    /* text-center */
    text-align: center;
}
.respon-2grid{
    /* grid */
    display: grid;
}
@media (min-width: 1024px) {
    /* lg:grid-cols-2 */
    .respon-2grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (min-width: 640px) {
    .outside {
        /* sm:px-6 */
        padding-left: 1.5rem/* 24px */;
        padding-right: 1.5rem/* 24px */;
    }
}
@media (min-width: 1024px) {
    .outside {
        /* lg:px-8 */
        padding-left: 2rem/* 32px */;
        padding-right: 2rem/* 32px */;
    }
}
.outside02{
    /* p-4 */
    padding: 1rem/* 16px */;
}
.outside1{
    /* max-w-3xl */
    max-width: 48rem/* 768px */;
    /* mx-auto */
    margin-left: auto;
    margin-right: auto;
}
.outside2{
    /* max-w-4xl */
    max-width: 56rem/* 896px */;
    /* mx-auto */
    margin-left: auto;
    margin-right: auto;
}
.inside{
    /* bg-white */
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    /* shadow-xl */
    --tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}
.inside2{
    /* overflow-hidden */
    overflow: hidden;
}
@media (min-width: 640px) {
    .inside {/* sm:rounded-lg */
        border-radius: 0.5rem/* 8px */;
    }
    .inside1 {
        /* sm:rounded-lg */
        border-radius: 0.5rem/* 8px */;
    }
    .inside2{
        /* sm:rounded-2xl */
        border-radius: 1rem/* 16px */;
    }
}
.tablediv1{
    /* flex */
    display: flex;
    /* flex-col */
    flex-direction: column;
}
.tablediv2{
    /* -my-2 */
    margin-top: -0.5rem/* -8px */;
    margin-bottom: -0.5rem/* -8px */;
    /* overflow-x-auto */
    overflow-x: auto;
}
@media (min-width: 640px) {
    .tablediv2{
        /* sm:-mx-6 */
        margin-left: -1.5rem/* -24px */;
        margin-right: -1.5rem/* -24px */;
    }
}
@media (min-width: 1024px) {
    .tablediv2{
        /* lg:-mx-8 */
        margin-left: -2rem/* -32px */;
        margin-right: -2rem/* -32px */;
    }
}
.tablediv3{
    /* inline-block */
    display: inline-block;
    /* min-w-full */
    min-width: 100%;
    /* py-2 */
    padding-top: 0.5rem/* 8px */;
    padding-bottom: 0.5rem/* 8px */;
    /* align-middle */
    vertical-align: middle;
}
@media (min-width: 640px) {
    .tablediv3{
        /* sm:px-6 */
        padding-left: 1.5rem/* 24px */;
        padding-right: 1.5rem/* 24px */;
    }
}
@media (min-width: 1024px) {
    .tablediv3{
        /* lg:px-8 */
        padding-left: 2rem/* 32px */;
        padding-right: 2rem/* 32px */;
    }
}
.ptj-big{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* text-xl */
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
}
.cict-big{
    /* bg-yellow-600 */
    --tw-bg-opacity: 1;
    background-color: rgba(217, 119, 6, var(--tw-bg-opacity));
}
.aset-big{
    /* bg-blue-600 */
    --tw-bg-opacity: 1;
    background-color: rgba(37, 99, 235, var(--tw-bg-opacity));
}
.jpp-big{
    /* bg-green-600 */
    --tw-bg-opacity: 1;
    background-color: rgba(5, 150, 105, var(--tw-bg-opacity));
}
.ptj-outside{
    margin-left: 15%;
    position: absolute;
    z-index: 1;
    width: 70%;
    height: 3rem;
    /* flex */
    display: flex;
    /* justify-center */
    justify-content: center;
    /* border-t */
    border-top-width: 1px;
    /* border-gray-200 */
    --tw-border-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-border-opacity));
}
.ptj-butt{
    position: absolute;
    z-index: 3;
    height: 3.25rem;
    border-width: 0;
    background-color: rgba(255, 255, 255, 0);
    color: rgba(255, 255, 255, 1);
    border-radius: 1rem;
    /* justify-center */
    justify-content: center;
}
.bigprojname{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* text-xl */
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;
    /* font-bold */
    font-weight: 700;
    /* text-center */
    text-align: center;
}
.subprojuser{
    /* font-bold */
    font-weight: 700;
}
.subprojname{
    /* p-3 */
    padding: 0.75rem/* 12px */;
}
.ptj-sm{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* text-xl */
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;
    /* font-extrabold */
    font-weight: 800;
}
.cict-sm{
    /* text-yellow-600 */
    --tw-text-opacity: 1;
    color: rgba(217, 119, 6, var(--tw-text-opacity));
}
.aset-sm{
    /* text-blue-600 */
    --tw-text-opacity: 1;
    color: rgba(37, 99, 235, var(--tw-text-opacity));
}
.jpp-sm{
    /* text-green-600 */
    --tw-text-opacity: 1;
    color: rgba(5, 150, 105, var(--tw-text-opacity));
}
.mytable{
    /* min-w-full */
    min-width: 100%;
    /* divide-y */
    /* --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse)); */
    /* divide-gray-200 */
    /* --tw-divide-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-divide-opacity)); */
}
.thead{
    /* bg-gray-200 */
    --tw-bg-opacity: 1;
    background-color: rgba(229, 231, 235, var(--tw-bg-opacity));
}
.tbody{
    /* bg-white */
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    /* divide-y */
    /* --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse)); */
    /* divide-gray-200 */
    /* --tw-divide-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-divide-opacity)); */
}
.td{
    /* p-3 */
    padding: 0.75rem/* 12px */;
    /* text-center */
    text-align: center;
}
.td1{
    /* flex */
    display: flex;
    /* justify-center */
    justify-content: center;
}
.you{
    /* ml-2 */
    margin-left: 0.5rem/* 8px */;
    /* font-bold */
    font-weight: 700;
}
.email{
    /* p-3 */
    padding: 0.75rem/* 12px */;
    /* font-bold */
    font-weight: 700;
    /* text-center */
    text-align: center;
}
.admin{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* m-1 */
    margin: 0.25rem/* 4px */;
    /* font-bold */
    font-weight: 700;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* bg-yellow-500 */
    --tw-bg-opacity: 1;
    background-color: rgba(245, 158, 11, var(--tw-bg-opacity));
    /* rounded-lg */
    border-radius: 0.5rem/* 8px */;
}
.super-admin{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* m-1 */
    margin: 0.25rem/* 4px */;
    /* font-bold */
    font-weight: 700;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* bg-black */
    --tw-bg-opacity: 1;
    background-color: rgba(0, 0, 0, var(--tw-bg-opacity));
    /* rounded-lg */
    border-radius: 0.5rem/* 8px */;
}
.viewer{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* m-1 */
    margin: 0.25rem/* 4px */;
    /* font-bold */
    font-weight: 700;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* rounded-lg */
    border-radius: 0.5rem/* 8px */;
    /* bg-gradient-to-r */
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
    /* from-blue-700 */
    --tw-gradient-from: #1d4ed8;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(29, 78, 216, 0));
    /* to-green-700 */
    --tw-gradient-to: #047857;
}
.manager{
    /* p-1 */
    padding: 0.25rem/* 4px */;
    /* m-1 */
    margin: 0.25rem/* 4px */;
    /* font-bold */
    font-weight: 700;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* bg-purple-700 */
    --tw-bg-opacity: 1;
    background-color: rgba(109, 40, 217, var(--tw-bg-opacity));
    /* rounded-lg */
    border-radius: 0.5rem/* 8px */;
}
.progress{
    height: 1.5rem;
    /* relative */
    position: relative;
    /* flex-grow */
    flex-grow: 1;
    /* overflow-hidden */
    overflow: hidden;
    /* rounded-md */
    border-radius: 0.375rem/* 6px */;
    /* bg-gradient-to-b */
    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
    /* from-gray-400 */
    --tw-gradient-from: #9ca3af;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(156, 163, 175, 0));
    /* to-gray-500 */
    --tw-gradient-to: #6b7280;
    /* bg-clip-border */
    background-clip: border-box;
}
.progress-done{
    /* absolute */
    position: absolute;
    /* inset-0 */
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
    /* transition */
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
    /* rounded-md */
    border-radius: 0.375rem/* 6px */;
    /* bg-gradient-to-b */
    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
    /* from-green-600 */
    --tw-gradient-from: #059669;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(5, 150, 105, 0));
    /* to-green-400 */
    --tw-gradient-to: #34d399;
}
.progress-text{
    font-size: 1.1rem;
    line-height: .45rem;
    /* relative */
    position: relative;
    /* font-sans */
    font-family: Nunito, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    /* font-bold */
    font-weight: 700;
    /* text-center */
    text-align: center;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* h-6 */
    height: 1.5rem/* 24px */;
    padding: 0.5rem;
    /* flex-grow */
    flex-grow: 1;
}
.empty{
    /* text-center */
    text-align: center;
}
.loading{
    /* flex-grow */
    flex-grow: 1;
    /* text-center */
    text-align: right;
}
.hr{
    /* mb-3 */
    margin-bottom: 0.75rem/* 12px */;
    /* border-gray-200 */
    --tw-border-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-border-opacity));
}
/* w-10/12 p-3 m-3 mr-0 bg-gray-100 border-none rounded-md focus:bg-gray-200 */
.search-lw{
    width: 83.333333%;
    padding: 0.75rem/* 12px */;
    margin: 0.75rem/* 12px */;
    margin-right: 0px;
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    border-style: none;
    border-radius: 0.375rem/* 6px */;
}
.search-lw:focus{
    --tw-bg-opacity: 1;
    background-color: rgba(229, 231, 235, var(--tw-bg-opacity));
}
/* absolute overflow-hidden transform translate-x-3 translate-y-16 border-gray-700 divide-y rounded-md shadow-2xl */
.search-lw-lists{
    position: absolute;
    overflow: hidden;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    --tw-translate-x: 0.75rem/* 12px */;
    --tw-translate-y: 4rem/* 64px */;
    --tw-border-opacity: 1;
    border-color: rgba(55, 65, 81, var(--tw-border-opacity));
    --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
    border-radius: 0.375rem/* 6px */;
    --tw-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}
/* grid grid-cols-2 bg-gray-100 p-2 w-full border-gray-300 hover:bg-blue-600 hover:text-white */
.search-lw-list{
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    padding: 0.5rem/* 8px */;
    width: 100%;
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
}
.search-lw-list:hover{
    --tw-bg-opacity: 1;
    background-color: rgba(37, 99, 235, var(--tw-bg-opacity));
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
}
/* bg-blue-300 */
.search-lw-list-h{
    --tw-bg-opacity: 1;
    background-color: rgba(147, 197, 253, var(--tw-bg-opacity));
}
/* pr-2 font-bold text-right */
.search-lw-list-name{
    padding-right: 0.5rem/* 8px */;
    font-weight: 700;
    text-align: right;
}
/* pl-2 text-left */
.search-lw-list-email{
    padding-left: 0.5rem/* 8px */;
    text-align: left;
}
/* w-full p-2 text-center text-gray-600 bg-gray-100 border-gray-300 */
.search-lw-list-none{
    width: 100%;
    padding: 0.5rem/* 8px */;
    text-align: center;
    --tw-text-opacity: 1;
    color: rgba(75, 85, 99, var(--tw-text-opacity));
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
}
/* flex-grow p-3 m-3 font-bold text-white bg-green-600 rounded-md disabled:opacity-50 */
.search-lw-button{
    flex-grow: 1;
    padding: 0.75rem/* 12px */;
    margin: 0.75rem/* 12px */;
    font-weight: 700;
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    --tw-bg-opacity: 1;
    background-color: rgba(5, 150, 105, var(--tw-bg-opacity));
    border-radius: 0.375rem/* 6px */;
}
.search-lw-button:disabled{
    opacity: 0.5;
}
.search-lw-out{
    /* relative */
    position: relative;
    /* grid */
    display: grid;
    /* grid-cols-1 */
    grid-template-columns: repeat(1, minmax(0, 1fr));
}
.search-lw-reset{
    /* fixed */
    position: fixed;
    /* inset-0 */
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
}
/* focus:bg-gray-200 */
.search-lw2{
    /* w-full */
    width: 100%;
    /* p-3 */
    padding: 0.75rem/* 12px */;
    /* mt-1 */
    margin-top: 0.25rem/* 4px */;
    /* bg-gray-100 */
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    /* border-none */
    border-style: none;
    /* rounded-sm */
    border-radius: 0.125rem/* 2px */;
}
.search-lw2-lists1{
    z-index: 2;
    /* absolute */
    position: absolute;
    /* w-full */
    width: 100%;
    /* overflow-hidden */
    overflow: hidden;
    /* transform */
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    /* translate-y-12 */
    --tw-translate-y: 3rem/* 48px */;
    /* border-gray-700 */
    --tw-border-opacity: 1;
    border-color: rgba(55, 65, 81, var(--tw-border-opacity));
    /* divide-y */
    --tw-divide-y-reverse: 0;
    border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
    /* shadow-2xl */
    --tw-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    /* rounded-b-md */
    border-bottom-right-radius: 0.375rem/* 6px */;
    border-bottom-left-radius: 0.375rem/* 6px */;
}
/* grid grid-cols-2 bg-gray-100 p-2 w-full border-gray-300 hover:bg-blue-600 hover:text-white */
.search-lw-list{
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    padding: 0.5rem/* 8px */;
    width: 100%;
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
}
.search-lw-list:hover{
    --tw-bg-opacity: 1;
    background-color: rgba(37, 99, 235, var(--tw-bg-opacity));
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
}
.search-lw2-list2{
    /* bg-gray-100 */
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    /* p-2 */
    padding: 0.5rem/* 8px */;
    /* w-full */
    width: 100%;
    /* text-center */
    text-align: center;
    /* border-gray-300 */
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
    /* font-bold */
    font-weight: 700;
}
.search-lw2-list2:hover{
    /* hover:bg-blue-600 */
    --tw-bg-opacity: 1;
    background-color: rgba(37, 99, 235, var(--tw-bg-opacity));
    /* hover:text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
}
/* bg-blue-300 */
.search-lw-list-h{
    --tw-bg-opacity: 1;
    background-color: rgba(147, 197, 253, var(--tw-bg-opacity));
}
/* pr-2 font-bold text-right */
.search-lw-list-name{
    padding-right: 0.5rem/* 8px */;
    font-weight: 700;
    text-align: right;
}
.search-lw-list-proj{
    padding-right: 0.5rem/* 8px */;
    font-weight: 700;
}
/* pl-2 text-left */
.search-lw-list-email{
    padding-left: 0.5rem/* 8px */;
    text-align: left;
}
/* w-full p-2 text-center text-gray-600 bg-gray-100 border-gray-300 */
.search-lw-list-none{
    width: 100%;
    padding: 0.5rem/* 8px */;
    text-align: center;
    --tw-text-opacity: 1;
    color: rgba(75, 85, 99, var(--tw-text-opacity));
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity));
}
.search-lw2-text{
    /* h-6 */
    height: 1.5rem/* 24px */;
    /* mb-5 */
    margin-bottom: 1.25rem/* 20px */;
    /* ml-1 */
    margin-left: 0.25rem/* 4px */;
}
.search-lw2-text-r{
    /* font-bold */
    font-weight: 700;
    /* text-red-700 */
    --tw-text-opacity: 1;
    color: rgba(185, 28, 28, var(--tw-text-opacity));
}
/* focus:bg-gray-200 */
.search-lw2-select{
    /* w-full */
    width: 100%;
    /* p-3 */
    padding: 0.75rem/* 12px */;
    /* mt-1 */
    margin-top: 0.25rem/* 4px */;
    /* mb-5 */
    margin-bottom: 1.25rem/* 20px */;
    /* text-xl */
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;
    /* font-black */
    font-weight: 900;
    /* bg-gray-100 */
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
    /* border-none */
    border-style: none;
    /* rounded-sm */
    border-radius: 0.125rem/* 2px */;
}
.search-lw2-button{
    /* w-full */
    width: 100%;
    /* pt-3 */
    padding-top: 0.75rem/* 12px */;
    /* pb-3 */
    padding-bottom: 0.75rem/* 12px */;
    /* mt-2 */
    margin-top: 0.5rem/* 8px */;
    /* text-xl */
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;
    /* font-bold */
    font-weight: 700;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
    /* bg-green-500 */
    --tw-bg-opacity: 1;
    background-color: rgba(16, 185, 129, var(--tw-bg-opacity));
    /* border-none */
    border-style: none;
    /* cursor-pointer */
    cursor: pointer;
    /*  rounded-xl */
    border-radius: 0.75rem/* 12px */;
    /* opacity-90 */
    opacity: 0.9;
}
.search-lw2-button:hover{
    /* hover:opacity-100 */
    opacity: 1;
}
.search-lw2-button:disabled{
    /* disabled:opacity-50 */
    opacity: 0.5;
}

/* .l-scroll{
    height: 1rem;
    overflow-y: scroll;
} */

/* adminLTE */
.card{
    margin-bottom: 0.25rem;
}
.card-title{
    width: 55%;
    /* text-xl */
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;
    /* font-bold */
    font-weight: 700;
    /* text-right */
    text-align:right;
    /* text-white */
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
}
.card-body{
    padding: 0;
}
</style>
