<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Quest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container mt-4">
    <h2>Daftar Quest</h2>
    <!-- Form Pencarian -->
    <div class="mb-3">
        <label for="search" class="form-label">Cari Quest</label>
        <input type="text" id="search" class="form-control" oninput="searchQuest()" placeholder="Masukkan judul quest...">
    </div>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#questModal" onclick="openModal()">Tambah Quest</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Batas Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="questTableBody">
            @foreach ($quests as $quest)
                <tr>
                    <td>{{ $quest->title }}</td>
                    <td>{{ $quest->description }}</td>
                    <td>{{ $quest->due_date->format('d-m-Y') }}</td>
                    <td>
                        <span class="badge" style="background-color: {{ $quest->color }};">
                            {{ ucfirst(str_replace('_', ' ', $quest->status)) }}
                        </span>
                    </td>
                    <td>
                        <button id="checked{{ $quest->id }}" class="btn btn-{{ $quest->checked ? 'secondary' : 'success' }} btn-sm" 
                                onclick="toggleCheckedStatus({{ $quest->id }})">
                            {{ $quest->checked ? '❌' : '✅' }}
                        </button>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#questDetailModal" 
                                onclick="openDetailModal({{ json_encode($quest) }})">Lihat Detail</button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#questModal" 
                                onclick="openModal({{ json_encode($quest) }})">Edit</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" 
                                onclick="setDeleteQuestId({{ $quest->id }})">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>

    <!-- Modal Form -->
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
                    <!-- Detail quest akan dimasukkan di sini -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pemberitahuan Tugas Dibuat -->
    <div class="modal fade" id="taskCreatedModal" tabindex="-1" aria-labelledby="taskCreatedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskCreatedModalLabel">Tugas Berhasil Dibuat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tugas baru berhasil ditambahkan!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Quest -->
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
                <div class="mb-3 form-check">
                    <input type="checkbox" name="checked" id="checked" class="form-check-input" ${quest && quest.checked ? 'checked' : ''}>
                    <label for="checked" class="form-check-label">Sudah Selesai</label>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            `;
        }

        function openDetailModal(quest) {
            const modalBody = document.getElementById('questDetailBody');
            modalBody.innerHTML = `
                <h5>Judul: ${quest.title}</h5>
                <p><strong>Deskripsi:</strong> ${quest.description}</p>
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
                    location.reload(); // Refresh halaman setelah update berhasil
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
            const rows = document.querySelectorAll('#questTableBody tr');

            rows.forEach(row => {
                const title = row.querySelector('td').textContent.toLowerCase();
                if (title.includes(query)) {
                    row.style.display = '';  // Tampilkan baris jika ada kecocokan
                } else {
                    row.style.display = 'none';  // Sembunyikan baris jika tidak ada kecocokan
                }
            });
        }


    </script>
</body>
</html>
