<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
        }
        .crop-container {
            max-width: 100%;
            max-height: 400px;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="container mx-auto mt-10 p-6">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Form Section -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-full lg:w-1/2">
                <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600">Tambah Buku</h1>
                <form id="bookForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Input Fields for Book Information -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Buku</label>
                        <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Buku</label>
                        <input type="file" id="image" name="image" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" accept="image/*">
                    </div>

                    <div class="mb-5">
                        <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-2">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="tahunTerbit" class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit</label>
                        <input type="number" name="tahunTerbit" id="tahunTerbit" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="ISBN" class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                        <input type="number" name="ISBN" id="ISBN" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" rows="4" required oninput="updatePreview()"></textarea>
                    </div>

                    <div class="mb-5">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700 mb-2">Sub Kategori</label>
                        <select name="subcategory_id" id="subcategory_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-5">
                        <label for="jumlahStock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stock</label>
                        <input type="number" name="jumlahStock" id="jumlahStock" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring focus:ring-indigo-200 focus:outline-none">Simpan Buku</button>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-full lg:w-1/2">
                <h2 class="text-2xl font-bold mb-4 text-indigo-600">Pratinjau Buku</h2>
                <img id="previewImage" class="object-cover w-40 h-56 rounded-lg" src="https://via.placeholder.com/150" alt="Gambar Buku">
                <div class="mt-4 text-left">
                    <p class="font-semibold">Nama Buku: <span id="previewName">-</span></p>
                    <p>Penulis: <span id="previewPenulis">-</span></p>
                    <p>Penerbit: <span id="previewPenerbit">-</span></p>
                    <p>Tahun Terbit: <span id="previewTahunTerbit">-</span></p>
                    <p>Status: <span id="previewStatus">-</span></p>
                    <p>ISBN: <span id="previewISBN">-</span></p>
                    <p>Jumlah Stock: <span id="previewJumlahStock">-</span></p>
                    <button id="toggleDescription" class="text-indigo-600 mt-2" onclick="toggleDescription(event)">Tampilkan Deskripsi</button>
                    <p class="text-gray-600 mt-2 hidden" id="fullDescription">Deskripsi Lengkap: <span id="previewFullDescription">-</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Crop Modal -->
    <div id="cropModal" class="modal">
        <div class="modal-content">
            <h2 class="text-xl font-semibold mb-4">Crop Gambar</h2>
            <div class="crop-container">
                <img id="cropImage" src="">
            </div>
            <div class="mt-4 text-right">
                <button id="cropButton" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Crop & Simpan</button>
                <button id="cancelButton" class="px-4 py-2 bg-gray-600 text-white rounded-lg ml-2">Batal</button>
            </div>
        </div>
    </div>

    <script>
        let cropper;
        const imageInput = document.getElementById('image');
        const cropModal = document.getElementById('cropModal');
        const cropImage = document.getElementById('cropImage');
        const previewImage = document.getElementById('previewImage');
        const cropButton = document.getElementById('cropButton');
        const cancelButton = document.getElementById('cancelButton');

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    cropImage.src = reader.result;
                    cropModal.classList.add('active');
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 2 / 3, // Aspect ratio for portrait
                        viewMode: 1,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        cropButton.addEventListener('click', () => {
            if (cropper) {
                // Ambil hasil cropping dalam bentuk Blob
                cropper.getCroppedCanvas().toBlob((blob) => {
                    // Buat objek file baru dari Blob
                    const croppedFile = new File([blob], "cropped-image.jpg", { type: "image/jpeg" });

                    // Ganti file input dengan hasil crop
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    imageInput.files = dataTransfer.files;

                    // Update preview gambar
                    const previewUrl = URL.createObjectURL(croppedFile);
                    previewImage.src = previewUrl;

                    // Tutup modal
                    cropModal.classList.remove('active');
                    cropper.destroy();
                    cropper = null;
                }, "image/jpeg");
            }
        });

        cancelButton.addEventListener('click', () => {
            cropModal.classList.remove('active');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        // Update the preview dynamically
        function updatePreview() {
            document.getElementById('previewName').textContent = document.getElementById('name').value || '-';
            document.getElementById('previewPenulis').textContent = document.getElementById('penulis').value || '-';
            document.getElementById('previewPenerbit').textContent = document.getElementById('penerbit').value || '-';
            document.getElementById('previewTahunTerbit').textContent = document.getElementById('tahunTerbit').value || '-';
            document.getElementById('previewISBN').textContent = document.getElementById('ISBN').value || '-';
            document.getElementById('previewJumlahStock').textContent = document.getElementById('jumlahStock').value || '-';
            document.getElementById('previewFullDescription').textContent = document.getElementById('description').value || '-';
        }

        // Toggle description visibility
        function toggleDescription(event) {
            const descElement = document.getElementById('fullDescription');
            if (descElement.classList.contains('hidden')) {
                descElement.classList.remove('hidden');
                event.target.textContent = 'Sembunyikan Deskripsi';
            } else {
                descElement.classList.add('hidden');
                event.target.textContent = 'Tampilkan Deskripsi';
            }
        }
    </script>

</body>
</html>
