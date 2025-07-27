<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .input-focus-effect:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a6fd1 0%, #6a42a1 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient:active {
            transform: translateY(0);
        }

        .custom-checkbox {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            outline: none;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
        }

        .custom-checkbox:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 5px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-5xl flex flex-col md:flex-row bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        <!-- Left Column -->
        <div class="md:w-1/2 h-64 md:h-auto login-image flex items-center justify-center p-8">
            <div class="text-center animate__animated animate__fadeIn">
                <h1 class="text-4xl font-bold text-white mb-4">Welcome Back</h1>
                <p class="text-white opacity-80">Sign in to access your personalized dashboard</p>
                <div class="mt-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-white opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="md:w-1/2 p-10 flex flex-col justify-center">
            <div class="text-center mb-8 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Login to your account</h2>
                <p class="text-gray-600 dark:text-gray-300">Enter your credentials to continue</p>
            </div>

            @if (session('status'))
                <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 text-center animate__animated animate__fadeIn">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- NIS -->
                <div class="animate__animated animate__fadeIn">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIS</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="email" type="text" name="email" value="{{ old('email') }}"
                               class="block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 input-focus-effect"
                               required autofocus autocomplete="username" placeholder="Enter your NIS">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate__animated animate__fadeIn">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="animate__animated animate__fadeIn">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               class="block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 input-focus-effect"
                               required autocomplete="current-password" placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 animate__animated animate__fadeIn">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Login Button -->
                <div class="animate__animated animate__fadeIn">
                    <button type="submit"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg shadow-md transition-all duration-300">
                        Sign In
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Footer -->
            
        </div>
    </div>
</body>
</html>
