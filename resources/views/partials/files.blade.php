<span id="files-{{ $folder->id }}" class="files" @if ($sub) style="display: none;" @endif>
    <ul class="tree-file">
        @foreach ($folder->files as $file)
            <li>
                <span>
                    <span class="no-sub"></span>
                    <i class="fa {{ $file->getIcon() }}"></i>
                    
                    <a href="{{ $file->getLink() }}" target="_blank">
                        <span class="name-prefix">{{ $file->fullName }}</span>
                    </a>

                    <span class="create-sub-folder">
                        <a href="{{ $file->getLink() }}" download="{{ $file->fullName }}" style="margin-right: 5px;">
                            <i class="fa fa-download"></i>
                        </a>
                        
                        <a href="javascript:;" onclick="confSubmit(document.getElementById('delete-form-{{ $folder->id }}'));">
                            <i class="fa fa-remove" style="color: red;"></i>
                        </a>

                        {!! Form::open(['method' => 'DELETE','route' => ['files.destroy', $file->id], 'style' => 'display:none', 'id' => 'delete-file-form-' . $file->id]) !!}
                        {!! Form::close() !!}
                    </span>
                </span>
            </li>
        @endforeach
    </ul>
</span>