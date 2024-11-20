<!-- <?php
//var_dump($data);
?> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Your Task</title>
    
    <link rel="stylesheet" href="../../css/output.css">
  </head>


  <body class="bg-gray-100">
    <div class="flex h-screen">
    <?php include 'partials/empSidebar.php'; ?>

      <div class="flex-1 flex flex-col overflow-hidden">
        <?php include 'partials/header.php'; ?>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
          <div class="mx-auto p-5">
            <h3 class="text-gray-700 text-3xl font-medium mb-6">
             Create Tasks
            </h3>
            <br>
            <div
              class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-9/12 mx-auto"
            >
              <div class="p-6 flex-1 overflow-y-auto">
               
                <form
                  action="/employee/tasks/edit?id=<?= htmlspecialchars($taskId) ?>"
                  id="edit_task"
                  class="space-y-4 flex flex-col justify-between h-full"
                  method="POST"
                >
                  <div class="space-y-4">
                    <p class="text-center text-md font-sm text-lg pb-2" id="message"></p>
          
                    <!---put php errors here !-->
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <p class="text-base text-center font-medium text-red-700">
                            <?= htmlspecialchars(array_values($errors)[0]) ?>
                        </p>
                    <?php endif; ?>
                     
                    <div class="relative">
                      <label
                        for="user"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >Status</label
                      >
                      <select
                        id="status"
                        name="status"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg border text-sm
                        focus:outline-none
                         focus:border-cyan-500 focus:ring-cyan-500 
                        focus:ring-2
                        disabled:opacity-50 disabled:pointer-events-none"
                      >
                        <option value="">Update the status</option>
                        <option value="Pending" <?= $task['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="In_Progress" <?= $task['status'] == 'In_Progress'
                        	? 'selected'
                        	: '' ?>>In Progress</option>
                        <option value="Completed" <?= $task['status'] == 'Completed'
                        	? 'selected'
                        	: '' ?>>Completed</option>
                      </select>
                    </div>

                    <div class="relative">
                      <label
                        for="comments"
                        class="block text-sm font-medium text-gray-700 mb-2"
                        >comments</label
                      >
                      <textarea
                        id="comments"
                        name="comments"
                        class="px-3 py-2 block w-full h-20 border-gray-200 rounded-lg border text-sm focus:outline-none focus:border-cyan-500 focus:ring-cyan-500 focus:ring-2"
                      ><?= htmlspecialchars($task['comments'] ?? '') ?></textarea>
                    </div>
                    
                  </div>

                  <button
                    type="submit"
                    id="submitButton"
                    class="w-52 py-3 px-4 inline-flex mx-auto mt-8 justify-center items-center text-sm font-medium rounded-lg bg-cyan-600 text-white hover:bg-cyan-700 focus:outline-none focus:bg-cyan-700"
                  >
                    Edit Task
                  </button>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
