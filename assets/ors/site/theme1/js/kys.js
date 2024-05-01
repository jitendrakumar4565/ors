$(document).ready(function () {

    // For Basundhara Field Mutation Service Modification
    $('button[data-apply-alt]').on('click', function () {

        $('#footerModal .modal-title').html(kysAsk);
        let html = '<ul class="list-group list-group-flush">';

        // console.log(serviceList, lang);

        for (const item of serviceList) {
            html += `
         <li class="list-group-item"><a class="text-decoration-none" href="${item.url}" target="_blank" rel="noopener noreferrer">${item[lang]}</a></li>
         `;
        }
        html += '</ul>';

        $('#footerModal .modal-body').html(html);
        
        const myModalEl = document.getElementById('footerModal');
        const modal = new bootstrap.Modal(myModalEl, { keyboard: true, backdrop: 'static' });
        modal.show();

    });


});
