<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Courses') }}
            </h2>
            <a href="{{ route('admin.courses.show', $course) }}"
                class="font-bold py-2 px-4 bg-gray-700 hover:bg-gray-800 text-white rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                
                <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?: $course->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" />
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="" class="rounded-2xl object-cover w-[90px] h-[90px]">
                        <x-text-input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail" autocomplete="thumbnail" />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_trailer" :value="__('Path Trailer')" />
                        <x-text-input id="path_trailer" class="block mt-1 w-full" type="text" name="path_trailer"
                            :value="old('path_trailer') ?: $course->path_trailer" autocomplete="path_trailer" />
                        <x-input-error :messages="$errors->get('path_trailer')" class="mt-2" />
                    </div>

                    {{-- <div class="mt-4">
                        <x-input-label for="teacher" :value="__('teacher')" />
                        <x-text-input id="teacher" class="block mt-1 w-full" type="text" name="teacher_id" :value="old('teacher')" autocomplete="teacher" />
                        <x-input-error :messages="$errors->get('teacher')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="teacher" :value="__('teacher')" />
                        
                        <select name="teacher_id" id="teacher_id" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">Choose item</option>
                            @forelse($teachers as $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                            @empty
                            @endforelse
                        </select>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div> --}}

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        
                        <select name="category_id" id="category_id" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">Choose category</option>
                            @forelse($categories as $category)
                                <option {{ $category->id == $course->category_id ? 'selected' : null }} value="{{$category->id}}">{{$category->name}}</option>
                            @empty
                            @endforelse
                        </select>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <textarea name="about" id="about" cols="30" rows="5" class="border border-slate-300 rounded-xl w-full">{{ old('about') ?: $course->about }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <hr class="my-5">

                    <div class="mt-4">
                        
                        <div class="flex flex-col gap-y-5">
                            <x-input-label for="keypoints" :value="__('Keypoints')" />
                            @forelse ($course->keypoints as $keypoint)
                                <input type="text" class="py-3 rounded-lg border-slate-300 border" value="{{ $keypoint->name }}" name="course_keypoints[]">
                            @empty
                                <p>Data Keypoints Not Available</p>
                            @endforelse
                        </div>
                        <x-input-error :messages="$errors->get('keypoints')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
                        <button type="submit" class="font-bold py-2 px-4 bg-indigo-700 hover:bg-indigo-800 text-white rounded-md">
                            Update Course
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
