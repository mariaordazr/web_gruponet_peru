const showMenu = (toggleId, navbarId, bodyId) =>{
    const toggle = document.getElementById(toggleId),
    navbar = document.getElementById(navbarId),
    bodypadding = document.getElementById(bodyId)

    if(toggle && navbar){
        toggle.addEventListener('click', ()=>{
            navbar.classList.toggle('show1')
            toggle.classList.toggle('rotate')
            bodypadding.classList.toggle('expander')
        })
    }
}
showMenu('nav-toggle','navbar','body')

const linkColor = document.querySelectorAll('.nav__link1');

function colorLink(){
    linkColor.forEach(l => l.classList.remove('active1'));
    this.classList.add('active1');
}

linkColor.forEach(l => l.addEventListener('click', colorLink));