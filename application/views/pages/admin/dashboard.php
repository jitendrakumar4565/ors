<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webviewer/8.2.1/webviewer.min.js"></script>
<style>
    #pdf {
        width: 100%;
        height: 520px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12" id="pdf">
                sdfs
            </div>

        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        const url = 'https://apssb.nic.in/upload/RECINS001/answer_key_mts_2023_examiation.pdf';
        const loadingTask = pdfjsLib.getDocument(url);

        // Render the PDF document in an embedded viewer
        const viewerUrl = 'https://mozilla.github.io/pdf.js/web/viewer.html?file=' + encodeURIComponent(url) + '&toolbar=1&navpanes=0&disableTextLayer=false&download=1&zoom=1';
        const viewerElement = document.getElementById('pdf');
        //  viewerElement.innerHTML = "ready";
        viewerElement.innerHTML = '<iframe src="' + viewerUrl + '" style="border: none; width: 100%; height: 100%;"></iframe>';
    });

    // Load the PDF document

</script>
-->