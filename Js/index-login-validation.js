const loginForm = document.getElementById('loginForm')
const Username = document.getElementById('login-Username')
const Password = document.getElementById('login-Password')
const error_login = document.getElementById('error_login')

loginForm.addEventListener('submit',(e) =>{
    let messages=[]
    if(Username.value === '' || Username.value === null){
        messages.push('Error: Username Not Entered \n');
    }
    if(Password.value.length === 0){
        messages.push('Error: Password Not Entered \n');
    }
    else if(Password.value.length < 6){
        messages.push('Error: Password Must be greater than 6 char \n');
    }
    else if(Password.value.length > 20){
        messages.push('Error: Password Must be less than 20 char \n');
    }
    if(messages.length > 0){
        e.preventDefault()
        error_login.innerText = messages.join(' ');
    }
})