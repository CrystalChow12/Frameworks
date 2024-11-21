<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    
    <link rel="stylesheet" href="../../css/output.css">
  </head>
  <body>
  
    <div id="app">
      <div class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
          <div class="text-center mb-6">
            <h2 class="text-center text-2xl font-bold">Sign In</h2>
            <p class="mt-2 mb-6 text-sm text-gray-600">Sign in to your account</p>

            <?php if (isset($errors) && !empty($errors)): ?>
              <p class="text-center font-medium text-red-700 py-4 mt-4 text-lg">
              <?= htmlspecialchars(array_values($errors)[0]) ?>
              </p>
            <!-- <?php
            	//else:
            	?>
                <p class="font-medium text-sm text-gray-700">No errors</p> -->
          <?php endif; ?>
          </div>

          <form id="loginForm" action="/login" method="POST">
            <div class="grid gap-y-4">
              <div>
                <label for="email" class="block mb-2 font-medium"
                  >Email address</label
                >
                <div class="relative">
                  <input
                    type="email"
                    id="email"
                    name="email"
                    
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm 
                    focus:outline-none
                        focus:border-cyan-500 focus:ring-cyan-500
                        focus:ring-2
                        disabled:opacity-50 disabled:pointer-events-none"
                    placeholder="Email address"
                  />
                </div>
                
              </div>
              <div>
                <label for="password" class="block mb-2 font-medium"
                  >Password</label
                >
                <div class="relative">
                  <input
                    type="password"
                    id="password"
                    name="password"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm focus:outline-none
                    focus:border-cyan-500 focus:ring-cyan-500
                    focus:ring-2
                    disabled:opacity-50 disabled:pointer-events-none"
                  />
                  <button
                    type="button"
                    id="togglePassword"
                    class="absolute flex items-center cursor-pointer inset-y-0 right-0 mr-3 text-gray-400"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="size-[20px] hover:text-black transition-colors"
                    >
                      <path
                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                      />
                      <circle cx="12" cy="12" r="3" />
                    </svg>
                  </button>
                </div>
                
              </div>
              <button
                type="submit"
                class="mx-auto mt-8 w-52 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-cyan-600 text-white hover:bg-cyan-700 focus:outline-none focus:bg-cyan-700 disabled:opacity-50 disabled:pointer-events-none"
              >
                Login
              </button>
            </div>
          </form>
          <br>
          <a href="/register" class="text-center text-sm text-gray-700 hover:text-cyan-600">Don't have an account? Register Here</a>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
          const type =
            password.getAttribute('type') === 'password' ? 'text' : 'password';
          password.setAttribute('type', type);

          const svg = this.querySelector('svg');
          if (type === 'password') {
            svg.innerHTML = `
              <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
              <circle cx="12" cy="12" r="3"/>
            `;
          } else {
            svg.innerHTML = `
              <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
              <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
              <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
              <path d="m2 2 20 20"/>
            `;
          }
        });
      });
    </script>
  </body>
</html>
