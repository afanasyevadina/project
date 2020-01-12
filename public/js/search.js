document.querySelectorAll("[data-search]")
.forEach(field => field.oninput = function() {
    var query = this.value.toLowerCase()
    document.querySelectorAll(this.getAttribute("data-search"))
    .forEach(el => el.hidden = el.innerHTML.toLowerCase().indexOf(query) < 0)
})