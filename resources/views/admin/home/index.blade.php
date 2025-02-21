@extends('admin.layouts.boilerplate')

@section('page_title', 'Welcome to '.app_name())

@section('content')
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-gray-900">
        @if (Route::has('admin.dashboard'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8 sp:pt-20">
            <div class="flex justify-center text-center pt-8 sm:justify-start sm:pt-0">
                <div>
                    @if(app()->isProduction())
                        <span class="text-gray-500 dark:text-gray-400 text-8 sp:text-6">Welcome to</span><br/>
                    @endif
                    <span class="text-gray-500 dark:text-gray-400 text-20 sp:text-16">{{ app_name() }}</span>
                </div>
            </div>
            @if(!app()->isProduction())
                <div class="flex justify-center mt-8 sm:items-center sm:justify-between">
                    <div class="text-center text-xl sp:text-4 text-gray-500 dark:text-gray-400 sm:text-left">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <span>Welcome to &nbsp;</span>
                            </div>
                        </div>
                    </div>
    
                    <div class="ml-4 text-center text-xl sp:text-4 text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
