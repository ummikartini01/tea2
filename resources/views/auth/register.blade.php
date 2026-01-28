<x-guest-layout>
    <!-- Success Messages -->
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
            <p class="text-gray-600">Join our tea community today</p>
        </div>

        <!-- Name -->
        <div class="input-group">
            <input 
                id="name" 
                type="text" 
                name="name" 
                :value="old('name')" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                placeholder=" "
                required 
                autofocus 
                autocomplete="name"
            >
            <label for="name" class="bg-white px-1">Full Name</label>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="input-group">
            <input 
                id="email" 
                type="email" 
                name="email" 
                :value="old('email')" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                placeholder=" "
                required 
                autocomplete="username"
            >
            <label for="email" class="bg-white px-1">Email Address</label>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group">
            <input 
                id="password" 
                type="password" 
                name="password" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                placeholder=" "
                required 
                autocomplete="new-password"
            >
            <label for="password" class="bg-white px-1">Password</label>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                placeholder=" "
                required 
                autocomplete="new-password"
            >
            <label for="password_confirmation" class="bg-white px-1">Confirm Password</label>
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Account Type Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
            <div class="space-y-2">
                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-200">
                    <input type="radio" name="role" value="user" checked class="w-4 h-4 text-green-600 focus:ring-green-500">
                    <div class="ml-3">
                        <span class="font-medium text-gray-900">User Account</span>
                        <p class="text-sm text-gray-500">Browse and rate teas, get personalized recommendations</p>
                    </div>
                </label>
                <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-200">
                    <input type="radio" name="role" value="admin" class="w-4 h-4 text-green-600 focus:ring-green-500">
                    <div class="ml-3">
                        <span class="font-medium text-gray-900">Admin Account</span>
                        <p class="text-sm text-gray-500">Manage teas, users, and system settings</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <input 
                type="checkbox" 
                id="terms" 
                name="terms" 
                required
                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 mt-1"
            >
            <label for="terms" class="ml-2 text-sm text-gray-600">
                I agree to the <a href="#" class="text-green-600 hover:text-green-500">Terms and Conditions</a> and <a href="#" class="text-green-600 hover:text-green-500">Privacy Policy</a>
            </label>
        </div>

        <!-- Register Button -->
        <button type="submit" class="w-full btn-primary text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
            Create Account
        </button>

        <!-- Login Link -->
        <div class="text-center pt-6 border-t border-gray-200">
            <p class="text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-500 font-semibold transition duration-200">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
