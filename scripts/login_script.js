function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

let login_tab = document.getElementById("login_tab");

let register_tab = document.getElementById("register_tab");

let active_tab = login_tab;

let username_login = document.querySelector("#login_form > input[type='text']");

let password_login = document.querySelector("#login_form > input[type='password']");

let submit_login = document.querySelector("#login_form > input[type='submit']");

let username_register = document.querySelector("#register_form > input[type='text']");

let password_register = document.querySelector("#register_form > input[type='password']");

let email_register = document.querySelector("#register_form > input[type='email']");

let submit_register = document.querySelector("#register_form > input[type='submit']");

let login_form = document.querySelector("#login_form");

let register_form = document.querySelector("#register_form");

register_tab.addEventListener('click', event =>{
    console.log("register clicked");
    if(active_tab == login_tab){
        register_tab.style.borderBottom = "none";
        register_tab.style.borderRight = "none";
        register_tab.style.borderTop = "4px solid #00a2e8";
        register_tab.style.backgroundColor="#fff";
        login_tab.style.borderBottom="1px solid #ccc";
        login_tab.style.borderLeft="1px solid #ccc";
        login_tab.style.borderTop = "4px solid #ccc";
        login_tab.style.backgroundColor = "inherit";
        register_form.style.display = "flex";
        login_form.style.display = "none";
        active_tab = register_tab;
    }
});

login_tab.addEventListener('click',event =>{
    if (active_tab == register_tab){
        login_tab.style.borderBottom = "none";
        login_tab.style.borderLeft = "none";
        login_tab.style.borderTop = "4px solid #00a2e8";
        login_tab.style.backgroundColor="#fff";
        register_tab.style.borderBottom="1px solid #ccc";
        register_tab.style.borderLeft="1px solid #ccc";
        register_tab.style.borderTop = "4px solid #ccc";
        register_tab.style.backgroundColor = "inherit";
        login_form.style.display = "flex";
        register_form.style.display = "none";
        active_tab = login_tab;
    }
});

submit_login.addEventListener('mouseover',event =>{
    submit_login.style.backgroundColor = "#0078e8";
});

submit_login.addEventListener('mouseout',event =>{
    submit_login.style.backgroundColor = "#00a2e8";
});

submit_register.addEventListener('mouseover',event =>{
    submit_register.style.backgroundColor = "#0078e8";
});

submit_register.addEventListener('mouseout',event =>{
    submit_register.style.backgroundColor = "#00a2e8";
});


login_tab.addEventListener('mouseover',event=>{
    if (active_tab == register_tab)
    login_tab.style.borderTop = "4px solid #00a2e8";
    login_tab.style.backgroundColor="#fff";
});

register_tab.addEventListener('mouseover', event =>{
    register_tab.style.borderTop = "4px solid #00a2e8";
    register_tab.style.backgroundColor="#fff";
});

login_tab.addEventListener('mouseout',event =>{
    if (active_tab == register_tab){
        login_tab.style.borderTop = "4px solid #ccc";
        login_tab.style.backgroundColor = "inherit";
    }
});

register_tab.addEventListener('mouseout', event =>{
    if (active_tab == login_tab){
        register_tab.style.borderTop = "4px solid #ccc";
        register_tab.style.backgroundColor="#inherit";
    }
});

username_login.addEventListener('focus',event =>{
    username_login.style.backgroundColor = "#fff";
});

password_login.addEventListener("focus",event =>{
    password_login.style.backgroundColor = "#fff";
});

username_login.addEventListener('blur',event =>{
    username_login.style.backgroundColor = "#eee";
});

password_login.addEventListener("blur",event =>{
    password_login.style.backgroundColor = "#eee";
});

submit_login.addEventListener('click',event =>{
    let invalidFlag = 0;
    if (username_login.value.length == 0){
        username_login.style.backgroundColor = "#ff3333";
        invalidFlag = 1;
    }
    if (password_login.value.length == 0){
        password_login.style.backgroundColor = "#ff3333";
        invalidFlag = 1;
    }
    if (invalidFlag){
        return;
    }
    let request = new XMLHttpRequest();
    let csrfValue = document.getElementById('csrf').value;
    request.addEventListener("load", loginComplete);
    request.open("post","../action_login.php",true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({
        username: username_login.value,
        password: password_login.value,
        csrf: csrfValue
    }));
});



username_register.addEventListener('focus',event =>{
    username_register.style.backgroundColor = "#fff";
});

password_register.addEventListener("focus",event =>{
    password_register.style.backgroundColor = "#fff";
});

email_register.addEventListener("focus", event => {
    email_register.style.backgroundColor = "#fff";
})

username_register.addEventListener('blur',event =>{
    username_register.style.backgroundColor = "#eee";
});

password_register.addEventListener("blur",event =>{
    password_register.style.backgroundColor = "#eee";
});

email_register.addEventListener("blur",event =>{
    email_register.style.backgroundColor = "#eee";
});

submit_register.addEventListener('click',event =>{
    let invalidFlag = 0;
    if (username_register.value.length == 0){
        username_register.style.backgroundColor = "#ff3333";
        invalidFlag = 1;
    }
    if (email_register.value.length == 0 || email_register.value.indexOf('@') < 0){
        email_register.style.backgroundColor = "#ff3333";
        invalidFlag = 1;
    }
    if (password_register.value.length == 0){
        password_register.style.backgroundColor = "#ff3333";
        invalidFlag = 1;
    }
    if (invalidFlag){
        return;
    }
    let csrfValue = document.getElementById('csrf').value;
    let request = new XMLHttpRequest();
    request.addEventListener("load", registerComplete);
    request.open("post","../action_register.php",false);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({
        username: username_register.value,
        email: email_register.value ,
        password: password_register.value,
        csrf: csrfValue
    }));
});


function loginComplete(event){
    console.log(this.responseText);
    if (this.responseText == '-1'){
        alert('User does not exist');
    }else if (this.responseText == '-2'){
        alert('Incorrect Password');
    }else{
       document.location.href = '../index.php';
    }
}

function registerComplete(event){
    console.log(this.responseText);
    if (this.responseText == '-1'){
        alert('Email registered already');
    }else if (this.responseText == '-2'){
        alert('User does not exist');
    }else{
       document.location.href = '../index.php';
    }
}
