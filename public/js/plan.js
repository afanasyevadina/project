document.querySelectorAll('[name="lab"], [name="practice"], [name="project"], [name="theory"]').forEach(el => el.oninput = () => {
    var theory = el.form.elements.theory.value ? parseInt(el.form.elements.theory.value, 10) : 0
    var lab = el.form.elements.lab.value ? parseInt(el.form.elements.lab.value, 10) : 0
    var practice = el.form.elements.practice.value ? parseInt(el.form.elements.practice.value, 10) : 0
    var project = el.form.elements.project.value ? parseInt(el.form.elements.project.value, 10) : 0
    var total = el.form.elements.total
    total.value = theory + lab + practice + project
})

document.querySelectorAll('[name="is_project"]').forEach(el => el.onchange = () => {
    if(!el.checked) el.form.elements.project.disabled.value = ''
    el.form.elements.project.disabled = !el.checked
})

document.querySelectorAll('[name="is_exam"]').forEach(el => el.onchange = () => {
    if(!el.checked) el.form.elements.exam.disabled.value = ''
    if(!el.checked) el.form.elements.consul.disabled.value = ''
    el.form.elements.exam.disabled = !el.checked
    el.form.elements.consul.disabled = !el.checked
})