@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">
            <div><h1 class="generic-title">@lang('cookies.title')</h1></div>
            <div><h2 class="generic-subtitle">@lang('cookies.subtitle')</h2></div>
        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10 who-padding">
                    <p class="text-justify">@lang('cookies.p1')</p>
                    <h4>@lang('cookies.t2')</h4>
                    <p class="text-justify">@lang('cookies.p2')</p>
                    <h4>@lang('cookies.t3')</h4>
                    <p class="text-justify">@lang('cookies.p3')</p>
                    {{--Tabla1--}}
                    <h5 class="text-center full-width">@lang('cookies.table1.title')</h5>
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('cookies.table1.th1')</th>
                                <th>@lang('cookies.table1.th2')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>@lang('cookies.table1.tr1.td1')</td>
                                <td>@lang('cookies.table1.tr1.td2')</td>
                            </tr>
                            <tr>
                                <td>@lang('cookies.table1.tr2.td1')</td>
                                <td>@lang('cookies.table1.tr2.td2')</td>
                            </tr>
                        </tbody>
                    </table>
                    {{--Tabla2--}}
                    <h5 class="text-center full-width">@lang('cookies.table2.title')</h5>
                    <table class="table table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('cookies.table2.th1')</th>
                            <th>@lang('cookies.table2.th2')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>@lang('cookies.table2.tr1.td1')</td>
                            <td>@lang('cookies.table2.tr1.td2')</td>
                        </tr>
                        <tr>
                            <td>@lang('cookies.table2.tr2.td1')</td>
                            <td>@lang('cookies.table2.tr2.td2')</td>
                        </tr>
                        <tr>
                            <td>@lang('cookies.table2.tr3.td1')</td>
                            <td>@lang('cookies.table2.tr3.td2')</td>
                        </tr>
                        <tr>
                            <td>@lang('cookies.table2.tr4.td1')</td>
                            <td>@lang('cookies.table2.tr4.td2')</td>
                        </tr>
                        <tr>
                            <td>@lang('cookies.table2.tr5.td1')</td>
                            <td>@lang('cookies.table2.tr5.td2')</td>
                        </tr>
                        </tbody>
                    </table>
                    <h4>@lang('cookies.t4')</h4>
                    <p class="text-justify">@lang('cookies.p4')</p>
                    <h4>@lang('cookies.t5')</h4>
                    <p class="text-justify">@lang('cookies.p5')</p>
                    <h4>@lang('cookies.t6')</h4>
                    <p class="text-justify">@lang('cookies.p6')</p>
                    {{--Enlaces--}}
                    <h5>@lang('cookies.browser1')</h5>
                    <ul>
                        <li>@lang('cookies.link1.t1'): <a href="{{ Lang::get('cookies.link1.l1') }}" target="_blank">@lang('cookies.link1.l1')</a></li>
                        <li>@lang('cookies.link1.t2'): <a href="{{ Lang::get('cookies.link1.l2') }}" target="_blank">@lang('cookies.link1.l2')</a></li>
                        <li>@lang('cookies.link1.t3'): <a href="{{ Lang::get('cookies.link1.l3') }}" target="_blank">@lang('cookies.link1.l3')</a></li>
                        <li>@lang('cookies.link1.t4'): <a href="{{ Lang::get('cookies.link1.l4') }}" target="_blank">@lang('cookies.link1.l4')</a></li>
                        <li>@lang('cookies.link1.t5'): <a href="{{ Lang::get('cookies.link1.l5') }}" target="_blank">@lang('cookies.link1.l5')</a></li>
                    </ul>
                    <h5>@lang('cookies.browser2')</h5>
                    <ul>
                        <li><a href="{{ Lang::get('cookies.link2') }}" target="_blank">@lang('cookies.link2')</a></li>
                    </ul>
                    <h5>@lang('cookies.browser3')</h5>
                    <ul>
                        <li><a href="{{ Lang::get('cookies.link3') }}" target="_blank">@lang('cookies.link3')</a></li>
                    </ul>
                    <h5>@lang('cookies.browser4')</h5>
                    <ul>
                        <li><a href="{{ Lang::get('cookies.link4.l2') }}" target="_blank">@lang('cookies.link4.l2')</a></li>
                    </ul>
                    <h4>@lang('cookies.t7')</h4>
                    <p class="text-justify">@lang('cookies.p7')</p>
                    <h4>@lang('cookies.t8')</h4>
                    <p class="text-justify">@lang('cookies.p8')</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection
