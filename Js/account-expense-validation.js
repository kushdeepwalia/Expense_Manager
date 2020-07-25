const expenseForm = document.getElementById('expenseForm')
const expense_amount = document.getElementById('expense-amount')
const expense_sub = document.getElementById('expense-sub-category')
const expense_date = document.getElementById('expense-date')
const expense_desc = document.getElementById('expense-desc')
const expense_mode = document.getElementById('expense-mode')
const error_expense_add = document.getElementById('errorAddingExpense')

expenseForm.addEventListener('submit',(e) =>{
    let messages=[]
    if(expense_amount.value === 0 || expense_amount.value === null || expense_amount.value === ""){
        messages.push('Error: Amount Cant be Zero, Null Or Vacant \n');
    }
    if(expense_sub.value === "none"){
        messages.push('Error: Sub Category not selected \n');
    }
    if(expense_date.value === "0000-00-00" || expense_date.value == ""){
        messages.push('Error: Date not Mentioned \n');
    }
    if(expense_mode.value === "none"){
        messages.push('Error: Expense Mode not specified \n');
    }
    if(messages.length > 0){
        e.preventDefault()
        error_expense_add.innerText = messages.join(' ');
    }
})