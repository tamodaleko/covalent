@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 file_browser">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="form-group">
                                <!-- <label>Select Company</label> -->
                                <br>
                                <select id="company" name="company" class="form-control" onchange="getFolders(this.value);">
                                    <option value="">Select Company</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12 col-sm-12 col-xs-12 search-col">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 search-col-inner">
                                    <div class="dashboard-widget-content">
                                        <div id="contentFolder3" class="contentFolder">
                                            <ul class="tree-file pkk">
                                                <li class="sub-6666cd76f96956469e7be39d750cc7d9">
                                                    <span class="item">
                                                        <span class="no-sub"></span>
                                                        <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix">/</span></a>
                                                    </span>
                                                </li>
                                                <li id="pCybernext" class="sub-689acf8324a47cecde1d0bdabd1aa24f">
                                                    <span class="item Cybernext">
                                                        <input type="checkbox" name="folder[]" value="Cybernext/" class="chb">
                                                        <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-down"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name active"> Cybernext</span></a>
                                                        <span class="create-sub-folder" style="display: none;"><span id="status-Cybernext" class="status complete">complete</span><span id="meta-Cybernext" class="metadata test  ">test   </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                    </span>
                                                    <span class="sub pkk">
                                                        <ul class="tree-file">
                                                            <li id="pKamal" class="sub">
                                                                <span class="item Kamal">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/Kamal/" class="chb">
                                                                    <span class="no-sub"></span>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name">Kamal</span></a>
                                                                    <span class="create-sub-folder" style="display: none;"><span id="status-Kamal" class="status notstarted">notstarted</span><span id="meta-Kamal" class="metadata  no"> no </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pPawan" class="sub">
                                                                <span class="item Pawan">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/Pawan/" class="chb">
                                                                    <a href="javascript:;" class="arrow" data-id="44d59ed0b94886844e3563efe6a52fa6" data-prefix="Cybernext/Pawan/"><span><i class="fa fa-caret-right"></i></span></a>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name" data="Cybernext/Pawan/" data-text="Pawan">Pawan</span></a>
                                                                    <span class="create-sub-folder" style="display: none;"><span id="status-Pawan" class="status inprogress">inprogress</span><span id="meta-Pawan" class="metadata  in"> in </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pRahul" class="sub-b9ec70f48d8acb9fa7d7d19a65a754ff">
                                                                <span class="item Rahul">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/Rahul/" class="chb">
                                                                    <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-right"></i></span></a>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;" ><span class="name-prefix name-b9ec70f48d8acb9fa7d7d19a65a754ff" data="Cybernext/Rahul/" data-text="Rahul">Rahul</span></a>
                                                                    <span class="create-sub-folder" style="display: none;"><span id="status-Rahul" class="status inprogress">inprogress</span><span id="meta-Rahul" class="metadata  r"> r </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pShared" class="sub-4647003c84da95f058070531d6aadc54">
                                                                <span class="item Shared">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/Shared/" class="chb">
                                                                    <a href="javascript:;" class="arrow" data-id="4647003c84da95f058070531d6aadc54" data-prefix="Cybernext/Shared/"><span><i class="fa fa-caret-right"></i></span></a>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name-4647003c84da95f058070531d6aadc54" data="Cybernext/Shared/" data-text="Shared">Shared</span></a>
                                                                    <span class="create-sub-folder" style="display: none;"><span id="status-Shared" class="status inprogress">inprogress</span><span id="meta-Shared" class="metadata  in "> in  </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pVineet" class="sub-e4c10b5ecf448fc9be467ec3c13bbd5b">
                                                                <span class="item Vineet">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/Vineet/" class="chb">
                                                                    <span class="no-sub"></span>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name" data="Cybernext/Vineet/" data-text="Vineet">Vineet</span></a>
                                                                    <span class="create-sub-folder" style="display: none;"><span id="status-Vineet" class="status "></span><span id="meta-Vineet" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pnewuser" class="sub-c2b29e7f35b7c221686a39969a2fcf73">
                                                                <span class="item newuser">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/newuser/" class="chb">
                                                                    <span class="no-sub"></span>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name-c2b29e7f35b7c221686a39969a2fcf73" data="Cybernext/newuser/" data-text="newuser">newuser</span></a>
                                                                    <span class="create-sub-folder" style="display: none;"><span id="status-newuser" class="status "></span><span id="meta-newuser" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pvasu" class="sub-23ef4c0f5126319d1743f7e568cc670c">
                                                                <span class="item vasu">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/vasu/" class="chb">
                                                                    <span class="no-sub"></span>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name" data="Cybernext/vasu/" data-text="vasu">vasu</span></a>
                                                                    <span class="create-sub-folder"><span id="status-vasu" class="status "></span><span id="meta-vasu" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                            <li id="pzzz" class="sub-b724b769eebae7c8de7a5dcb0091b57a">
                                                                <span class="item zzz">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/zzz/" class="chb">
                                                                    <span class="no-sub"></span>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name" data="Cybernext/zzz/" data-text="zzz">zzz</span></a>
                                                                    <span class="create-sub-folder"><span id="status-zzz" class="status "></span><span id="meta-zzz" class="metadata "> </span><a href="javascript:;"><i class="fa fa-eye"></i>  </a><a href="javascript:;"><i class="fa fa-remove"></i>  </a></span>
                                                                </span>
                                                                <span class="sub"></span>
                                                            </li>
                                                        </ul>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-sec">
                                            <button id="upload-file" type="button" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Upload file</button>
                                            <button id="btn-panel-create-new-folder" type="button" class="btn btn-info">
                                                <i class="fa fa-folder-open-o"></i> Create folder
                                            </button>
                                            <button id="status123" type="button" class="btn btn-info" data-toggle="modal" data-target="#status-file-modal"><i class="fa fa-file-o" aria-hidden="true"></i> Status</button>
                                            <button type="button" class="btn btn-info btn-select"><i class="fa fa-refresh"></i> Refresh</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 search-files">
                                    <div class="clearfix"></div>
                                    <div class="breadcrumbs">
                                        <ul class="folder-breadcrumb">
                                            <li><i class="fa fa-folder-open-o"></i> <b>Current path :</b> </li>
                                            <li><a href="javascript:;">/</a></li>
                                            <li class="active">Cybernext</li>
                                        </ul>
                                    </div>
                                    <div class="input-group search">
                                        <input id="search" type="text" class="form-control" placeholder="Input file name here">
                                        <button id="btn-search-new" type="button" class="btn btn-primary">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                    <div class="contentfrefix" id="contentfrefix">
                                        <form id="zips" name="zips" action="#" method="post">
                                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th>#</th>
                                                        <th>
                                                            <input id="chkall" value="" type="checkbox" class="flatchk" name="multiple_checkbox">
                                                        </th>
                                                        <th class="column-title"> </th>
                                                        <th class="column-title" width="250">Name</th>
                                                        <th class="column-title">Date Uploaded </th>
                                                        <th class="column-title">Size</th>
                                                        <!--<th class="column-title"><input type="checkbox" id="checkAll" /></th> -->
                                                        <th class="column-title no-link last"><span class="nobr">Action</span> </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="content-file">
                                                    <tr class="row-1 even pointer Cybernext">
                                                        <td>1</td>
                                                        <td class="a-center ">
                                                            <input id="del-1"  type="checkbox" class="flatchk file-checkbox" name="table_records">
                                                            <input id="download-1" class="chk" type="checkbox" name="files[]" value="http://s3-us-west-1.amazonaws.com/cybernext/Cybernext/Amazon%20S3%20File%20Managers%20%282%29.png">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:;" class="img-popup" data-toggle="modal"><img class="img-file" src="./img/Amazon S3 File Managers (2).png"></a>
                                                        </td>
                                                        <td class=" ">
                                                            <i class="fa fa-file-image-o"></i>
                                                            <a href="./img/Amazon S3 File Managers (2).png" title="" target="_blank">Amazon S3 File Managers (2).png</a>
                                                        </td>
                                                        <td class="date_td ">Sep 25,2018. 07:08:56</td>
                                                        <td class=" ">
                                                            <span>26,1 Kb</span>
                                                        </td>
                                                        <td class=" last">
                                                            <a href="./img/Amazon S3 File Managers (2).png"><i class="fa fa-cloud-download" ></i> Download</a>
                                                            <a href="javascript:;"><i class="fa fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="12">
                                                            <span class="download_btn"><button class="btn btn-info download_all" id="submit" name="createzip" value="Download All" disabled="" type="submit"><i class="fa fa-cloud-download"></i> Download Selected</button></span>
                                                            <a class="btn btn-danger" href="javascript:;">
                                                                <i class="fa fa-trash"> </i> Delete selected
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
