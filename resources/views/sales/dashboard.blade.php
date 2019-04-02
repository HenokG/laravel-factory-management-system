@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3 justify-content-center">
            @include('sidebar')
            <div class="col-md-9">
                <h2>Welcome :)</h2>
                <ul class="my-3">
                    <li>Click '<b>Proforma No Import Excel</b>' to import excel file with proforma no</li>
                    <li>Click '<b>Delivery No Import Excel</b>' to import excel file with delivery no</li>
                </ul>

                <button type="file" class="btn bg-primary-color mb-3" id="proformaExcel"
                        onclick="onProformaImportClick()">
                    Proforma No Import Excel
                </button>
                <button type="button" class="btn bg-primary-color mb-3" id="deliveryExcel"
                        onclick="onDeliveryImportClick()">
                    Delivery No Import Excel
                </button>
                <input type="file" id="proformaExcelFileInput" class="invisible">
                <input type="file" id="deliveryExcelFileInput" class="invisible">

                <table class="table table-hover my-5" id="myTable">

                    <tbody>

                    </tbody>
                </table>

                <button type="button" class="btn bg-primary-color my-5 invisible" id="sendToSystem"
                        onclick="onSendToSystem()">
                    Send to System
                </button>
            </div>
        </div>

    </div>
    <script src="/frameworks/xlsx.full.min.js"></script>
    <script src="/js/excel_importer.js"></script>
    <script src="/js/customers.js"></script>
    <script>
        function onProformaImportClick() {
            $("#proformaExcelFileInput").click();
        }

        function onDeliveryImportClick() {
            $("#deliveryExcelFileInput").click();
        }
    </script>
    <!-- Company Modal END -->

@endsection