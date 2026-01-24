@extends('admin.layouts.master')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Errors : </strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($role, ['method' => 'PATCH','route' => ['admin.roles.update', $role->id]]) !!}
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <h4  class="alert alert-warning  text-center" style="color:#fff;">
                            تعديل مجموعة صلاحيات
							<br>  
						</h4>
                    </div> 

                    <div class="clearfix"></div> 
                    <br>
                    <div class="main-content-label mg-b-5">
                        <div class="row">
                            <div class="form-group col-lg-12 text-center">
                                <p>اسم المجموعة </p> 
                              <input type="text" value="{{$role->name}}" readonly name="name"
                                       placeholder="اسم المجموعة"
                                       class="form-control text-center" style="font-size:16px;">      
                            </div> 
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">اسم الصلاحية</th>
                                <th class="text-center">اضافة</th>
                                <th class="text-center">عرض</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>المستخدمين</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("1", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="1">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("2", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="2">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("3", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="3">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("4", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="4">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>صلاحيات المستخدمين</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("5", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="5">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("6", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="6">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("7", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="7">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("8", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="8">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td> الفروع </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("9", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="9">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("10", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="10">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("11", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="11">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("12", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="12">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td> الأصناف </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("13", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="13">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("14", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="14">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("15", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="15">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("16", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="16">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td> اوامر الادخال المخزني</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("17", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="17">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("18", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="18">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td></td> 
                                <td></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td> الفواتير الضريبية</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("19", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="19">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("20", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="20">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td></td> 
                                <td></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td> فواتير المشتريات</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("21", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="21">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("22", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="22">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td> مرتجع المبيعات</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("23", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="23">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("24", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="24">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>9</td>
                                <td> سندات الصرف</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("25", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="25">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("26", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="26">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("27", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="27">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("28", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="28">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr> 
                            <tr>
                                <td>10</td>
                                <td> سندات القبض </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("29", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="29">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("30", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="30">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("31", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="31">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("32", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="32">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td> تقارير المخزون </td>
								<td></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("33", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="33">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td></td>
								<td></td>
							</tr>	
							<tr>
                                <td>12</td>
                                <td> المخازن </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("34", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="34">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("35", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="35">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("36", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="36">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("37", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="37">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td> العملاء</td>
                                <td >
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("38", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="38">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td >
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("39", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="39">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td >
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("40", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="40">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td >
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("41", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="41">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td> الموردين </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("42", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="42">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("43", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="43">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("44", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="44">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("45", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="45">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>  الحسابات</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("46", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="46">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("47", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="47">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("48", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="48">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("49", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="49">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>الاعدادات</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("50", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="50">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("51", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="51">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("52", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="52">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("53", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="53">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>اسعار الذهب </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("54", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="54">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("55", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="55">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("56", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="56">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("57", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="57">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 								
                            </tr>
                            <tr>
                                <td>18</td>
                                <td> المخزون </td>
								<td></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("58", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="58">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td></td>
								<td></td>
							</tr>
                            <tr>
                                <td>19</td>
                                <td> دفتر الشغل </td>
								<td></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("59", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="59">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td></td>
								<td></td>
							</tr>
                            <tr>
                                <td>20</td>
                                <td> دفتر الكسر </td>
								<td></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("60", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="60">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
								<td></td>
								<td></td>
							</tr> 
                            <tr>
                                <td>22</td>
                                <td> دفتر دخول النقدية</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("65", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="65">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("66", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="66">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("67", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="67">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("68", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="68">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 								
                            </tr>
                            <tr>
                                <td>23</td>
                                <td> دفتر خروج النقدية</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("69", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="69">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("70", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="70">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("71", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="71">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("72", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="72">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 								
                            </tr>
                            <tr>
                                <td>24</td>
                                <td>   قائمة الجرد</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("75", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="75">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("76", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="76">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("77", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="77">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("78", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="78">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 								
                            </tr>
                            <tr>
                                <td>25</td>
                                <td>الفواتير الضريبية المبسطة</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("79", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="79">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("80", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="80">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td></td>   
                                <td></td>								
                            </tr>
                            <tr>
                                <td>26</td>
                                <td>التقارير المحاسبية</td> 
                                <td></td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("83", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="83">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td></td>   
                                <td></td>								
                            </tr>
                            <tr>
                                <td>27</td>
                                <td>القيود المحاسبية</td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("84", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="84">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("85", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="85">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("86", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="86">
                                        <span class="slider round"></span>
                                    </label>
                                </td>   
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("87", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="87">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 								
                            </tr>
                            <tr>
                                <td>28</td>
                                <td>ميزان ارصدة الذهب</td> 
                                <td></td> 
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("92", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="92">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td></td>   
                                <td></td>								
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>اشعار مدين لفاتورة مبسطة</td>  
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("93", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="93">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("94", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="94">
                                        <span class="slider round"></span>
                                    </label>
                                </td>  
                                <td></td>
                                <td></td>								
                            </tr>
                            <tr>
                                <td>30</td>
                                <td>اشعار مدين لفاتورة ضريبية</td>  
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("95", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="95">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("96", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="96">
                                        <span class="slider round"></span>
                                    </label>
                                </td>  
                                <td></td>
                                <td></td>								
                            </tr>
                            <tr>
                                <td>31</td>
                                <td>مردود المشتريات </td>  
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("97", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="97">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("98", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="98">
                                        <span class="slider round"></span>
                                    </label>
                                </td>  
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("99", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="99">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("100", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="100">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 							
                            </tr>
                            <tr>
                                <td>32</td>
                                <td>النسخ الاحتياطي </td>  
								<td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("101", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="101">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("102", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="102">
                                        <span class="slider round"></span>
                                    </label>
                                </td>  
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="permission[]"
                                               <?php if (in_array("103", $rolePermissions)) {
                                                   echo "checked";
                                               } ?> value="103">
                                        <span class="slider round"></span>
                                    </label>
                                </td> 
                                <td> 
                                </td> 							
                            </tr>
                            
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> تأكيد وتعديل الصلاحيات</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- main-content closed -->
    {!! Form::close() !!}

    <!-- main-content closed -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script>
        $('#check_all').click(function () {
            $('input[type=checkbox]').prop('checked', true);
        });
    </script>
@endsection

