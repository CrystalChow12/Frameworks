<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Task Records</title>
		<link rel="stylesheet" href="../../css/output.css" />
	</head>

	<body class="bg-gray-100">
		<div class="flex">
			<?php include 'partials/manSidebar.php'; ?>

			<div class="flex-1 flex flex-col overflow-hidden">
				<?php include 'partials/header.php'; ?>
				
				<main class="flex-1 bg-gray-200">
					<div class="mx-auto p-5">
						<h3 class="text-gray-700 text-3xl font-medium">Task Records</h3>
						<br />
						<div class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-12/12 mx-auto">
							<div class="flex-1 overflow-y-auto">
								<div class="flex flex-col">
									<div class="m-1.5 overflow-x-auto">
										<div class="p-1.5 min-w-full inline-block align-middle">
											<div class="py-3 px-4 flex justify-between items-center">
												<div class="relative max-w-xs">
													<label for="search" class="sr-only">Search</label>
													<input
														type="text"
														id="search"
														class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
														placeholder="Search for a task"
														onkeyup="filterTasks()"
													/>
													<div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
														<svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
															<circle cx="11" cy="11" r="8"></circle>
															<path d="m21 21-4.3-4.3"></path>
														</svg>
													</div>
												</div>
												<div>
													<label for="status-filter" class="sr-only">Filter by Status</label>
													<select id="status-filter" onchange="filterTasks()" class="py-2 px-3 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
														<option value="">All Statuses</option>
														<option value="Pending">Pending</option>
														<option value="In Progress">In Progress</option>
														<option value="Completed">Completed</option>
													</select>
												</div>
											</div>
											<div class="overflow-hidden">
												<table class="min-w-full divide-y divide-gray-200">
													<thead class="bg-gray-50">
														<tr class="align-middle">
															<th scope="col" class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase">Task</th>
															<th scope="col" class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase">Employee</th>
															<th scope="col" class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase">Manager</th>
															<th scope="col" class="py-3 px-16 text-xs text-center font-medium text-gray-500 uppercase">Due Date</th>
															<th scope="col" class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase">Employee Comments</th>
															<th scope="col" class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase">Status</th>
															<th scope="col" class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase">Action</th>
														</tr>
													</thead>
													<tbody class="divide-y divide-gray-200">
														<?php if (isset($tasks) && !empty($tasks)): ?>
															<?php foreach ($tasks as $task): ?>
																<tr>
																	<td class="px-14 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?= htmlspecialchars(
                 	$task['description'],
                 ) ?></td>
																	<td class="px-14 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800"><?= htmlspecialchars(
                 	$task['employee_username'] ?? 'Unassigned',
                 ) ?></td>
																	<td class="px-14 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800"><?= htmlspecialchars(
                 	$task['manager_username'],
                 ) ?></td>
																	<td class="text-center py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['due_date']) ?></td>
																	<td class="text-center py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['comments']) ?></td>
																	<td class="text-center py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['status']) ?></td>
																	<td class="px-12 py-4 whitespace-nowrap text-center text-sm font-medium">   
																		<button type="button" class="inline-flex items-center gap-x-1 pr-1 text-sm font-semibold rounded-lg border border-transparent text-cyan-500 hover:text-cyan-700 focus:outline-none focus:text-cyan-700 disabled:opacity-50 disabled:pointer-events-none">
																			<a href="/manager/tasks/edit?id=<?= htmlspecialchars($task['id']) ?>">Edit</a>
																		</button>
																	</td>
																</tr>
															<?php endforeach; ?>
														<?php else: ?>
															<tr>
																<td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No tasks found.</td>
															</tr>
														<?php endif; ?>
													</tbody>
												</table>
											</div>
											<!-- Pagination controls here (unchanged) -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
		
		<script>
			function filterTasks() {
				const searchInput = document.getElementById('search').value.toLowerCase();
				const statusFilter = document.getElementById('status-filter').value.toLowerCase();
				const rows = document.querySelectorAll('tbody tr');

				rows.forEach(row => {
					const taskDescription = row.cells[0].textContent.toLowerCase();
					const taskStatus = row.cells[5].textContent.toLowerCase();
					const matchesSearch = taskDescription.includes(searchInput);
					const matchesStatus = statusFilter === '' || taskStatus === statusFilter;

					if (matchesSearch && matchesStatus) {
						row.style.display = '';
					} else {
						row.style.display = 'none';
					}
				});
			}
		</script>
	</body>
</html>