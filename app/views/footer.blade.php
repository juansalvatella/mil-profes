<div id="pre-footer">
    <div class="container-fluid" style="padding-top:15px;padding-bottom:15px;">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 text-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/milprofes-logo-3.png') }}" class="hidden-xs hidden-md hidden-lg top-buffer-35" width="100" height="100" alt="milPROFES"/>
                            <img src="{{ asset('img/milprofes-logo-3.png') }}" class="hidden-sm top-buffer-10" width="130" height="130" alt="milPROFES"/>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-8 top-padding-25 bottom-padding-25 text-center">
                        <div class="text-left inline-block">
                            <div class="footer-contact"><span class="glyphicon glyphicon-earphone footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.phone_title') @lang('layout.phone')</div>
                            <div class="top-buffer-10 footer-contact"><span class="glyphicon glyphicon-envelope footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.email_title') @lang('layout.email')</div>
                            <div class="top-buffer-10 footer-contact"><span class="glyphicon glyphicon-home footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.address_title') @lang('layout.address')</div>
                            <div class="top-buffer-10 footer-contact" id="footer-faicons">
                                @lang('layout.follow_us')&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span>
                                        <a target="_blank" href="{{ Config::get('constants.social-links.facebook') }}" class="fa fa-facebook-f"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.twitter') }}" class="fa fa-twitter"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.linkedin') }}" class="fa fa-linkedin"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.googleplus') }}" class="fa fa-google-plus" rel="publisher"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.youtube') }}" class="fa fa-youtube"></a>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5">
                <div class="row">
                    <div class="col-xs-4 footer-sitemap">
                        <h4>@lang('footer.navigation')</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}">@lang('footer.home')</a></li>
                            <li><a href="{{ route('who') }}">@lang('footer.who')</a></li>
                            <li><a href="{{ route('faqs')  }}">@lang('footer.faqs')</a></li>
                            <li><a href="{{ route('contact') }}">@lang('footer.contact')</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-4 footer-sitemap">
                        <h4>@lang('footer.services')</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('services') }}">@lang('footer.schools')</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-4 footer-sitemap">
                        <h4>@lang('footer.legal')</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('terms') }}">@lang('footer.terms')</a></li>
                            <li><a href="{{ route('privacy') }}">@lang('footer.privacy')</a></li>
                            <li><a href="{{ route('cookies') }}">@lang('footer.cookies')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-offset-1 col-md-10 text-left top-padding-15 bottom-padding-15 small">
                @lang('layout.copyright')
                <div class="netw-link">
                    <a href="http://www.network30.com/" target="_blank">Network3.0</a>
                </div>
                &
                <div class="enosis-link">
                    <a href="http://e-nosis.com/" target="_blank">e-nosis</a>
                </div>
            </div>
        </div>
    </div>
</div>
