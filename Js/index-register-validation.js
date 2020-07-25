const registerForm = document.getElementById('registerForm')
const register_Username = document.getElementById('register-Username')
const register_Password = document.getElementById('register-Password')
const ConPassword = document.getElementById('ConPassword')
const Email = document.getElementById('email')
const Wallet = document.getElementById('wallet')
const error_register = document.getElementById('error_register')

registerForm.addEventListener('submit', (e) =>{
    let messages=[]
    if(register_Username.value === '' || register_Username.value === null){
        messages.push('Error: Username Not Entered \n');
    }
    if(Wallet.value === '' || Wallet.value === null){
        messages.push('Error: Wallet Name Not Entered \n');
    }
    if(register_Password.value.length === 0){
        messages.push('Error: Password Not Entered \n');
    }
    else if(register_Password.value.length < 6){
        messages.push('Error: Password Must be greater than 6 char \n');
    }
    else if(register_Password.value.length > 20){
        messages.push('Error: Password Must be less than 20 char \n');
    }
    if(register_Password.value != ConPassword.value){
        messages.push('Error: Password Not Matched \n');
    }
    a=Email.value;
    f1=a.indexOf('@');
    f2=a.indexOf('@',f1+1);
    e1=a.indexOf('.');
    e2=a.indexOf('.',e1+1);
    n=a.length;

    if(!(f1>0 && f2==-1 && e1>0 && e2==-1 && f1!=e1+1 && e1!=f1+1 && f1!=n-1 && e1!=n-1))
    {   
        messages.push('Error: Invalid Email');
    }
    if(messages.length > 0){
        e.preventDefault()
        error_register.innerText = messages.join(' ');
    }
})