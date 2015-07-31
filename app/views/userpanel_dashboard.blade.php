@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')
    {{ HTML::style('css/jquery.Jcrop.min.css') }}
@endsection

@section('content')

    <div class="container-fluid top-padding-25 bottom-padding-150 background-lamp">

    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <div class="profile-image">
                        <img class="thumbnail" height="100" width="100" src="{{ asset('img/avatars/'.$user->avatar) }}" title="{{ $user->username }} logo" alt="{{ $user->username }}">
                    </div>
                    <div class="profile-title">
                        <div><h1 class="profile-maintitle">@lang('userpanel.my-control-panel')</h1></div>
                        <div><h2 class="profile-subtitle">@if($user->hasRole('teacher')) @lang('userpanel.teacher-role') @endif {{ $user->name }}</h2></div>
                    </div>
                </div>
                <div class="pull-right">
                    <a href="{{ url('profe/'.$user->slug) }}" class="btn btn-default"><i class="fa fa-user-plus"></i> @lang('userpanel.see-my-profile')</a>
                </div>
                @if($user->hasRole("admin"))
                    <div class="pull-right" style="width:150px;text-align:center;">
                        <a href="{{ url('admin/school/reviews') }}" class="btn btn-primary btn-xs inline-block">@lang('userpanel.school-ratings')</a>
                        <a href="{{ url('admin/teacher/reviews') }}" class="btn btn-primary btn-xs inline-block top-buffer-4">@lang('userpanel.teacher-ratings')</a>
                        <a href="{{ url('admin/schools') }}" class="btn btn-warning btn-xs inline-block top-buffer-4">@lang('userpanel.admin-schools')</a>
                        <a href="{{ url('admin/teachers') }}" class="btn btn-warning btn-xs inline-block top-buffer-4">@lang('userpanel.admin-teachers')</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
<div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tabs-profile magic-align-2 container" role="tablist">
        <li role="presentation" class="active"><a href="#teacher_tab" aria-controls="teacher_tab" role="tab" data-toggle="tab">@lang('userpanel.my-lessons')</a></li>
        <li role="presentation"><a href="#profile_tab" aria-controls="profile_tab" role="tab" data-toggle="tab">@lang('userpanel.my-data')</a></li>
    </ul>
    <div class="tab-content container user-box top-padding-50 bottom-padding-50" role="tabpanel">
        <div role="tabpanel" class="tab-pane active" id="teacher_tab">
            {{ $content_teacher }}
        </div>
        <div role="tabpanel" class="tab-pane" id="profile_tab">

            <div class="container-fluid top-padding-25 bottom-padding-25">

                <div class="col-xs-12 bottom-buffer-35">
                    <span class="school-rating-span">@lang('userpanel.my-avatar')</span>
                </div>

                <form class="form-horizontal">
                    <div class="col-xs-12 form-group" id="file-input">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="avatar">@lang('userpanel.my-avatar')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <span class="btn btn-default btn-file btn-file-user1">
                            @lang('userpanel.new-image')<input type="file" name="avatar" id="avatar" />
                            </span>
                            <div class="help-block with-errors"><small id="file-input-error">@lang('userpanel.new-image-info')</small></div>
                        </div>
                    </div>
                </form>

                <form class="form-horizontal" action="{{ action('UsersController@updateUser') }}" method="post" role="form" id="user-data">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 bottom-buffer-35">
                        <span class="school-rating-span">@lang('userpanel.my-personal-data')</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="name">@lang('userpanel.name') (*)</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="{{ trans('userpanel.ph-name') }}" type="text" name="name" id="name" value="{{{ $user->name }}}" maxlength="50" required="required" data-error="{{ trans('userpanel.fill-this') }}">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="lastname">@lang('userpanel.lastname')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="{{ trans('userpanel.ph-lastname') }}" type="text" name="lastname" id="lastname" value="{{{ $user->lastname }}}" maxlength="100">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="gender">@lang('userpanel.gender')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <select class="form-control" id="gender" name="gender">
                                <option value="" @if(!$user->gender || ($user->gender!='male' && $user->gender!='female' && $user->gender!='other')) selected="selected" @endif >&nbsp;</option>
                                <option value="male" @if($user->gender=='male') selected @endif >@lang('userpanel.male')</option>
                                <option value="female" @if($user->gender=='female') selected @endif >@lang('userpanel.female')</option>
                                <option value="other" @if($user->gender=='other') selected @endif >@lang('userpanel.other')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="date_of_birth">@lang('userpanel.birthdate')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label for="day"><small>@lang('userpanel.day')</small></label>
                                    <select autocomplete="off" class="form-control" id="day" name="day">
                                        <?php
                                            $defaultDay = ($user->date_of_birth) ? date("d",strtotime($user->date_of_birth)) : 1;
                                        ?>
                                        @for($i=1;$i<32;++$i)
                                            <option @if($i==$defaultDay) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label for="month"><small>@lang('userpanel.month')</small></label>
                                    <?php $defaultMonth = ($user->date_of_birth) ? date("m",strtotime($user->date_of_birth)) : 1; ?>
                                    <select autocomplete="off" class="form-control" id="month" name="month">
                                        <option value="1" @if($defaultMonth==1) selected="selected" @endif >@lang('userpanel.january')</option>
                                        <option value="2" @if($defaultMonth==2) selected="selected" @endif >@lang('userpanel.february')</option>
                                        <option value="3" @if($defaultMonth==3) selected="selected" @endif >@lang('userpanel.march')</option>
                                        <option value="4" @if($defaultMonth==4) selected="selected" @endif >@lang('userpanel.april')</option>
                                        <option value="5" @if($defaultMonth==5) selected="selected" @endif >@lang('userpanel.may')</option>
                                        <option value="6" @if($defaultMonth==6) selected="selected" @endif >@lang('userpanel.june')</option>
                                        <option value="7" @if($defaultMonth==7) selected="selected" @endif >@lang('userpanel.july')</option>
                                        <option value="8" @if($defaultMonth==8) selected="selected" @endif >@lang('userpanel.august')</option>
                                        <option value="9" @if($defaultMonth==9) selected="selected" @endif >@lang('userpanel.september')</option>
                                        <option value="10" @if($defaultMonth==10) selected="selected" @endif >@lang('userpanel.october')</option>
                                        <option value="11" @if($defaultMonth==11) selected="selected" @endif >@lang('userpanel.november')</option>
                                        <option value="12" @if($defaultMonth==12) selected="selected" @endif >@lang('userpanel.december')</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label for="year"><small>@lang('userpanel.year')</small></label>
                                    {{--Form SELECT year of birth--}}
                                    <?php
                                        $currentYear = date("Y");
                                        $aCenturyAgo = date("Y", strtotime($currentYear)-(60*60*24*365.242*110));
                                        $defaultYear = ($user->date_of_birth) ? date("Y", strtotime($user->date_of_birth)) : $currentYear;
                                    ?>
                                    {{ Form::selectYear('year', $currentYear, $aCenturyAgo, $defaultYear,['autocomplete'=>'off','class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="address">@lang('userpanel.address') (*)</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="@lang('userpanel.ph-address')" type="text" name="address" id="address" value="{{{ $user->address }}}" maxlength="200" required="required" data-error="@lang('userpanel.fill-this')">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="email">@lang('userpanel.email') (*)</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="@lang('userpanel.ph-email')" type="email" name="email" id="email" value="{{{ $user->email }}}" required="required" data-error="@lang('userpanel.email-info')">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="phone">@lang('userpanel.telephone')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="@lang('userpanel.ph-telephone')" type="text" name="phone" id="phone" value="{{{ $user->phone }}}" pattern="^([0-9]){5,}$" maxlength="20" data-error="@lang('userpanel.telephone-info')">
                            <small><div class="help-block with-errors">@lang('userpanel.telephone-helper')</div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="description">@lang('userpanel.description')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <textarea rows="3" placeholder="@lang('userpanel.ph-description')" class="form-control" name="description" id="description" maxlength="450">{{ $user->description }}</textarea>
                            <small><div class="help-block with-errors"></div></small>
                            <div id="chars_feedback"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('buttons.save_changes')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <br/>

                <form class="form-horizontal" action="{{ action('UsersController@updateSocial') }}" method="post" role="form" id="user-social">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 bottom-buffer-35">
                        <span class="school-rating-span">@lang('userpanel.web-and-social')</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="facebook">Facebook</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="@lang('userpanel.ph-facebook')" type="url" name="facebook" id="facebook" value="{{{ $user->link_facebook }}}" data-error="@lang('userpanel.facebook-error')">
                            <div class="help-block with-errors"><small>@lang('userpanel.facebook-helper')</small></div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="twitter">Twitter</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="@lang('userpanel.ph-twitter')" type="url" name="twitter" id="twitter" value="{{{ $user->link_twitter }}}" data-error="@lang('userpanel.twitter-error')">
                            <div class="help-block with-errors"><small>@lang('userpanel.twitter-helper')</small></div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="googleplus">Google+</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="@lang('userpanel.ph-gplus')" type="url" name="googleplus" id="googleplus" value="{{{ $user->link_googleplus }}}" data-error="@lang('userpanel.gplus-error')">
                            <div class="help-block with-errors"><small>@lang('userpanel.gplus-helper')</small></div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="instagram">Instagram</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="@lang('userpanel.ph-instagram')" type="url" name="instagram" id="instagram" value="{{{ $user->link_instagram }}}" data-error="@lang('userpanel.instagram-error')">
                            <small><div class="help-block with-errors">@lang('userpanel.instagram-helper')</div></small>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="linkedin">LinkedIn</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="@lang('userpanel.ph-linkedin')" type="url" name="linkedin" id="linkedin" value="{{{ $user->link_linkedin }}}" data-error="@lang('userpanel.linkedin-error')">
                            <small><div class="help-block with-errors">@lang('userpanel.linkedin-helper')</div></small>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="web">@lang('userpanel.my-web')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="@lang('userpanel.ph-my-web')" type="url" name="web" id="web" value="{{{ $user->link_web }}}" data-error="@lang('userpanel.my-web-error')">
                            <small><div class="help-block with-errors">@lang('userpanel.my-web-helper')</div></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('buttons.save_changes')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <form class="form-horizontal" action="{{ action('UsersController@updateUserPasswd') }}" method="post" role="form" id="user-passwd">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 top-buffer-35 bottom-buffer-35">
                        <span class="school-rating-span">@lang('userpanel.change-passwd')</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="old_password">@lang('userpanel.current-passwd')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="Contraseña actual" type="password" name="old_password" id="old_password" required="required" pattern=".{6,}" data-error="@lang('userpanel.current-passwd-error')">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="new_password">@lang('userpanel.new-passwd')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control reset-password" placeholder="@lang('userpanel.ph-new-passwd')" type="password" name="new_password" id="new_password" required="required" pattern=".{6,}" data-error="@lang('userpanel.new-passwd-error')">
                            <small><div class="help-block with-errors">@lang('userpanel.new-passwd-helper')</div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="new_password_confirmation">@lang('userpanel.confirm-passwd')</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="@lang('userpanel.ph-confirm-passwd')" type="password" name="new_password_confirmation" id="new_password_confirmation" required="required" data-match=".reset-password" data-error="@lang('userpanel.confirm-passwd-error')" data-match-error="@lang('userpanel.match-passwd-error')">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><input type="submit" value="Cambiar contraseña" class="btn btn-primary"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

{{--Modal to crop images--}}
<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('userpanel.crop-avatar')</h4>
            </div>
            <div class="modal-body container-fluid">
                <div id="canvasContainer" class="col-xs-12 text-center"></div>
                <div id="funcsContainer" class="col-xs-12">
                    <div id="previewTitle">@lang('userpanel.preview')</div>
                    <div id="previewContainer"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('buttons.cancel')</button>
                <form style="display: inline;" action="{{ route('userpanel.dashboard.update.avatar') }}" method="post" onsubmit="return checkCoords();">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    <input type="hidden" name="avatar" id="cropAvatar"/>
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input type="submit" class="btn btn-milprofes" value="@lang('userpanel.save-selection')" />
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('page_js')
    {{ HTML::script('js/jquery.Jcrop.min.js') }}
    <script type="text/javascript">
        $(document).ready(function(){
            MyProfileDashboard.init();
            Availabilities.init();
        });
    </script>
@endsection
