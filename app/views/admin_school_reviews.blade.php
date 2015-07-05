@extends('layout')
@section('content')

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h1>@lang('adminpanel.reviews.title_school') <small>@lang('adminpanel.reviews.dashboard')</small></h1>
                </div>
                <div class="pull-right">
                    <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default">@lang('buttons.back')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="float-right">{{ $reviews->links() }}</div>
        @if ($reviews->isEmpty())
            <p>@lang('adminpanel.reviews.not_found')</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>@lang('adminpanel.reviews.date')</th>
                    <th>@lang('adminpanel.reviews.who')</th>
                    <th>@lang('adminpanel.reviews.review')</th>
                    <th>@lang('adminpanel.reviews.rating')</th>
                    <th>@lang('adminpanel.reviews.course')</th>
                    <th>@lang('adminpanel.reviews.school')</th>
                    <th>@lang('adminpanel.reviews.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->created_at }}</td>
                        <td>{{ $review->reviewer }}</td>
                        <td>{{ $review->comment }}</td>
                        <td>{{ $review->value }}</td>
                        <td>{{ $review->lesson_reviewed }}</td>
                        <td><a href="{{ url('academia',$review->slug) }}" target="_blank">{{ $review->reviewed }}</a></td>
                        <td>
                            <a href="{{ url('admin/delete/school/review',$review->id) }}" class="btn btn-danger">@lang('buttons.delete')</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="panel panel-default">
                <div class="panel-body">
                    @lang('common.showing') {{ $reviews->getFrom() }}-{{ $reviews->getTo() }} @lang('common.from-total') {{ $reviews->getTotal() }} @lang('common.reviews').
                </div>
            </div>
        @endif
        <div class="float-right">{{ $reviews->links() }}</div>
    </div>

@endsection
