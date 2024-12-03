<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun Perpustakaan Unhas</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>
    <style>
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            display: none;
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .modal.show {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 shadow-lg rounded-lg w-full max-w-4xl flex">
        <div class="w-1/2 pr-4">
            <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">Tambahkan Mahasiswa</h1>
            <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Profil</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                        onchange="showCropModal(event)">
                    @error('image')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-sm text-gray-500 mt-1">*Gunakan email dengan domain @student.unhas.ac.id</p>
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="button" class="absolute right-2 top-3 text-gray-500" onclick="togglePassword()">
                        👁️
                    </button>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" oninput="updatePreview()">
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('nim')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="program_studi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi') }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('program_studi')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                    <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan') }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('angkatan')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none">
                        Daftar
                    </button>
                </div>
            </form>
        </div>

        <div class="w-1/2 pl-4">
            <div class="border p-4 rounded-lg">
                <h2 class="text-lg font-bold mb-4">Preview Profil</h2>
                <div class="flex items-center mb-4">
                    <img id="previewImage" class="w-16 h-16 rounded-full object-cover" src="" alt="Preview Gambar">
                    <div class="ml-4">
                        <p id="previewName" class="text-lg font-semibold">Nama</p>
                        <p id="previewEmail" class="text-sm text-gray-500">Email</p>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ url()->previous() }}">
                    <button
                        class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none">
                        Batal
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="modal" id="cropModal">
        <div>
            <h2 class="text-lg font-semibold mb-4">Crop Gambar Profil</h2>
            <div class="mb-4">
                <img id="imageCropper" src="" alt="Crop Gambar" style="max-width: 100%">
            </div>
            <div class="flex justify-between">
                <button type="button" class="bg-gray-300 px-4 py-2 rounded" onclick="closeModal()">Batal</button>
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="cropImage()">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        function showCropModal(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('imageCropper');
                    imgElement.src = e.target.result;
                    document.getElementById('cropModal').classList.add('show');
                    initializeCropper(imgElement);
                };
                reader.readAsDataURL(file);
            }
        }

        let cropper;
        function initializeCropper(image) {
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 0.8,
                responsive: true
            });
        }

        function cropImage() {
            const canvas = cropper.getCroppedCanvas();
            const dataURL = canvas.toDataURL('image/jpeg');
            document.getElementById('previewImage').src = dataURL;
            document.getElementById('cropModal').classList.remove('show');
        }

        function closeModal() {
            document.getElementById('cropModal').classList.remove('show');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            passwordConfirmInput.type = type;
        }
    </script>
</body>
</html>
