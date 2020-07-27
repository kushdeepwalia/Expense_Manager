const proForm = document.getElementById('profileForm')
const proUser = document.getElementById('updateUser')
const proPass = document.getElementById('updatePassword')
const proEmail = document.getElementById('updateEmail')
const proWallet = document.getElementById('updateWallet')
const error_profile = document.getElementById('profileUpdateError')

proForm.addEventListener('submit', (e) =>{
    let messages=[];
    if(proUser.value === '' || proUser.value === null){
        messages.push('Error: Username Not Entered \n');
    }
    if(proWallet.value === '' || proWallet.value === null){
        messages.push('Error: Wallet Name Not Entered \n');
    }
    if(proPass.value.length === 0){
        messages.push('Error: Password Not Entered \n');
    }
    else if(proPass.value.length < 6){
        messages.push('Error: Password Must be greater than 6 char \n');
    }
    else if(proPass.value.length > 20){
        messages.push('Error: Password Must be less than 20 char \n');
    }
    a=proEmail.value;
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
        error_profile.innerText = messages.join(' ');
    }
})