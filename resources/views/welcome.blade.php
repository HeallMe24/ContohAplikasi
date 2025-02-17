<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            cursor: pointer;
        }
        .todo-item.completed span {
            text-decoration: line-through;
        }
        .add-task-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center text-white py-3" style="background-color: #007bff;">To-Do List</h1>
        
        <div class="container my-3">
            <!-- Tombol T untuk menampilkan gambar -->
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#calendarImage" aria-expanded="false" aria-controls="calendarImage">
                T <!-- Gantilah T dengan ikon jika diinginkan -->
            </button>
    
            <!-- Gambar yang akan muncul saat tombol ditekan -->
            <div class="collapse" id="calendarImage">
                <img src="../assets/img/calendar.png" class="img-fluid" alt="Calendar Image">
            </div>
        </div>
        
        <ul class="nav nav-tabs" id="todoTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#terlewat">Terlewat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#mendatang">Mendatang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#sudahDilakukan">Sudah Dilakukan</a>
            </li>
        </ul>
        
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="terlewat">
                <div class="todo-item">
                    <span>Judul Tugas 1</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
                <div class="todo-item">
                    <span>Judul Tugas 2</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
                <div class="todo-item">
                    <span>Judul Tugas 3</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="mendatang">
                <div class="todo-item">
                    <span>Judul Tugas 4</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
                <div class="todo-item">
                    <span>Judul Tugas 5</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
                <div class="todo-item">
                    <span>Judul Tugas 6</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="sudahDilakukan">
                <div class="todo-item">
                    <span>Judul Tugas 7</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
                <div class="todo-item">
                    <span>Judul Tugas 8</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
                <div class="todo-item">
                    <span>Judul Tugas 9</span>
                    <div>
                        <button class="btn btn-sm btn-primary toggle-button">A</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewTaskModal">B</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editTaskModal">C</button>
                        <button class="btn btn-sm btn-danger">D</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary add-task-button" data-bs-toggle="modal" data-bs-target="#taskModal">+</button>

    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" placeholder="Judul Tugas">
                    <textarea class="form-control mb-2" placeholder="Deskripsi Tugas"></textarea>
                    <select class="form-control mb-2">
                        <option value="blue">Biru</option>
                        <option value="red">Merah</option>
                        <option value="yellow">Kuning</option>
                        <option value="green">Hijau</option>
                    </select>
                    <input type="date" class="form-control mb-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" value="Judul Tugas 1">
                    <textarea class="form-control mb-2">Deskripsi tugas yang dapat diedit.</textarea>
                    <input type="date" class="form-control mb-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="viewTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Judul:</strong> Judul Tugas 1</p>
                    <p><strong>Deskripsi:</strong> Ini adalah deskripsi tugas.</p>
                    <p><strong>Tanggal Upload:</strong> 2025-02-06</p>
                    <p><strong>Kadaluarsa Sebelum:</strong> 2025-02-24</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelectorAll('.toggle-button').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.todo-item');
                item.classList.toggle('completed');
                this.textContent = item.classList.contains('completed') ? 'Z' : 'A';
            });
        });
    </script>
</body>
</html>
