document.querySelector('#all').onchange = function() {
	document.querySelectorAll(this.dataset.select)
	.forEach(el => el.checked = this.checked)
}
document.querySelector('#create').onclick = function() {
	document.querySelectorAll('.create')
	.forEach(el => el.hidden = false)
}
document.querySelector('#cancel').onclick = function() {
	document.querySelectorAll('.create')
	.forEach(el => el.hidden = true)
}