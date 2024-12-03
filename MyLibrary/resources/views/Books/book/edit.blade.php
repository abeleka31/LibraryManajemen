<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
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
                <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600">Edit Buku</h1>
                <form id="bookForm" action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Input Fields for Book Information -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Buku</label>
                        <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ old('name', $book->name) }}" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Buku</label>
                        <input type="file" id="image" name="image" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" accept="image/*">
                    </div>

                    <div class="mb-5">
                        <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ old('penulis', $book->penulis) }}" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-2">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ old('penerbit', $book->penerbit) }}" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="tahunTerbit" class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit</label>
                        <input type="number" name="tahunTerbit" id="tahunTerbit" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ old('tahunTerbit', $book->tahun_terbit) }}" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                            <option value="tersedia" {{ $book->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak tersedia" {{ $book->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="ISBN" class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                        <input type="number" name="ISBN" id="ISBN" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ old('ISBN', $book->ISBN) }}" required oninput="updatePreview()">
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" rows="4" required oninput="updatePreview()">{{ old('description', $book->description) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700 mb-2">Sub Kategori</label>
                        <select name="subcategory_id" id="subcategory_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" required oninput="updatePreview()">
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ $book->subcategory_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    

                    <div class="mb-5">
                        <label for="jumlahStock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stock</label>
                        <input type="number" name="jumlahStock" id="jumlahStock" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" value="{{ old('jumlahStock', $book->jumlah_stock) }}" required oninput="updatePreview()">
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring focus:ring-indigo-200 focus:outline-none">Simpan Buku</button>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="bg-white p-6 shadow-lg rounded-lg w-full lg:w-1/2">
                <h2 class="text-2xl font-bold mb-4 text-indigo-600">Pratinjau Buku</h2>
                <img id="previewImage" class="object-cover w-40 h-56 rounded-lg" src="{{ $book->image_url }}" alt="Gambar Buku">
                <div class="mt-4 text-left">
                    <p class="font-semibold">Nama Buku: <span id="previewName">{{ old('name', $book->name) }}</span></p>
                    <p>Penulis: <span id="previewPenulis">{{ old('penulis', $book->penulis) }}</span></p>
                    <p>Penerbit: <span id="previewPenerbit">{{ old('penerbit', $book->penerbit) }}</span></p>
                    <p>Tahun Terbit: <span id="previewTahunTerbit">{{ old('tahunTerbit', $book->tahun_terbit) }}</span></p>
                    <p>Status: <span id="previewStatus">{{ old('status', $book->status) }}</span></p>
                    <p>Deskripsi: <span id="previewDescription">{{ old('description', $book->description) }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Image Cropper -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <h2 class="text-xl font-bold mb-4">Crop Gambar</h2>
            <div class="crop-container">
                <img id="cropImage" src="#" alt="Gambar untuk Crop">
            </div>
            <div class="mt-4">
                <button id="cropButton" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Crop dan Simpan</button>
                <button id="cancelButton" class="px-4 py-2 bg-gray-600 text-white rounded-lg ml-4">Batal</button>
            </div>
        </div>
    </div>

    <script>
        let cropper;
        function updatePreview() {
            document.getElementById('previewName').innerText = document.getElementById('name').value;
            document.getElementById('previewPenulis').innerText = document.getElementById('penulis').value;
            document.getElementById('previewPenerbit').innerText = document.getElementById('penerbit').value;
            document.getElementById('previewTahunTerbit').innerText = document.getElementById('tahunTerbit').value;
            document.getElementById('previewStatus').innerText = document.getElementById('status').value;
            document.getElementById('previewDescription').innerText = document.getElementById('description').value;

            const image = document.getElementById('image').files[0];
            if (image) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewImage').src = e.target.result;
                };
                reader.readAsDataURL(image);
            }
        }

        document.getElementById('image').addEventListener('change', function() {
            const image = document.getElementById('image').files[0];
            if (image) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('cropImage').src = e.target.result;
                    document.getElementById('imageModal').classList.add('active');
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(document.getElementById('cropImage'), {
                        aspectRatio: 2 / 3,  // 2:3 ratio for cropping
                        viewMode: 2
                    });

                    document.getElementById('cropButton').onclick = function() {
                        const croppedImage = cropper.getCroppedCanvas().toDataURL();
                        document.getElementById('previewImage').src = croppedImage;
                        document.getElementById('image').value = croppedImage; // Store cropped image data in input
                        document.getElementById('imageModal').classList.remove('active');
                        cropper.destroy();
                    };

                    document.getElementById('cancelButton').onclick = function() {
                        document.getElementById('imageModal').classList.remove('active');
                        cropper.destroy();
                    };
                };
                reader.readAsDataURL(image);
            }
        });
    </script>
</body>
</html>
