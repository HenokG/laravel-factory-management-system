@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3">
            @include('sidebar')
            <div class="col-md-9">
                @php
                    $company = \App\Company::find(session()->get(\App\Util\FinalConstants::SESSION_COMPANYID_LABEL));
                @endphp
                <h2>{{$company->name}} General Import Export and Commission Agent P.L.C</h2>
                @if(isset($order_descriptions) && count($order_descriptions) != 0)
                <ul class="float-right">
                    <li>Performa No   {{$order_descriptions[0]->performa_no}}</li>
                    <li>Delivery No   {{$order_descriptions[0]->order['delivery_no']}}</li>
                    <li>Date {{now()}}</li>
                </ul>
                @endif
                <form action="mail-order">
                    <input type="hidden" name="to_manager" value="{{$company->manager_email}}">
                    <input type="hidden" name="to_owner" value="{{$company->owner_email}}">
                    <button type="button" class="btn bg-primary-color mb-3 print" onclick="window.print()">
                        <i class="ion-ios-printer"></i> Print &amp; Send Email
                    </button>
                </form>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Material Name</th>
                        <th scope="col">Material Type</th>
                        <th scope="col">Length</th>
                        <th scope="col">Width</th>
                        <th scope="col">Thickness</th>
                        <th scope="col">PCS</th>
                        <th scope="col">M1</th>
                        <th scope="col">M2</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Remark</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--for displaying subtotal and m1 total--}}
                    @php
                        $m1_total = 0;
                        $sub_total = 0;

                        $current_material = null;
                    @endphp
                    @foreach($order_descriptions as $order_description)
                        @php
                            if($current_material == null){
                                $current_material = $order_description->material_name;
                            }
                            if($current_material == $order_description->material_name){
                                $m1_total += $order_description->m1;
                                $sub_total += $order_description->m2;
                            }else{
                                echo "<tr class='bg-light'><th scope='row'>M1</th><td></td><td></td><td></td><td></td><td></td><td><b>" . $m1_total . "</b></td><td></td><td></td><td></td><td></td>" . "<tr class='bg-grey'><th scope='row'>Sub Total</th><td></td><td></td><td></td><td></td><td></td><td></td><td><b>" . $sub_total . "</b></td><td></td><td></td><td></td>";
                                $current_material = $order_description->material_name;
                                $sub_total = 0;
                                $m1_total = 0;
                            }

                        @endphp
                        <tr id="{{$order_description->performa_no}}">
                            <td scope="row">{{$order_description->material_name}}</td>
                            <td>{{$order_description->material_type}}</td>
                            <td>{{$order_description->length}}</td>
                            <td>{{$order_description->width}}</td>
                            <td>{{$order_description->thickness}}</td>
                            <td>{{$order_description->pcs}}</td>
                            <td>{{$order_description->m1}}</td>
                            <td>{{$order_description->m2}}</td>
                            <td>{{$order_description->unit_price}}</td>
                            <td>{{$order_description->amount}}</td>
                            <td>{{$order_description->remark}}</td>
                        </tr>
                        @php

                            if($loop->last){
                                echo "<tr class='bg-light'><th scope='row'>M1</th><td></td><td></td><td></td><td></td><td></td><td><b>" . $m1_total . "</b></td><td></td><td></td><td></td><td></td></tr>" . "<tr class='bg-grey'><th scope='row'>Sub Total</th><td></td><td></td><td></td><td></td><td></td><td></td><td><b>" . $sub_total . "</b></td><td></td><td></td><td></td></tr>";
                            }

                        @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Company Modal END -->

@endsection