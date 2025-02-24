<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Quest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .quest-card {
            border-left: 5px solid;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
        }
        .quest-card .details {
            flex-grow: 1;
        }
        .quest-card .actions button {
            margin-left: 5px;
        }

        .add-quest{
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 24px;
        }

        .small-text {
            font-size: 14px;
            line-height: 1.4;
        }

        .modal-body {
            max-height: 70vh; /* agr modal tdak memenuhi lyar */
            overflow-y: auto; /* scroll klo pnjang */
            word-wrap: break-word; /* Tulisan gk kluar */
            overflow-wrap: break-word;
        }

        .modal-body h5 {
            white-space: nowrap; /* Hindari teks terlalu panjang dalam satu baris */
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%; /* Pastikan judul tidak melebihi modal */
        }

        .small-text {
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

    </style>
</head>
<body class="container mt-4" style="background-image: url('{{ asset('assets/img/images.png') }}');">
    <h2 class="text-center fw-bold my-3 text-uppercase" 
    style="color: #fff; text-shadow: 0 0 10px #ff8c00, 0 0 20px #ff4500;">⚡ Quest Hari Ini ⚡</h2>

    <div class="mb-3">
        <label for="search" class="form-label" style="background-color: #f8f9fa; flex-wrap: ;">Cari Quest</label>
        <input type="text" id="search" class="form-control" oninput="searchQuest()" placeholder="Masukkan judul quest...">
    </div>
    
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#questModal" onclick="openModal()">Tambah Quest</button>
    <button class="btn btn-primary add-quest" data-bs-toggle="modal" data-bs-target="#questModal" onclick="openModal()"> <img src="assets/img/plus.png" height="35px" width="35px"></button>
    
    <div class="d-flex justify-content-between mb-3">
        <div>
            <select id="filter-status" class="form-select" onchange="applyFilter()">
                <option value="" {{ request('status') == null ? 'selected' : '' }}>Semua</option>
                <option value="mendatang" {{ request('status') == 'mendatang' ? 'selected' : '' }}>Mendatang</option>
                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Selesai</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>            
        </div>
        <div>
            <button id="sort-button" class="btn btn-secondary" onclick="toggleSort()">Terbaru ⬆</button>
        </div>
    </div>
    
    @if(session('success'))
        <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
            <div id="uploadToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @else
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        <div id="uploadToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                   Kamu Jelek
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div id="questList">
        @foreach ($quests as $quest)
        @php
            $today = now()->format('Y-m-d');
            if ($quest->checked) {
                $status = 'Selesai ✅';
                $statusClass = 'text-success';
            } elseif ($quest->due_date->format('Y-m-d') < $today) {
                $status = 'Terlambat ⏳';
                $statusClass = 'text-danger';
            } elseif ($quest->due_date->format('Y-m-d') > $today) {
                $status = 'Mendatang ⏳';
                $statusClass = 'text-primary';
            } else {
                $status = 'Belum Selesai ⏳';
                $statusClass = 'text-warning';
            }
    
            $shortTitle = strlen($quest->title) > 30 ? substr($quest->title, 0, 30) . '...' : $quest->title;
        @endphp
        <div class="quest-card" style="border-left-color: {{ $quest->color }};">
            <div class="details">
                <h5 class="mb-1">{{ $shortTitle }}</h5>
                <small class="{{ $statusClass }}">Status: <strong>{{ $status }}</strong></small>
                <br>
                <small>Batas Waktu: {{ $quest->due_date->format('d-m-Y') }}</small>
            </div>
            <div class="actions">
                <button id="checked{{ $quest->id }}" class="btn btn-{{ $quest->checked ? 'secondary' : 'success' }} btn-sm" 
                        onclick="toggleCheckedStatus({{ $quest->id }})">
                    {{ $quest->checked ? '❌' : '✅' }}
                </button>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#questDetailModal" 
                        onclick="openDetailModal({{ json_encode($quest) }})">Lihat</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#questModal" 
                        onclick="openModal({{ json_encode($quest) }})">Edit</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" 
                        onclick="setDeleteQuestId({{ $quest->id }})">Hapus</button>
            </div>
        </div>
        @endforeach
    </div>
    

    <!-- Tombol Create -->
    <div class="modal fade" id="questModal" tabindex="-1" aria-labelledby="questModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questModalLabel">Tambah Quest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="questForm" method="POST">
                        @csrf
                        <input type="hidden" id="questId" name="questId">

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Batas Waktu</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="checked" id="checked" class="form-check-input custom-checkbox">
                            <label for="checked" class="form-check-label">Sudah Selesai</label>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="questDetailModal" tabindex="-1" aria-labelledby="questDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questDetailModalLabel">Detail Quest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="questDetailBody">
                    <!-- Detail Quest -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus quest ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElement = document.getElementById('uploadToast');
            if (toastElement) {
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
        });

        function openModal(quest = null) {
            const form = document.getElementById('questForm');
            form.action = quest ? `/quests/${quest.id}` : '/quests';
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                ${quest ? '<input type="hidden" name="_method" value="PUT">' : ''}
                <input type="hidden" id="questId" name="questId" value="${quest ? quest.id : ''}">

                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" value="${quest ? quest.title : ''}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control">${quest ? quest.description : ''}</textarea>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Batas Waktu</label>
                    <input type="date" name="due_date" id="due_date" class="form-control" value="${quest ? quest.due_date : ''}" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            `;
        }
        function openDetailModal(quest) {
            const modalBody = document.getElementById('questDetailBody');

            // Sesuaikan ukuran font jika judul lebih dari 30 karakter
            let titleFontSize = quest.title.length > 30 ? '18px' : '22px';

            // Tambahkan class 'small-text' jika deskripsi lebih dari 200 karakter
            let descriptionClass = quest.description.length > 200 ? 'small-text' : '';

            modalBody.innerHTML = `
                <h5 style="font-size: ${titleFontSize}; font-weight: bold;" title="${quest.title}">Judul: ${quest.title}</h5>
                <p class="${descriptionClass}"><strong>Deskripsi:</strong> ${quest.description}</p>
                <p><strong>Batas Waktu:</strong> ${new Date(quest.due_date).toLocaleDateString()}</p>
                <p><strong>Status:</strong> ${quest.status}</p>
                <p><strong>Sudah Selesai:</strong> ${quest.checked ? 'Ya' : 'Tidak'}</p>
            `;
        }



        function setDeleteQuestId(questId) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/quests/${questId}`;
        }

        function toggleCheckedStatus(questId) {
            const button = document.getElementById(`checked${questId}`);
            const isChecked = button.classList.contains('btn-secondary');

            fetch(`/quests/${questId}/updateStatus`, {
                method: 'PATCH',
                body: JSON.stringify({ checked: !isChecked }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh Halaman
                } else {
                    console.error('Gagal memperbarui status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function searchQuest() {
            const query = document.getElementById('search').value.toLowerCase();
            const quests = document.querySelectorAll('.quest-card');
            
            quests.forEach(quest => {
                const title = quest.querySelector('h5').textContent.toLowerCase();
                quest.style.display = title.includes(query) ? '' : 'none';
            });
        }

            
        let urlParams = new URLSearchParams(window.location.search);
        let currentSort = urlParams.get('sort') || 'desc';

        
        function updateSortButtonText() {
            let btn = document.getElementById('sort-button');
            btn.textContent = currentSort === 'desc' ? 'Terbaru ⬆' : 'Terlama ⬇';
        }
        updateSortButtonText();

        function toggleSort() {
            currentSort = currentSort === 'desc' ? 'asc' : 'desc';
            updateSortButtonText();
            applyFilter();
        }

        function applyFilter() {
            let status = document.getElementById('filter-status').value;
            let urlParams = new URLSearchParams(window.location.search);

            if (status) {
                urlParams.set('status', status);
            } else {
                urlParams.delete('status'); // Menghapus parameter status jika "Semua" dipilih
            }

            urlParams.set('sort', currentSort);
            window.location.search = urlParams.toString();
        }
    </script>
</body>
</html>
