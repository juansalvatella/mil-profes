@extends('layout')
@section('content')

<div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
    <div class="container">
    
        <div class="generic-title"><h3>@lang('contact.contact-us')</h3></div>

        <div class="generic-subtitle">@lang('contact.ask-us')</div>

    </div>
</div>
<div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
    <div class="container generic-box top-padding-50 bottom-padding-100 magic-align">

            @if (Session::get('success'))
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
                    </div>
                </div>
            @endif
            @if (Session::get('error'))
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                        <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
                    </div>
                </div>
            @endif

            {{ Form::open(array('action' => 'ContactController@getContactForm','id'=>'contact')) }}

            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-4">

                {{ Form::label('contact_name', @trans('contact.contact_form_name'), array('class'=>'contact-contact-form-label')) }}
                <div class="form-group">
                    {{ Form::text('contact_name', '', array('class'=>'form-control','placeholder'=>@trans('contact.name_placeholder'),'required','maxlength'=>'50','data-error'=>'Rellene este campo.')) }}
                    <small><span class="help-block with-errors"></span></small>
                </div>
                {{ Form::label('contact_subject', @trans('contact.contact_form_subject'), array('class'=>'contact-contact-form-label')) }}
                <div class="form-group">
                    {{ Form::text('contact_subject', '', array('class'=>'form-control','placeholder'=>@trans('contact.subject_placeholder'),'required','maxlength'=>'50','data-error'=>'Rellene este campo.')) }}
                    <small><span class="help-block with-errors"></span></small>
                </div>
                {{ Form::label('contact_message', @trans('contact.contact_form_message'), array('class'=>'contact-contact-form-label')) }}
                <div class="form-group">
                    {{ Form::textarea('contact_message', '', array('rows' => 6, 'class'=>'form-control','placeholder'=>@trans('contact.message_placeholder'),'required','maxlength'=>'1000','data-error'=>'Rellene este campo.')) }}
                    <small><span class="help-block with-errors"></span></small>
                </div>

            </div>

            <div class="col-xs-12  col-sm-4">

                {{ Form::label('contact_lastname', @trans('contact.contact_form_lastname'), array('class'=>'contact-contact-form-label')) }}
                <div class="form-group">
                    {{ Form::text('contact_lastname', '', array('class'=>'form-control','placeholder'=>@trans('contact.lastname_placeholder'),'maxlength'=>'100')) }}
                    <small><span class="help-block with-errors"></span></small>
                </div>
                {{ Form::label('contact_email', @trans('contact.contact_form_email'), array('class'=>'contact-contact-form-label')) }}
                <div class="form-group">
                    {{ Form::email('contact_email', '', array('class'=>'form-control','placeholder'=>@trans('contact.mail_placeholder'),'required','data-error'=>'Introduce una dirección válida de correo electrónico.')) }}
                    <small><span class="help-block with-errors"></span></small>
                </div>

                <div class="col-xs-12 text-left top-padding-25">
                    <div class="row top-buffer-15 contact-contact"><span class="glyphicon glyphicon-earphone contact-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.phone_title') @lang('layout.phone')</div>
                    <div class="row top-buffer-10 contact-contact"><span class="glyphicon glyphicon-envelope contact-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.email_title') @lang('layout.email')</div>
                    <div class="row top-buffer-10 contact-contact"><span class="glyphicon glyphicon-home contact-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.address_title') @lang('layout.address')</div>
                </div>

                <div class="col-xs-12 top-buffer-25 text-left" id="contact-follow">@lang('layout.follow_us')&nbsp;&nbsp;&nbsp;&nbsp;<span id="footer-faicons"><a href="#" class="fa fa-facebook-f"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-twitter"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-linkedin"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-google-plus"></a></span></div>

            </div>

            <div class="col-xs-12 col-sm-offset-2 col-sm-4 clear-left">
                <div class="form-group">
                    {{ Form::submit('Enviar', array('class' => 'btn input-lg contact-form-submit-btn-2')) }}
                </div>
            </div>

            {{ Form::close(); }}
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#contact").validator();
                });
            </script>


    </div>
</div>
<div class="container-fluid background-gblack">
    <hr class="hr-page-end"/>
</div>



    




        



    

@endsection