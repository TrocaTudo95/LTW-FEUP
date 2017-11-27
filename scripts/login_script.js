let login_tab = document.getElementById("login_tab");

let sign_in_tab = document.getElementById("sign_in_tab");

let active_tab = login_tab;

sign_in_tab.addEventListener('click', event =>{
    if(active_tab == login_tab){
        sign_in_tab.style.borderBottom = "none";
        sign_in_tab.style.borderRight = "none";
        sign_in_tab.style.borderTop = "4px solid #00a2e8";
        sign_in_tab.style.backgroundColor="#fff";
        login_tab.style.borderBottom="1px solid #ccc";
        login_tab.style.borderLeft="1px solid #ccc";
        login_tab.style.borderTop = "4px solid #ccc";
        login_tab.style.backgroundColor = "inherit";
        active_tab = sign_in_tab;
    }
});

login_tab.addEventListener('click',event =>{
    if (active_tab == sign_in_tab){
        login_tab.style.borderBottom = "none";
        login_tab.style.borderLeft = "none";
        login_tab.style.borderTop = "4px solid #00a2e8";
        login_tab.style.backgroundColor="#fff";
        sign_in_tab.style.borderBottom="1px solid #ccc";
        sign_in_tab.style.borderLeft="1px solid #ccc";
        sign_in_tab.style.borderTop = "4px solid #ccc";
        sign_in_tab.style.backgroundColor = "inherit";
        active_tab = login_tab;
    }
});


login_tab.addEventListener('mouseover',event=>{
    if (active_tab == sign_in_tab)
    login_tab.style.borderTop = "4px solid #00a2e8";
    login_tab.style.backgroundColor="#fff";
});

sign_in_tab.addEventListener('mouseover', event =>{
    sign_in_tab.style.borderTop = "4px solid #00a2e8";
    sign_in_tab.style.backgroundColor="#fff";
});

login_tab.addEventListener('mouseout',event =>{
    if (active_tab == sign_in_tab){
        login_tab.style.borderTop = "4px solid #ccc";
        login_tab.style.backgroundColor = "inherit";
    }
});

sign_in_tab.addEventListener('mouseout', event =>{
    if (active_tab == login_tab){
        sign_in_tab.style.borderTop = "4px solid #ccc";
        sign_in_tab.style.backgroundColor="#inherit";
    }
});