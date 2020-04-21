var forms = document.querySelectorAll('form.self-reload')
for (var i = 0; i < forms.length; i++) {
    forms[i].addEventListener('submit', function (e) {
        e.preventDefault()
        var submit = this.querySelector('[type=submit]')
        if(submit) {
            var submitText = submit.value
            submit.minWidth = submit.clientWidth + 'px'
            submit.value = 'Loading...'
        }
        var elements = this.querySelectorAll('[name]')
        var result = []
        for(var c = 0; c< elements.length; c++) {
            if(['checkbox', 'radio'].includes(elements[c].type) && !elements[c].checked) continue;
            if(!elements[c].disabled) {
                result.push(elements[c].name + '=' + elements[c].value)
            }
        }
        window.axios.post(this.action, result.join('&'))
        .then(response => {
            if(document.querySelector(this.dataset.alert)) {
                document.querySelector(this.dataset.alert).hidden = false
                setTimeout(() => document.querySelector(this.dataset.alert).hidden = true, 3000)
                if(submit) submit.value = submitText
            } else {
                window.location.reload()
            }
        })
        return false
    })
}

var links = document.querySelectorAll('a.self-reload')
for (var i = 0; i < links.length; i++) {
    links[i].addEventListener('click', function (e) {
        e.preventDefault()
        this.style.minWidth = this.clientWidth + 'px'
        this.innerHTML = 'Loading...'
        window.axios.get(this.href)
        .then(response => {
            if(document.querySelector(this.dataset.alert)) {
                document.querySelector(this.dataset.alert).hidden = false
            } else {
                window.location.reload()
            }
        })
        return false
    })
}