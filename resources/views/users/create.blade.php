@extends('layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="col-md-6 col-sm-6 col-xs-12 form-horizontal Hide_row">
        <input type="hidden" id="status_create_folder" value="">
        <input type="hidden" id="status_upload" value="">
        <input type="hidden" id="old_bucket" value="">
        <input type="hidden" id="old_bucket_upload" value="">
        <div class="form-group">
            <label class="control-label col-md-5 col-sm-5 col-xs-12 pl-0">Choose available Buckets</label>
            <div class="col-md-7 col-sm-7 col-xs-12 select_butket_div">
                <select name="bucket" class="select_butket form-control" tabindex="-1">
                    <option value="covalentdata">covalentdata</option>
                    <option selected="selected" value="cybernext">cybernext</option>
                    <option value="internalcovalent">internalcovalent</option>
                </select>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row new_user">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> <i class="fa fa-bars"> </i>Create a New User</h2>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form role="form" action="#" method="POST" onsubmit="return check(this)">
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="firstname" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lastname" class="form-control">
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                   <label>Username</label>
                                   <input type="text" name="username" class="form-control">
                                   
                                   </div> -->
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3,4}$" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="lpassword_new" type="password" name="password1" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        <label>Password Confirmation</label>
                                        <input id="password_confirm" type="password" name="password2" class="form-control" onchange="checkPasswordMatch();" required="">
                                        <span id="confirm_error" class="Alert error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        <label>Select Company </label><br>
                                        <select id="com_id" name="com_id" class="form-control" onchange="getFolders(this.value);" required="">
                                            <option value="">Select Company</option>
                                            <option value="8">cybernext</option>
                                            <option value="10">Hindustan Times Pvt Ltd</option>
                                            <option value="11">IBM India Ltd</option>
                                            <option value="22">sdddsdds</option>
                                            <option value="25">Cybernext 5</option>
                                            <option value="27">Test com 5</option>
                                            <option value="28">Company D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><span class="txt-lg">Select Folder : </span></label><span id="show_error" style="display:none"></span><br>
                                        <div id="contentFolder3" class="contentFolder">
                                            <ul class="tree-file pkk">
                                                <li class="sub-6666cd76f96956469e7be39d750cc7d9">
                                                    <span class="item">
                                                        <span class="no-sub"></span>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix">/</span></a>
                                                    </span>
                                                </li>
                                                <li id="pCybernext" class="sub-689acf8324a47cecde1d0bdabd1aa24f">
                                                    <span class="item Cybernext">
                                                        <input type="checkbox" name="folder[]" value="Cybernext/" class="chb">
                                                        <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix name-689acf8324a47cecde1d0bdabd1aa24f"> Cybernext</span></a>
                                                        <span class="create-sub-folder"><span id="status-Cybernext" class="status complete">complete</span><span id="meta-Cybernext" class="metadata test  ">test   </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="pcnext2" class="sub-8fdd3406f5bbacb6df5ff6299cf1a838">
                                                    <span class="item cnext2">
                                                        <input type="checkbox" name="folder[]" value="cnext2/" class="chb">
                                                        <a href="javascript:;" class="arrow" ><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix name"> cnext2</span></a>
                                                        <span class="create-sub-folder"><span id="status-cnext2" class="status complete">complete</span><span id="meta-cnext2" class="metadata xas">xas </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="pt2" class="sub-66041b1a687781b0e84c7a54bea7df44">
                                                    <span class="item t2">
                                                        <input type="checkbox" name="folder[]" value="t2/" class="chb">
                                                        <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix"> t2</span></a>
                                                        <span class="create-sub-folder"><span id="status-t2" class="status "></span><span id="meta-t2" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="ptest" class="sub-13e138d54eb8818da29c3992edef070a">
                                                    <span class="item test">
                                                        <input type="checkbox" name="folder[]" value="test/" class="chb">
                                                        <span class="no-sub"></span>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix"> test</span></a>
                                                        <span class="create-sub-folder"><span id="status-test" class="status "></span><span id="meta-test" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="puser1" class="sub-7097e4e739fcd97cc0f40a70cb6ba7c2">
                                                    <span class="item user1">
                                                        <input type="checkbox" name="folder[]" value="user1/" class="chb">
                                                        <span class="no-sub"></span>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix"> user1</span></a>
                                                        <span class="create-sub-folder"><span id="status-user1" class="status inprogress">inprogress</span><span id="meta-user1" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="puser2" class="sub-c9efdab3191d252c0f06c990aadc9667">
                                                    <span class="item user2">
                                                        <input type="checkbox" name="folder[]" value="user2/" class="chb">
                                                        <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix"> user2</span></a>
                                                        <span class="create-sub-folder"><span id="status-user2" class="status inprogress">inprogress</span><span id="meta-user2" class="metadata Test">Test </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="puser3" class="sub-051cf3fe4e26e8bfca0e232ce6609cab">
                                                    <span class="item user3">
                                                        <input type="checkbox" name="folder[]" value="user3/" class="chb">
                                                        <a href="javascript:;" class="arrow" data-id="051cf3fe4e26e8bfca0e232ce6609cab" data-prefix="user3/"><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;" ><span class="name-prefix"> user3</span></a>
                                                        <span class="create-sub-folder"><span id="status-user3" class="status complete">complete</span><span id="meta-user3" class="metadata test">test </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                                <li id="puser4" class="sub-22f7e8b2b336f087d3e6d01be340b4f0">
                                                    <span class="item user4">
                                                        <input type="checkbox" name="folder[]" value="user4/" class="chb">
                                                        <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i>  <a href="javascript:;"><span class="name-prefix name"> user4</span></a>
                                                        <span class="create-sub-folder"><span id="status-user4" class="status notstarted">notstarted</span><span id="meta-user4" class="metadata meta ttt">meta ttt </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk"></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <p class="help-block">Leave blank if you dont want to assign.</p>
                                        <button style="display:none" type="button" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh folders</button>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select class="form-control" name="active">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        <label>Admin</label>
                                        <select class="form-control" name="admin">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                    <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-check"></i> Save and Exit</button>
                                    <button type="reset" class="btn btn-default"><i class="fa fa-repeat"></i> Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection
