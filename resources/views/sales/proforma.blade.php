@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3 justify-content-center">
            @include('sidebar')
            <div class="col-md-9">
                <h2 class="font-weight-bold">Firdows General Import Export and Commission Agent P.L.C</h2>
                <ul class="my-3">
                    <li>Company: <b>{{ $order->company_name }}</b></li>
                    <li>Proforma No: <b>{{$order->created_at->year . $order->proforma_no }}</b></li>
                    <li>Fs No: <b>{{$order->fsno }}</b></li>
                    <li>Delivery Date: <b>{{ $order->delivery_date }}</b></li>
                    <li>Delivery Date ETH: <b>{{ $order->delivery_date_et }}</b></li>
                </ul>

                <button type="button" class="btn bg-primary-color my-4 px-4" onclick="print();">
                    Print
                </button>
                <table class="table table-hover" id="myTable">

                    <tbody>

                    </tbody>
                </table>
                <div class="my-5">
                    <b>{!! $order->note !!}</b>
                </div>
            </div>
        </div>

    </div>
    <script src="/frameworks/xlsx.full.min.js"></script>
    <script src="/js/excel_importer.js"></script>
    <script>

        console.log({!! $proforma !!});
        $(document).ready(
            displayTable({!! $proforma !!})
        )
    </script>
@endsection