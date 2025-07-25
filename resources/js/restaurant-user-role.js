document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-user-role');
    const container = document.getElementById('user-role-container');
    let index = 1;

    if (!addBtn || !container) return;

    addBtn.addEventListener('click', () => {
        const template = document.createElement('template');
        template.innerHTML = document
            .getElementById('user-role-template')
            .innerHTML.replace(/__INDEX__/g, index);
        container.appendChild(template.content.firstElementChild);
        index++;
    });
});
