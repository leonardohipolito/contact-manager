import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
document.addEventListener('alpine:init', () => {
    Alpine.magic('deleteModal', () => route => {
        confirm('Confirm exclusion?') && axios.delete(route).then(() => window.location.reload())
    })
})

Alpine.start();
