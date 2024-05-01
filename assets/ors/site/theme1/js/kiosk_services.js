$(document).ready(function () {

    // DataTable Config
    const table = $('#example')
        .DataTable({
            pageLength: 10,
            order: [[0, 'asc'], [1, 'asc']],
            scrollX: true,
            processing: true,
            deferRender: true,
            language: {
                url: langPath
            },

        });


    /* Listener for DataTable events */

    $('#example').on('draw.dt', function () {
        // Add/Remove Dark Mode

        switch (localStorage.getItem('ors-dark-mode')) {
            case 'light':

                $('.dataTable .odd > td').removeClass('line-color');
                $('.dataTables_info, .dataTables_length, .dataTables_filter').removeClass('line-color');
                $('.ors-btn').removeClass('link-color');

                break;

            case 'dark':

                $('.dataTable .odd > td').addClass('line-color');
                $('.ors-btn').addClass('link-color');
                $('.dataTables_info, .dataTables_length, .dataTables_filter').addClass('line-color');

        }

    });

});