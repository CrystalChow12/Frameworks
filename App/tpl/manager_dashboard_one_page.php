<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Task Management</title>
		<link rel="stylesheet" href="../../css/output.css" />
	</head>

	<body class="bg-gray-100">
		<div class="flex">
			<?php include 'partials/manSidebar.php'; ?>

			<div class="flex-1 flex flex-col overflow-hidden">
				<?php include 'partials/header.php'; ?>
				
				<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
					<div class="mx-auto p-5">
						<h3 class="text-gray-700 text-3xl font-medium">Task Management</h3>
						<br />
						<div class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-full mx-auto">
							<div class="flex-1 overflow-y-auto">
								<div class="flex flex-col">
									<div class="m-1.5 overflow-x-auto">
										<div class="p-1.5 min-w-full inline-block align-middle">
											<div class="py-3 px-4">
												<div class="relative max-w-xs">
													<label class="sr-only">Search</label>
													<input
														type="text"
														name="hs-table-search"
														id="hs-table-search"
														class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
														placeholder="Search for a task"
													/>
													<div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
														<svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
															<circle cx="11" cy="11" r="8"></circle>
															<path d="m21 21-4.3-4.3"></path>
														</svg>
													</div>
												</div>
											</div>
											<div class="overflow-hidden">
												<table class="min-w-full divide-y divide-gray-200">
													<thead class="bg-gray-50">
														<tr>
															<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Task</th>
															<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Employee</th>
															<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Due Date</th>
															<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Status</th>
															<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Action</th>
														</tr>
													</thead>
													<tbody class="divide-y divide-gray-200">
														<?php if (isset($tasks) && !empty($tasks)): ?>
															<?php foreach ($tasks as $task): ?>
																<tr id="task-row-<?= htmlspecialchars($task['id']) ?>">
																	<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?= htmlspecialchars($task['description']) ?></td>
																	<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['assigned_to']) ?></td>
																	<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['due_date']) ?></td>
																	<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['status']) ?></td>
																	<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
																		<button onclick="toggleEditForm(<?= htmlspecialchars($task['id']) ?>)" class="text-cyan-600 hover:text-cyan-900">Edit</button>
                                                                    </td>
																</tr>
																<tr id="edit-form-<?= htmlspecialchars($task['id']) ?>" class="hidden">
																	<td colspan="5">
																		<form action="/manager/tasks/edit" method="POST" class="p-4 bg-gray-50">
																			<input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
																			<div class="grid grid-cols-2 gap-4">
																				<div>
																					<label for="description-<?= $task['id'] ?>" class="block text-sm font-medium text-gray-700">Description</label>
																					<textarea id="description-<?= $task['id'] ?>" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
																				</div>
																				<div>
																					<label for="assigned_to-<?= $task['id'] ?>" class="block text-sm font-medium text-gray-700">Assigned To</label>
																					<select id="assigned_to-<?= $task['id'] ?>" name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
																						<?php foreach ($users as $user): ?>
																							<option value="<?= htmlspecialchars($user['id']) ?>" <?= ($task['assigned_to'] == $user['id']) ? 'selected' : '' ?>><?= htmlspecialchars($user['username']) ?></option>
																						<?php endforeach; ?>
																					</select>
																				</div>
																				<div>
																					<label for="due_date-<?= $task['id'] ?>" class="block text-sm font-medium text-gray-700">Due Date</label>
																					<input type="date" id="due_date-<?= $task['id'] ?>" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
																				</div>
																				<div>
																					<label for="status-<?= $task['id'] ?>" class="block text-sm font-medium text-gray-700">Status</label>
																					<select id="status-<?= $task['id'] ?>" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
																						<option value="Pending" <?= ($task['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
																						<option value="In Progress" <?= ($task['status'] == 'In Progress') ? 'selected' : '' ?>>In Progress</option>
																						<option value="Completed" <?= ($task['status'] == 'Completed') ? 'selected' : '' ?>>Completed</option>
																					</select>
																				</div>
																			</div>
																			<div class="mt-4 flex justify-end">
																				<button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-cyan-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Update Task</button>
																				<button type="button" onclick="toggleEditForm(<?= htmlspecialchars($task['id']) ?>)" class="ml-3 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Cancel</button>
																			</div>
																		</form>
																	</td>
																</tr>
															<?php endforeach; ?>
														<?php else: ?>
															<tr>
																<td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No tasks found.</td>
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
			function toggleEditForm(taskId) {
				const row = document.getElementById(`task-row-${taskId}`);
				const form = document.getElementById(`edit-form-${taskId}`);
				row.classList.toggle('hidden');
				form.classList.toggle('hidden');
			}
		</script>
	</body>
</html>