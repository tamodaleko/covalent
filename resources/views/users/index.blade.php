@extends('layouts.app')

@section('content')
<div class="row users_management">
    <!-- start userlist -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bars"> </i>Users Management cybernext</h2>
                <span class="right"><a class="btn btn-danger" href="#"><i class="fa fa-user-o"></i> Add new user</a></span>         
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="clearfix"></div>
                <div class="dashboard-widget-content a">
                    <div class="col-md-6 col-sm-6 col-xs-12 left">
                        <div class="form-group">
                            <label>Select Company </label><br>
                            <select id="com_id" name="com_id" class="form-control" onchange="getComUsers(this.value);">
                                <option value="">Select Company</option>
                                <option value="no-company">No Company Selected</option>
                                <option value="8" selected="">cybernext</option>
                                <option value="10">Hindustan Times Pvt Ltd</option>
                                <option value="11">IBM India Ltd</option>
                                <option value="22">sdddsdds</option>
                                <option value="25">Cybernext 5</option>
                                <option value="27">Test com 5</option>
                                <option value="28">Company D</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 label-top"><label> cybernext Users </label></div>
                    <div class="contentfrefix" id="contentfrefix1">
                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Folders</th>
                                    <th>Admin</th>
                                    <th>Status</th>
                                    <th>Join Date</th>
                                    <!--<th>Company</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="content-file">
                                <tr class="odd gradeX">
                                    <td>1</td>
                                    <td>Pawan Thakur</td>
                                    <td>pawan.cybernext@gmail.com</td>
                                    <td>
                                        Cybernext/Pawan/,<br>Cybernext/Rahul/test/,<br>Cybernext/Rahul/test/subtest2/sub-subtest1/,<br>Cybernext/zzz/,<br>                                            
                                    </td>
                                    <td>yes</td>
                                    <td><span class="green"></span></td>
                                    <td>07/25/2018</td>
                                    <!-- <td>
                                       </td> -->
                                    <td class="center">
                                        <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="confirm btn btn-danger" >Delete</a>
                                    </td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td>5</td>
                                    <td>SD T</td>
                                    <td>SD2017@gmail.com</td>
                                    <td>
                                        Cybernext/Rahul/test/subtest1/,<br>                                           
                                    </td>
                                    <td>no</td>
                                    <td><span class="green"></span></td>
                                    <td>08/03/2018</td>
                                    <!-- <td>
                                       </td> -->
                                    <td class="center">
                                        <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="confirm btn btn-danger" >Delete</a>
                                    </td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td>8</td>
                                    <td>rahul s</td>
                                    <td>test@gmail.com</td>
                                    <td>
                                        Cybernext/Rahul/,<br>                                             
                                    </td>
                                    <td>no</td>
                                    <td><span class="green"></span></td>
                                    <td>08/16/2018</td>
                                    <!-- <td>
                                       </td> -->
                                    <td class="center">
                                        <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="confirm btn btn-danger" >Delete</a>
                                    </td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td>47</td>
                                    <td>wavyqhhh w</td>
                                    <td>wavyq@amail.club</td>
                                    <td>
                                        Cybernext/zzz/,<br>                                           
                                    </td>
                                    <td>no</td>
                                    <td><span class="green"></span></td>
                                    <td>09/24/2018</td>
                                    <!-- <td>
                                       </td> -->
                                    <td class="center">
                                        <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="confirm btn btn-danger" >Delete</a>
                                    </td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td>58</td>
                                    <td>vasundhara ahuja</td>
                                    <td>vcybernext@gmail.com</td>
                                    <td>
                                        Cybernext/,<br>                                           
                                    </td>
                                    <td>no</td>
                                    <td><span class="green"></span></td>
                                    <td>09/25/2018</td>
                                    <!-- <td>
                                       </td> -->
                                    <td class="center">
                                        <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="confirm btn btn-danger" >Delete</a>
                                    </td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td>70</td>
                                    <td>dfgdfgdg </td>
                                    <td>tobavuf@cmail.club</td>
                                    <td>
                                        Cybernext/zzz/,<br>                                           
                                    </td>
                                    <td>no</td>
                                    <td><span class="green"></span></td>
                                    <td>10/01/2018</td>
                                    <!-- <td>
                                       </td> -->
                                    <td class="center">
                                        <a href="#" class="btn btn-primary">Edit</a>
                                        <a href="#" class="confirm btn btn-danger" >Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row -->
@endsection
