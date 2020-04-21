/*window.onscroll = function(e) {
    var menu = this.document.getElementById('navbar')
    if(window.scrollY + window.innerHeight <= menu.clientHeight) {
        menu.style.bottom = null
        menu.style.top = 56 - window.scrollY + 'px'
    } else {
        menu.style.top = null
        menu.style.bottom = '0px'
    }
}*/
document.getElementById('menu-toggle').addEventListener('click', function() {
	var navbar = document.getElementById('navbar')
	navbar.classList.toggle('navbar-hidden')
})