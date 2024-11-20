<!-- <?php
//var_dump($data);
?> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create New User</title>
    <link rel="stylesheet" href="../../css/output.css">
  </head>


  <body class="bg-gray-100">
    <div class="flex h-screen">
    <?php include 'partials/sidebar.php'; ?>

      <div class="flex-1 flex flex-col overflow-hidden">
        <?php include 'partials/header.php'; ?>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
          <div class="mx-auto p-5">
            <h3 class="text-gray-700 text-3xl font-medium">
              Create New User Account
            </h3>
            <br>
            <div
              class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-9/12 mx-auto"
            >
              <div class="p-6 flex-1 overflow-y-auto">
                <!-- <h4 class="text-xl font-semibold mb-4">
                  
                  Create New User Account
                  
                </h4> -->
                <form
                  action= "/admin/register"
                  method="POST"
                  id="createUser"
                  class="space-y-4 flex flex-col justify-between h-full"
                >
                  <div class="space-y-4">
                    <p class="text-center text-md font-sm text-lg pb-2" id="message"></p>
          
                    <!---put php errors here !-->
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <p class="text-base text-center font-medium text-red-700">
                            <?= htmlspecialchars(array_values($errors)[0]) ?>
                        </p>
                    <!-- <?php
                    	//else:
                    	?>
                        <p class="font-medium text-sm text-gray-700">No errors</p> -->
                    <?php endif; ?>

                      <?php if (isset($messages) && !empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <p class="text-base text-center font-medium text-green-700"><?= htmlspecialchars(
                            	$message,
                            ) ?></p>
                            <?php endforeach; ?>
                      <?php endif; ?>

                      
                      
                     
                    <div class="relative">
                      <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Email</label
                      >
                      <input
                        type="text"
                        id="email"
                        name="email"
                        placeholder="yourname@example.com"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm 
                        focus:outline-none
                        focus:border-cyan-500 focus:ring-cyan-500
                        focus:ring-2"
                      />
                    </div>
                    <div class="relative">
                      <label
                        for="username"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Username</label
                      >
                      <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="firstname.lastname"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm 
                        focus:outline-none
                        focus:border-cyan-500 focus:ring-cyan-500
                        focus:ring-2"
                      />
                    </div>
                    <div class="relative">
                      <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Password</label
                      >
                      <div class="relative">
                        <input
                          type="password"
                          id="password"
                          name="password"
                          
                          class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm focus:outline-none
                          focus:border-cyan-500 focus:ring-cyan-500
                          focus:ring-2"
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
                    <div class="relative">
                      <label
                        for="confirmPassword"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Confirm Password</label
                      >
                      <div class="relative">
                        <input
                          type="password"
                          id="confirmPassword"
                          name="confirmPassword"
                          
                          class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm focus:outline-none
                          focus:border-cyan-500 focus:ring-cyan-500
                          focus:ring-2
                          "
                        />
                        <button
                          type="button"
                          id="toggleConfirmPassword"
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
                    <div class="relative">
                      <label
                        for="role"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Role</label
                      >
                      <select
                        id="role"
                        name="role"
                        
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm
                        focus:outline-none
                         focus:border-cyan-500 focus:ring-cyan-500 
                        focus:ring-2
                        disabled:opacity-50 disabled:pointer-events-none"
                      >
                        <option value="">Select a role</option>
                        <option value="1">Admin</option>
                        <option value="3">Employee</option>
                        <option value="2">Manager</option>
                      </select>
                    </div>
                  </div>
                  <button
                    type="submit"
                    id="submitButton"
                    class="w-52 py-3 px-4 inline-flex mx-auto mt-8 justify-center items-center text-sm font-medium rounded-lg bg-cyan-600 text-white hover:bg-cyan-700 focus:outline-none focus:bg-cyan-700"
                  >
                    Create Account
                  </button>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script src="../../js/register.js" defer></script>
  </body>
</html>
