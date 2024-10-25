import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import {Alpine} from '../../vendor/livewire/livewire/dist/livewire.esm';
import ClipboardJS from "clipboard";
import intersect from '@alpinejs/intersect'
import mask from '@alpinejs/mask'
import sort from '@alpinejs/sort'
import ValidationErrors from 'wire-validation';

// window.Pusher = Pusher;
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY ?? 'app-key',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? '127.0.0.1',
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? '',
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? '',
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? "mt1",
//     forceTLS: false,
//     encrypted: true,
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
// });

// Instantiate clipboard
var clipboard = new ClipboardJS('.btn-copy');

clipboard.on('success', function (e) {
    e.clearSelection();
});

clipboard.on('error', function (e) {
});

async function handleFiles(files) {
    let fileInput = document.getElementById('fileUpload');
    if (!fileInput) {
        return;
    }
    let dt = new DataTransfer();
    fileInput.files = dt.files;
    fileInput.files = files;
    dragging = false;
    var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
    if (files.length > 0) {
        uploadModal.show();
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            // Tạo một phần tử list-group-item mới
            let listItem = document.createElement('div');
            listItem.className = 'list-group-item';
            // Tạo nội dung cho list-group-item
            let row = document.createElement('div');
            row.className = 'row align-items-center';
            let colAuto1 = document.createElement('div');
            colAuto1.className = 'col-auto';
            let badge = document.createElement('span');
            badge.className = 'badge bg-red';
            colAuto1.appendChild(badge);
            let colAuto2 = document.createElement('div');
            colAuto2.className = 'col-auto';
            let link = document.createElement('a');
            link.href = '#';
            let avatar = document.createElement('span');
            avatar.className = 'avatar';
            let fileType = file.name.split('.').pop().toLowerCase();
            // Kiểm tra xem file có phải là ảnh hay không
            if (file.type.startsWith('image/')) {
                // Nếu file là ảnh, hiển thị URL của ảnh
                let reader = new FileReader();
                reader.onloadend = function () {
                    avatar.style.backgroundImage = 'url(' + reader.result + ')';
                }
                reader.readAsDataURL(file);
            } else {
                // Nếu file không phải là ảnh, hiển thị ký tự đầu tiên của tên file
                avatar.textContent = fileType[0];
            }

            link.appendChild(avatar);
            colAuto2.appendChild(link);

            let col = document.createElement('div');
            col.className = 'col text-truncate';
            let fileName = document.createElement('a');
            fileName.className = 'text-reset d-block';
            fileName.textContent = file.name;
            let fileSize = document.createElement('div');
            fileSize.className = 'd-block text-secondary text-truncate mt-n1';
            fileSize.textContent = file.size + ' bytes';
            col.appendChild(fileName);
            col.appendChild(fileSize);

            let colAuto3 = document.createElement('div');
            colAuto3.className = 'col-auto';
            let link2 = document.createElement('a');
            link2.href = '#';
            link2.className = 'list-group-item-actions';
            link2.addEventListener('click', function (event) {
                event.preventDefault();
                listItem.remove();
                let dt = new DataTransfer();
                let fileInput = document.getElementById('fileUpload');
                for (let j = 0; j < fileInput.files.length; j++) {
                    if (j !== i) {
                        dt.items.add(fileInput.files[j]);
                    }
                }
                fileInput.files = dt.files;
            });
            let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', 'icon icon-tabler icon-tabler-x');
            svg.setAttribute('width', '24');
            svg.setAttribute('height', '24');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('stroke-width', '2');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke-linecap', 'round');
            svg.setAttribute('stroke-linejoin', 'round');
            let path1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path1.setAttribute('stroke', 'none');
            path1.setAttribute('d', 'M0 0h24v24H0z');
            path1.setAttribute('fill', 'none');
            let path2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path2.setAttribute('d', 'M18 6l-12 12');
            let path3 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path3.setAttribute('d', 'M6 6l12 12');
            svg.appendChild(path1);
            svg.appendChild(path2);
            svg.appendChild(path3);
            link2.appendChild(svg);
            colAuto3.appendChild(link2);

            row.appendChild(colAuto1);
            row.appendChild(colAuto2);
            row.appendChild(col);
            row.appendChild(colAuto3);
            listItem.appendChild(row);

            // Thêm list-group-item vào list-group
            let listGroup = document.querySelector('#list-file');
            listGroup.appendChild(listItem);
        }
    }
}


Alpine.plugin(mask)
Alpine.plugin(sort)
Alpine.plugin(intersect)
Alpine.plugin(ValidationErrors);
Livewire.start()


import './echo';
