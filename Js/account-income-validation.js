const loginForm = document.getElementById('incomeForm')
const income_amount = document.getElementById('income-amount')
const income_sub = document.getElementById('income-sub-category')
const income_date = document.getElementById('income-date')
const income_desc = document.getElementById('income-desc')
const income_mode = document.getElementById('income-mode')
const error_income_add = document.getElementById('errorAddingIncome')

loginForm.addEventListener('submit',(e) =>{
    let messages=[]
    if(income_amount.value === 0 || income_amount.value === null || income_amount.value === ""){
        messages.push('Error: Amount Cant be Zero, Null Or Vacant \n');
    }
    if(income_sub.value === "none"){
        messages.push('Error: Sub Category not selected \n');
    }
    if(income_date.value === "0000-00-00" || income_date.value == ""){
        messages.push('Error: Date not Mentioned \n');
    }
    if(income_mode.value === "none"){
        messages.push('Error: Income Mode not specified \n');
    }
    if(messages.length > 0){
        e.preventDefault()
        error_income_add.innerText = messages.join(' ');
    }
})