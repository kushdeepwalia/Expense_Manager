const openModalButtons = document.querySelectorAll('[data-modal-target]')
const closeModalButtons = document.querySelectorAll('[data-close-button]')
const overlay = document.getElementById('overlay')

openModalButtons.forEach(button => {
    button.addEventListener('click',() => {
        const modal=document.querySelector(button.dataset.modalTarget)
        openModal(modal)
    })
})

overlay.addEventListener('click',() => {
    const modals = document.querySelectorAll('.modal.active')
    modals.forEach(modal => {
        closeModal(modal)
    }) 
})
closeModalButtons.forEach(button => {
    button.addEventListener('click',() => {
        const modal= button.closest('.modal')
        closeModal(modal)
    })
})

function openModal(modal){
    if(modal==null) return
    overlay.classList.add('active');
    modal.classList.add('active');
}

function closeModal(modal){
    if(modal==null) return
    overlay.classList.remove('active');
    modal.classList.remove('active');
}