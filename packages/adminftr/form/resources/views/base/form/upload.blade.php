@php
    $keyName = $name;
@endphp
<div x-data="{{ $name }}filepond" wire:ignore>
    <div class="row justify-content-between mb-2">
        <label for="{{ $name }}" class="form-label col-auto">{{ $label }}</label>
        <a type="button" class="col-auto" data-bs-toggle="modal" data-bs-target="#file-manager">
            <i class="fa fa-folder-open"></i>
        </a>
    </div>
    <input type="file"
           class="form-control"
           name="{{ $name }}"
           accept="{{$acceptedFileTypes}}"
           id="{{ $name }}"
           multiple="{{$multiple}}">
</div>
@error('data.'.$name)
<div class="invalid-feedback d-block">
    {{ $message }}
</div>
@enderror

<script>
    document.addEventListener('livewire:init', () => {
        Alpine.data('{{ $name }}filepond', () => ({
            url: null,
            init() {
                const input = document.getElementById('{{ $name }}');
                const pond = FilePond.create(input, {
                    allowReorder: true,
                    imageCropAspectRatio: 1,
                    maxFiles: {{$maxfiles ?? 1}},
                    allowImageCrop: true,
                    allowImagePreview: true,
                    allowVideoPreview: true,
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                            let panelroot = document.querySelector('.filepond--panel-root');
                            panelroot.style.backgroundColor = 'var(--tblr-bg-surface)';
                            if (file instanceof File) {
                            @this.upload('{{$isRelationship ? 'relations':'data'}}.{{ $relationshipName? $relationshipName : $name }}', file, (response) => {
                                load(response);
                            }, (response) => {
                                error(response.error);
                            }, (event) => {
                                progress(event.lengthComputable, event.loaded, event.total);
                            })
                            } else {
                                load(file['name'])
                            }

                        },
                        revert: (uniqueFileId, load, error) => {
                            let data = @this.get('{{$isRelationship ? 'relations':'data'}}.{{ $relationshipName? $relationshipName : $name }}');
                            for (let i = 0; i < data.length; i++) {
                                if (data[i]['{{$filePath}}'].includes(uniqueFileId)) {
                                    data.splice(i, 1);
                                    break;
                                }
                            }
                            @this.set('{{$isRelationship ? 'relations':'data'}}.{{ $relationshipName? $relationshipName : $name }}', data)
                            load();
                        },
                        load: (source, load, error, progress, abort, headers) => {
                            fetch(source)
                                .then(response => response.blob())
                                .then(blob => {
                                    load(blob);
                                })
                                .catch(() => {
                                    error('Không thể tải tệp.');
                                });
                        }
                    },
                });
                const existingFiles = @this.get('{{$isRelationship ? 'relations':'data'}}.{{ $relationshipName? $relationshipName : $name }}');
                if (Array.isArray(existingFiles)) {
                    existingFiles.forEach(fileData => {
                        const fileUrl = "{{ asset('storage') }}/" + fileData['{{ $filePath ?? $keyName }}'];
                        pond.addFile(fileUrl).then(file => {
                            file.setMetadata('uploaded', true);
                        });
                    });
                } else {
                    if (existingFiles) {
                        const fileUrl = "{{ asset('storage/') }}/" + existingFiles;
                        pond.addFile(fileUrl).then(file => {
                            file.setMetadata('uploaded', true);
                        });
                    }
                }
                pond.on('addfile', (error, file) => {
                    if (error) {
                        console.error('FilePond error:', error);
                    }
                });

            }
        }));
    });
</script>
