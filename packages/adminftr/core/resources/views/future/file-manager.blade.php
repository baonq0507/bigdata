<div x-data="filemanager">
    <div x-show="contextMenuVisible"
         @click.away="hideContextMenu()"
         :style="'position: fixed; top: ' + contextMenuY + 'px; left: ' + contextMenuX + 'px; z-index: 1000;' + 'display: ' + (contextMenuVisible ? 'block' : 'none')"
         class="dropdown-menu show">
        <template x-if="contextMenuItemType === 'folder'">
            <div>
                <a class="dropdown-item" href="#" @click.prevent="renameFolder(contextMenuItem)">Đổi tên thư mục</a>
                <a class="dropdown-item" href="#" @click.prevent="deleteFolder(contextMenuItem)">Xóa thư mục</a>
            </div>
        </template>
        <template x-if="contextMenuItemType === 'file'">
            <div>
                <a class="dropdown-item" href="#" @click.prevent="renameFile(contextMenuItem)">Đổi tên tệp</a>
                <a class="dropdown-item" href="#" @click.prevent="deleteFile(contextMenuItem)">Xóa tệp</a>
            </div>
        </template>
    </div>
    <div class="card-body position-relative h-100">
        <div class="row justify-content-between">
            <div class="col-auto">
                <form class="d-flex" role="search">
                    <div class="input-icon mb-3 w-100">
                        <input type="text" x-model="search" class="form-control" placeholder="Search…">
                        <span class="input-icon-addon">
                            <template x-if="loading">
                                <!-- Loading icon -->
                                <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                            </template>
                            <template x-if="!loading">
                                <!-- Search icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                    <circle cx="10" cy="10" r="7"></circle>
                                    <line x1="21" y1="21" x2="15" y2="15"></line>
                                </svg>
                            </template>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    {{ __('Upload') }}
                </a>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col">
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-horizontal">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M4 6l8 0"/>
                            <path d="M16 6l4 0"/>
                            <path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M4 12l2 0"/>
                            <path d="M10 12l10 0"/>
                            <path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M4 18l11 0"/>
                            <path d="M19 18l1 0"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">{{ __('Move to Trash') }}</a></li>
                        <li><a class="dropdown-item" href="#">{{ __('Permanently Delete') }}</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary"
                            @click="openModalFolder"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        {{ __('New Folder') }}
                    </button>
                </div>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <button type="button" class="btn active text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icons-tabler-outline icon-tabler-grip-horizontal">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                            <path d="M5 15m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                            <path d="M12 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                            <path d="M12 15m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                            <path d="M19 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                            <path d="M19 15m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                        </svg>
                    </button>
                    <button type="button" class="btn text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icons-tabler-outline icon-tabler-list">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 6l11 0"/>
                            <path d="M9 12l11 0"/>
                            <path d="M9 18l11 0"/>
                            <path d="M5 6l0 .01"/>
                            <path d="M5 12l0 .01"/>
                            <path d="M5 18l0 .01"/>
                        </svg>
                    </button>
                </div>
                <button class="btn btn-primary" @click="reloadFiles" :disabled="loading"
                >
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-reload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
                </button>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 mb-4">
                <div class="breadcrumb" x-ref="breadcrumb">
                </div>
            </div>
        </div>
       <template x-if="loading">
           <div class="position-absolute row top-50 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-opacity-50" style="z-index: 1050;">
               <div class="col text-center text-muted">
                   <div class="spinner-border" role="status">
                       <span class="visually-hidden">{{ __('Loading...') }}</span>
                   </div>
               </div>
           </div>
       </template>
        <div class="row list-file">
            <template x-if="!loading">
                <template x-if="folders.length > 0 || files.length > 0 ">
                    <div :class="setfiles.length > 0 ? 'col-md-9 col-sm-12 col-lg-9' : 'col-md-12 col-lg-12'">
                        <div class="row files" x-sort >
                            <template x-for="item in folders">
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-3">
                                    <div class="card folder-card h-100"
                                         @contextmenu="showContextMenu($event, item, 'folder')">
                                        <input type="checkbox" :value="item" x-model="selectedFolders" class="form-check-input mt-2 ms-2">
                                        <div class="card-body text-center" style="cursor: pointer;" @click="selectFolder(item)" x-sort:item>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                                            </svg>
                                            <h3 class="card-text text-truncate mb-1" x-text="item.split('/').pop()"></h3>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-for="file in files">
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-3" x-sort:item>
                                    <div class="card folder-card" style="cursor: pointer;"
                                         @contextmenu="showContextMenu($event, file, 'file')">
                                        <input type="checkbox" :value="file"  class="form-check-input mt-2 ms-2">
                                        <div class="card-body text-center">
                                            <template x-if="checkFileType(file) === 'Image'">
                                                <div class="card-image" @click="showLinkFile(file)">
                                                    <img :src="renderUrl(file)" loading="lazy" width="50" height="50" alt="Hình ảnh" />
                                                </div>
                                            </template>
                                            <template x-if="['Image', 'Video'].indexOf(checkFileType(file))">
                                                <div x-html="getFileIconClass(file)" @click="showLinkFile(file)"></div>
                                            </template>
                                            <template x-if="file.category === 'Video'">
                                                <img :src="renderUrl(file)" loading="lazy" alt="Video" class="img-fluid" @click="showLinkFile(file)" />
                                            </template>
                                            <h3 class="card-text text-truncate mb-1" x-text="file.file_name" @click="showLinkFile(file)"></h3>
                                            <div class="d-flex justify-content-between align-items-center mt-2 ms-2 me-2">
                                                <p class="card-text mb-0" x-text="formatFileSize(file.file_size)"></p>
                                                <a :href="renderUrl(file)" download style="z-index: 999">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M12 5v13m-4 -4l4 4l4 -4" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div></div>
                        </div>
                    </div>
                </template>
            </template>
            <template x-if="!loading">
                <template x-if="setfiles.length > 0">
                    <div class="col-md-3 col-sm-12 col-lg-3" x-show="folders.length > 0 || files.length > 0">
                        <div class="card show-file">
                            <div class="card-header">
                                <h2>{{ __('File Information') }}</h2>
                                <!-- Icon X để đóng card, sử dụng FontAwesome -->
                                <button class="btn btn-sm btn-secondary" style="position: absolute; top: 10px; right: 10px;">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>

                </template>
            </template>

        </div>

        <template x-if="
            folders.length === 0 && files.length === 0
            && search.length === 0
            && !loading">
            <div class="row" >
                <div class="col text-center text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2"/>
                    </svg>
                    <h3>{{ __('No files or folders found.') }}</h3>
                </div>
            </div>
        </template>
    </div>
    <!-- Modal Upload -->
    <div class="modal fade"  id="uploadModal" aria-labelledby="uploadModalLabel" aria-hidden="true"
         x-data="fileUpload">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Upload Files') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form x-ref="uploadForm">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">{{ __('Choose files to upload') }}</label>
                            <input class="form-control" type="file" id="fileInput" x-on:change="handleFileSelection"
                                   multiple>
                        </div>
                    </form>

                    <!-- Danh sách tệp được chọn -->
                    <div class="mt-3" x-show="files.length > 0">
                        <h5>{{ __('Selected Files') }}</h5>
                        <ul class="list-group">
                            <template x-for="(file, index) in files" :key="index">
                                <li class="list-group-item d-flex align-items-center">
                                    <!-- Hiển thị ảnh thu nhỏ nếu là hình ảnh -->
                                    <template x-if="file.isImage">
                                        <img :src="file.url" alt=""
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    </template>
                                    <!-- Hiển thị biểu tượng nếu không phải hình ảnh -->
                                    <template x-if="!file.isImage">
                                        <i :class="getFileIconClass(file)" style="font-size: 24px;"></i>
                                    </template>
                                    <!-- Thông tin tệp -->
                                    <div class="ms-2">
                                        <div><strong x-text="file.name"></strong></div>
                                        <div class="text-muted" x-text="formatFileSize(file.size)"></div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" @click="uploadFiles">{{ __('Upload') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal New Folder -->
    <div class="modal fade" style="z-index: 9999;" id="newFolderModal" aria-labelledby="newFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('New Folder') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body
                ">
                    <div class="mb-3">
                        <label for="folderName" class="form-label">{{ __('Folder Name') }}</label>
                        <input type="text" class="form-control"
                               x-model="folderName"
                        >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            @click="createFolder"
                    >{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal New Folder -->
</div>

@script
<script>
    Alpine.data('filemanager', () => ({
        search: '',
        loading: false,
        files: [],
        setfiles:[],
        limit:$wire.entangle('limit'),
        viewMode: 'grid',
        folders: [],
        folder:'',
        selectedFolders: [],
        folderName:'',
        breadcrumbs: ['Home'],
        contextMenuVisible: false,
        contextMenuX: 0,
        contextMenuY: 0,
        contextMenuItem: null,
        contextMenuItemType: '',
        init() {
            $wire.on('fileUploaded', () => {
                this.getFileManager();
            });
            this.$watch('search', () => {

            });
            this.$watch('breadcrumbs', () => {
                this.createBreadcrumbs();
            });
            this.createBreadcrumbs();
            this.getFileManager();
        },
        showContextMenu(event, item, itemType) {
            event.preventDefault(); // Ngăn chặn menu chuột phải mặc định
            this.contextMenuVisible = true;
            this.contextMenuX = event.clientX;
            this.contextMenuY = event.clientY;
            this.contextMenuItem = item;
            this.contextMenuItemType = itemType;
        },
        hideContextMenu() {
            this.contextMenuVisible = false;
            this.contextMenuItem = null;
            this.contextMenuItemType = '';
        },
        renameFolder(folder) {
            // Thực hiện logic đổi tên thư mục
            alert('Đổi tên thư mục: ' + folder);
            this.hideContextMenu();
        },
        renameFile(file) {
            // Thực hiện logic đổi tên tệp
            alert('Đổi tên tệp: ' + file.file_name);
            this.hideContextMenu();
        },
        deleteFile(file) {
            // Thực hiện logic xóa tệp
            $wire.call('deleteFile', file).then(() => {
                this.files = this.files.filter(f => f !== file);
            });
            this.hideContextMenu();
        },
        deleteFolder(folder) {
            // Thực hiện logic xóa thư mục
            $wire.call('deleteFolder', folder).then(() => {
                this.folders = this.folders.filter(item => item !== folder);
            });
            this.hideContextMenu();
        },
        renderUrl(file){
            return '{{asset('storage')}}/' + file.file_path.replace('public/','');
        },
        reloadFiles(){
            this.getFileManager(this.folder);
        },
        openModalFolder(){
            new bootstrap.Modal(document.getElementById('newFolderModal')).show();
        },
        getFileManager(folder = '') {
           if (this.loading === false) {
               this.loading = true;
               $wire.call('getFiles',folder).then(filePaths => {
                   this.files = filePaths['files'];
                   this.folders = filePaths['folders'];
                   this.loading = false;
               })
           }
        },



        formatFileSize(size) {
            let i = Math.floor(Math.log(size) / Math.log(1024));
            let sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
            return (size / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
        },
        createFolder(){
            this.loading = true;
            let path = this.breadcrumbs.join('/').replace('Home/', '');
            path = this.breadcrumbs.join('/').replace('Home', '');
            $wire.call('createFolder', this.folderName,path).then((res) => {
                if (res){
                    this.folders.push(res);
                }
                this.loading = false;
            });
            this.folderName = '';
            new bootstrap.Modal(document.getElementById('newFolderModal')).hide();
        },

        createBreadcrumbs(){
            const breadcrumbs = this.$refs.breadcrumb;
            breadcrumbs.innerHTML = '';
            this.breadcrumbs.forEach((folder, index) => {
                const breadcrumb = document.createElement('a');
                breadcrumb.classList.add('breadcrumb-item');
                breadcrumb.innerText = folder;
                breadcrumb.style.cursor = 'pointer';
                breadcrumb.addEventListener('click', () => {
                    this.breadcrumbs = this.breadcrumbs.slice(0, index + 1);
                    this.folder = this.breadcrumbs.join('/');
                    this.folder = this.folder.replace('Home/', '');
                    this.folder = this.folder.replace('Home', '');
                    this.getFileManager(this.folder);
                });
                breadcrumbs.appendChild(breadcrumb);
            });
        },
        showLinkFile(file) {
            this.setfiles = [];
            this.setfiles.push(file);
        },

        checkFileType(file){
            const extension = file.file_type;
            const imageExtensions = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
            const videoExtensions = ['video/mp4', 'video/avi', 'video/mkv', 'video/mov', 'video/wmv'];
            const audioExtensions = ['audio/mp3', 'audio/wav', 'audio/ogg', 'audio/m4a'];
            const wordExtensions = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            const excelExtensions = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            const powerpointExtensions = ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
            const pdfExtensions = ['application/pdf'];
            const zipExtensions = ['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed'];
            const textExtensions = ['text/plain'];
            //html file
            const htmlExtensions = ['text/html'];
            if (imageExtensions.includes(extension)) {
                return 'Image';
            } else if (videoExtensions.includes(extension)) {
                return 'Video';
            } else if (audioExtensions.includes(extension)) {
                return 'Audio';
            }
            else if (htmlExtensions.includes(extension)) {
                return 'Html';
            }
            else if (wordExtensions.includes(extension)){
                return 'Word';
            }
            else if (excelExtensions.includes(extension)){
                return 'Excel';
            }
            else if (powerpointExtensions.includes(extension)){
                return 'Powerpoint';
            }
            else if (pdfExtensions.includes(extension)){
                return 'Pdf';
            }
            else if (zipExtensions.includes(extension)){
                return 'Zip';
            }
            else if (textExtensions.includes(extension)){
                return 'Text';
            }
            else {
                return 'Other';
            }
        },

        getFileIconClass(file) {
            const type = this.checkFileType(file);
            const iconMap = {
                'default': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-info"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M11 14h1v4h1" /><path d="M12 11h.01" /></svg>',
                'Audio': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-music"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M13 17a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M9 17v-13h10v13" /><path d="M9 8h10" /></svg>',
                'Html': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-html"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 16v-8l2 5l2 -5v8" /><path d="M1 16v-8" /><path d="M5 8v8" /><path d="M1 12h4" /><path d="M7 8h4" /><path d="M9 8v8" /><path d="M20 8v8h3" /></svg>',
                'Image': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-image"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="3" width="18" height="18" rx="3" /><circle cx="8.5" cy="8.5" r="1" /><polyline points="10 10 10 10.4 10 14" /><line x1="14" y1="10" x2="14" y2="10.4" /><line x1="18" y1="6" x2="18" y2="6.4" /><line x1="6" y1="18" x2="6.01" y2="18" /></svg>',
                'Video': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-movie"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M8 4l0 16" /><path d="M16 4l0 16" /><path d="M4 8l4 0" /><path d="M4 16l4 0" /><path d="M4 12l16 0" /><path d="M16 8l4 0" /><path d="M16 16l4 0" /></svg>',
                'Word': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-word"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M9 12l1.333 5l1.667 -4l1.667 4l1.333 -5" /></svg>',
                'Excel': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-excel"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M10 12l4 5" /><path d="M10 17l4 -5" /></svg>',
                'Powerpoint': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v8h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-2z" /><path d="M3 12h2a2 2 0 1 0 0 -4h-2v8" /><path d="M17 12h3" /><path d="M21 8h-4v8" /></svg>',
                'Pdf': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M7 20l4 -4m0 4l-4 -4" /><line x1="3" y1="3" x2="21" y2="21" /></svg>',
                'Zip': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-zip"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 16v-8h2a2 2 0 1 1 0 4h-2" /><path d="M12 8v8" /><path d="M4 8h4l-4 8h4" /></svg>',
                'Text': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-txt"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M16.5 15h3" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M4.5 15h3" /><path d="M6 15v6" /><path d="M18 15v6" /><path d="M10 15l4 6" /><path d="M10 21l4 -6" /></svg>',
                'Other': '<svg  xmlns="http://www.w3.org/2000/svg"  width="50" height="50"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-info"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M11 14h1v4h1" /><path d="M12 11h.01" /></svg>'
            };
            return iconMap[type] || iconMap['default'];
        },

        selectFolder(folder) {
            this.folder = folder.replace('Home/', '');
            this.folder = folder.replace('Home', '');
            this.breadcrumbs.push(folder.split('/').pop());
            this.getFileManager(folder);
        }
    }));

    Alpine.data('fileUpload', () => ({
        files: [],
        handleFileSelection(event) {
            this.files = [];
            for (let i = 0; i < event.target.files.length; i++) {
                let file = event.target.files[i];
                let isImage = file.type.startsWith('image/');
                let fileItem = {
                    file: file,
                    name: file.name,
                    size: file.size,
                    status: 'Chưa upload',
                    progress: 0,
                    isImage: isImage,
                    url: ''
                };
                if (isImage) {
                    fileItem.url = URL.createObjectURL(file);
                }
                this.files.push(fileItem);
            }
        },
        formatFileSize(size) {
            let i = Math.floor(Math.log(size) / Math.log(1024));
            let sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
            return (size / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
        },
        getFileIconClass(file) {
            const extension = file.name.split('.').pop().toLowerCase();
            const iconMap = {
                'default': 'bi bi-file-earmark'
            };
            return iconMap[extension] || iconMap['default'];
        },
        uploadFiles() {
            if (this.files.length === 0) {
                alert('Vui lòng chọn tệp để upload.');
                return;
            }

            this.files.forEach((fileItem, index) => {
                this.uploadFile(fileItem, index);
            });
        },
        uploadFile(fileItem, index) {
            fileItem.status = 'Đang upload';

            let formData = new FormData();
            formData.append('file', fileItem.file);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/upload'); // Thay '/upload' bằng đường dẫn API của bạn

            xhr.upload.addEventListener('progress', (event) => {
                if (event.lengthComputable) {
                    let percentComplete = Math.round((event.loaded / event.total) * 100);
                    this.files[index].progress = percentComplete;
                }
            });

            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    this.files[index].status = 'Hoàn thành';
                } else {
                    this.files[index].status = 'Lỗi';
                }
                // Hủy URL đối tượng sau khi upload xong để giải phóng bộ nhớ
                if (this.files[index].isImage) {
                    URL.revokeObjectURL(this.files[index].url);
                }
            });

            xhr.addEventListener('error', () => {
                this.files[index].status = 'Lỗi';
            });

            xhr.send(formData);
        }
    }));
</script>
@endscript

