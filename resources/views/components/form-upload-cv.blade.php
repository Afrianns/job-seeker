<form action="{{ route($routeName) }}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="mb-5">
        <input name="cv_file" @class(['bg-gray-50 text-gray-900 text-sm rounded-lg block w-full border', 'focus:ring-red-500 focus:border-red-500 border-2 border-red-300' => $errors->has('cv_file'), 'focus:ring-blue-500 focus:border-blue-500 border-gray-300' => !$errors->has('cv_file')]) id="cv_file" type="file">
        @error('cv_file')
        <p class="bg-red-500 text-red-50 py-2 px-5 rounded mt-3">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Upload</button>
</form>