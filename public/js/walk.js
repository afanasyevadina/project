document.querySelectorAll('.td-input input, .td-input textarea').forEach(el => el.onkeydown = function(event) {
	if([37,38,39,40].includes(event.keyCode)) {
		event.preventDefault()
		var tr, td, input
		switch(event.keyCode) {
			case 40:
			tr = event.path[2].nextElementSibling
			if(tr) {
				td = tr.cells[event.path[1].cellIndex]
				if(td) {
					input = td.querySelector('input, textarea')
					if(input) input.focus()
				}
			}
			break;
			case 38:
			tr = event.path[2].previousElementSibling
			if(tr) {
				td = tr.cells[event.path[1].cellIndex]
				if(td) {
					input = td.querySelector('input, textarea')
					if(input) input.focus()
				}
			}
			break;
			case 39:
			tr = event.path[2]
			if(tr) {
				td = tr.cells[event.path[1].cellIndex + 1]
				if(td) {
					input = td.querySelector('input, textarea')
					if(input) input.focus()
				}
			}
			break;
			case 37:
			tr = event.path[2]
			if(tr) {
				td = tr.cells[event.path[1].cellIndex - 1]
				if(td) {
					input = td.querySelector('input, textarea')
					if(input) input.focus()
				}
			}
			break;
		}
	}
})