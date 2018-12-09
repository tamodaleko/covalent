<span id="files-{{ $folder->id }}" class="files" @if ($sub) style="display: none;" @endif>
    <ul class="tree-file">
        @foreach ($folder->files as $file)
            <li>
                <span>
                    <span class="no-sub"></span>
                    <i class="fa {{ $file->getIcon() }}"></i>
                    <a href="javascript:;">
                        <span class="name-prefix">{{ $file->name . '.' . $file->extension }}</span>
                    </a>

                    <span class="create-sub-folder">
                        
                    </span>
                </span>
            </li>
        @endforeach
    </ul>
</span>