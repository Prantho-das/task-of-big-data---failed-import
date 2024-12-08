<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Import</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h1 class="text-lg font-bold mb-4">Import File</h1>

        <form id="importForm" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="file">Select File</label>
                <input type="file" name="file" id="file"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none"
                    required>
            </div>
            <button type="submit" id="submitBtn"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                Upload File
            </button>
        </form>

        <div id="feedback" class="hidden mt-4">
            <div id="successMessage"
                class="hidden bg-green-100 text-green-700 border border-green-400 p-4 rounded mb-2">
                <strong>Success!</strong> Rows Imported: <span id="importedCount">0</span>
            </div>
            <div id="errorMessage" class="hidden bg-red-100 text-red-700 border border-red-400 p-4 rounded">
                <strong>Error!</strong> Rows Failed: <span id="failedCount">0</span>.
                <a id="downloadFailedFile" href="#" class="text-blue-500 underline">Download Failed Rows</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('importForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const feedback = document.getElementById('feedback');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            const importedCount = document.getElementById('importedCount');
            const failedCount = document.getElementById('failedCount');
            const downloadFailedFile = document.getElementById('downloadFailedFile');

            feedback.classList.add('hidden');
            successMessage.classList.add('hidden');
            errorMessage.classList.add('hidden');

            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Uploading...';

            try {
                const response = await fetch('/bulk-import-export', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                });

                const data = await response.json();

                if (response.ok) {
                    feedback.classList.remove('hidden');

                    if (data.imported_count > 0) {
                        importedCount.textContent = data.imported_count;
                        successMessage.classList.remove('hidden');
                    }

                    if (data.failed_count > 0) {
                        failedCount.textContent = data.failed_count;
                        downloadFailedFile.href = data.failed_file_url;
                        errorMessage.classList.remove('hidden');
                    }
                } else {
                    alert('An error occurred during upload.');
                }
            } catch (error) {
                console.error(error);
                alert('Something went wrong.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Upload File';
            }
        });
    </script>
</body>

</html>
