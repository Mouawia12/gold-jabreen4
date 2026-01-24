<!-- Logout Modal-->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modelTitle"> {{__('main.add_item')}}</label>
                <button type="button" class="close modal-close-btn close-create" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="paymentBody">
                <form method="POST" action="{{ route('storeItem') }}"
                      enctype="multipart/form-data" id="modal_form">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.code') }} <span style="color:red; font-size:20px; font-weight:bold;">*</span>
                                </label>
                                <input type="text" id="code" name="code"
                                       class="form-control"
                                       placeholder="{{ __('main.code') }}"  readonly/>
                                <input type="text" id="id" name="id"
                                       class="form-control"
                                       placeholder="{{ __('main.code') }}" hidden=""/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.item_type') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <select class="form-control" id="item_type" name="item_type" >
                                    <option value="1">{{__('main.item_type1')}}</option>
                                    <option value="2">{{__('main.item_type2')}}</option>
                                    <option value="3">{{__('main.item_type3')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.name_ar') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="text" id="name_ar" name="name_ar"
                                       class="form-control"
                                       placeholder="{{ __('main.name_ar') }}" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.name_en') }}  </label>
                                <input type="text" id="name_en" name="name_en"
                                       class="form-control"
                                       placeholder="{{ __('main.name_en') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('main.category') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <select class="form-control" id="category_id" name="category_id" >
                                    <option value=""> select...</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category -> id}}">{{Config::get('app.locale') == 'ar' ? $category -> name_ar : $category -> name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 type1">
                            <div class="form-group">
                                <label>{{ __('main.karat') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <select class="form-control" id="karat_id" name="karat_id" >
                                    <option value=""> select...</option>
                                    @foreach($karats as $karat)
                                        <option
                                            value="{{$karat -> id}}">{{Config::get('app.locale') == 'ar' ? $karat -> name_ar : $karat -> name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row type1">
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.weight') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number"  step="any" id="weight" name="weight"
                                       class="form-control"
                                       placeholder="0" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.no_metal') }}  </label>
                                <input type="number" step="any" id="no_metal" name="no_metal"
                                       class="form-control"
                                       placeholder="0" value="0"/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.no_metal_type') }} </label>
                                <select class="form-control" id="no_metal_type" name="no_metal_type">
                                    <option value="1" selected>{{__('main.no_metal_type1')}}</option>
                                    <option value="2">{{__('main.no_metal_type2')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row type1">
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.stamp_value') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="tax" name="tax"
                                       class="form-control"
                                       placeholder="0" readonly/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.made_Value') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="made_Value" name="made_Value"
                                       class="form-control"
                                       placeholder="0" value="0" />
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.state') }}</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="1" selected>{{__('main.state1')}}</option>
                                    <option value="2">{{__('main.state2')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row type2">
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.cost') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="cost" name="cost"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.price') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="price" name="price"
                                       class="form-control"
                                       placeholder="0" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>{{ __('main.tax') }} <span
                                        style="color:red; font-size:20px; font-weight:bold;">*</span> </label>
                                <input type="number" step="any" id="taxx" name="taxx"
                                       class="form-control"
                                       placeholder="0" required />
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label>{{ __('main.img') }}</label>
                            <div class="row">


                                <div class="col-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="img" name="img"
                                               accept="image/png, image/jpeg" >
                                        <label class="custom-file-label" for="img"
                                               id="path">{{__('main.img_choose')}} </label>
                                    </div>
                                    <br> <span
                                        style="font-size: 9pt ; color:gray;">{{ __('main.img_hint') }}</span>

                                </div>
                                <div class="col-3 text-right">
                                    <img src="../assets/img/photo.png" id="profile-img-tag" width="150px"
                                         height="150px" class="profile-img"/>
                                </div>
                                <div class="col-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="att_file" name="att_file"
                                               accept="application/pdf" >
                                               
                                        <label class="custom-file-label" for="att_file"
                                               id="path">{{__('main.img_choose')}} 
                                        </label>
                                    </div>
                                    <br> 
                                    <span style="font-size: 9pt ; color:gray;">{{ __('main.img_hint') }}</span>
                                </div>
                                <div class="col-3 text-right">
                                    <a herf="" class="profile-pdf">
                                    </a> 
                                </div>
                            </div>
                            @error('printer')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6" style="display: block; margin: 20px auto; text-align: center;">
                            <button type="button" class="btn btn-labeled btn-primary" id="submit_modal_btn">
                                {{__('main.save_btn')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
