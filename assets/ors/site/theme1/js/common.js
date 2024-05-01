/* Login Model */
function loadDynamicContentModal(serviceId) {
    // const domain = window.location.origin;
    const domain = "services/login/logout.html";

    let frame = '<iframe is="x-frame-bypass" id="iframeIdLogin" src="' + domain + '/loginWindow.do?servApply=N&&lt;csrf:token%20uri=%27loginWindow.do%27/&gt;" style="width: 100%; height: 430px; border: none;"></iframe>';

    if (serviceId != '0000') {
        let sendurl = domain + "/directApply.do?serviceId=" + serviceId;
        // console.log(sendurl);

        frame = '<iframe is="x-frame-bypass" id="iframeIdLogin" src="' + sendurl + '" style="width: 100%; height: 430px; border: none;"></iframe>';
    }

    $('#loginModel .modal-body').html(frame);

    const myModalEl = document.getElementById('loginModel');
    const modal = new bootstrap.Modal(myModalEl, { keyboard: true });
    modal.show();
    
    ///////////////////////////////////
    
    const iFrame = document.getElementById('iframeIdLogin');
    console.log(iFrame);

    iFrame.addEventListener('load', function (event) {
    
    const preTag = iFrame.contentWindow.document.querySelector('pre');

    //console.log(preTag);
    
});
    
    
}


function formatNumber(num, notation = 'standard') {
    // console.log(num);

    return new Intl.NumberFormat('en-IN', {
        style: "decimal",
        // maximumSignificantDigits: 3,
        notation: notation
    }).format(num);
}



$(document).ready(function () {

    /* Enable tooltips globally */

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });


    /* New Login popup click handler */
    $('.new-login').on('click', function (event) {
        
        event.preventDefault();
        
        const myModalEl = document.getElementById('newLoginModel');
        const modal = new bootstrap.Modal(myModalEl, { keyboard: true });
        modal.show();
    });

    /* Serviceplus login model */
    $('.servicePluslogin').on('click', function (event) {

        event.preventDefault();
        loadDynamicContentModal('0000');
    });



    // El-search 
    $('.search').click(function (event) {
        event.preventDefault();

        $('#el-search-form').slideToggle('fast');

        document.getElementById('el-search').focus();
    });


    // Service APPLY button
    $('#service-apply-btn, .skill_apply_btn').on('click', function (event) {

        loadDynamicContentModal($(this).data('service-id'));
    });


    // Footer links
    $('.ord-footer-links > li').on('click', function (event) {
        event.preventDefault();

        // privacy policy 
        if (event.currentTarget.matches('.ord-footer-links > li:nth-child(2)')) {
            $('#footerModal .modal-title').html(privacyTitle);
            $('#footerModal .modal-body').html(privacyContent);

            const myModalEl = document.getElementById('footerModal');
            const modal = new bootstrap.Modal(myModalEl, { keyboard: true });
            modal.show();
        }
        else if (event.currentTarget.matches('.ord-footer-links > li:nth-child(1)')) {   // TnC
            $('#footerModal .modal-title').html(tncTitle);
            $('#footerModal .modal-body').html(tncContent);

            const myModalEl = document.getElementById('footerModal');
            const modal = new bootstrap.Modal(myModalEl, { keyboard: true });
            modal.show();
        }
        else if (event.currentTarget.matches('.ord-footer-links > li:nth-child(3)')) {   // copyright
            $('#footerModal .modal-title').html(copyrightTitle);
            $('#footerModal .modal-body').html(copyrightContent);

            const myModalEl = document.getElementById('footerModal');
            const modal = new bootstrap.Modal(myModalEl, { keyboard: true });
            modal.show();
        }
        else if (event.currentTarget.matches('.ord-footer-links > li:nth-child(4)')) {   // Rnc
            $('#footerModal .modal-title').html(rncTitle);
            $('#footerModal .modal-body').html(rncContent);

            const myModalEl = document.getElementById('footerModal');
            const modal = new bootstrap.Modal(myModalEl, { keyboard: true });
            modal.show();
        }
        else {
            window.location.href = event.target.href;
        }

    });



    const rootElement = document.documentElement;  // root element of the doc (HtmlElement)
    const scrollToTopBtn = document.querySelector('.scrollToTopBtn');

    scrollToTopBtn.addEventListener('click', function (event) {
        rootElement.scrollTo({ top: 0 });
    });


    document.addEventListener('scroll', function (event) {

        if (rootElement.scrollTop > 300) {

            // Show button
            scrollToTopBtn.classList.add('showBtn');
        }
        else {

            // Hide button
            scrollToTopBtn.classList.remove('showBtn');
        }

    }, { passive: true });


    // Portal Alert Dialog
    if (Boolean(siteAlertFlag) && (window.location.pathname == '/' || window.location.pathname == '/site') ) {
        $('#footerModal .modal-title').html(siteAlertTitle);
        $('#footerModal .modal-body').html(siteAlertMsg);

        const myModalEl = document.getElementById('footerModal');
        const modal = new bootstrap.Modal(myModalEl, { keyboard: true, backdrop: 'static' });
        modal.show();
    }

});
