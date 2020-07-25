const openTab = document.querySelectorAll('[data-tab-target]')
openTab.forEach(a => {
    a.addEventListener('click',() => {
        const tab=document.querySelector(a.dataset.tabTarget)
        opentab(tab)
    })
})
function opentab(tab){
    if(tab==null) return
    const sections=document.querySelectorAll('section');
    sections.forEach(section=>{
        section.classList.remove('active')
        section.classList.add('inactive')
        
    });
    tab.classList.add('active');
    tab.classList.remove('inactive');
}
