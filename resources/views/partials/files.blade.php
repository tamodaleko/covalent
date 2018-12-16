<span id="files-{{ $folder->id }}" class="files" @if ($sub) style="display: none;" @endif>
    <ul class="tree-file">
        @foreach ($folder->files as $file)
            <li>
                <span>
                    <span class="no-sub"></span>
                    <input type="checkbox" name="files[]" class="file_checkbox" value="{{ $file->id }}">
                    
                    <i class="fa {{ $file->getIcon() }}"></i>
                    
                    <a href="{{ $file->getLink() }}" target="_blank">
                        <span class="name-prefix">{{ $file->fullName }}</span>
                    </a>

                    <span class="create-sub-folder">

                        @if ($file->isViewable())
                            <a href="javascript:;" data-toggle="modal" data-target="#imagePreviewModal" data-url="{{ $file->getLink() }}" style="margin-right: 5px;">
                                <i class="fa fa-image"></i>
                            </a>
                        @endif

                        <a href="javascript:;" onclick="confSubmit(document.getElementById('copy-file-form-{{ $file->id }}'));" style="margin-right: 5px;">
                            <i class="fa fa-copy"></i>
                        </a>

                        <a href="{{ $file->getLink() }}" download="{{ $file->fullName }}" style="margin-right: 5px;">
                            <i class="fa fa-download"></i>
                        </a>

                        <a href="javascript:;" onclick="confSubmit(document.getElementById('delete-file-form-{{ $file->id }}'));">
                            <i class="fa fa-remove" style="color: red;"></i>
                        </a>

                        {!! Form::open(['route' => ['files.copy', $file->id], 'style' => 'display:none', 'id' => 'copy-file-form-' . $file->id]) !!}
                        {!! Form::close() !!}

                        {!! Form::open(['method' => 'DELETE', 'route' => ['files.destroy', $file->id], 'style' => 'display:none', 'id' => 'delete-file-form-' . $file->id]) !!}
                        {!! Form::close() !!}
                    </span>
                </span>
            </li>
        @endforeach
    </ul>
</span>