<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="../../css/output.css">
  </head>


  <body class="bg-gray-100">
    <div class="flex h-screen">
	<?php include 'partials/sidebar.php'; ?>

      <div class="flex-1 flex flex-col overflow-hidden">
		<?php include 'partials/header.php'; ?>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
          <div class="mx-auto p-5">
            <h4 class="text-gray-700 text-3xl font-medium mb-6">
              Admin Dashboard
            </h4>
            
            <div
              class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-9/12 mx-auto"
            >
              <div class="p-6 flex-1 overflow-y-auto">
                <?php if (isset($statistics) && !empty($statistics)): ?>
                  <?php foreach ($statistics as $stat): ?>
                    <p>Total Tasks: <?= htmlspecialchars($stat['totalTasks']) ?></p>
                    <p>Pending Tasks: <?= htmlspecialchars($stat['pendingTasks']) ?></p>
                    <p>Completed Tasks: <?= htmlspecialchars($stat['completedTasks']) ?></p>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p>There are no statistics to display.</p>
                <?php endif; ?>
                
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script src="../../js/register.js" defer></script>
  </body>
</html>
