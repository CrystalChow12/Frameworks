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
                  action="/admin/update"
                  method="POST"
                  id="updateUser"
                  class="space-y-4 flex flex-col justify-between h-full"
                >
                  <div class="space-y-4">
                    <p class="text-center text-md font-sm text-lg pb-2" id="message"></p>
          
                    <!---put php errors here !-->
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <p class="text-base text-center font-medium text-red-700">
                            <?= htmlspecialchars(array_values($errors)[0]) ?>
                        </p>
                    <?php else: ?>
                        <p class="font-medium text-sm text-gray-700">There are no errors</p>
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
                        <option value="2">Employee</option>
                        <option value="3">Manager</option>
                      </select>
                    </div>
                  </div>
                  <button
                    type="submit"
                    id="submitButton"
                    class="w-52 py-3 px-4 inline-flex mx-auto mt-8 justify-center items-center text-sm font-medium rounded-lg bg-cyan-600 text-white hover:bg-cyan-700 focus:outline-none focus:bg-cyan-700"
                  >
                    Edit User
                  </button>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    <!-- <script src="../../js/register.js" defer></script> -->
  </body>
</html>
